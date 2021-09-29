#!/bin/sh

dc_config_path=./docker-compose.yml

if [ ! -r $dc_config_path ]; then
    >&2 echo "$0 needs to be called from the project root directory"
    >&2 echo "$dc_config_path not found here"
    exit 1
fi

DC="docker-compose -f $dc_config_path"

$DC down || /usr/bin/true
$DC up -d --build

# start the services
$DC exec sti_project service nginx start
$DC exec sti_project service php5-fpm start

$DC exec sti_project chown -R www-data:www-data /usr/share/nginx/databases