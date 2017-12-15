# Updating from alpha-1

The `alpha-2` version contains some important changes.

## Notable changes

* Added `edit`, `remove`, `revoke`, `show`, `status`, `ls` and `validate` commands.
* Support importing xml formatted online mandates.
* Error is emitted if the same file is imported twice.
* Drastically improved test suite.
* Updated dependencies, most importantly giroapp now depends on `php 7.1` and the
  `SimpleXML` extension.
* Event names have been altered. Inspect [`Events`](/src/Events.php) and update your plugins..
* When adding a new mandate the payer number now defaults to the donor personal id.
  This means that if you add a mandate from the command line in non-interative mode
  and don't specify a payer number the personal id will be used (previously an
  error was thrown).

```shell
giroadd add -id xxxxxx-xxxx -n
```

## How to update

It is recomended that you reinstall giroapp when updating to alpha-2. (Doing a
`git pull` + `composer update` may lead to errors for multiple reasons.)

1. Make a copy of your database and aplha-1 installation.

2. `cd` to the desired installation directory (for example `cd /opt`).

3. Install using composer

```shell
composer create-project byrokrat/giroapp:1.0.0-alpha2 --no-interaction --no-dev
```

4. Add `/opt/giroapp/bin` to your environment `PATH`.

5. Update the database. See below.

### Updating the database

Alpha2 contains some updates in the database schema that breaks backwards
compatability.

> NOTE! Make sure to make a copy of your data before continuing.

You may use

```sh
giroapp validate
```

to validate the integrity of the database. After updating to alpha-2 running
validate will trigger a lot of errors.

To update your db use the sed script `alpha1-to-alpha2.sedscript` and the `migrate`
command as follows (where `my-giroapp-dir` points to your giroapp content directory).

```sh
cat my-giroapp-dir/data/donors.json | sed -f alpha1-to-alpha2.sedscript > updated-donors.json
cp updated-donors.json my-giroapp-dir/data/donors.json
giroapp migrate
giroapp validate
```

The validate command shoud now inform you that all errors are fixed.
