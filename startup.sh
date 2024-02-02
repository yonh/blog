#!/bin/bash

# Generate static site content
php /var/www/html/generate_blog.php

# Ensure the output directory exists
echo 'Checking if output directory exists...'
if [ ! -d "/var/www/html/output" ]; then
  mkdir -p /var/www/html/output
  echo 'Output directory created.'
else
  echo 'Output directory already exists.'
fi

# Start PHP built-in server
php -S 0.0.0.0:80 -t /var/www/html/output/