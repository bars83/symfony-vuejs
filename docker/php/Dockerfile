ARG CI_REGISTRY_IMAGE
ARG CI_COMMIT_REF_SLUG

FROM $CI_REGISTRY_IMAGE/php-base:$CI_COMMIT_REF_SLUG

COPY --chown=www-data:www-data ./bin /var/www/html/bin
COPY --chown=www-data:www-data ./config /var/www/html/config
COPY --chown=www-data:www-data ./src /var/www/html/src
COPY --chown=www-data:www-data ./templates /var/www/html/templates
COPY --chown=www-data:www-data ./translations /var/www/html/translations
COPY --chown=www-data:www-data ./var /var/www/html/var
COPY --chown=www-data:www-data ./vendor /var/www/html/vendor
COPY --chown=www-data:www-data ./composer.json /var/www/html/composer.json
COPY --chown=www-data:www-data ./composer.lock /var/www/html/composer.lock
COPY --chown=www-data:www-data ./symfony.lock /var/www/html/symfony.lock
COPY --chown=www-data:www-data ./public/index.php /var/www/html/public/index.php
COPY --chown=www-data:www-data ./public/build/entrypoints.json /var/www/html/public/build/entrypoints.json
COPY --chown=www-data:www-data ./public/build/manifest.json /var/www/html/public/build/manifest.json

ARG BUILD_TIME

ENV BUILD_TIME_ENV=$BUILD_TIME

ENV IS_CI=true

RUN echo $BUILD_TIME_ENV && echo $IS_CI

#USER root
#
#RUN mkdir -p /var/www/html/app/cache /var/www/html/app/logs && chown -R www-data:www-data /var/www/html/app/cache /var/www/html/app/logs

USER www-data

CMD php bin/console doctrine:migrations:migrate && php-fpm

cat > public/build/manifest.json <<EOF
{
  "build/0.eb225194.js": "/build/0.eb225194.js",
  "build/app.js": "/build/app.595c0e8c.js"
}
EOF
