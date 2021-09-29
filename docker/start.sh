#!/bin/sh

# create container + volume with site and database
docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8888:80 --name sti_project --hostname sti arubinst/sti:project2018

# start the services
docker exec -u root sti_project service nginx start
docker exec -u root sti_project service php5-fpm start

# change the ownership of the website and database to the nginx user
docker exec -u root sti_project chown -R www-data:www-data /usr/share/nginx/html
docker exec -u root sti_project chown -R www-data:www-data /usr/share/nginx/databases