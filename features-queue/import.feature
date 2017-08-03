Feature: Importing files from autogirot
  In order to manage autogiro donors
  As a user
  I need to be able to import files from autogirot

  Background:
    Given a fresh installation
    And an orgnization 'foo' with bankgiro '58056201' and bgc customer number '123456'

  Scenario: I import an invalid file
    When I import:
        """
        This is not a valid autogiro file
        """
    Then I get an error

  Scenario: I import a file with wrong payee bankgiro
    When I import:
        """
        TODO: A file not with payee bankgiro 58056201
        """
    Then I get an error

  Scenario: I import a file with wrong payee bgc customer number
    When I import:
        """
        TODO: A file not with payee bgc-customer-number 123456
        """
    Then I get an error

  Scenario: I import a new digital mandate
    When I import:
        """
        TODO: a file containing "new" donor "12345"
        """
    Then the donor database contains:
      | payer-number | state                  |
      | 12345        | NewDigitalMandateState |

  Scenario: I import a digital mandate that already exists
    Given there are donors:
      | payer-number | state       |
      | 12345        | ActiveState |
    When I import:
        """
        TODO: a file containing "new" donor "12345"
        """
    Then I get an error

  Scenario: I import a donor rejection
    Given there are donors:
      | payer-number | state            |
      | 12345        | MandateSentState |
    When I import:
        """
        TODO: a file containing "rejected" donor "12345"
        """
    Then the donor database contains:
      | payer-number | state         |
      | 12345        | InactiveState |

  Scenario: I import a donor approval
    Given there are donors:
      | payer-number | state            |
      | 12345        | MandateSentState |
    When I import:
        """
        TODO: a file containing "approved" donor "12345"
        """
    Then the donor database contains:
      | payer-number | state                |
      | 12345        | MandateApprovedState |

  Scenario: I import a donor revocation
    Given there are donors:
      | payer-number | state       |
      | 12345        | ActiveState |
    When I import:
        """
        TODO: a file containing "revoked" donor "12345"
        """
    Then the donor database contains:
      | payer-number | state         |
      | 12345        | InactiveState |
