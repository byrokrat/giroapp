# ງir໐คpp

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/giroapp.svg?style=flat-square)](https://packagist.org/packages/byrokrat/giroapp)
[![Build Status](https://img.shields.io/travis/byrokrat/giroapp/master.svg?style=flat-square)](https://travis-ci.org/byrokrat/giroapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/giroapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/giroapp)

Command line app for managing autogiro donations.

## Installation

1. Download the latest phar archive from the [releases](https://github.com/byrokrat/giroapp/releases) tab.

2. Copy `giroapp.phar` to desired installation target (for example `/opt`).

3. Optionally rename `giroapp.phar` => `giroapp`.

4. Optionally change your user directory path. See below.

5. Copy [`giroapp.ini.dist`](giroapp.ini.dist) to `giroapp.ini` in you user directory.

6. Edit `giroapp.ini` to your needs.

### Changing the user directory path

By default giroapp keeps database and other installation specific files in a
directory named `giroapp` in current working directory. This might not be
optimal for a number of reasons (something like `/var/lib/giroapp` would
for example be better from a security perspective).

Change the user directory path by creating a `GIROAPP_PATH` environment variable
pointing to the desired directory.

### Adding plugins

Giroapp supports dynamic [plugins](docs/plugins.md). Officially supported plugins:

* [Mailer](https://github.com/byrokrat/giroapp-mailer-plugin): send mails on giroapp events.

## Building

Giroapp uses [bob](https://github.com/CHH/bob) to run tests and build artifacts.

To complete a build you must first install some dependencies.

```shell
composer global require chh/bob:^1.0@alpha
bob install_dev_tools
composer install
```

Make sure to have the global composer bin directory in your include path.

```shell
export PATH=$PATH:~/.composer/vendor/bin/
```

Build project from within the project directory tree

```shell
bob
```

Or for more information run

```shell
bob --tasks
```
