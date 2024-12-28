# Gunakan image PHP yang sesuai dengan versi Laravel Anda
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Copy composer.json dan composer.lock
COPY composer.json composer.lock ./

# Install dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader
COPY . .

# Set permissions
RUN chown -R www-data:www-data .

# Expose port
EXPOSE 80

# Command untuk menjalankan aplikasi
CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]