FROM vincentchalamon/symfony:wheezy-php55

WORKDIR /root

RUN sed -ri 's/\[www\]/[www]\nenv[SYMFONY_ENV]="dev"/' /etc/php5/fpm/pool.d/www.conf

WORKDIR /var/www

ENV PATH /root/.composer/vendor/bin:$PATH

ADD docker/vhost.conf /etc/nginx/sites-available/default

EXPOSE 8888
