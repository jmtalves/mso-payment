FROM phpdockerio/php:8.2-fpm
WORKDIR "/var/www/html"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.2-bz2 \ 
        php8.2-gd \ 
        php8.2-gmagick \ 
        php8.2-http \ 
        php8.2-igbinary \ 
        php8.2-imap \ 
        php8.2-mcrypt \ 
        php8.2-memcache \ 
        php8.2-memcached \ 
        php8.2-mysql \ 
        php8.2-redis \ 
        php8.2-snmp \ 
        php8.2-soap \ 
        php8.2-xdebug \ 
        php8.2-yaml \
        supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY ./ /var/www/html

COPY supervisord/* /etc/supervisor/

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]