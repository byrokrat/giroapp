Feature: Examine database status
  In order to manage autogiro donors
  As a user
  I need to be able to examine the current state of the database

  Background:
    Given a fresh installation
    And there are donors:
      | payer-number | state               | id          | amount |
      | 1            | ACTIVE              | 840821-3067 | 100    |
      | 2            | INACTIVE            | 820828-6966 | 100    |
      | 3            | MANDATE_APPROVED    | 550319-1016 | 100    |
      | 4            | MANDATE_SENT        | 980403-7985 | 100    |
      | 5            | NEW_DIGITAL_MANDATE | 650211-5097 | 100    |
      | 6            | NEW_MANDATE         | 950819-4058 | 100    |
      | 7            | REVOCATION_SENT     | 781121-3714 | 100    |
      | 8            | REVOKE_MANDATE      | 890121-5742 | 100    |

  Scenario: I check the exportable count
    When I run "status --exportable-count"
    Then the output contains a line like "/^4$/"

  Scenario: I check the donor count
    When I run "status --donor-count"
    Then the output contains a line like "/^8$/"

  Scenario: I check the active donor count
    When I run "status --active-donor-count"
    Then the output contains a line like "/^1$/"

  Scenario: I check the amount count
    When I run "status --monthly-amount"
    Then the output contains a line like "/^100$/"
