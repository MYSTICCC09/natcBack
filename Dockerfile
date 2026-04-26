FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /app
COPY . .

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]

RUN apt-get update && apt-get install -y curl libcurl4-openssl-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql curl