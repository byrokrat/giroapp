PHPSPEC=vendor/bin/phpspec
BEHAT=vendor/bin/behat
README_TESTER=vendor/bin/readme-tester
PHPSTAN=vendor/bin/phpstan
PHPCS=vendor/bin/phpcs
BOX=vendor/bin/box
SECURITY_CHECKER=vendor/bin/security-checker

COMPOSER_CMD=composer

TARGET=giroapp.phar
DESTDIR=/usr/local/bin
CONTAINER=src/DependencyInjection/ProjectServiceContainer.php
STATE_GRAPH=docs/states.svg

ETC_FILES:=$(shell find etc/ -type f -name '*')
SRC_FILES:=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER))

.DEFAULT_GOAL=all

.PHONY: all build clean maintainer-clean

all: test analyze docs build check

build: preconds $(TARGET)

$(TARGET): vendor-bin/installed $(CONTAINER) $(SRC_FILES) bin/giroapp box.json.dist composer.lock
	$(COMPOSER_CMD) install --prefer-dist --no-dev
	$(BOX) compile
	$(COMPOSER_CMD) install

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
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
# Install/uninstall
#

.PHONY: install uninstall

install: $(TARGET)
	mkdir -p $(DESTDIR)
	cp $< $(DESTDIR)/giroapp

uninstall:
	rm -f $(DESTDIR)/giroapp

#
# Build preconditions
#

.PHONY: preconds dependency_check security_check

preconds: dependency_check security_check

dependency_check: vendor/installed
	$(COMPOSER_CMD) validate --strict
	$(COMPOSER_CMD) outdated --strict --minor-only

security_check: vendor/installed $(SECURITY_CHECKER)
	$(SECURITY_CHECKER) security:check composer.lock

#
# Documentation
#

.PHONY: docs

docs: vendor-bin/installed $(STATE_GRAPH)
	$(README_TESTER) README.md docs

$(STATE_GRAPH): $(CONTAINER) $(ETC_FILES)
	bin/build_state_graph | dot -Tsvg -o $@

#
# Tests and analysis
#

.PHONY: test analyze phpspec behat debug check phpstan phpcs

test: phpspec behat

analyze: phpstan phpcs

phpspec: vendor-bin/installed
	$(PHPSPEC) run

behat: vendor-bin/installed $(CONTAINER)
	$(BEHAT) --stop-on-failure --suite=default

debug: vendor-bin/installed $(CONTAINER)
	$(BEHAT) --stop-on-failure --suite=debug

check: vendor-bin/installed $(TARGET)
	$(BEHAT) --stop-on-failure --suite=phar

phpstan: vendor-bin/installed
	$(PHPSTAN) analyze -c phpstan.neon -l 7 src

phpcs: vendor-bin/installed
	$(PHPCS) src --standard=PSR2 --ignore=$(CONTAINER)
	$(PHPCS) spec --standard=spec/ruleset.xml

#
# Dependencies
#

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

vendor-bin/installed: vendor/installed
	$(COMPOSER_CMD) bin phpspec require phpspec/phpspec:^5
	$(COMPOSER_CMD) bin behat require behat/behat:^3
	$(COMPOSER_CMD) bin readme-tester require hanneskod/readme-tester:^1.0@beta
	$(COMPOSER_CMD) bin phpstan require "phpstan/phpstan:<2"
	$(COMPOSER_CMD) bin phpcs require squizlabs/php_codesniffer:^3
	$(COMPOSER_CMD) bin box require humbug/box:^3
	$(COMPOSER_CMD) bin security-checker require sensiolabs/security-checker
	touch $@
