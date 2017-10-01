Feature: Display information on individual donors
  In order to manage autogiro donors
  As a user
  I need to be able to display donor info

  Scenario: I display info on a donor
    Given a fresh installation
    And there are donors:
      | payer-number | name | account     | id         | amount |
      | 1            | foo  | 50001111116 | 8203232775 | 100    |
    When I run "show 1"
    Then the output contains "foo"
    And the output contains "5000,111 111-6"
    And the output contains "820323-2775"
    And the output contains "100"

  Scenario: I filter info on a donor
    Given a fresh installation
    And there are donors:
      | payer-number | name | account     | id         | amount |
      | 1            | foo  | 50001111116 | 8203232775 | 100    |
    When I run "show 1 --name"
    Then the output matches:
        """
        foo

        """
