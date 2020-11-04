Feature: Importing xml mandate files

  Scenario: I import an online autogiro form
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        xml_mandate_payer_nr_strategy = ignore
        """
    And a file named "mandate.xml":
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
    When I run "import-xml-mandates mandate.xml"
    Then there is no error
    And the database contains donor "12345" with "state" matching "NEW_MANDATE"
    And the "imports_dir" directory contains "1" files

  Scenario: I import an online autogiro form with no payer number
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        xml_mandate_payer_nr_strategy = personal-id
        """
    And a file named "mandate.xml":
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
            <Betalarnummer></Betalarnummer>
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
    When I run "import-xml-mandates mandate.xml"
    Then there is no error
    And the database contains donor "8203232775"

  Scenario: I import a form with a donor that already exists
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        """
    And there are donors:
        | payer-number | id         |
        | 12345        | 8203232775 |
    And a file named "mandate.xml":
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
    When I run "import-xml-mandates mandate.xml"
    Then there is no error
    And the "imports_dir" directory contains "0" files

  Scenario: I forcefully import a form with two donors of wich one already exists
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        """
    And there are donors:
        | payer-number | id         |
        | 11111        | 8203232775 |
    And a file named "mandate.xml":
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
            <Betalares_x0020_namn>FOO</Betalares_x0020_namn>
            <Betalares_x0020_adress_1></Betalares_x0020_adress_1>
            <Betalares_x0020_adress_2></Betalares_x0020_adress_2>
            <Betalares_x0020_adress_3></Betalares_x0020_adress_3>
            <Betalares_x0020_postnr></Betalares_x0020_postnr>
            <Betalares_x0020_postort></Betalares_x0020_postort>
            <Betalarnummer>11111</Betalarnummer>
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
            <Betalares_x0020_namn>BAR</Betalares_x0020_namn>
            <Betalares_x0020_adress_1></Betalares_x0020_adress_1>
            <Betalares_x0020_adress_2></Betalares_x0020_adress_2>
            <Betalares_x0020_adress_3></Betalares_x0020_adress_3>
            <Betalares_x0020_postnr></Betalares_x0020_postnr>
            <Betalares_x0020_postort></Betalares_x0020_postort>
            <Betalarnummer>22222</Betalarnummer>
            <Kontoinnehavarens_x0020_bank></Kontoinnehavarens_x0020_bank>
            <Kontonr>33008507269887</Kontonr>
            <Kontoinnehavarens_x0020_personnr>8507269887</Kontoinnehavarens_x0020_personnr>
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
    When I run "import-xml-mandates mandate.xml --force"
    Then there is no error
    And the database contains donor "22222" with "state" matching "NEW_MANDATE"
    And the "imports_dir" directory contains "1" files

  Scenario: I import a form with a donor that already exists and the always_force_imports config set
    Given a fresh installation
    And a configuration file:
        """
        org_id = 835000-0892
        org_bg = 58056201
        always_force_imports = true
        """
    And there are donors:
        | payer-number | id         |
        | 12345        | 8203232775 |
    And a file named "mandate.xml":
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
    When I run "import-xml-mandates mandate.xml"
    Then there is no error
    And the "imports_dir" directory contains "1" files
