# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Install any needed packages specified in requirements.txt
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \  # Install PostgreSQL development files
&& docker-php-ext-install zip pdo_mysql pdo_pgsql \
    && a2enmod rewrite \
    && a2enmod headers  # Enable Apache modules

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variables for PostgreSQL connection
ENV DB_CONNECTION pgsql
ENV DB_HOST dpg-cn7n82uct0pc738vtpng-a.singapore-postgres.render.com
ENV DB_PORT 5432
ENV DB_DATABASE survey_app
ENV DB_USERNAME root
ENV DB_PASSWORD z4ECUN5GUxLTIpcGu3Y3lyt2sBRzTu9z

# Update the default apache site with the config we created
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Update the Apache document root to /app/public
ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run composer and Laravel commands when the container launches
CMD ["bash", "-c", "\
    echo 'Running composer'; \
    composer global require hirak/prestissimo; \
    composer install --no-dev --working-dir=/var/www/html; \
    echo 'Caching config...'; \
    php artisan config:cache; \
    echo 'Caching routes...'; \
    php artisan route:cache; \
    echo 'Running migrations...'; \
    php artisan migrate --force; \
    apache2-foreground \
    "]
