Feature: Adding new donors
  In order to manage autogiro donors
  As a user
  I need to be able to add new donors

  Scenario: I add a new donor with payer number based on id
    Given a fresh installation
    And the ID payer number strategy
    When I run "add --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then the donors database contains:
      | payer-number | name | account     | id         | state       | amount |
      | 8203232775   | foo  | 50001111116 | 8203232775 | NEW_MANDATE | 100    |

  Scenario: I add a donor that already exists
    Given a fresh installation
    And there are donors:
      | payer-number | name | account     | id         | state  | amount |
      | 1            | foo  | 50001111116 | 8203232775 | ACTIVE | 100    |
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    Then I get an error
