![byrokrat](res/logo.svg)

# Giroapp

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/giroapp.svg?style=flat-square)](https://packagist.org/packages/byrokrat/giroapp)
[![Build Status](https://img.shields.io/travis/byrokrat/giroapp/master.svg?style=flat-square)](https://travis-ci.com/github/byrokrat/giroapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/giroapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/giroapp)

Command line app for managing autogiro donations.

## Installation

### Using phive (recommended)

Install using [phive][3]

```shell
phive install byrokrat/giroapp
```

### As a phar archive

Download the latest phar archive from the [releases][1] tab.

Optionally rename `giroapp.phar` to `giroapp` for a smoother experience.

### Using composer

Install as a [composer][2] dependency

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

The build script uses [composer][2] to handle dependencies and [phive][3] to
handle build tools. If they are not installed as `composer` or `phive`
respectivly you can use something like

```shell
make COMPOSER_CMD=./composer.phar PHIVE_CMD=./phive.phar
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

* [giroapp-completion-plugin][4]: shell completion.
* [giroapp-mailer-plugin][5]: send mails on giroapp events.

[1]: <https://github.com/byrokrat/giroapp/releases>
[2]: <https://getcomposer.org/>
[3]: <https://phar.io/>
[4]: <https://github.com/byrokrat/giroapp-completion-plugin>
[5]: <https://github.com/byrokrat/giroapp-mailer-plugin>
