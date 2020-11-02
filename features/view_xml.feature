Feature: Viewing xml mandate files

  Background:
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        """

  Scenario: I view the contents of an online autogiro form
    Given a file named "mandate.xml":
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
    When I run "view-xml-mandates mandate.xml"
    Then there is no error
    And the output contains "hhhhhhhh-hhhh-hhhh-hhhh-hhhhhhhhhhhh"
