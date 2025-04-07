# Base image

FROM php:8.4-apache

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive


RUN apt-get update && apt-get install -y libmcrypt-dev libzip-dev \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt
	
RUN apt-get install -y libpq-dev ssl-cert \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql zip \
	&& docker-php-ext-install calendar && docker-php-ext-configure calendar
	
RUN docker-php-ext-configure zip
	
# Install git
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git	
	
# Install gd	
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/  --with-jpeg=/usr/include/ --with-webp=/usr/include/ && \
    docker-php-ext-install gd
	
# Install Imagick

RUN apt update && \
    apt upgrade && \
    apt install -y libmagickwand-dev --no-install-recommends && \
    pecl install imagick && docker-php-ext-enable imagick && \
    rm -rf /var/lib/apt/lists/*

# Install imap
RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Install soap
RUN apt-get update && \
    apt-get install -y libxml2-dev

RUN docker-php-ext-install soap



RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev libzip-dev sendmail


# Install sendmail

COPY ./Docker/config/sendmail.ini /usr/local/etc/php/conf.d/sendmail.ini
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini

RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint

RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint



# And clean up the image

RUN rm -rf /var/lib/apt/lists/*

	
	
# Install composer	
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Enable mod_rewrite
RUN a2enmod rewrite

# Enable ssl
RUN a2enmod ssl \
	&& a2ensite default-ssl.conf \
	&& a2enmod headers

RUN echo "max_execution_time=3600" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
	


