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
    Then the database contains donor "12345" with "state" matching "MANDATE_APPROVED"

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
   Then the database contains donor "12345" with "state" matching "MANDATE_APPROVED"

  Scenario: I import an autogiro file rejecting a mandate register request
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

  Scenario: I import an autogiro file revoking a mandate
    Given there are donors:
      | payer-number | state  |
      | 12345        | ACTIVE |
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        73005805620100000000000123455000000001111116198203232775     033320170817
        092017081799000000001
        """
    Then the database contains donor "12345" with "state" matching "INACTIVE"
