# Updating from alpha-1

The `alpha-2` version contains some updates in the database schema that breaks
backwards compatability.

The sed script `alpha1-to-alpa2.sedscript` can update your `donors.json` to
the current syntax.

From your giroapp storage directory usage is as follows

```sh
cat data/donors.json | sed -f alpha1-to-alpa2.sedscript > data/donors.json
```

> NOTE! Make sure to make a copy of your data before updating.
