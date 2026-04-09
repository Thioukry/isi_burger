# Utilisation de l'image PHP officielle avec FPM
FROM php:8.2-fpm

# Installation des dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Nettoyage du cache pour réduire la taille de l'image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP indispensables pour Laravel et MySQL
# Ajout de 'zip' qui est souvent requis par Composer
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installation de Composer (Copie depuis l'image officielle)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www

# Copie de tout le projet dans le conteneur
COPY . /var/www


# On installe sans lancer les scripts (pour éviter l'erreur package:discover)
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts

# Ajustement des permissions pour Laravel (indispensable pour le stockage)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exposition du port interne
EXPOSE 9000

CMD ["php-fpm", "-F"]
