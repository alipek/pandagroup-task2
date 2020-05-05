FROM php:7.4.5

RUN curl https://gist.githubusercontent.com/alipek/46b4e29a6627b057b3caaab1bbf5c65b/raw/c12faf968e659356ec1cb53f313e7f8383836be3/getcomposer.sh | bash - \
    && docker-php-ext-install pdo_mysql