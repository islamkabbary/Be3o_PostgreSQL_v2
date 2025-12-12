<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\CategoryAttribute;

class CreateAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ----------------------
            // BASIC AD INFO
            // ----------------------
            'category_id'      => ['required', 'integer', Rule::exists('categories', 'id')],
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string'],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'currency'         => ['nullable', Rule::in(['EGP','USD','SAR','AED'])],

            'condition'        => ['nullable', Rule::in(['new','used','refurbished'])],

            // ----------------------
            // LOCATION DATA
            // ----------------------
            'location'                         => ['required', 'array'],
            'location.governorate'             => ['required', 'string', 'max:100'],
            'location.city'                    => ['required', 'string', 'max:100'],
            'location.area'                    => ['nullable', 'string', 'max:100'],
            'location.latitude'                => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude'               => ['nullable', 'numeric', 'between:-180,180'],

            // ----------------------
            // IMAGES
            // ----------------------
            'images'                           => ['nullable', 'array', 'max:10'],
            'images.*'                         => ['nullable', 'file', 'image', 'mimes:png,jpg,jpeg,webp', 'max:5120'],

            // ----------------------
            // ATTRIBUTES (Dynamic Data)
            // ----------------------
            'attributes'                       => ['nullable', 'array'],
            'attributes.*.id'                  => ['required', 'integer', Rule::exists('category_attributes', 'id')],
            'attributes.*.value'               => ['nullable'], // custom validation below
        ];
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // ------------------------------
            // Validate Category Ownership
            // ------------------------------
            if ($this->filled('attributes')) {
                $categoryId = $this->category_id;

                foreach ($this->attributes as $item) {
                    $attr = CategoryAttribute::find($item['id']);

                    if (!$attr) continue;

                    if ($attr->category_id != $categoryId) {
                        $validator->errors()->add(
                            'attributes',
                            "Attribute ID {$attr->id} does not belong to this category."
                        );
                        continue;
                    }

                    // -----------------------------------
                    // Validate Attribute Type vs Value
                    // -----------------------------------
                    $value = $item['value'];

                    switch ($attr->attribute_type) {

                        case 'text':
                            if (!is_string($value)) {
                                $validator->errors()->add("attributes.{$attr->id}", "Value must be a string.");
                            }
                            break;

                        case 'number':
                            if (!is_numeric($value)) {
                                $validator->errors()->add("attributes.{$attr->id}", "Value must be a number.");
                            }
                            break;

                        case 'boolean':
                            if (!in_array($value, [true, false, 1, 0, '1', '0'], true)) {
                                $validator->errors()->add("attributes.{$attr->id}", "Value must be true/false.");
                            }
                            break;

                        case 'date':
                            if (!strtotime($value)) {
                                $validator->errors()->add("attributes.{$attr->id}", "Value must be a valid date.");
                            }
                            break;

                        case 'select':
                            if (!in_array($value, $attr->options ?? [])) {
                                $validator->errors()->add("attributes.{$attr->id}", "Invalid option selected.");
                            }
                            break;

                        case 'multi_select':
                            if (!is_array($value)) {
                                $validator->errors()->add("attributes.{$attr->id}", "Value must be an array.");
                                break;
                            }
                            foreach ($value as $v) {
                                if (!in_array($v, $attr->options ?? [])) {
                                    $validator->errors()->add("attributes.{$attr->id}", "Invalid multi-select option.");
                                }
                            }
                            break;

                        default:
                            $validator->errors()->add("attributes.{$attr->id}", "Unknown attribute type.");
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Category is required.',
            'title.required'       => 'Title is required.',
            'description.required' => 'Description is required.',
            'images.*.image'       => 'Each file must be a valid image.',
        ];
    }
}
