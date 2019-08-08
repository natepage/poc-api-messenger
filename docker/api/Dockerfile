########################################################################################################################
##
## PHP
##
########################################################################################################################
FROM php:7.3-fpm AS php

## SET ENV FOR PROD
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="15000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="128"

## DEFAULT EXTENSIONS
RUN apt-get update && apt-get install --no-install-recommends -y \
      libzip-dev \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && pecl install xdebug-2.7.2  \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*


RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini" \
    && sed -i 's/memory_limit = .*/memory_limit = 512M/' "${PHP_INI_DIR}/php.ini"

RUN rm -rfv /var/www/*

WORKDIR /var/www

########################################################################################################################
##
## COMPOSER
##
########################################################################################################################
FROM php AS composer

RUN apt-get update && apt-get install --no-install-recommends -y \
      curl \
      git \
      zip \
      unzip  \
   && rm -rf /var/lib/apt/lists/*

# Install composer
COPY ./docker/api/composer-installer.sh /usr/local/bin/composer-installer

RUN chmod +x /usr/local/bin/composer-installer \
    && /usr/local/bin/composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN /usr/local/bin/composer global require hirak/prestissimo -n; exit 0

# install Symfony Flex globally to speed up download of Composer packages (parallelized prefetching)
RUN set -eux; \
	composer global require "symfony/flex" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
	composer clear-cache

VOLUME '/var/www/.composer'

########################################################################################################################
##
## COMPOSER INSTALL
##
########################################################################################################################
FROM composer AS composer_install

COPY ./composer.json /var/www/composer.json
COPY ./composer.lock /var/www/composer.lock
COPY ./symfony.lock /var/www/symfony.lock

RUN composer install -o -v --prefer-dist --no-dev --no-scripts --no-progress --no-suggest; \
    composer clear-cache

########################################################################################################################
##
## API PRODUCTION
##
########################################################################################################################
FROM php AS api-production


## SSM ENVIRONMENT
COPY --from=base2/awsenv /awsenv /bin/awsenv
RUN mkdir /ssm

## PHP OVERRIDES AND EXTENSIONS
COPY ./docker/api/php.ini "${PHP_INI_DIR}/conf.d/99-overrides.ini"
COPY ./docker/api/php-fpm.d/fpm.conf /usr/local/etc/php-fpm.d/zzz-overrides.conf
COPY ./docker/api/conf.d/*.ini "${PHP_INI_DIR}/conf.d/"

## COPY APPLICATION
COPY bin bin/
COPY config config/
COPY public public/
COPY src src/

## PLACEHOLDER .env
# do not use .env files in production
RUN echo '<?php return [];' > .env.local.php

# VENDOR DIRECTORY
COPY --from=composer_install /var/www/vendor /var/www/vendor

## CONFIGURE STORAGE
RUN set -eux; \
	mkdir -p /var/www/var/cache /var/www/var/log;
RUN find /var/www/var -type d -exec chmod -v 0770 {} + \
    && find /var/www/var -type f -exec rm -v {} + \
    && chown -Rv www-data:www-data /var/www/var

VOLUME /var/www/var

COPY ./docker/api/*.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

WORKDIR /var/www

ENTRYPOINT [ "/usr/local/bin/startup.sh" ]
CMD [ "/usr/local/sbin/php-fpm", "-F", "-O" ]

