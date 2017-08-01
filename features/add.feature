Feature: Adding new donors
  In order to manage autogiro donors
  As a user
  I need to be able to add new donors

  Scenario: I add a new donor with an explicit payer number
    Given a fresh installation
    And the explicit payer number strategy
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then the donor database contains:
      | payer-number | name | account     | id         | state           | amount |
      | 1            | foo  | 50001111116 | 8203232775 | NewMandateState | 100    |

  Scenario: I fail to supply an explicit payer number
    Given a fresh installation
    And the explicit payer number strategy
    When I run "add --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then I get an error

  Scenario: I fail to supply an account number
    Given a fresh installation
    And the explicit payer number strategy
    When I run "add --payer-number 1 --id 8203232775 --name foo --amount 100"
    Then I get an error

  Scenario: I fail to supply an id number
    Given a fresh installation
    And the explicit payer number strategy
    When I run "add --payer-number 1 --account 50001111116 --name foo --amount 100"
    Then I get an error

  Scenario: I add a new donor that already exists
    Given a fresh installation
    And there are donors:
      | payer-number | name | account     | id         | state       | amount |
      | 1            | foo  | 50001111116 | 8203232775 | ActiveState | 100    |
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then I get an error
