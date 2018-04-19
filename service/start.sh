#!/usr/bin/env bash

printenv | awk '{split($0,m,"="); print "export "m[1]"=\""m[2]"\""}' >> /root/.bashrc

php /var/www/bin/console d:d:c --if-not-exists && \
#php /var/www/bin/console swagger:export web/public/ -e dev --force && \
php /var/www/bin/console d:s:u --force && \
chmod -R 0777 /var/www/var/cache/ && \
chmod -R 0777 /var/www/var/logs/ && \
if [ -f /var/www/web/public/swagger.json ]; then
chmod -R 0777 /var/www/web/public/swagger.json
fi    && \
rm -Rf /var/www/var/cache/* && \
cp supervisor.conf /etc/supervisor/conf.d/ && \
supervisord
