#!/usr/bin/env bash

composer install

ln -s $(pwd)/medea_web/ web/profiles/medea_web

cd web && drush si medea_web

drush uli