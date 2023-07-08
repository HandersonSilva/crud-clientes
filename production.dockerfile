FROM php:7.2

# Instala dependências
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libzip-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  gettext-base \
  zip \
  unzip \
  libmagickwand-dev \
  git \
  curl \
  vim \
  libxml2-dev \
  zlib1g-dev \
  libpq-dev \
  && curl -sL https://deb.nodesource.com/setup_12.x | bash - &&\
  apt-get install -y nodejs

RUN rm -rf /var/lib/apt/lists/*

#instal redis
RUN pecl install redis
RUN docker-php-ext-install mysqli pdo_mysql soap bcmath gd zip
RUN docker-php-ext-enable redis
RUN docker-php-ext-install pcntl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Id do usuário
ARG USER_ID=1000

# Copiando scripts e config necessários para dentro da imagem.
COPY ./docker/php/docker-start.sh /docker/docker-start.sh
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copia o diretório da aplicação para o container
COPY ./src /var/www/html

WORKDIR /var/www/html

RUN rm -rf /var/www/html/composer.lock
RUN composer install

RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap

# Altera permissão de execução para o script entrypoint
RUN chmod +x /docker/docker-start.sh \
    # Cria grupo, usuário e o atribui ao grupo
   && useradd -u ${USER_ID} -g www-data --shell /bin/bash --create-home switch

# Altera o usuário para "switch"
#USER switch

EXPOSE 9000

# Script de inicialização do container
ENTRYPOINT ["/docker/docker-start.sh"]