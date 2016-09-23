Feature: Revoking mandates
  In order to manage autogiro donators
  As a user
  I need to be able to revoke donor mandates

  Scenario: I revoke a mandate
    Given a database containing donor "12345"
    When I revoke donor "12345"
    Then the database contains donor "12345" with state "RevokeMandateState"
