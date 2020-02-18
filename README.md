# :money_with_wings: GIROAPP

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/giroapp.svg?style=flat-square)](https://packagist.org/packages/byrokrat/giroapp)
[![Build Status](https://img.shields.io/travis/byrokrat/giroapp/master.svg?style=flat-square)](https://travis-ci.org/byrokrat/giroapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/giroapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/giroapp)

Command line app for managing autogiro donations.

## Installation

### As a phar archive (recommended)

Download the latest phar archive from the
[releases](https://github.com/byrokrat/giroapp/releases) tab.

Optionally rename `giroapp.phar` to `giroapp` for a smoother experience.

### Through composer

```shell
composer require byrokrat/giroapp
```

This will make `giroapp` avaliable as `vendor/bin/giroapp`.

### From source

To build you need `make`

```shell
make
sudo make install
```

If composer is not installed as `composer` you can use something like

```shell
make COMPOSER_CMD=./composer.phar
```

## Getting started

By default giroapp looks for configurations in a file called `giroapp.ini` in
the current working directory. Tell giroapp where to look for configurations
be defining a `GIROAPP_INI` environment variable.

Run `giroapp init` to create a default `giroapp.ini` in the current working
directory. Edit using a standard text editor.

Simply run `giroapp` to se the list of avaliable commands.

## Plugins

Giroapp supports dynamic [plugins](docs/plugins.md). Officially supported plugins:

* [giroapp-completion-plugin](https://github.com/byrokrat/giroapp-completion-plugin): shell completion.
* [giroapp-mailer-plugin](https://github.com/byrokrat/giroapp-mailer-plugin): send mails on giroapp events.
