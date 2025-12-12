<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;

trait FileManagerTrait
{
    /**
     * Upload a single file with optional watermark, resize, and compression
     *
     * @param UploadedFile $file
     * @param string $type File type (ads, users, gallery, etc.)
     * @param array $options Additional options for processing
     * @return string|null The stored file path
     */
    public function uploadFile(UploadedFile $file, string $type = 'misc', array $options = []): ?string
    {
        try {
            $path = $this->getPathByType($type);
            $filename = $this->generateUniqueFilename($file);
            $fullPath = $path . '/' . $filename;

            // Check if the file is an image
            if ($this->isImage($file)) {
                $image = Image::make($file->getRealPath());

                // Resize if dimensions are provided
                if (isset($options['width']) || isset($options['height'])) {
                    $image = $this->resizeImage(
                        $image,
                        $options['width'] ?? null,
                        $options['height'] ?? null
                    );
                }

                // Add watermark if requested
                if (isset($options['watermark']) && $options['watermark']) {
                    $image = $this->addWatermark(
                        $image,
                        $options['watermark_text'] ?? 'Copyright',
                        $options['watermark_position'] ?? 'bottom-right',
                        $options['watermark_size'] ?? 20,
                        $options['watermark_color'] ?? '#ffffff',
                        $options['watermark_opacity'] ?? 50
                    );
                }

                // Compress and save
                $quality = $options['quality'] ?? 85;
                $encoded = $image->encode($file->getClientOriginalExtension(), $quality);
                Storage::disk('public')->put($fullPath, $encoded);
            } else {
                // For non-image files, store directly
                Storage::disk('public')->putFileAs($path, $file, $filename);
            }

            return $fullPath;
        } catch (\Exception $e) {
            \Log::error('File upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Bulk upload multiple files
     *
     * @param array $files Array of UploadedFile instances
     * @param string $type File type (ads, users, gallery, etc.)
     * @param array $options Additional options for processing
     * @return array Array of uploaded file paths
     */
    public function uploadMultipleFiles(array $files, string $type = 'misc', array $options = []): array
    {
        $uploadedPaths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $path = $this->uploadFile($file, $type, $options);
                if ($path) {
                    $uploadedPaths[] = $path;
                }
            }
        }

        return $uploadedPaths;
    }

    /**
     * Update a file (delete old and upload new)
     *
     * @param string|null $oldFilePath The old file path to delete
     * @param UploadedFile $newFile The new file to upload
     * @param string $type File type (ads, users, gallery, etc.)
     * @param array $options Additional options for processing
     * @return string|null The new file path
     */
    public function updateFile(?string $oldFilePath, UploadedFile $newFile, string $type = 'misc', array $options = []): ?string
    {
        // Delete the old file if it exists
        if ($oldFilePath) {
            $this->deleteFile($oldFilePath);
        }

        // Upload the new file
        return $this->uploadFile($newFile, $type, $options);
    }

    /**
     * Delete a file from storage
     *
     * @param string|null $filePath The file path to delete
     * @return bool
     */
    public function deleteFile(?string $filePath): bool
    {
        if (!$filePath) {
            return false;
        }

        try {
            if (Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->delete($filePath);
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('File deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple files from storage
     *
     * @param array $filePaths Array of file paths to delete
     * @return int Number of files successfully deleted
     */
    public function deleteMultipleFiles(array $filePaths): int
    {
        $deletedCount = 0;

        foreach ($filePaths as $filePath) {
            if ($this->deleteFile($filePath)) {
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Get the storage path based on file type
     *
     * @param string $type
     * @return string
     */
    protected function getPathByType(string $type): string
    {
        $paths = [
            'ads' => 'uploads/ads',
            'users' => 'uploads/users',
            'gallery' => 'uploads/gallery',
        ];

        return $paths[$type] ?? 'uploads/misc';
    }

    /**
     * Generate a unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitized = preg_replace('/[^A-Za-z0-9\-_]/', '_', $filename);
        $timestamp = time();
        $random = bin2hex(random_bytes(8));

        return "{$sanitized}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Check if file is an image
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function isImage(UploadedFile $file): bool
    {
        $mimeType = $file->getMimeType();
        return str_starts_with($mimeType, 'image/');
    }

    /**
     * Resize an image maintaining aspect ratio
     *
     * @param InterventionImage $image
     * @param int|null $width
     * @param int|null $height
     * @return InterventionImage
     */
    protected function resizeImage(InterventionImage $image, ?int $width, ?int $height): InterventionImage
    {
        return $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }

    /**
     * Add watermark to an image
     *
     * @param InterventionImage $image
     * @param string $text
     * @param string $position
     * @param int $size
     * @param string $color
     * @param int $opacity
     * @return InterventionImage
     */
    protected function addWatermark(
        InterventionImage $image,
        string $text,
        string $position = 'bottom-right',
        int $size = 20,
        string $color = '#ffffff',
        int $opacity = 50
    ): InterventionImage {
        // Calculate position
        [$x, $y, $align, $valign] = $this->calculateWatermarkPosition($position, $image->width(), $image->height());

        // Convert hex color to RGB
        $rgb = $this->hexToRgb($color);
        
        // Create color with opacity
        $colorWithOpacity = array_merge($rgb, ['alpha' => $opacity / 100]);

        // Add text watermark
        $image->text($text, $x, $y, function ($font) use ($size, $colorWithOpacity, $align, $valign) {
            $font->size($size);
            $font->color($colorWithOpacity);
            $font->align($align);
            $font->valign($valign);
            
            // Try to use a system font, fallback to default
            if (file_exists(public_path('fonts/Arial.ttf'))) {
                $font->file(public_path('fonts/Arial.ttf'));
            }
        });

        return $image;
    }

    /**
     * Calculate watermark position coordinates
     *
     * @param string $position
     * @param int $imageWidth
     * @param int $imageHeight
     * @return array
     */
    protected function calculateWatermarkPosition(string $position, int $imageWidth, int $imageHeight): array
    {
        $padding = 20;
        
        return match ($position) {
            'top-left' => [$padding, $padding, 'left', 'top'],
            'top-center' => [$imageWidth / 2, $padding, 'center', 'top'],
            'top-right' => [$imageWidth - $padding, $padding, 'right', 'top'],
            'center-left' => [$padding, $imageHeight / 2, 'left', 'middle'],
            'center' => [$imageWidth / 2, $imageHeight / 2, 'center', 'middle'],
            'center-right' => [$imageWidth - $padding, $imageHeight / 2, 'right', 'middle'],
            'bottom-left' => [$padding, $imageHeight - $padding, 'left', 'bottom'],
            'bottom-center' => [$imageWidth / 2, $imageHeight - $padding, 'center', 'bottom'],
            'bottom-right' => [$imageWidth - $padding, $imageHeight - $padding, 'right', 'bottom'],
            default => [$imageWidth - $padding, $imageHeight - $padding, 'right', 'bottom'],
        };
    }

    /**
     * Convert hex color to RGB array
     *
     * @param string $hex
     * @return array
     */
    protected function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Get the full URL of a stored file
     *
     * @param string|null $filePath
     * @return string|null
     */
    public function getFileUrl(?string $filePath): ?string
    {
        if (!$filePath) {
            return null;
        }

        return Storage::disk('public')->url($filePath);
    }

    /**
     * Check if file exists
     *
     * @param string|null $filePath
     * @return bool
     */
    public function fileExists(?string $filePath): bool
    {
        if (!$filePath) {
            return false;
        }

        return Storage::disk('public')->exists($filePath);
    }
}