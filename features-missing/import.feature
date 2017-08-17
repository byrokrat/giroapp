Feature: Importing files
  In order to manage autogiro donors
  As a user
  I need to be able to import files

  Background:
    Given a fresh installation
    And an orgnization 'foo' with bankgiro '58056201' and bgc customer number '123456'

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
      | 12345        | InactiveState |

  Scenario: I import an autogiro file with a new digital mandate
    When I import:
        """
        AG-EMEDGIV layout with a new mandate..
        """
    Then the donor database contains:
      | payer-number | state                  |
      | 12345        | NewDigitalMandateState |

  Scenario: I import an autogiro file with a digital mandate that already exists
    Given there are donors:
      | payer-number | state       |
      | 12345        | ActiveState |
    When I import:
        """
        AG-EMEDGIV layout with a new mandate..
        """
    Then I get an error
