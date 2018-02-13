FROM wordpress:4.8.3-php7.1-apache

# Install zip extension
RUN docker-php-ext-install zip

# Add WP-CLI
RUN curl -o /bin/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x /bin/wp-cli.phar

# Add composer
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/bin/composer





