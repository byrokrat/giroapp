#!/usr/bin/env sh
set -e

phpspec run
#behat --stop-on-failure
phpcs
