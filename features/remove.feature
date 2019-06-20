Feature: Removing donors
  In order to manage autogiro donors
  As a user
  I need to be able to remove inactive donors from database

  Scenario: I remove an inactive donor
    Given a fresh installation
    And there are donors:
      | payer-number | state    |
      | 12345        | INACTIVE |
    When I run "remove 12345"
    And I run "show 12345"
    Then I get a "DONOR_DOES_NOT_EXIST_EXCEPTION" error

    Scenario: I try to remove a non-inactive donor
      Given a fresh installation
      And there are donors:
        | payer-number | stat   |
        | 12345        | ACTIVE |
      When I run "remove 12345"
      Then the database contains donor "12345" with "state" matching "ACTIVE"

    Scenario: I force removal of a non-inactive donor
      Given a fresh installation
      And there are donors:
        | payer-number | stat   |
        | 12345        | ACTIVE |
      When I run "remove 12345 -f"
      And I run "show 12345"
      Then I get a "DONOR_DOES_NOT_EXIST_EXCEPTION" error

    Scenario: I remove all donors
      Given a fresh installation
      And there are donors:
        | payer-number | state               | id          | amount |
        | 1            | ACTIVE              | 840821-3067 | 100    |
        | 2            | INACTIVE            | 820828-6966 | 100    |
        | 3            | INACTIVE            | 550319-1016 | 100    |
      When I run "remove --all"
      And I run "status --inactive-count"
      Then the output contains a line like "/^0$/"
