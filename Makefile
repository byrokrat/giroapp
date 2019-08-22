COMPOSER=composer

PHPSPEC=vendor/bin/phpspec
BEHAT=vendor/bin/behat
README_TESTER=vendor/bin/readme-tester
PHPSTAN=vendor/bin/phpstan
PHPCS=vendor/bin/phpcs
BOX=vendor/bin/box
SECURITY_CHECKER=vendor/bin/security-checker

ETC_FILES=$(shell find etc/ -type f -name '*')
SRC_FILES=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER))

TARGET=giroapp.phar
CONTAINER=src/DependencyInjection/ProjectServiceContainer.php
STATE_GRAPH=docs/states.svg

.DEFAULT_GOAL := all

.PHONY: all build clean maintainer-clean

all: test analyze docs build check

build: preconds $(TARGET)

$(TARGET): vendor $(BOX) $(CONTAINER) $(SRC_FILES) bin/giroapp box.json.dist
	$(COMPOSER) install --prefer-dist --no-dev
	$(BOX) compile
	$(COMPOSER) install

$(CONTAINER): vendor $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

clean:
	rm $(TARGET) --interactive=no -f
	rm -rf vendor
	rm -rf vendor-bin

maintainer-clean: clean
	@echo 'This command is intended for maintainers to use; it'
	@echo 'deletes files that may need special tools to rebuild.'
	rm $(CONTAINER) -f
	rm $(STATE_GRAPH) -f

#
# Build preconditions
#

.PHONY: preconds dependency_check security_check

preconds: dependency_check security_check

dependency_check: vendor
	$(COMPOSER) validate --strict
	$(COMPOSER) outdated --strict --direct --minor-only

security_check: vendor $(SECURITY_CHECKER)
	$(SECURITY_CHECKER) security:check composer.lock

#
# Documentation
#

.PHONY: docs

docs: vendor $(README_TESTER) $(STATE_GRAPH)
	$(README_TESTER) README.md docs

$(STATE_GRAPH): $(CONTAINER) $(ETC_FILES)
	bin/build_state_graph | dot -Tsvg -o $@

#
# Tests and analysis
#

.PHONY: test analyze phpspec behat debug check phpstan phpcs

test: phpspec behat

analyze: phpstan phpcs

phpspec: vendor $(PHPSPEC)
	$(PHPSPEC) run

behat: vendor $(BEHAT) $(CONTAINER)
	$(BEHAT) --stop-on-failure --suite=default

debug: vendor $(BEHAT) $(CONTAINER)
	$(BEHAT) --stop-on-failure --suite=debug

check: vendor $(BEHAT) $(TARGET)
	$(BEHAT) --stop-on-failure --suite=phar

phpstan: vendor $(PHPSTAN)
	$(PHPSTAN) analyze -c phpstan.neon -l 7 src

phpcs: vendor $(PHPCS)
	$(PHPCS) src --standard=PSR2 --ignore=$(CONTAINER)
	$(PHPCS) spec --standard=spec/ruleset.xml

#
# Dependencies
#

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor: composer.lock
	composer install

$(PHPSPEC):
	$(COMPOSER) bin phpspec require phpspec/phpspec:^5

$(BEHAT):
	$(COMPOSER) bin behat require behat/behat:^3

$(README_TESTER):
	$(COMPOSER) bin readme-tester require hanneskod/readme-tester:^1.0@beta

$(PHPSTAN):
	$(COMPOSER) bin phpstan require "phpstan/phpstan:<2"

$(PHPCS):
	$(COMPOSER) bin phpcs require squizlabs/php_codesniffer:^3

$(BOX):
	$(COMPOSER) bin box require humbug/box:^3

$(SECURITY_CHECKER):
	$(COMPOSER) bin security-checker require sensiolabs/security-checker
