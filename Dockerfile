# Build stage
FROM yiisoftware/yii2-php:8.2-apache AS build

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-cache --no-dev --prefer-dist --no-progress --no-interaction --no-scripts
COPY . /app
RUN composer install --no-cache --no-dev --prefer-dist --no-progress --no-interaction

# Production stage
FROM yiisoftware/yii2-php:8.2-apache AS prod

WORKDIR /app
COPY --from=build /app /app

# Set permissions
RUN chmod -R 777 runtime web/assets web/uploads

# Expose port
EXPOSE 80

# Apache will start automatically
CMD ["apache2-foreground"]
