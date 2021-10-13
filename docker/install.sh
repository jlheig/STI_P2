#!/bin/sh

dc_config_path=./docker-compose.yml

if [ ! -r $dc_config_path ]; then
    >&2 echo "$0 needs to be called from the project root directory"
    >&2 echo "$dc_config_path not found here"
    exit 1
fi

sys="$(expr substr $(uname -s) 1 10)"

if [ $sys == "MINGW32_NT" ] || [ $sys == "MINGW64_NT" ]; then
    winpty="winpty "
fi

DC="docker-compose -f $dc_config_path"

$winpty $DC down || /usr/bin/true
$winpty $DC up -d --build

# start the services
$winpty $DC exec -T sti_project service nginx start
$winpty $DC exec -T sti_project service php5-fpm start

# make sure nginx user owner of the sqlite file

$winpty $DC exec -T sti_project chown -R www-data:www-data ./usr/share/nginx/databases

# setup the database
$DC exec -T sti_project sqlite3 ./usr/share/nginx/databases/database.sqlite < ./docker/setup/init.sql
$DC exec -T sti_project sqlite3 ./usr/share/nginx/databases/database.sqlite < ./docker/setup/seed.sql