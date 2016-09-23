Feature: Purging inactive donors
  In order to manage autogiro donators
  As a user
  I need to be able to purge inactive donors from db

  Scenario: I purge inactove donors
    Given a database containing donor "12345" with state "InactiveState"
    When I purge
    Then the database does not contain donor "12345"
