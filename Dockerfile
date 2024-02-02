FROM php:8.0-cli

RUN apt-get update && apt-get install -y unzip && docker-php-ext-install pdo pdo_mysql

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the application source code into the image
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run Composer to install dependencies inside the image
RUN composer install --no-dev --optimize-autoloader

# Ensure the output directory is present
RUN mkdir -p output

# Copy the startup script, ensure it's executable, and execute it when container starts
COPY startup.sh /var/www/html/startup.sh
RUN chmod +x /var/www/html/startup.sh
CMD ["sh", "/var/www/html/startup.sh"]