Feature: Initializing installation
  In order to manage autogiro donors
  As a user
  I need to be able to install app

  Scenario: I create a standard giroapp.ini
    Given a fresh installation
    When I run "init"
    Then there is a file named "giroapp.ini"

  Scenario: I try to overwrite an existing giroapp.ini
    Given a fresh installation
    And a file named "giroapp.ini":
        """
        """
    When I run "init"
    Then I get a "RUNTIME_EXCEPTION" error
