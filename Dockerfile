# استخدم PHP 8.2 مع FPM
FROM php:8.2-fpm

# تثبيت الأدوات الأساسية وملحقات PostgreSQL
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    nodejs npm libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# نسخ ملفات المشروع
COPY . .

# تثبيت PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# تثبيت JS dependencies وبناء Vite
RUN npm install
RUN npm run build

# صلاحيات الملفات
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]
