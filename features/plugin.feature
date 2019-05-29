Feature: Plugins
  In order to create custom setups
  As a user
  I need to be able to register plugins

  Scenario: I register a plugin
    Given a fresh installation
    And a plugin:
        """
        use byrokrat\giroapp\Plugin\PluginInterface;
        use byrokrat\giroapp\Plugin\EnvironmentInterface;
        use byrokrat\giroapp\Event\ExecutionStarted;
        use Symfony\Component\EventDispatcher\EventSubscriberInterface;

        class TestPlugin implements PluginInterface
        {
            public function loadPlugin(EnvironmentInterface $environment): void
            {
                $environment->registerSubscriber(new class implements EventSubscriberInterface {
                    public static function getSubscribedEvents()
                    {
                        return [ExecutionStarted::CLASS => 'onExecutionStart'];
                    }

                    public function onExecutionStart()
                    {
                        echo "my-cool-plugin-is-executed";
                    }
                });
            }
        }

        return new TestPlugin;
        """
    When I run "ls"
    Then the output contains "my-cool-plugin-is-executed"
