Feature: Importing files
  In order to manage autogiro donors
  As a user
  I need to be able to import donors from online form xml format

  Scenario: I import an online autogiro form
    Given a fresh installation
    And a configuration file:
        """
        org.state_id = 835000-0892
        org.bankgiro = 58056201
        """
    When I import:
        """
        <?xml version="1.0" encoding="utf-8"?>
        <DocumentElement>
          <MedgivandeViaHemsida>
            <Formulärnamn>my-form-id</Formulärnamn>
            <Betalningsmottagares_x0020_namn></Betalningsmottagares_x0020_namn>
            <Betalningsmottagares_x0020_adress_1></Betalningsmottagares_x0020_adress_1>
            <Betalningsmottagares_x0020_adress_2></Betalningsmottagares_x0020_adress_2>
            <Betalningsmottagares_x0020_adress_3></Betalningsmottagares_x0020_adress_3>
            <Betalningsmottagares_x0020_postnr></Betalningsmottagares_x0020_postnr>
            <Betalningsmottagares_x0020_postort></Betalningsmottagares_x0020_postort>
            <Bankgironr>5805-6201</Bankgironr>
            <Organisationsnr>835000-0892</Organisationsnr>
            <Autogiroanmälan_x002C__x0020_medgivande />
            <Betalares_x0020_namn>foobar</Betalares_x0020_namn>
            <Betalares_x0020_adress_1></Betalares_x0020_adress_1>
            <Betalares_x0020_adress_2></Betalares_x0020_adress_2>
            <Betalares_x0020_adress_3></Betalares_x0020_adress_3>
            <Betalares_x0020_postnr></Betalares_x0020_postnr>
            <Betalares_x0020_postort></Betalares_x0020_postort>
            <Betalarnummer>12345</Betalarnummer>
            <Kontoinnehavarens_x0020_bank></Kontoinnehavarens_x0020_bank>
            <Kontonr>50001111116</Kontonr>
            <Kontoinnehavarens_x0020_personnr>8203232775</Kontoinnehavarens_x0020_personnr>
            <Övrig_x0020_info>
              <customdata>
                <name>custom field name</name>
                <value></value>
              </customdata>
            </Övrig_x0020_info>
            <Verifieringstid></Verifieringstid>
            <Verifieringsreferens>hhhhhhhh-hhhh-hhhh-hhhh-hhhhhhhhhhhh</Verifieringsreferens>
          </MedgivandeViaHemsida>
        </DocumentElement>
        """
    Then there is no error
    And the database contains donor "12345" with "state" matching "NEW_MANDATE"
