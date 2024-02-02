FROM php:8.0-cli

RUN apt-get update && apt-get install -y unzip && docker-php-ext-install pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory and copy files
WORKDIR /var/www/html
COPY . /var/www/html

# Install PHP dependencies with Composer
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "generate_blog.php"]
