#!/usr/bin/env bash
set -e

# get env vars
if [ -n "${SSM_PATH+x}" ]; then
  eval "$(awsenv)"
fi

CONSOLE="/var/www/bin/console"

if [ -f ${CONSOLE} ]; then
    # Migrate database if artisan exists
    /usr/local/bin/php ${CONSOLE} doctrine:clear:metadata:cache || exit 1
    /usr/local/bin/php ${CONSOLE} doctrine:migrations:migrate || exit 1
    /usr/local/bin/php ${CONSOLE} doctrine:generate:proxies || exit 1
    /usr/local/bin/php ${CONSOLE} doctrine:clear:metadata:cache || exit 1
    /usr/local/bin/php ${CONSOLE} doctrine:clear:result:cache || exit 1
    /usr/local/bin/php ${CONSOLE} doctrine:clear:query:cache || exit 1
    exit 0
fi

exit 1