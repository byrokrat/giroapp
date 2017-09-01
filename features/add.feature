Feature: Adding new donors
  In order to manage autogiro donors
  As a user
  I need to be able to add new donors

  Scenario: I add a new donor with an explicit payer number
    Given a fresh installation
    And the explicit payer number strategy
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then the database contains donor "1" with "name" matching "foo"
    And the database contains donor "1" with "account" matching "5000,111 111-6"
    And the database contains donor "1" with "id" matching "820323-2775"
    And the database contains donor "1" with "state" matching "NEW_MANDATE"
    And the database contains donor "1" with "amount" matching "100"

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
      | payer-number | name | account     | id         | state  | amount |
      | 1            | foo  | 50001111116 | 8203232775 | ACTIVE | 100    |
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then I get an error
