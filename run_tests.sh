#!/usr/bin/env sh
set -e

vendor/bin/phpspec run

# TODO add behat to travis once we have a context...
# vendor/bin/behat --stop-on-failure

vendor/bin/phpcs --standard=PSR2 src

vendor/bin/phpcs --standard=spec/ruleset.xml spec
