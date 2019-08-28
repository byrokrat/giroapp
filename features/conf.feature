Feature: Displaying configurations
  In order to write installscripts for plugins
  As a developer
  I need to be able to access configurations programmatically

  Scenario: I read a config that does not exist
    Given a fresh installation
    When I run "conf this-config-does-not-exists"
    Then I get a "INVALID_CONFIG_EXCEPTION" error

  Scenario: I read a config
    Given a fresh installation
    And a configuration file:
      """
      org_id = 1234567897
      org_bg = 58056201
      org_bgc_nr = ------
      """
    When I run "conf org_bgc_nr"
    Then the output matches:
        """
        ------

        """
