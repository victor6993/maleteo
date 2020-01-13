FROM phpdockerio/php73-fpm:latest
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install wget php7.3-mysql git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

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
