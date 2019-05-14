# Updating to alpha-5

> This is the guide for updating from alpha-3 or 4 to alpha-5. Instructions for updating
> from alpha-2 can be fund [here](https://github.com/byrokrat/giroapp/blob/1.0.0-alpha3/UPDATING.md).

## Notable changes in alpha-5

* Added more filters.
* Multiple filters are now allowed with the `ls` command.
* Adds support for negated filters using the `--filter-not` option.
* Added sorters.
* Added posibility to load custom donor states through plugins.
* Supports importing files from multiple files and directories.
* Better exception handling with error codes.
* All paths are now specified using `giroapp.ini` directives. See `giroapp.ini.dist`.
  You will need to patch your local copy with the new settings.
* Some default directory names have changed, specificaly the `var` directory
  is no longer used.
* Replaced `GIROAPP_PATH` environment variable with `GIROAPP_INI` pointing to the
  `giroapp.ini` to use. Update your environment accordingly.
* Plugins may now specify api version constraints.
* Logging con now be configured in `giroapp.ini`.
* Removed the `validate` command.
* Removed the `migrate` command.
* Requires php `>= 7.2`.
* New database interface and the possibility to add custom databases through plugins..
* Renamed `Console/CommandInterface` => `Console/ConsoleInterface` and
  `Plugin/EnvironmentInterface::registerCommand()` => `Plugin/EnvironmentInterface::registerConsoleCommand()`.
