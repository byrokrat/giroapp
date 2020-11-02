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

        class TestPlugin implements PluginInterface
        {
            public function loadPlugin(EnvironmentInterface $environment): void
            {
                $environment->registerListener(function (ExecutionStarted $event) {
                    echo "my-cool-plugin-is-executed";
                });
            }
        }

        return new TestPlugin;
        """
    When I run "ls"
    Then the output contains "my-cool-plugin-is-executed"

  Scenario: I register a plugin that requires an unsupported API version
    Given a fresh installation
    And a plugin:
        """
        use byrokrat\giroapp\Plugin\PluginInterface;
        use byrokrat\giroapp\Plugin\EnvironmentInterface;
        use byrokrat\giroapp\Plugin\ApiVersionConstraint;

        class UnsupportedApiPlugin implements PluginInterface
        {
            public function loadPlugin(EnvironmentInterface $environment): void
            {
                $environment->assertApiVersion(new ApiVersionConstraint('MyPlugin', '^99999999999999'));
            }
        }

        return new UnsupportedApiPlugin;
        """
    When I run "ls"
    Then I get an error
