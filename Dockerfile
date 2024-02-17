# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Install any needed packages specified in requirements.txt
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql \
    && a2enmod rewrite

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variable
ENV APACHE_DOCUMENT_ROOT /app/public

# Update the default apache site with the config we created
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Run app.py when the container launches
CMD ["apache2-foreground"]
