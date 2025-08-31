FROM php:8.4-fpm

ARG USER_ID=1000
ARG USER_NAME=www-user
ARG GROUP_ID=1000
ARG GROUP_NAME=www-user
ARG XDEBUG_ON=true
ARG XDEBUG_MODE="debug"
ARG XDEBUG_PORT=9003
ARG XDEBUG_IDEKEY="PHPSTORM"

###
### Installing the latest version of composer
###
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

###
### Installing basic dependencies
###
RUN export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" && \
    apt-get update && \
    apt-get install -y \
    libmagickwand-dev \
	libssl-dev \
	libpq-dev \
	libonig-dev \
	libzip-dev \
	libxslt-dev \
    librabbitmq-dev \
    gcc \
    g++ \
    make \
	nano \
	procps \
	unzip \
    git \
	default-mysql-client \
    aspell \
    aspell-en \
    aspell-ru

###
### Installing PHP extensions
###
RUN docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install bz2 && \
    docker-php-ext-install calendar && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install soap && \
    docker-php-ext-install sockets && \
    docker-php-ext-install exif && \
    docker-php-ext-install sysvsem && \
    docker-php-ext-install gettext

RUN docker-php-ext-install xsl && \
    docker-php-ext-install bcmath

RUN echo log_errors=On > /usr/local/etc/php/php.ini

RUN if [ ${XDEBUG_ON} = true ]; then \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_port=${XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.log=/var/www/logs/xdebug/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.idekey=${XDEBUG_IDEKEY}" >> /usr/local/etc/php/conf.d/xdebug.ini \
;fi
RUN mkdir /var/www/logs && mkdir /var/www/logs/xdebug && touch /var/www/logs/xdebug/xdebug.log;

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN sed -i 's/{USER_NAME}/'${USER_NAME}'/g' /usr/local/etc/php-fpm.d/zz-docker.conf && \
    sed -i 's/{GROUP_NAME}/'${GROUP_NAME}'/g' /usr/local/etc/php-fpm.d/zz-docker.conf


RUN addgroup --gid ${GROUP_ID} --system ${GROUP_NAME} && \
    adduser --uid ${USER_ID} --system ${USER_NAME} --gid ${GROUP_ID}

RUN chown -R ${USER_NAME}:${GROUP_NAME} /var/www
RUN chmod u+rwx,g+rx,o+rx /var/www
RUN find /var/www -type d -exec chmod u+rwx,g+rx,o+rx {} +
RUN find /var/www -type f -exec chmod u+rw,g+rw,o+r {} +

USER ${USER_NAME}

WORKDIR /var/www/public

CMD ["php-fpm"]

EXPOSE 9000
