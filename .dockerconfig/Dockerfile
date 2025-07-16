FROM php:8.0-fpm

# add the commands
COPY ./fix /bin/fix
RUN chmod +x /bin/fix

# install deps
RUN apt update && apt install -y \
    nano \
    bash \
    nodejs \
    npm \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle sudo

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql exif pcntl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Configure sudo groups
RUN groupadd sudoers

# Configure user
RUN useradd -s /usr/bin/bash usc
RUN usermod -aG sudo usc
RUN usermod -aG sudoers usc
RUN usermod --password "" usc

# Copy aesthetic ASCII
COPY ./bashrc /home/usc/.bashrc

# change work directory
USER usc
WORKDIR /var/www

# Expose the port.
EXPOSE 9000
CMD ["php-fpm"]
