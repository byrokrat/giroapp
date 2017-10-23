# Updating from alpha-1

The `alpha-2` version contains some important changes.

## Dependencies

Depends on php 7.1
Depends on the SimpleXML extension.

## CLI

When adding a new mandate payer number now defaults to donor personal id. This
means that if you add a mandate from the command line in non-interative mode
and don't specify a payer number the personal id will be used (previously an
error was thrown).

```shell
giroadd add -id xxxxxx-xxxx -n
```

## Database

Contains some updates in the database schema that breaks backwards compatability.

The sed script `alpha1-to-alpa2.sedscript` can update your `donors.json` to
the current syntax.

From your giroapp storage directory usage is as follows

```sh
cat data/donors.json | sed -f alpha1-to-alpa2.sedscript > data/donors.json
```

> NOTE! Make sure to make a copy of your data before updating.
