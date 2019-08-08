#!/usr/bin/env bash
set -e

# get env vars
if [ -n "${SSM_PATH+x}" ]; then
  eval "$(awsenv)"
fi

ENV=${APP_ENV:-prod}
ROLE=${CONTAINER_ROLE:-api}

if [ "$ENV" != "local" ]; then
    echo "Removing Xdebug..."
    rm -rf /usr/local/etc/php/conf.d/{docker-php-ext-xdebug,xdebug}.ini
fi

CONSOLE="/var/www/bin/console"

#if [ -f ${CONSOLE} ]; then
#    echo "configure shell for www-data"
#    chsh -s /bin/bash www-data
#
#    echo "doctrine:clear:metadata:cache"
#    /bin/su -c "/usr/local/bin/php ${CONSOLE} doctrine:clear:metadata:cache" - www-data
#
#    echo "doctrine:clear:result:cache"
#    /bin/su -c "/usr/local/bin/php ${CONSOLE} doctrine:clear:result:cache" - www-data
#
#    echo "doctrine:clear:query:cache"
#    /bin/su -c " /usr/local/bin/php ${CONSOLE} doctrine:clear:query:cache" - www-data
#
#    echo "doctrine:generate:proxies"
#    /bin/su -c "/usr/local/bin/php ${CONSOLE} doctrine:generate:proxies" - www-data
#fi

#if [ "$ROLE" == "cron" ]; then
#    while true; do
#        php /var/www/artisan schedule:run --verbose --no-interaction &
#        sleep 60
#    done
#else
#    exec "$@"
#fi

exec "$@"