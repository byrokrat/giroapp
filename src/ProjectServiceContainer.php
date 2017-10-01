<?php

namespace byrokrat\giroapp;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ProjectServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class ProjectServiceContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = array();
        $this->normalizedIds = array(
            'byrokrat\\autogiro\\parser\\parser' => 'byrokrat\\autogiro\\Parser\\Parser',
            'byrokrat\\autogiro\\parser\\parserfactory' => 'byrokrat\\autogiro\\Parser\\ParserFactory',
            'byrokrat\\banking\\accountfactory' => 'byrokrat\\banking\\AccountFactory',
            'byrokrat\\banking\\bankgirofactory' => 'byrokrat\\banking\\BankgiroFactory',
            'byrokrat\\giroapp\\applicationmonitor' => 'byrokrat\\giroapp\\ApplicationMonitor',
            'byrokrat\\giroapp\\builder\\datebuilder' => 'byrokrat\\giroapp\\Builder\\DateBuilder',
            'byrokrat\\giroapp\\builder\\donorbuilder' => 'byrokrat\\giroapp\\Builder\\DonorBuilder',
            'byrokrat\\giroapp\\builder\\mandatekeybuilder' => 'byrokrat\\giroapp\\Builder\\MandateKeyBuilder',
            'byrokrat\\giroapp\\di\\pluginloader' => 'byrokrat\\giroapp\\DI\\PluginLoader',
            'byrokrat\\giroapp\\listener\\committinglistener' => 'byrokrat\\giroapp\\Listener\\CommittingListener',
            'byrokrat\\giroapp\\listener\\importingautogirolistener' => 'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener',
            'byrokrat\\giroapp\\listener\\importinglistener' => 'byrokrat\\giroapp\\Listener\\ImportingListener',
            'byrokrat\\giroapp\\listener\\importingxmllistener' => 'byrokrat\\giroapp\\Listener\\ImportingXmlListener',
            'byrokrat\\giroapp\\listener\\invalidnodefilteringlistener' => 'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener',
            'byrokrat\\giroapp\\listener\\logginglistener' => 'byrokrat\\giroapp\\Listener\\LoggingListener',
            'byrokrat\\giroapp\\listener\\mandatepersistinglistener' => 'byrokrat\\giroapp\\Listener\\MandatePersistingListener',
            'byrokrat\\giroapp\\listener\\mandateresponselistener' => 'byrokrat\\giroapp\\Listener\\MandateResponseListener',
            'byrokrat\\giroapp\\listener\\outputtinglistener' => 'byrokrat\\giroapp\\Listener\\OutputtingListener',
            'byrokrat\\giroapp\\mapper\\donormapper' => 'byrokrat\\giroapp\\Mapper\\DonorMapper',
            'byrokrat\\giroapp\\mapper\\schema\\donorschema' => 'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema',
            'byrokrat\\giroapp\\mapper\\schema\\postaladdressschema' => 'byrokrat\\giroapp\\Mapper\\Schema\\PostalAddressSchema',
            'byrokrat\\giroapp\\mapper\\settingsmapper' => 'byrokrat\\giroapp\\Mapper\\SettingsMapper',
            'byrokrat\\giroapp\\mapper\\transactionmapper' => 'byrokrat\\giroapp\\Mapper\\TransactionMapper',
            'byrokrat\\giroapp\\state\\activestate' => 'byrokrat\\giroapp\\State\\ActiveState',
            'byrokrat\\giroapp\\state\\errorstate' => 'byrokrat\\giroapp\\State\\ErrorState',
            'byrokrat\\giroapp\\state\\inactivestate' => 'byrokrat\\giroapp\\State\\InactiveState',
            'byrokrat\\giroapp\\state\\mandateapprovedstate' => 'byrokrat\\giroapp\\State\\MandateApprovedState',
            'byrokrat\\giroapp\\state\\mandatesentstate' => 'byrokrat\\giroapp\\State\\MandateSentState',
            'byrokrat\\giroapp\\state\\newdigitalmandatestate' => 'byrokrat\\giroapp\\State\\NewDigitalMandateState',
            'byrokrat\\giroapp\\state\\newmandatestate' => 'byrokrat\\giroapp\\State\\NewMandateState',
            'byrokrat\\giroapp\\state\\revocationsentstate' => 'byrokrat\\giroapp\\State\\RevocationSentState',
            'byrokrat\\giroapp\\state\\revokemandatestate' => 'byrokrat\\giroapp\\State\\RevokeMandateState',
            'byrokrat\\giroapp\\state\\statefactory' => 'byrokrat\\giroapp\\State\\StateFactory',
            'byrokrat\\giroapp\\xml\\customdatatranslator' => 'byrokrat\\giroapp\\Xml\\CustomdataTranslator',
            'byrokrat\\giroapp\\xml\\xmlmandatemigrationinterface' => 'byrokrat\\giroapp\\Xml\\XmlMandateMigrationInterface',
            'byrokrat\\giroapp\\xml\\xmlmandateparser' => 'byrokrat\\giroapp\\Xml\\XmlMandateParser',
            'byrokrat\\id\\idfactory' => 'byrokrat\\id\\IdFactory',
            'byrokrat\\id\\organizationidfactory' => 'byrokrat\\id\\OrganizationIdFactory',
        );
        $this->methodMap = array(
            'byrokrat\\autogiro\\Parser\\Parser' => 'getByrokrat_Autogiro_Parser_ParserService',
            'byrokrat\\autogiro\\Parser\\ParserFactory' => 'getByrokrat_Autogiro_Parser_ParserFactoryService',
            'byrokrat\\banking\\AccountFactory' => 'getByrokrat_Banking_AccountFactoryService',
            'byrokrat\\banking\\BankgiroFactory' => 'getByrokrat_Banking_BankgiroFactoryService',
            'byrokrat\\giroapp\\ApplicationMonitor' => 'getByrokrat_Giroapp_ApplicationMonitorService',
            'byrokrat\\giroapp\\Builder\\DateBuilder' => 'getByrokrat_Giroapp_Builder_DateBuilderService',
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => 'getByrokrat_Giroapp_Builder_DonorBuilderService',
            'byrokrat\\giroapp\\Builder\\MandateKeyBuilder' => 'getByrokrat_Giroapp_Builder_MandateKeyBuilderService',
            'byrokrat\\giroapp\\DI\\PluginLoader' => 'getByrokrat_Giroapp_DI_PluginLoaderService',
            'byrokrat\\giroapp\\Listener\\CommittingListener' => 'getByrokrat_Giroapp_Listener_CommittingListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => 'getByrokrat_Giroapp_Listener_ImportingAutogiroListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingListener' => 'getByrokrat_Giroapp_Listener_ImportingListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => 'getByrokrat_Giroapp_Listener_ImportingXmlListenerService',
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => 'getByrokrat_Giroapp_Listener_InvalidNodeFilteringListenerService',
            'byrokrat\\giroapp\\Listener\\LoggingListener' => 'getByrokrat_Giroapp_Listener_LoggingListenerService',
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => 'getByrokrat_Giroapp_Listener_MandatePersistingListenerService',
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => 'getByrokrat_Giroapp_Listener_MandateResponseListenerService',
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => 'getByrokrat_Giroapp_Listener_OutputtingListenerService',
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => 'getByrokrat_Giroapp_Mapper_DonorMapperService',
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => 'getByrokrat_Giroapp_Mapper_Schema_DonorSchemaService',
            'byrokrat\\giroapp\\Mapper\\Schema\\PostalAddressSchema' => 'getByrokrat_Giroapp_Mapper_Schema_PostalAddressSchemaService',
            'byrokrat\\giroapp\\Mapper\\SettingsMapper' => 'getByrokrat_Giroapp_Mapper_SettingsMapperService',
            'byrokrat\\giroapp\\Mapper\\TransactionMapper' => 'getByrokrat_Giroapp_Mapper_TransactionMapperService',
            'byrokrat\\giroapp\\State\\ActiveState' => 'getByrokrat_Giroapp_State_ActiveStateService',
            'byrokrat\\giroapp\\State\\ErrorState' => 'getByrokrat_Giroapp_State_ErrorStateService',
            'byrokrat\\giroapp\\State\\InactiveState' => 'getByrokrat_Giroapp_State_InactiveStateService',
            'byrokrat\\giroapp\\State\\MandateApprovedState' => 'getByrokrat_Giroapp_State_MandateApprovedStateService',
            'byrokrat\\giroapp\\State\\MandateSentState' => 'getByrokrat_Giroapp_State_MandateSentStateService',
            'byrokrat\\giroapp\\State\\NewDigitalMandateState' => 'getByrokrat_Giroapp_State_NewDigitalMandateStateService',
            'byrokrat\\giroapp\\State\\NewMandateState' => 'getByrokrat_Giroapp_State_NewMandateStateService',
            'byrokrat\\giroapp\\State\\RevocationSentState' => 'getByrokrat_Giroapp_State_RevocationSentStateService',
            'byrokrat\\giroapp\\State\\RevokeMandateState' => 'getByrokrat_Giroapp_State_RevokeMandateStateService',
            'byrokrat\\giroapp\\State\\StateFactory' => 'getByrokrat_Giroapp_State_StateFactoryService',
            'byrokrat\\giroapp\\Xml\\CustomdataTranslator' => 'getByrokrat_Giroapp_Xml_CustomdataTranslatorService',
            'byrokrat\\giroapp\\Xml\\XmlMandateMigrationInterface' => 'getByrokrat_Giroapp_Xml_XmlMandateMigrationInterfaceService',
            'byrokrat\\giroapp\\Xml\\XmlMandateParser' => 'getByrokrat_Giroapp_Xml_XmlMandateParserService',
            'byrokrat\\id\\IdFactory' => 'getByrokrat_Id_IdFactoryService',
            'byrokrat\\id\\OrganizationIdFactory' => 'getByrokrat_Id_OrganizationIdFactoryService',
            'db' => 'getDbService',
            'db_donor_collection' => 'getDbDonorCollectionService',
            'db_donor_engine' => 'getDbDonorEngineService',
            'db_log_collection' => 'getDbLogCollectionService',
            'db_log_engine' => 'getDbLogEngineService',
            'db_settings_collection' => 'getDbSettingsCollectionService',
            'db_settings_engine' => 'getDbSettingsEngineService',
            'db_transaction_collection' => 'getDbTransactionCollectionService',
            'db_transaction_engine' => 'getDbTransactionEngineService',
            'event_dispatcher' => 'getEventDispatcherService',
            'filesystem' => 'getFilesystemService',
            'organization_bg' => 'getOrganizationBgService',
            'organization_id' => 'getOrganizationIdService',
        );
        $this->privates = array(
            'filesystem' => true,
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    /**
     * {@inheritdoc}
     */
    public function isCompiled()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isFrozen()
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 3.3 and will be removed in 4.0. Use the isCompiled() method instead.', __METHOD__), E_USER_DEPRECATED);

        return true;
    }

    /**
     * Gets the public 'byrokrat\autogiro\Parser\Parser' shared autowired service.
     *
     * @return \byrokrat\autogiro\Parser\Parser
     */
    protected function getByrokrat_Autogiro_Parser_ParserService()
    {
        return $this->services['byrokrat\autogiro\Parser\Parser'] = ${($_ = isset($this->services['byrokrat\autogiro\Parser\ParserFactory']) ? $this->services['byrokrat\autogiro\Parser\ParserFactory'] : $this->get('byrokrat\autogiro\Parser\ParserFactory')) && false ?: '_'}->createParser();
    }

    /**
     * Gets the public 'byrokrat\autogiro\Parser\ParserFactory' shared autowired service.
     *
     * @return \byrokrat\autogiro\Parser\ParserFactory
     */
    protected function getByrokrat_Autogiro_Parser_ParserFactoryService()
    {
        return $this->services['byrokrat\autogiro\Parser\ParserFactory'] = new \byrokrat\autogiro\Parser\ParserFactory();
    }

    /**
     * Gets the public 'byrokrat\banking\AccountFactory' shared autowired service.
     *
     * @return \byrokrat\banking\AccountFactory
     */
    protected function getByrokrat_Banking_AccountFactoryService()
    {
        return $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory();
    }

    /**
     * Gets the public 'byrokrat\banking\BankgiroFactory' shared autowired service.
     *
     * @return \byrokrat\banking\BankgiroFactory
     */
    protected function getByrokrat_Banking_BankgiroFactoryService()
    {
        return $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory();
    }

    /**
     * Gets the public 'byrokrat\giroapp\ApplicationMonitor' shared autowired service.
     *
     * @return \byrokrat\giroapp\ApplicationMonitor
     */
    protected function getByrokrat_Giroapp_ApplicationMonitorService()
    {
        return $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Builder\DateBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\DateBuilder
     */
    protected function getByrokrat_Giroapp_Builder_DateBuilderService()
    {
        return $this->services['byrokrat\giroapp\Builder\DateBuilder'] = new \byrokrat\giroapp\Builder\DateBuilder();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Builder\DonorBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\DonorBuilder
     */
    protected function getByrokrat_Giroapp_Builder_DonorBuilderService()
    {
        return $this->services['byrokrat\giroapp\Builder\DonorBuilder'] = new \byrokrat\giroapp\Builder\DonorBuilder(${($_ = isset($this->services['byrokrat\giroapp\Builder\MandateKeyBuilder']) ? $this->services['byrokrat\giroapp\Builder\MandateKeyBuilder'] : $this->get('byrokrat\giroapp\Builder\MandateKeyBuilder')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Builder\MandateKeyBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\MandateKeyBuilder
     */
    protected function getByrokrat_Giroapp_Builder_MandateKeyBuilderService()
    {
        return $this->services['byrokrat\giroapp\Builder\MandateKeyBuilder'] = new \byrokrat\giroapp\Builder\MandateKeyBuilder();
    }

    /**
     * Gets the public 'byrokrat\giroapp\DI\PluginLoader' shared autowired service.
     *
     * @return \byrokrat\giroapp\DI\PluginLoader
     */
    protected function getByrokrat_Giroapp_DI_PluginLoaderService()
    {
        return $this->services['byrokrat\giroapp\DI\PluginLoader'] = new \byrokrat\giroapp\DI\PluginLoader($this->getEnv('GIROAPP_PATH').'/plugins', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\CommittingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\CommittingListener
     */
    protected function getByrokrat_Giroapp_Listener_CommittingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\CommittingListener'] = new \byrokrat\giroapp\Listener\CommittingListener(${($_ = isset($this->services['db']) ? $this->services['db'] : $this->get('db')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\ImportingAutogiroListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingAutogiroListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingAutogiroListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] = new \byrokrat\giroapp\Listener\ImportingAutogiroListener(${($_ = isset($this->services['byrokrat\autogiro\Parser\Parser']) ? $this->services['byrokrat\autogiro\Parser\Parser'] : $this->get('byrokrat\autogiro\Parser\Parser')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\ImportingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\ImportingXmlListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingXmlListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingXmlListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] = new \byrokrat\giroapp\Listener\ImportingXmlListener(${($_ = isset($this->services['byrokrat\giroapp\Xml\XmlMandateParser']) ? $this->services['byrokrat\giroapp\Xml\XmlMandateParser'] : $this->get('byrokrat\giroapp\Xml\XmlMandateParser')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\InvalidNodeFilteringListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\InvalidNodeFilteringListener
     */
    protected function getByrokrat_Giroapp_Listener_InvalidNodeFilteringListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] = new \byrokrat\giroapp\Listener\InvalidNodeFilteringListener(${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->get('byrokrat\banking\BankgiroFactory')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Mapper\SettingsMapper']) ? $this->services['byrokrat\giroapp\Mapper\SettingsMapper'] : $this->get('byrokrat\giroapp\Mapper\SettingsMapper')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getByrokrat_Giroapp_Listener_LoggingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener(${($_ = isset($this->services['db_log_collection']) ? $this->services['db_log_collection'] : $this->get('db_log_collection')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\MandatePersistingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandatePersistingListener
     */
    protected function getByrokrat_Giroapp_Listener_MandatePersistingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] = new \byrokrat\giroapp\Listener\MandatePersistingListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->get('byrokrat\giroapp\Mapper\DonorMapper')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\MandateResponseListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandateResponseListener
     */
    protected function getByrokrat_Giroapp_Listener_MandateResponseListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] = new \byrokrat\giroapp\Listener\MandateResponseListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->get('byrokrat\giroapp\Mapper\DonorMapper')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\OutputtingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\OutputtingListener
     */
    protected function getByrokrat_Giroapp_Listener_OutputtingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['output']) ? $this->services['output'] : $this->get('output')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Mapper\DonorMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\DonorMapper
     */
    protected function getByrokrat_Giroapp_Mapper_DonorMapperService()
    {
        return $this->services['byrokrat\giroapp\Mapper\DonorMapper'] = new \byrokrat\giroapp\Mapper\DonorMapper(${($_ = isset($this->services['db_donor_collection']) ? $this->services['db_donor_collection'] : $this->get('db_donor_collection')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema']) ? $this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema'] : $this->get('byrokrat\giroapp\Mapper\Schema\DonorSchema')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Mapper\Schema\DonorSchema' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\Schema\DonorSchema
     */
    protected function getByrokrat_Giroapp_Mapper_Schema_DonorSchemaService()
    {
        return $this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema'] = new \byrokrat\giroapp\Mapper\Schema\DonorSchema(${($_ = isset($this->services['byrokrat\giroapp\Mapper\Schema\PostalAddressSchema']) ? $this->services['byrokrat\giroapp\Mapper\Schema\PostalAddressSchema'] : $this->get('byrokrat\giroapp\Mapper\Schema\PostalAddressSchema')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\State\StateFactory']) ? $this->services['byrokrat\giroapp\State\StateFactory'] : $this->get('byrokrat\giroapp\State\StateFactory')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->get('byrokrat\banking\AccountFactory')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->get('byrokrat\id\IdFactory')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Mapper\Schema\PostalAddressSchema' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema
     */
    protected function getByrokrat_Giroapp_Mapper_Schema_PostalAddressSchemaService()
    {
        return $this->services['byrokrat\giroapp\Mapper\Schema\PostalAddressSchema'] = new \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Mapper\SettingsMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\SettingsMapper
     */
    protected function getByrokrat_Giroapp_Mapper_SettingsMapperService()
    {
        return $this->services['byrokrat\giroapp\Mapper\SettingsMapper'] = new \byrokrat\giroapp\Mapper\SettingsMapper(${($_ = isset($this->services['db_settings_collection']) ? $this->services['db_settings_collection'] : $this->get('db_settings_collection')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Mapper\TransactionMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\TransactionMapper
     */
    protected function getByrokrat_Giroapp_Mapper_TransactionMapperService()
    {
        return $this->services['byrokrat\giroapp\Mapper\TransactionMapper'] = new \byrokrat\giroapp\Mapper\TransactionMapper(${($_ = isset($this->services['db_transaction_collection']) ? $this->services['db_transaction_collection'] : $this->get('db_transaction_collection')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\ActiveState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\ActiveState
     */
    protected function getByrokrat_Giroapp_State_ActiveStateService()
    {
        return $this->services['byrokrat\giroapp\State\ActiveState'] = new \byrokrat\giroapp\State\ActiveState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\ErrorState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\ErrorState
     */
    protected function getByrokrat_Giroapp_State_ErrorStateService()
    {
        return $this->services['byrokrat\giroapp\State\ErrorState'] = new \byrokrat\giroapp\State\ErrorState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\InactiveState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\InactiveState
     */
    protected function getByrokrat_Giroapp_State_InactiveStateService()
    {
        return $this->services['byrokrat\giroapp\State\InactiveState'] = new \byrokrat\giroapp\State\InactiveState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\MandateApprovedState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\MandateApprovedState
     */
    protected function getByrokrat_Giroapp_State_MandateApprovedStateService()
    {
        return $this->services['byrokrat\giroapp\State\MandateApprovedState'] = new \byrokrat\giroapp\State\MandateApprovedState(${($_ = isset($this->services['byrokrat\giroapp\Builder\DateBuilder']) ? $this->services['byrokrat\giroapp\Builder\DateBuilder'] : $this->get('byrokrat\giroapp\Builder\DateBuilder')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\MandateSentState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\MandateSentState
     */
    protected function getByrokrat_Giroapp_State_MandateSentStateService()
    {
        return $this->services['byrokrat\giroapp\State\MandateSentState'] = new \byrokrat\giroapp\State\MandateSentState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\NewDigitalMandateState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\NewDigitalMandateState
     */
    protected function getByrokrat_Giroapp_State_NewDigitalMandateStateService()
    {
        return $this->services['byrokrat\giroapp\State\NewDigitalMandateState'] = new \byrokrat\giroapp\State\NewDigitalMandateState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\NewMandateState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\NewMandateState
     */
    protected function getByrokrat_Giroapp_State_NewMandateStateService()
    {
        return $this->services['byrokrat\giroapp\State\NewMandateState'] = new \byrokrat\giroapp\State\NewMandateState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\RevocationSentState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\RevocationSentState
     */
    protected function getByrokrat_Giroapp_State_RevocationSentStateService()
    {
        return $this->services['byrokrat\giroapp\State\RevocationSentState'] = new \byrokrat\giroapp\State\RevocationSentState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\RevokeMandateState' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\RevokeMandateState
     */
    protected function getByrokrat_Giroapp_State_RevokeMandateStateService()
    {
        return $this->services['byrokrat\giroapp\State\RevokeMandateState'] = new \byrokrat\giroapp\State\RevokeMandateState();
    }

    /**
     * Gets the public 'byrokrat\giroapp\State\StateFactory' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\StateFactory
     */
    protected function getByrokrat_Giroapp_State_StateFactoryService()
    {
        return $this->services['byrokrat\giroapp\State\StateFactory'] = new \byrokrat\giroapp\State\StateFactory();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Xml\CustomdataTranslator' shared autowired service.
     *
     * @return \byrokrat\giroapp\Xml\CustomdataTranslator
     */
    protected function getByrokrat_Giroapp_Xml_CustomdataTranslatorService()
    {
        return $this->services['byrokrat\giroapp\Xml\CustomdataTranslator'] = new \byrokrat\giroapp\Xml\CustomdataTranslator(${($_ = isset($this->services['byrokrat\giroapp\Xml\XmlMandateMigrationInterface']) ? $this->services['byrokrat\giroapp\Xml\XmlMandateMigrationInterface'] : $this->get('byrokrat\giroapp\Xml\XmlMandateMigrationInterface')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Xml\XmlMandateMigrationInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Xml\NullXmlMandateMigration
     */
    protected function getByrokrat_Giroapp_Xml_XmlMandateMigrationInterfaceService()
    {
        return $this->services['byrokrat\giroapp\Xml\XmlMandateMigrationInterface'] = new \byrokrat\giroapp\Xml\NullXmlMandateMigration();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Xml\XmlMandateParser' shared autowired service.
     *
     * @return \byrokrat\giroapp\Xml\XmlMandateParser
     */
    protected function getByrokrat_Giroapp_Xml_XmlMandateParserService()
    {
        return $this->services['byrokrat\giroapp\Xml\XmlMandateParser'] = new \byrokrat\giroapp\Xml\XmlMandateParser(${($_ = isset($this->services['organization_id']) ? $this->services['organization_id'] : $this->get('organization_id')) && false ?: '_'}, ${($_ = isset($this->services['organization_bg']) ? $this->services['organization_bg'] : $this->get('organization_bg')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Builder\DonorBuilder']) ? $this->services['byrokrat\giroapp\Builder\DonorBuilder'] : $this->get('byrokrat\giroapp\Builder\DonorBuilder')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Xml\CustomdataTranslator']) ? $this->services['byrokrat\giroapp\Xml\CustomdataTranslator'] : $this->get('byrokrat\giroapp\Xml\CustomdataTranslator')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->get('byrokrat\banking\AccountFactory')) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->get('byrokrat\id\IdFactory')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\id\IdFactory' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getByrokrat_Id_IdFactoryService()
    {
        return $this->services['byrokrat\id\IdFactory'] = new \byrokrat\id\PersonalIdFactory(${($_ = isset($this->services['byrokrat\id\OrganizationIdFactory']) ? $this->services['byrokrat\id\OrganizationIdFactory'] : $this->get('byrokrat\id\OrganizationIdFactory')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\id\OrganizationIdFactory' shared service.
     *
     * @return \byrokrat\id\OrganizationIdFactory
     */
    protected function getByrokrat_Id_OrganizationIdFactoryService()
    {
        return $this->services['byrokrat\id\OrganizationIdFactory'] = new \byrokrat\id\OrganizationIdFactory();
    }

    /**
     * Gets the public 'db' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Yaysondb
     */
    protected function getDbService()
    {
        return $this->services['db'] = new \hanneskod\yaysondb\Yaysondb(array('settings' => ${($_ = isset($this->services['db_settings_engine']) ? $this->services['db_settings_engine'] : $this->get('db_settings_engine')) && false ?: '_'}, 'donors' => ${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->get('db_donor_engine')) && false ?: '_'}, 'transactions' => ${($_ = isset($this->services['db_transaction_engine']) ? $this->services['db_transaction_engine'] : $this->get('db_transaction_engine')) && false ?: '_'}, 'log' => ${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->get('db_log_engine')) && false ?: '_'}));
    }

    /**
     * Gets the public 'db_donor_collection' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Collection
     */
    protected function getDbDonorCollectionService()
    {
        return $this->services['db_donor_collection'] = new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->get('db_donor_engine')) && false ?: '_'});
    }

    /**
     * Gets the public 'db_donor_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbDonorEngineService()
    {
        return $this->services['db_donor_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/donors.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
    }

    /**
     * Gets the public 'db_log_collection' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Collection
     */
    protected function getDbLogCollectionService()
    {
        return $this->services['db_log_collection'] = new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->get('db_log_engine')) && false ?: '_'});
    }

    /**
     * Gets the public 'db_log_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\LogEngine
     */
    protected function getDbLogEngineService()
    {
        return $this->services['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('GIROAPP_PATH').'/var/log');
    }

    /**
     * Gets the public 'db_settings_collection' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Collection
     */
    protected function getDbSettingsCollectionService()
    {
        return $this->services['db_settings_collection'] = new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_settings_engine']) ? $this->services['db_settings_engine'] : $this->get('db_settings_engine')) && false ?: '_'});
    }

    /**
     * Gets the public 'db_settings_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbSettingsEngineService()
    {
        return $this->services['db_settings_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/settings.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
    }

    /**
     * Gets the public 'db_transaction_collection' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Collection
     */
    protected function getDbTransactionCollectionService()
    {
        return $this->services['db_transaction_collection'] = new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_transaction_engine']) ? $this->services['db_transaction_engine'] : $this->get('db_transaction_engine')) && false ?: '_'});
    }

    /**
     * Gets the public 'db_transaction_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbTransactionEngineService()
    {
        return $this->services['db_transaction_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/transactions.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
    }

    /**
     * Gets the public 'event_dispatcher' shared autowired service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->get('byrokrat\giroapp\Listener\LoggingListener')) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->get('byrokrat\giroapp\Listener\LoggingListener')) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->get('byrokrat\giroapp\Listener\LoggingListener')) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->get('byrokrat\giroapp\Listener\OutputtingListener')) && false ?: '_'};
        }, 1 => 'onERROREVENT'), -10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->get('byrokrat\giroapp\Listener\OutputtingListener')) && false ?: '_'};
        }, 1 => 'onWARNINGEVENT'), -10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->get('byrokrat\giroapp\Listener\OutputtingListener')) && false ?: '_'};
        }, 1 => 'onINFOEVENT'), -10);
        $instance->addListener('DEBUG_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->get('byrokrat\giroapp\Listener\OutputtingListener')) && false ?: '_'};
        }, 1 => 'onDEBUGEVENT'), -10);
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingListener'] : $this->get('byrokrat\giroapp\Listener\ImportingListener')) && false ?: '_'};
        }, 1 => 'onIMPORTEVENT'), 9);
        $instance->addListener('IMPORT_AUTOGIRO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] : $this->get('byrokrat\giroapp\Listener\ImportingAutogiroListener')) && false ?: '_'};
        }, 1 => 'onIMPORTAUTOGIROEVENT'), 9);
        $instance->addListener('IMPORT_XML_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingXmlListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] : $this->get('byrokrat\giroapp\Listener\ImportingXmlListener')) && false ?: '_'};
        }, 1 => 'onIMPORTXMLEVENT'), 9);
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener']) ? $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] : $this->get('byrokrat\giroapp\Listener\InvalidNodeFilteringListener')) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'), 10);
        $instance->addListener('EXECUTION_END_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\CommittingListener']) ? $this->services['byrokrat\giroapp\Listener\CommittingListener'] : $this->get('byrokrat\giroapp\Listener\CommittingListener')) && false ?: '_'};
        }, 1 => 'onEXECUTIONENDEVENT'), 1);
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandateResponseListener']) ? $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] : $this->get('byrokrat\giroapp\Listener\MandateResponseListener')) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'), 1);
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->get('byrokrat\giroapp\Listener\MandatePersistingListener')) && false ?: '_'};
        }, 1 => 'onMANDATEADDEDEVENT'), 10);
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->get('byrokrat\giroapp\ApplicationMonitor')) && false ?: '_'};
        }, 1 => 'dispatchWarning'), 10);
        ${($_ = isset($this->services['byrokrat\giroapp\DI\PluginLoader']) ? $this->services['byrokrat\giroapp\DI\PluginLoader'] : $this->get('byrokrat\giroapp\DI\PluginLoader')) && false ?: '_'}->loadPlugins($instance);

        return $instance;
    }

    /**
     * Gets the public 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\AccountNumber
     */
    protected function getOrganizationBgService()
    {
        return $this->services['organization_bg'] = ${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->get('byrokrat\banking\BankgiroFactory')) && false ?: '_'}->createAccount(${($_ = isset($this->services['byrokrat\giroapp\Mapper\SettingsMapper']) ? $this->services['byrokrat\giroapp\Mapper\SettingsMapper'] : $this->get('byrokrat\giroapp\Mapper\SettingsMapper')) && false ?: '_'}->findByKey("bankgiro"));
    }

    /**
     * Gets the public 'organization_id' shared autowired service.
     *
     * @return \byrokrat\id\Id
     */
    protected function getOrganizationIdService()
    {
        return $this->services['organization_id'] = ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->get('byrokrat\id\IdFactory')) && false ?: '_'}->create(${($_ = isset($this->services['byrokrat\giroapp\Mapper\SettingsMapper']) ? $this->services['byrokrat\giroapp\Mapper\SettingsMapper'] : $this->get('byrokrat\giroapp\Mapper\SettingsMapper')) && false ?: '_'}->findByKey("org_number"));
    }

    /**
     * Gets the private 'filesystem' shared service.
     *
     * @return \League\Flysystem\Filesystem
     */
    protected function getFilesystemService()
    {
        $this->services['filesystem'] = $instance = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($this->getEnv('GIROAPP_PATH')));

        (new \byrokrat\giroapp\DI\FilesystemConfigurator(array(0 => 'data/settings.json', 1 => 'data/donors.json', 2 => 'data/transactions.json', 3 => 'var/log'), array(0 => 'plugins')))->createFiles($instance);

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters) || isset($this->loadedDynamicParameters[$name]))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters) || isset($this->loadedDynamicParameters[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = array(
        'user.dir' => false,
    );
    private $dynamicParameters = array();

    /**
     * Computes a dynamic parameter.
     *
     * @param string The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        switch ($name) {
            case 'user.dir': $value = $this->getEnv('GIROAPP_PATH'); break;
            default: throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
        }
        $this->loadedDynamicParameters[$name] = true;

        return $this->dynamicParameters[$name] = $value;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'db.settings' => 'data/settings.json',
            'db.donors' => 'data/donors.json',
            'db.transactions' => 'data/transactions.json',
            'db.log' => 'var/log',
            'env(giroapp_path)' => 'giroapp',
            'plugins.dir' => 'plugins',
        );
    }
}