# Accessing the service layer directly

You can access the giroapp service layer directly without passing a shell. Note
that to do so you should install giroapp as a composer dependency of your
project.

Se the `EnvironmentInterface`, `DonorQueryInterface` and `CommandBus` namespace
for more information on the service layer interface.

<!-- @ignore -->
```php
include 'vendor/autoload.php';

use byrokrat\giroapp\DependencyInjection\ProjectServiceContainer;
use byrokrat\giroapp\Plugin\EnvironmentInterface;

use byrokrat\giroapp\CommandBus\UpdatePhone;
use byrokrat\giroapp\CommandBus\Commit;

// path to configuration file
$iniFile = __DIR__ . '/.giroapp/giroapp.ini';

// MUST be set before ProjectServiceContainer is instantiated
putenv("GIROAPP_INI=$iniFile");

$giroappEnv = (new ProjectServiceContainer)->get(EnvironmentInterface::CLASS);

$commandBus = $giroappEnv->getCommandBus();
$donorQuery = $giroappEnv->getDonorQuery();

// Fetch some donor from storage
$donor = $donorQuery->requireByPayerNumber('12345');

// Update donor using one of the service layer commands
$commandBus->handle(new UpdatePhone($donor, '+461234567890'));

// NOTE that since Donor is immutable you need to refetch from storage to get changes
$donor = $donorQuery->requireByPayerNumber('12345');

echo $donor->getPhone();

// NOTE that a Commit command must be executed to persist changes!
$commandBus->handle(new Commit);
```
