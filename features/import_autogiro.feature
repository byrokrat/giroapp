Feature: Importing files
  In order to manage autogiro donors
  As a user
  I need to be able to import files

  Background:
    Given a fresh installation
    And a configuration file:
        """
        org_id = 1234567897
        org_bgc_nr = 123456
        org_bg = 58056201
        """

  Scenario: I import an invalid file
    When I import:
        """
        This is not a valid autogiro file
        """
    Then I get a "UNKNOWN_FILE_EXCEPTION" error

  Scenario: I import an autogiro file with invalid payee bankgiro
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560050501055
        092017081799000000000
        """
    Then I get a "INVALID_AUTOGIRO_FILE_EXCEPTION" error

  Scenario: I import an autogiro file with invalid payee bgc customer number
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           9999990058056201
        092017081799000000000
        """
    Then I get a "INVALID_AUTOGIRO_FILE_EXCEPTION" error

  Scenario: I import the same file twice
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        092017081799000000000
        """
    And I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        092017081799000000000
        """
    Then I get a "FILE_ALREADY_IMPORTED_EXCEPTION" error

  Scenario: I import an autogiro file approving a mandate register request
    Given there are donors:
      | payer-number | state        |
      | 12345        | MANDATE_SENT |
    When I import:
      """
      01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
      73005805620100000000000123455000000001111116198203232775     043220170817
      092017081799000000001
      """
    Then the database contains donor "12345" with "state" matching "AWAITING_TRANSACTION_REGISTRATION"

  Scenario: I import mandate approval using STDIN
    Given there are donors:
      | payer-number | state        |
      | 12345        | MANDATE_SENT |
    When I import using STDIN:
       """
       01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
       73005805620100000000000123455000000001111116198203232775     043220170817
       092017081799000000001
       """
   Then the database contains donor "12345" with "state" matching "AWAITING_TRANSACTION_REGISTRATION"

  Scenario: I import an autogiro file rejecting a mandate registration request
    Given there are donors:
      | payer-number | state        |
      | 12345        | MANDATE_SENT |
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        73005805620100000000000123455000000001111116198203232775     042320170817
        092017081799000000001
        """
    Then the database contains donor "12345" with "state" matching "ERROR"

  Scenario: I import an autogiro file with a succesfull transaction report
    Given there are donors:
      | payer-number | state                         |
      | 12345        | TRANSACTION_REGISTRATION_SENT |
    When I import:
        """
        01AUTOGIRO              20190701113835820825BET. SPEC & STOPP TK1234560058056201
        15000000000000000000033000082032327752019070100010000000000000010000   00000002
        82201907011    00000000000123450000000100000058056201AAAAAAAAAAAAAAAA          0
        09201907019900000001000000000001000000000000000000000000000000000000
        """
    Then the database contains donor "12345" with "state" matching "ACTIVE"

  Scenario: I import a transaction report of a newly revoked donor
    Given there are donors:
      | payer-number | state           |
      | 12345        | REVOCATION_SENT |
    When I import:
        """
        01AUTOGIRO              20190701113835820825BET. SPEC & STOPP TK1234560058056201
        15000000000000000000033000082032327752019070100010000000000000010000   00000002
        82201907011    00000000000123450000000100000058056201AAAAAAAAAAAAAAAA          0
        09201907019900000001000000000001000000000000000000000000000000000000
        """
    Then there is no error
