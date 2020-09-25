COMPOSER_CMD=composer
PHIVE_CMD=phive

PHPSPEC_CMD=tools/phpspec
BEHAT_CMD=tools/behat
README_TESTER_CMD=tools/readme-tester
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs
BOX_CMD=tools/box
SECURITY_CHECKER_CMD=tools/security-checker

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

$(TARGET): vendor/installed $(CONTAINER) $(SRC_FILES) bin/giroapp box.json.dist composer.lock $(BOX_CMD)
	$(COMPOSER_CMD) install --prefer-dist --no-dev
	$(BOX_CMD) compile
	$(COMPOSER_CMD) install

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

clean:
	rm $(TARGET) --interactive=no -f
	rm -rf vendor
	rm -rf tools

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

security_check: composer.lock $(SECURITY_CHECKER_CMD)
	$(SECURITY_CHECKER_CMD) security:check composer.lock

#
# Documentation
#

.PHONY: docs

docs: vendor/installed $(README_TESTER_CMD) $(STATE_GRAPH)
	$(README_TESTER_CMD) README.md docs

$(STATE_GRAPH): $(CONTAINER) $(ETC_FILES)
	bin/build_state_graph | dot -Tsvg -o $@

#
# Tests and analysis
#

.PHONY: test analyze phpspec behat debug check phpstan phpcs

test: phpspec behat

analyze: phpstan phpcs

phpspec: vendor/installed $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run

behat: vendor/installed $(BEHAT_CMD) $(CONTAINER)
	$(BEHAT_CMD) --stop-on-failure --suite=default

debug: vendor/installed $(BEHAT_CMD) $(CONTAINER)
	$(BEHAT_CMD) --stop-on-failure --suite=debug

check: vendor/installed $(BEHAT_CMD) $(TARGET)
	$(BEHAT_CMD) --stop-on-failure --suite=phar

phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -c phpstan.neon -l 7 src

phpcs: $(PHPCS_CMD)
	$(PHPCS_CMD) src --standard=PSR2 --ignore=$(CONTAINER)
	$(PHPCS_CMD) spec --standard=spec/ruleset.xml

#
# Dependencies
#

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

tools/installed: $(SECURITY_CHECKER_CMD)
	$(PHIVE_CMD) install --force-accept-unsigned --trust-gpg-keys CF1A108D0E7AE720 --trust-gpg-keys 31C7E470E2138192 --trust-gpg-keys 
	touch $@

$(PHPSPEC_CMD): tools/installed

$(BEHAT_CMD): tools/installed

$(README_TESTER_CMD): tools/installed

$(PHPSTAN_CMD): tools/installed

$(PHPCS_CMD): tools/installed

$(BOX_CMD): tools/installed

$(SECURITY_CHECKER_CMD):
	wget https://get.sensiolabs.org/security-checker.phar
	chmod u+x security-checker.phar
	mkdir -p tools
	mv security-checker.phar $(SECURITY_CHECKER_CMD)
