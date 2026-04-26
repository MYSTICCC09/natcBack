FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql curl

WORKDIR /app
COPY . .

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]