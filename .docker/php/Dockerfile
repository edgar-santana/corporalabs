FROM php:7.2.3-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip \
    gnupg gnupg1 gnupg2
RUN docker-php-ext-install pdo pdo_mysql
COPY php.ini /etc/php/7.2.3/php.ini
COPY php-fpm-pool.conf /etc/php/7.2.3/pool.d/www.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

# Install dependencies:
# - nodejs: Compile assets
# - npm: Install node modules
# - yarn: Install & manage node modules [should make npm obsolete]
# - libpq-dev
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && \
    apt-get install -qq -y nodejs yarn \
    libpq-dev

RUN groupadd corporalabs -g 999
RUN useradd corporalabs -g corporalabs -d /home/corporalabs -m
# RUN chown corporalabs /home/www/corporalabs

RUN rm -rf /var/lib/apt/lists/*
RUN echo "es_ES.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen

WORKDIR /home/www/

EXPOSE 9000
CMD ["php-fpm"]
