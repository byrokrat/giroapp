#!/usr/bin/env sh
set -e

vendor/bin/phpspec run

vendor/bin/behat --stop-on-failure

vendor/bin/phpcs src --standard=PSR2 --ignore=src/ProjectServiceContainer.php

vendor/bin/phpcs spec --standard=spec/ruleset.xml
