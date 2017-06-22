#!/usr/bin/env sh
set -e

vendor/bin/phpspec run

# vendor/bin/behat --stop-on-failure
# TODO add behat to travis once we have a context...

vendor/bin/phpcs
