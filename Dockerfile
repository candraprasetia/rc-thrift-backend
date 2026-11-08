FROM php:8.2-cli

# Install ekstensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Buat dan pindah ke folder aplikasi
WORKDIR /app

# Salin seluruh kode backend
COPY . /app

# Berikan izin akses folder storage dan cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Buka port 80 untuk Railway
EXPOSE 80

# Jalankan server bawaan PHP Laravel secara langsung
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
