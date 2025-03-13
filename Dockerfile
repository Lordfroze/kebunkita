# Menggunakan image PHP 8.2 dengan FPM
FROM php:8.2-fpm

# Instal ekstensi yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set direktori kerja
WORKDIR /var/www/html

# Salin file proyek
COPY . .

# Set permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan Composer
RUN composer install --optimize-autoloader --no-dev

# Expose port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
