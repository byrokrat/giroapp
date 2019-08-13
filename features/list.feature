Feature: Listing donors in database
  In order to manage autogiro donors
  As a user
  I need to be able to list donors

  Scenario: I list donors
    Given a fresh installation
    And there are donors:
      | payer-number | name | state       |
      | 11111        | foo  | NEW_MANDATE |
    When I run "list"
    Then the output contains "11111"
    And the output contains "foo"
    And the output contains "NEW_MANDATE"

  Scenario: I filter listed donors
    Given a fresh installation
    And there are donors:
      | payer-number | name | state       |
      | 11111        | foo  | NEW_MANDATE |
    When I run "list --filter active"
    Then the output does not contain "11111"

  Scenario: I negate filter
    Given a fresh installation
    And there are donors:
      | payer-number | name | state       |
      | 11111        | foo  | NEW_MANDATE |
    When I run "ls --filter-not active"
    Then the output contains "11111"
