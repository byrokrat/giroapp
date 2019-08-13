# ງir໐คpp

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/giroapp.svg?style=flat-square)](https://packagist.org/packages/byrokrat/giroapp)
[![Build Status](https://img.shields.io/travis/byrokrat/giroapp/master.svg?style=flat-square)](https://travis-ci.org/byrokrat/giroapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/giroapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/giroapp)

Command line app for managing autogiro donations.

## Installation

1. Download the latest phar archive from the [releases](https://github.com/byrokrat/giroapp/releases) tab.

2. Optionally drop the `.phar` extension.

3. Run `giroapp init` to create a default `giroapp.ini` in the current directory.

4. Edit `giroapp.ini` using a standard text editor.

5. Optionally specify the location of the configuration file. See below.

### Specifying the location of giroapp.ini

By default giroapp looks for configurations in a file called `giroapp.ini` in
the current working directory. Tell giroapp where to look for configurations
be defining a `GIROAPP_INI` environment variable.

## Plugins

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
