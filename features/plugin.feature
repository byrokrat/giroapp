Feature: Plugins
  In order to create custom setups
  As a user
  I need to be able to register plugins

  Scenario: I register a plugin
    Given a fresh installation
    And a plugin:
        """
        use Symfony\Component\EventDispatcher\EventSubscriberInterface;
        use byrokrat\giroapp\Events;

        class TestPlugin implements EventSubscriberInterface
        {
            public static function getSubscribedEvents()
            {
                return [
                    Events::EXECUTION_START_EVENT => 'onExecutionStart'
                ];
            }

            public function onExecutionStart()
            {
                echo "my-cool-plugin-is-executed";
            }
        }
        """
    When I run "status"
    Then the output contains "my-cool-plugin-is-executed"
