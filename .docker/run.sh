#!/bin/bash


# Set Default php version for the system
update-alternatives --set php /usr/bin/php7.4

#PHP start using fpm
/etc/init.d/php7.2-fpm stop
/etc/init.d/php7.4-fpm start

# Server start
/etc/init.d/nginx start

while [[ true ]]; do
    sleep 1
done
