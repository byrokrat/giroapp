Feature: Examine database status
  In order to manage autogiro donors
  As a user
  I need to be able to examine the current state of the database

  Background:
    Given a fresh installation
    And there are donors:
      | payer-number | state               | amount |
      | 1            | ACTIVE              | 100    |
      | 2            | INACTIVE            | 100    |
      | 3            | MANDATE_APPROVED    | 100    |
      | 4            | MANDATE_SENT        | 100    |
      | 5            | NEW_DIGITAL_MANDATE | 100    |
      | 6            | NEW_MANDATE         | 100    |
      | 7            | REVOCATION_SENT     | 100    |
      | 8            | REVOKE_MANDATE      | 100    |

  Scenario: I check the exportable count
    When I run "status --exportable-count"
    Then the output matches "/^4$/"

  Scenario: I check the donor count
    When I run "status --donor-count"
    Then the output matches "/^8$/"

  Scenario: I check the active donor count
    When I run "status --active-donor-count"
    Then the output matches "/^1$/"

  Scenario: I check the amount count
    When I run "status --monthly-amount"
    Then the output matches "/^100$/"
