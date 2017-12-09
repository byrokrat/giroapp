Feature: Validating the database
  In order to manage autogiro donors
  As a user
  I need to be able to validate the database

  Scenario: I validate the database
    Given a fresh installation
    When I run "add --payer-number 1 --account 50001111116 --id 8203232775 --name foo --amount 100"
    And I run "validate"
    Then there is no error
