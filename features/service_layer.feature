Feature: Executing the service layer
    In order to write a GUI
    As a user
    I need to be able to access the service layer

    Scenario: I access the service layer
        Given a fresh installation
        And there are donors:
            | payer-number |
            | 12345        |
        And a file named "test.php":
            """
            <?php

            $installPath = getenv('GIROAPP_INSTALL_PATH');

            require "$installPath/vendor/autoload.php";

            use byrokrat\giroapp\DependencyInjection\ProjectServiceContainer;
            use byrokrat\giroapp\Plugin\EnvironmentInterface;
            use byrokrat\giroapp\CommandBus\UpdateName;
            use byrokrat\giroapp\CommandBus\Commit;

            $giroappEnv = (new ProjectServiceContainer)->get(EnvironmentInterface::CLASS);

            $commandBus = $giroappEnv->getCommandBus();
            $donorQuery = $giroappEnv->getDonorQuery();

            $donor = $donorQuery->requireByPayerNumber('12345');

            $commandBus->handle(new UpdateName($donor, 'new-custom-name'));
            $commandBus->handle(new Commit);
            """
        When i run raw command "php test.php"
        Then the database contains donor "12345" with "name" matching "new-custom-name"
