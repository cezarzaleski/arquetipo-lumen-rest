FROM php:7.1-fpm

RUN apt-get update \
    && apt-get install -y \
    && curl --silent --show-error https://getcomposer.org/installer | php && chmod +x composer.phar \
    && ln -s composer.phar /usr/bin/composer \
    && docker-php-ext-install pdo pdo_mysql

#RUN ["chmod", "+x", "/code/docker/php/migrate.sh"]
#RUN ["chmod", "+x", "./php/wait-for-it.sh"]
ENTRYPOINT ["sh", "/code/docker/php/migrate.sh"]