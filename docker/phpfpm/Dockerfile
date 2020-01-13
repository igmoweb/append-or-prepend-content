FROM johnpbloch/phpfpm:7.2

RUN curl -L https://phar.phpunit.de/phpunit-6.5.8.phar > /tmp/phpunit.phar \
	&& chmod +x /tmp/phpunit.phar \
	&& mv /tmp/phpunit.phar /usr/local/bin/phpunit

CMD ["php-fpm"]

EXPOSE 9000
