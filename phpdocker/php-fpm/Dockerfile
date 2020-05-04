FROM php:7.4-fpm
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update
RUN apt-get install -y git zip libonig-dev libxml2-dev wget vim libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql xml pcntl \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug 
RUN docker-php-ext-enable xdebug

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini.new
RUN cat /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini >> /usr/local/etc/php/conf.d/xdebug.ini.new \
    && mv /usr/local/etc/php/conf.d/xdebug.ini.new /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ARG user
ARG uid

RUN useradd -m -u $uid $user


# Install Composer
##################
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer


# Install symfony installer
###########################
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN echo "alias ll='ls -lrat'" >> /root/.bashrc
RUN echo "export LS_OPTIONS='--color=auto'" >> /root/.bashrc
RUN echo "alias ls='ls \$LS_OPTIONS'" >> /root/.bashrc


## HABILITAR EXTENSIONES PARA MYSQL
#RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql xml pcntl
