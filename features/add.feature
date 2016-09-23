Feature: Adding new donors
  In order to manage autogiro donators
  As a user
  I need to be able to add new donors

  Scenario: I add a new donor
    Given an empty database
    When I add a new donor "12345"
    Then the database contains donor "12345" with state "NewMandateState"

  Scenario: I add a new donor that already exists
    Given a database containing donor "12345"
    When I add a new donor "12345"
    Then I get an error
