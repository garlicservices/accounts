FROM garlic/base

MAINTAINER Maksym Churkyn <imaximius@gmail.com>

# Set timezone
RUN echo Europe/Kiev >/etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata \
    && echo 'date.timezone=Europe/Kiev' >> /usr/local/etc/php/conf.d/timezone.ini

# Install LDAP ext
RUN apt-get update && \
    apt-get install -y libldap2-dev libssl-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# Copy the project
COPY . /var/www/

# Run Composer install
RUN mkdir -p /var/www/vendor \
 && cd /var/www/ \
 && composer install --no-dev --no-suggest --no-progress 2>&1

WORKDIR /var/www/

# Add entrypoint
ADD start.sh .
RUN chmod +x start.sh

CMD ["/bin/bash", "start.sh"]