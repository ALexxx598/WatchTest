FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
      libicu-dev \
      libpq-dev \
      git \
      zip \
      unzip \
    && docker-php-ext-install \
      pdo_mysql \
      bcmath \
      mysqli \
      pdo \
      intl

#install mysql clinet for migrations
RUN apt-get -y --no-install-recommends install default-mysql-server

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#install xdebug
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions xdebug && docker-php-ext-enable xdebug

#xdebug mappings
ENV PHP_IDE_CONFIG 'serverName=symfonyDocker'
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=127.0.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY . /var/www/app
WORKDIR /var/www/app

COPY . /var/www/cli
WORKDIR /var/www/cli