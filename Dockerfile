FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev \
    libxml2-dev libzip-dev zip unzip \
    libfreetype6-dev libjpeg62-turbo-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (Konfigurasi GD agar mendukung gambar)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy SEMUA file project dulu
COPY . .

# Buat folder yang dibutuhkan & set permission
RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/logs \
    && chmod -R 777 bootstrap/cache \
    && chmod -R 777 storage

# Install dependencies (no-scripts agar tidak jalankan artisan dulu)
RUN composer install --no-interaction --no-dev --no-scripts --ignore-platform-reqs

# Jalankan scripts composer secara manual setelah semua siap
RUN composer dump-autoload --optimize

# Set permission & ownership
RUN chown -R www-data:www-data /var/www

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]