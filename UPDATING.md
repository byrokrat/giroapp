# UPDATING

## Beta-9

* Renamed `import-xml-mandate` => `import-xml-mandates`
* No longer required to review each field of an imported xml mandate separately
* Added the `view-xml-mandates` command
* Made it possible to revoke paused mandates.
* Update db json schema versions to 1.0
* Fixed a bugg where imported files where stored when import failed
* Imported xml mandate files are now stored in the `imports_dir` directory
* Added support for the `--force` option in the `import-xml-mandates` command
* Added `always_force_imports` setting
* Added `--all` and `--show` options to the `status` command
* Removed named stat options from `status` command (eg. `--donor-count`,
  use `--show donor-count` instead)
* Added status hook for plugins

## Beta-8

* Made online form default source in add command.
* Made it possible to listen to `NEW_MANDATE` and `NEW_DIGITAL_MANDATE` events.
* Add support for setting donor values to an empty string in `edit`
* Added `delete-attribute` command
* Added the `import-xml-mandate` command, replaces import xml using `import`
* Added support for inspecting and editing imported xml mandate data
* Added support for configuring xml import using ini-settings and plugins

## Beta-7

* Added the `mailstr` formatter.
* Fixed a fatal error when organization id was entered as a person id.
* Fixed a bugg where init could not work if no giroapp.ini existed.

## Beta-6

* Moved shell completion to plugin.

## Beta-5

* Fix a bug to allow active donors to remov specific transactions.

## Beta-4

Beta-4 adds a few minor features and can simply be dumped in place of beta-1, 2
or 3. When updating from an alpha version se `Beta-1` below..

### Notable changes in beta-4

* Added the `conf` command to programmatically access configurations.
* Added support for bash autocompletion.

## Beta-3

Beta-3 is generally a bug-fix release and the phar can simply be dumped in place
of beta-1 or beta-2. When updating from an alpha version se `Beta-1` below..

### Notable changes in beta-3

* Prints a trace on foreign errors when in verbose mode.
* Run all commands after input is read to avoid confusion in plugins on SIGTERM.
* Add `rm` as an alias for `remove`.
* Using `moneyphp\money` for monetary amounts.
* Make sure that releases are built using the lowest supported php version.

## Beta-2

Beta-2 is generally a bug-fix release and the phar can simply be dumped in place
of beta-1. When updating from an alpha version se `Beta-1` below..

### Notable changes in beta-2

* Donors can now be identified by name at command line. Use `--id-payer-number`
  and `--id-mandate-key` flags to force id to be payer number or mandate key..
* Fixed a bug where transaction reports imported after a state change failed.
* Fixed a bug where importing removed transactions on revoked donors failed.

## Beta-1

> This is the guide for updating from alpha-5 to beta-1. Instructions for updating
> from alpha-3 or 4 can be fund [here](https://github.com/byrokrat/giroapp/blob/1.0.0-alpha5/UPDATING.md).

### Notable changes in beta-1

* Added the `log_format` ini setting and fixed broken `log_level` compliance.
* Added a donor event store database. Please see `Updating the database` below.
* Fixed bugg #190, donor addresses no longer fails when unknown fields are present.
* Renamed `inactive` filter `revoked`.
* Support the complete pause-restart cycle.
* Now records transaction reports to `DonorEventStore`.
* Added the `transactions` command to inspect recorded transactions.
* The `edit-state` command now always forces new state.
* Added the possibility to change donation amounts using the `edit-amount` command.
  Note that the `edit` command no longer handles new amounts.
* Added the `edit-payer-number` command to change payer number. Experimental.
* Added a `init` command to simplify the installation process.

### Updating the database

Beta-1 contains some BC-breaking changes to the database schema. Update your raw
json databse file using the `update_db.php` script.

> NOTE: The `update_db.php` script has been dropped from master:head. Checkout
> beta-1 to access.

> NOTE: Backup the contents of your database before continuing!

> NOTE: For this script to run it must be used DIRECTLY after updating. If the
> giroapp executable is used before this script an empty `donor_events.json_lines`
> file will be created in the json database directory. If that occurs you must
> delete the `donor_events.json_lines` file before running `update_db.php`.

Usage:

```shell
php update_db.php <path-to-json-database-directory>
```

Running this script creates two new files in the json database directory.

* `donors_fixed.json` contains the translated contents of `donors.json`. Rename to
  `donors.json` to complete the transition.
* `donor_events.json_lines` contains the event store database generated from `donors.json`.
  Leave this file as is.
