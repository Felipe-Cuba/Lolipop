# Use PHP 7.4 with Apache
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    zip

# Enable Apache modules
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Create uploads directory if needed
RUN mkdir -p /var/www/html/uploads \
    && chown www-data:www-data /var/www/html/uploads \
    && chmod 755 /var/www/html/uploads

# Apache configuration for URL rewriting
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/lolipop.conf \
    && a2enconf lolipop

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
