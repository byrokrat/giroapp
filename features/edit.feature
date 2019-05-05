Feature: Editing donors
  In order to manage autogiro donors
  As a user
  I need to be able to edit donors

  Scenario: I edit a donor identified by mandate key
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    When I run "edit wkjmljAZVk7KQz9w --name bar"
    Then there is no error
    And the database contains donor "1" with "mandate-key" matching "wkjmljAZVk7KQz9w"
    And the database contains donor "1" with "name" matching "bar"

  Scenario: I edit a donor identified by payer number
    Given a fresh installation
    And there are donors:
      | id         | account     | payer-number | name |
      | 8203232775 | 50001111116 | 1            | foo  |
    When I run "edit 1 --name bar"
    Then there is no error
    And the database contains donor "1" with "mandate-key" matching "wkjmljAZVk7KQz9w"
    And the database contains donor "1" with "name" matching "bar"

  Scenario: I edit a donor and set a lot of values
    Given a fresh installation
    And there are donors:
      | payer-number | name | email          | phone | amount | comment |
      | 1            | foo  | foo@host.com   | 123   | 0      | foo     |
    When I run "edit 1 --name=bar --email=hej@hoj.se --phone=789 --amount=100 --comment=updated"
    Then there is no error
    And the database contains donor "1" with "name" matching "bar"
    And the database contains donor "1" with "email" matching "hej@hoj.se"
    And the database contains donor "1" with "phone" matching "789"
    And the database contains donor "1" with "amount" matching "100"
    And the database contains donor "1" with "comment" matching "updated"

  Scenario: I edit a donor and change state
    Given a fresh installation
    And there are donors:
      | payer-number | state        |
      | 1            | MANDATE_SENT |
    When I run "edit 1 --state ACTIVE"
    Then there is no error
    And the database contains donor "1" with "state" matching "ACTIVE"
