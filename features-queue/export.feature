Feature: Exporting files to autogirot
  In order to manage autogiro donors
  As a user
  I need to be able to export files to autogirot

  Background:
    Given a fresh installation
    And an orgnization 'foo' with bankgiro '58056201' and bgc customer number '123456'

  Scenario: I export a new paper based mandate
    Given there are donors:
      | payer-number | account     | id         | state           |
      | 12345        | 50001111116 | 8203232775 | NewMandateState |
    When I run "export"
    Then the output matches:
        """
        TODO Regexp that matches the expected ag file...
        """
    And the donor database contains:
      | payer-number | state            |
      | 12345        | MandateSentState |

  Scenario: I respond to a new digital mandate
    Given there are donors:
      | payer-number | state                  |
      | 12345        | NewDigitalMandateState |
    When I run "export"
    Then the output matches:
        """
        TODO Regexp that matches the expected ag file...
        """
    And the donor database contains:
      | payer-number | state            |
      | 12345        | MandateSentState |

  Scenario: I register transactions from donor
    Given there are donors:
      | payer-number | state                |
      | 12345        | MandateApprovedState |
    When I run "export"
    Then the output matches:
        """
        TODO Regexp that matches the expected ag file...
        """
    And the donor database contains:
      | payer-number | state       |
      | 12345        | ActiveState |

  Scenario: I revoke a donor mandate
    Given there are donors:
      | payer-number | state              |
      | 12345        | RevokeMandateState |
    When I run "export"
    Then the output matches:
        """
        TODO Regexp that matches the expected ag file...
        """
    And the donor database contains:
      | payer-number | state               |
      | 12345        | RevocationSentState |
