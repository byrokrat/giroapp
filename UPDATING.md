# Updating to alpha-3

> This is the guide for updating from alpha-2 to alpha-3. Instructions for updating
> from alpha-1 can be fund [here](https://github.com/byrokrat/giroapp/blob/1.0.0-alpha2/UPDATING.md).

## Notable changes in alpha-3

* Fix bug #145. Now able to import files outside of current working directory.
* Export no longer writes to stdout, it generates files instead.
* Renaming in the `Xml` namespace.
* You now need to create one `XmlFormInterface` object for each supporten xml form.
* Supports plugins
* Added `state_desc` to donor schema. Run `giroapp migrate` to update database.
* Settings are now read from `giroapp.ini`. See `giroapp.ini.dist` for an example.
* Removed the `init` command.
