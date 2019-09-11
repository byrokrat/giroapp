Feature: CLI autocompletion

  Scenario: I complete a line
    Given a fresh installation
    When I run "_complete 'giroapp tran' 11"
    Then the output contains "transactions"
