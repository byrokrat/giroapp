# UPDATING

## Unreleased changes

* Donors can now be identified by name at command line. Use `--id-payer-number`
  and `--id-mandate-key` flags to force id to be payer number or mandate key..

## Updating to beta-1

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
