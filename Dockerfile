# File: Dockerfile
# 베이스 이미지로 PHP 8.0과 Apache 서버가 포함된 이미지를 사용합니다.
FROM php:8.0-apache

# GD 라이브러리 설치에 필요한 패키지들을 설치합니다.
RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# GD PHP 확장 모듈을 설치하고 활성화합니다.
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install -j$(nproc) gd

# 데이터베이스 연동을 위한 mysqli 확장 모듈을 설치합니다.
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Apache의 mod_rewrite 모듈을 활성화합니다. (옵션)
RUN a2enmod rewrite

# 작업 디렉토리를 /var/www/html로 설정합니다.
WORKDIR /var/www/html