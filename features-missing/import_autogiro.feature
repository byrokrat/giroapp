Feature: Importing files
  In order to manage autogiro donors
  As a user
  I need to be able to import files

  Background:
    Given a fresh installation
    And a payee with 'bankgiro' '58056201'
    And a payee with 'bgc-customer-number' '123456'

  Scenario: I import an autogiro file with invalid payee bankgiro
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560050501055
        092017081799000000000
        """
    Then I get an error

  Scenario: I import an autogiro file with invalid payee bgc customer number
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           9999990058056201
        092017081799000000000
        """
    Then I get an error

  Scenario: I import an autogiro file with a new digital mandate
    When I import:
        """
        AG-EMEDGIV layout with a new mandate..
        """
    Then the database contains donor "12345" with "state" matching "NEW_DIGITAL_MANDATE"

  Scenario: I import an autogiro file with a digital mandate that already exists
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
        """
        AG-EMEDGIV layout with a new mandate..
        """
    Then I get an error
