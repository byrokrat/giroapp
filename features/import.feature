Feature: Importing files
  In order to manage autogiro donors
  As a user
  I need to be able to import files

  Background:
    Given a fresh installation
    And an orgnization 'foo' with bankgiro '58056201' and bgc customer number '123456'

  Scenario: I import an invalid file
    When I import:
        """
        This is not a valid autogiro file
        """
    Then I get an error

  Scenario: I import an autogiro file approving a mandate register request
    Given there are donors:
      | payer-number | state            |
      | 12345        | MandateSentState |
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        73005805620100000000000123455000000001111116198203232775     043220170817
        092017081799000000000
        """
    Then the donor database contains:
      | payer-number | state                |
      | 12345        | MandateApprovedState |

  Scenario: I import an autogiro file rejecting a mandate register request
    Given there are donors:
      | payer-number | state            |
      | 12345        | MandateSentState |
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        73005805620100000000000123455000000001111116198203232775     042320170817
        092017081799000000000
        """
    Then the donor database contains:
      | payer-number | state         |
      | 12345        | ErrorState |

  Scenario: I import an autogiro file revocing a mandate
    Given there are donors:
      | payer-number | state       |
      | 12345        | ActiveState |
    When I import:
        """
        01AUTOGIRO              20170817            AG-MEDAVI           1234560058056201
        73005805620100000000000123455000000001111116198203232775     033320170817
        092017081799000000000
        """
    Then the donor database contains:
      | payer-number | state         |
      | 12345        | InactiveState |
