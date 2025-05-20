FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    zip \
    git \
    nano \
    && docker-php-ext-install mysqli pdo pdo_mysql intl opcache \
    && rm -rf /var/lib/apt/lists/*

# Aktifkan mod_rewrite untuk CodeIgniter
RUN a2enmod rewrite

# Set DocumentRoot agar langsung mengarah ke folder public
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-available/000-default.conf

# Install OPCache untuk meningkatkan performa
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Copy source code ke dalam container
COPY . /var/www/html/

# Atur working directory
WORKDIR /var/www/html/

# Berikan izin untuk folder writable dan uploads agar bisa diakses oleh PHP
RUN mkdir -p /var/www/html/public/uploads/photos && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/writable && \
    chmod -R 777 /var/www/html/writable

# Konfigurasi PHP tambahan
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=128M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=128M" >> /usr/local/etc/php/conf.d/custom.ini

# Pastikan Apache menggunakan user www-data
RUN sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=www-data/' /etc/apache2/envvars && \
    sed -i 's/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=www-data/' /etc/apache2/envvars

# Gunakan user www-data untuk menjalankan proses
USER www-data

# Restart Apache untuk menerapkan konfigurasi
CMD ["apache2-foreground"]
