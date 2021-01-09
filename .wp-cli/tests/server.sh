#!/bin/bash
#
# Create a WordPress installation and run a server

mkdir -p /home/www-data/.wp-cli/tests
cd /home/www-data/.wp-cli/tests

wp core download --path=.wordpress
wp db query "CREATE DATABASE IF NOT EXISTS wordpress; CREATE DATABASE IF NOT EXISTS tests"

wp server --host=0.0.0.0 --docroot=.wordpress
