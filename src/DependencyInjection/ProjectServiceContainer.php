<?php

namespace byrokrat\giroapp\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
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
     * @internal but protected for BC on cache:clear
     */
    protected $privates = array();

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = array();
        $this->syntheticIds = array(
            'Symfony\\Component\\Console\\Helper\\QuestionHelper' => true,
            'Symfony\\Component\\Console\\Input\\InputInterface' => true,
            'err_out' => true,
            'std_in' => true,
            'std_out' => true,
        );
        $this->methodMap = array(
            'Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => 'getEventDispatcherInterfaceService',
            'byrokrat\\giroapp\\Console\\AddCommand' => 'getAddCommandService',
            'byrokrat\\giroapp\\Console\\DropCommand' => 'getDropCommandService',
            'byrokrat\\giroapp\\Console\\EditCommand' => 'getEditCommandService',
            'byrokrat\\giroapp\\Console\\ExportCommand' => 'getExportCommandService',
            'byrokrat\\giroapp\\Console\\Helper\\InputReader' => 'getInputReaderService',
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => 'getQuestionFactoryService',
            'byrokrat\\giroapp\\Console\\Helper\\Validators' => 'getValidatorsService',
            'byrokrat\\giroapp\\Console\\ImportCommand' => 'getImportCommandService',
            'byrokrat\\giroapp\\Console\\InitCommand' => 'getInitCommandService',
            'byrokrat\\giroapp\\Console\\LsCommand' => 'getLsCommandService',
            'byrokrat\\giroapp\\Console\\MigrateCommand' => 'getMigrateCommandService',
            'byrokrat\\giroapp\\Console\\RevokeCommand' => 'getRevokeCommandService',
            'byrokrat\\giroapp\\Console\\ShowCommand' => 'getShowCommandService',
            'byrokrat\\giroapp\\Console\\StatusCommand' => 'getStatusCommandService',
            'byrokrat\\giroapp\\Console\\ValidateCommand' => 'getValidateCommandService',
            'byrokrat\\giroapp\\Listener\\ExitStatusListener' => 'getExitStatusListenerService',
            'db_settings_mapper' => 'getDbSettingsMapperService',
        );

        $this->aliases = array();
    }

    public function reset()
    {
        $this->privates = array();
        parent::reset();
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function getRemovedIds()
    {
        return array(
            'JsonSchema\\Validator' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Symfony\\Component\\Console\\Output\\OutputInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'byrokrat\\autogiro\\Parser\\Parser' => true,
            'byrokrat\\autogiro\\Parser\\ParserFactory' => true,
            'byrokrat\\autogiro\\Writer\\Writer' => true,
            'byrokrat\\autogiro\\Writer\\WriterFactory' => true,
            'byrokrat\\banking\\AccountFactory' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\Builder\\DateBuilder' => true,
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => true,
            'byrokrat\\giroapp\\Builder\\MandateKeyBuilder' => true,
            'byrokrat\\giroapp\\Listener\\CommittingListener' => true,
            'byrokrat\\giroapp\\Listener\\FileImportChecksumListener' => true,
            'byrokrat\\giroapp\\Listener\\FileImportDumpingListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => true,
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => true,
            'byrokrat\\giroapp\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => true,
            'byrokrat\\giroapp\\Listener\\MonitoringListener' => true,
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => true,
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => true,
            'byrokrat\\giroapp\\Mapper\\FileChecksumMapper' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\FileChecksumSchema' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\PostalAddressSchema' => true,
            'byrokrat\\giroapp\\Mapper\\SettingsMapper' => true,
            'byrokrat\\giroapp\\Mapper\\TransactionMapper' => true,
            'byrokrat\\giroapp\\Setup\\FilesystemConfigurator' => true,
            'byrokrat\\giroapp\\Setup\\LogFormatter' => true,
            'byrokrat\\giroapp\\Setup\\PluginLoader' => true,
            'byrokrat\\giroapp\\State\\ActiveState' => true,
            'byrokrat\\giroapp\\State\\ErrorState' => true,
            'byrokrat\\giroapp\\State\\InactiveState' => true,
            'byrokrat\\giroapp\\State\\MandateApprovedState' => true,
            'byrokrat\\giroapp\\State\\MandateSentState' => true,
            'byrokrat\\giroapp\\State\\NewDigitalMandateState' => true,
            'byrokrat\\giroapp\\State\\NewMandateState' => true,
            'byrokrat\\giroapp\\State\\RevocationSentState' => true,
            'byrokrat\\giroapp\\State\\RevokeMandateState' => true,
            'byrokrat\\giroapp\\State\\StatePool' => true,
            'byrokrat\\giroapp\\Utils\\File' => true,
            'byrokrat\\giroapp\\Utils\\FileReader' => true,
            'byrokrat\\giroapp\\Utils\\SystemClock' => true,
            'byrokrat\\giroapp\\Xml\\CustomdataTranslator' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateMigrationInterface' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateParser' => true,
            'byrokrat\\id\\IdFactory' => true,
            'byrokrat\\id\\OrganizationIdFactory' => true,
            'db' => true,
            'db_donor_collection' => true,
            'db_donor_engine' => true,
            'db_import_collection' => true,
            'db_import_engine' => true,
            'db_log_collection' => true,
            'db_log_engine' => true,
            'db_settings_collection' => true,
            'db_settings_engine' => true,
            'db_transaction_collection' => true,
            'db_transaction_engine' => true,
            'fs_cwd' => true,
            'fs_cwd_adapter' => true,
            'fs_cwd_reader' => true,
            'fs_imports' => true,
            'fs_imports_adapter' => true,
            'fs_user_dir' => true,
            'fs_user_dir_adapter' => true,
            'fs_user_dir_reader' => true,
            'organization_bg' => true,
            'organization_id' => true,
        );
    }

    /**
     * Gets the public 'Symfony\Component\EventDispatcher\EventDispatcherInterface' shared autowired service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcherInterfaceService()
    {
        $this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('FORCE_IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchWarning'), 10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\OutputtingListener'] ?? $this->privates['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(($this->services['std_out'] ?? $this->get('std_out')), ($this->services['err_out'] ?? $this->get('err_out'))));
        }, 1 => 'onERROREVENT'), -10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\OutputtingListener'] ?? $this->privates['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(($this->services['std_out'] ?? $this->get('std_out')), ($this->services['err_out'] ?? $this->get('err_out'))));
        }, 1 => 'onWARNINGEVENT'), -10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\OutputtingListener'] ?? $this->privates['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(($this->services['std_out'] ?? $this->get('std_out')), ($this->services['err_out'] ?? $this->get('err_out'))));
        }, 1 => 'onINFOEVENT'), -10);
        $instance->addListener('DEBUG_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\OutputtingListener'] ?? $this->privates['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(($this->services['std_out'] ?? $this->get('std_out')), ($this->services['err_out'] ?? $this->get('err_out'))));
        }, 1 => 'onDEBUGEVENT'), -10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ($this->services['byrokrat\giroapp\Listener\ExitStatusListener'] ?? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener());
        }, 1 => 'onFailure'));
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ($this->services['byrokrat\giroapp\Listener\ExitStatusListener'] ?? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener());
        }, 1 => 'onFailure'));
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportChecksumListener'] ?? $this->getFileImportChecksumListenerService());
        }, 1 => 'onIMPORTEVENT'), 10);
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportDumpingListener'] ?? $this->getFileImportDumpingListenerService());
        }, 1 => 'onIMPORTEVENT'), -10);
        $instance->addListener('FORCE_IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportDumpingListener'] ?? $this->getFileImportDumpingListenerService());
        }, 1 => 'onImportEvent'), -10);
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportingListener'] ?? $this->privates['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener());
        }, 1 => 'onIMPORTEVENT'));
        $instance->addListener('FORCE_IMPORT_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportingListener'] ?? $this->privates['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener());
        }, 1 => 'onImportEvent'));
        $instance->addListener('IMPORT_AUTOGIRO_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportingAutogiroListener'] ?? $this->getImportingAutogiroListenerService());
        }, 1 => 'onIMPORTAUTOGIROEVENT'));
        $instance->addListener('IMPORT_XML_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportingXmlListener'] ?? $this->getImportingXmlListenerService());
        }, 1 => 'onIMPORTXMLEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] ?? $this->getInvalidNodeFilteringListenerService());
        }, 1 => 'onMANDATERESPONSEEVENT'), 10);
        $instance->addListener('EXECUTION_END_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\CommittingListener'] ?? $this->getCommittingListenerService());
        }, 1 => 'onEXECUTIONENDEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandateResponseListener'] ?? $this->getMandateResponseListenerService());
        }, 1 => 'onMANDATERESPONSEEVENT'));
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMANDATEADDEDEVENT'));
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMANDATEDROPPEDEVENT'));
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] ?? $this->getMandatePersistingListenerService());
        }, 1 => 'onMandateUpdatedEvent'));
        (new \byrokrat\giroapp\Setup\PluginLoader($this->getEnv('string:GIROAPP_PATH').'/plugins', ($this->privates['fs_user_dir'] ?? $this->getFsUserDirService())))->loadPlugins($instance);

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\AddCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\AddCommand
     */
    protected function getAddCommandService()
    {
        $this->services['byrokrat\giroapp\Console\AddCommand'] = $instance = new \byrokrat\giroapp\Console\AddCommand(($this->privates['byrokrat\giroapp\Builder\DonorBuilder'] ?? $this->getDonorBuilderService()));

        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setInputReader(($this->services['byrokrat\giroapp\Console\Helper\InputReader'] ?? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(($this->services['Symfony\Component\Console\Input\InputInterface'] ?? $this->get('Symfony\Component\Console\Input\InputInterface')), ($this->services['std_out'] ?? $this->get('std_out')), ($this->services['Symfony\Component\Console\Helper\QuestionHelper'] ?? $this->get('Symfony\Component\Console\Helper\QuestionHelper')))));
        $instance->setQuestionFactory(($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] ?? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\DropCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\DropCommand
     */
    protected function getDropCommandService()
    {
        $this->services['byrokrat\giroapp\Console\DropCommand'] = $instance = new \byrokrat\giroapp\Console\DropCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\EditCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\EditCommand
     */
    protected function getEditCommandService()
    {
        $this->services['byrokrat\giroapp\Console\EditCommand'] = $instance = new \byrokrat\giroapp\Console\EditCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setInputReader(($this->services['byrokrat\giroapp\Console\Helper\InputReader'] ?? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(($this->services['Symfony\Component\Console\Input\InputInterface'] ?? $this->get('Symfony\Component\Console\Input\InputInterface')), ($this->services['std_out'] ?? $this->get('std_out')), ($this->services['Symfony\Component\Console\Helper\QuestionHelper'] ?? $this->get('Symfony\Component\Console\Helper\QuestionHelper')))));
        $instance->setQuestionFactory(($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] ?? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ExportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ExportCommand
     */
    protected function getExportCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ExportCommand'] = $instance = new \byrokrat\giroapp\Console\ExportCommand([new \byrokrat\autogiro\Writer\WriterFactory(), 'createWriter'](($this->services['db_settings_mapper'] ?? $this->getDbSettingsMapperService())->findByKey("bgc_customer_number"), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService())), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()));

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\InputReader' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\InputReader
     */
    protected function getInputReaderService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(($this->services['Symfony\Component\Console\Input\InputInterface'] ?? $this->get('Symfony\Component\Console\Input\InputInterface')), ($this->services['std_out'] ?? $this->get('std_out')), ($this->services['Symfony\Component\Console\Helper\QuestionHelper'] ?? $this->get('Symfony\Component\Console\Helper\QuestionHelper')));
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\QuestionFactory' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\QuestionFactory
     */
    protected function getQuestionFactoryService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\Validators' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\Validators
     */
    protected function getValidatorsService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\Validators'] = new \byrokrat\giroapp\Console\Helper\Validators(($this->privates['byrokrat\banking\AccountFactory'] ?? $this->privates['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()), ($this->privates['byrokrat\banking\BankgiroFactory'] ?? $this->privates['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()), ($this->privates['byrokrat\id\IdFactory'] ?? $this->getIdFactoryService()), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()));
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ImportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ImportCommand
     */
    protected function getImportCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ImportCommand'] = $instance = new \byrokrat\giroapp\Console\ImportCommand(new \byrokrat\giroapp\Utils\FileReader(new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local('.'))), ($this->services['std_in'] ?? $this->get('std_in')));

        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\InitCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\InitCommand
     */
    protected function getInitCommandService()
    {
        $this->services['byrokrat\giroapp\Console\InitCommand'] = $instance = new \byrokrat\giroapp\Console\InitCommand(($this->services['db_settings_mapper'] ?? $this->getDbSettingsMapperService()));

        $instance->setInputReader(($this->services['byrokrat\giroapp\Console\Helper\InputReader'] ?? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(($this->services['Symfony\Component\Console\Input\InputInterface'] ?? $this->get('Symfony\Component\Console\Input\InputInterface')), ($this->services['std_out'] ?? $this->get('std_out')), ($this->services['Symfony\Component\Console\Helper\QuestionHelper'] ?? $this->get('Symfony\Component\Console\Helper\QuestionHelper')))));
        $instance->setQuestionFactory(($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] ?? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\LsCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\LsCommand
     */
    protected function getLsCommandService()
    {
        $this->services['byrokrat\giroapp\Console\LsCommand'] = $instance = new \byrokrat\giroapp\Console\LsCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\MigrateCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\MigrateCommand
     */
    protected function getMigrateCommandService()
    {
        $this->services['byrokrat\giroapp\Console\MigrateCommand'] = $instance = new \byrokrat\giroapp\Console\MigrateCommand();

        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\RevokeCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\RevokeCommand
     */
    protected function getRevokeCommandService()
    {
        $this->services['byrokrat\giroapp\Console\RevokeCommand'] = $instance = new \byrokrat\giroapp\Console\RevokeCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->services['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ShowCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ShowCommand
     */
    protected function getShowCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ShowCommand'] = $instance = new \byrokrat\giroapp\Console\ShowCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->services['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\StatusCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\StatusCommand
     */
    protected function getStatusCommandService()
    {
        $this->services['byrokrat\giroapp\Console\StatusCommand'] = $instance = new \byrokrat\giroapp\Console\StatusCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ValidateCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ValidateCommand
     */
    protected function getValidateCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ValidateCommand'] = new \byrokrat\giroapp\Console\ValidateCommand(new \byrokrat\giroapp\Utils\FileReader(($this->privates['fs_user_dir'] ?? $this->getFsUserDirService())), ($this->privates['byrokrat\giroapp\Mapper\Schema\DonorSchema'] ?? $this->getDonorSchemaService())->getJsonSchema(), new \JsonSchema\Validator());
    }

    /**
     * Gets the public 'byrokrat\giroapp\Listener\ExitStatusListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ExitStatusListener
     */
    protected function getExitStatusListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener();
    }

    /**
     * Gets the public 'db_settings_mapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\SettingsMapper
     */
    protected function getDbSettingsMapperService()
    {
        return $this->services['db_settings_mapper'] = new \byrokrat\giroapp\Mapper\SettingsMapper(new \hanneskod\yaysondb\Collection(($this->privates['db_settings_engine'] ?? $this->getDbSettingsEngineService())));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Builder\DonorBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\DonorBuilder
     */
    protected function getDonorBuilderService()
    {
        return $this->privates['byrokrat\giroapp\Builder\DonorBuilder'] = new \byrokrat\giroapp\Builder\DonorBuilder(new \byrokrat\giroapp\Builder\MandateKeyBuilder(), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\CommittingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\CommittingListener
     */
    protected function getCommittingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\CommittingListener'] = new \byrokrat\giroapp\Listener\CommittingListener(new \hanneskod\yaysondb\Yaysondb(array('settings' => ($this->privates['db_settings_engine'] ?? $this->getDbSettingsEngineService()), 'donors' => ($this->privates['db_donor_engine'] ?? $this->getDbDonorEngineService()), 'transactions' => new \hanneskod\yaysondb\Engine\FlysystemEngine('data/transactions.json', ($this->privates['fs_user_dir'] ?? $this->getFsUserDirService())), 'imports' => ($this->privates['db_import_engine'] ?? $this->getDbImportEngineService()), 'log' => ($this->privates['db_log_engine'] ?? $this->getDbLogEngineService()))));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\FileImportChecksumListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileImportChecksumListener
     */
    protected function getFileImportChecksumListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\FileImportChecksumListener'] = new \byrokrat\giroapp\Listener\FileImportChecksumListener(new \byrokrat\giroapp\Mapper\FileChecksumMapper(new \hanneskod\yaysondb\Collection(($this->privates['db_import_engine'] ?? $this->getDbImportEngineService())), new \byrokrat\giroapp\Mapper\Schema\FileChecksumSchema()), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\FileImportDumpingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileImportDumpingListener
     */
    protected function getFileImportDumpingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\FileImportDumpingListener'] = new \byrokrat\giroapp\Listener\FileImportDumpingListener(new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($this->getEnv('string:GIROAPP_PATH').'/var/imports')), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingAutogiroListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingAutogiroListener
     */
    protected function getImportingAutogiroListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\ImportingAutogiroListener'] = new \byrokrat\giroapp\Listener\ImportingAutogiroListener([new \byrokrat\autogiro\Parser\ParserFactory(), 'createParser']());
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingXmlListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingXmlListener
     */
    protected function getImportingXmlListenerService()
    {
        $a = ($this->privates['byrokrat\id\IdFactory'] ?? $this->getIdFactoryService());

        return $this->privates['byrokrat\giroapp\Listener\ImportingXmlListener'] = new \byrokrat\giroapp\Listener\ImportingXmlListener(new \byrokrat\giroapp\Xml\XmlMandateParser($a->create(($this->services['db_settings_mapper'] ?? $this->getDbSettingsMapperService())->findByKey("org_number")), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService()), ($this->privates['byrokrat\giroapp\Builder\DonorBuilder'] ?? $this->getDonorBuilderService()), new \byrokrat\giroapp\Xml\CustomdataTranslator(new \byrokrat\giroapp\Xml\NullXmlMandateMigration()), ($this->privates['byrokrat\banking\AccountFactory'] ?? $this->privates['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()), $a));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\InvalidNodeFilteringListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\InvalidNodeFilteringListener
     */
    protected function getInvalidNodeFilteringListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] = new \byrokrat\giroapp\Listener\InvalidNodeFilteringListener(($this->privates['byrokrat\banking\BankgiroFactory'] ?? $this->privates['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()), ($this->services['db_settings_mapper'] ?? $this->getDbSettingsMapperService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getLoggingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener(new \hanneskod\yaysondb\Collection(($this->privates['db_log_engine'] ?? $this->getDbLogEngineService())));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandatePersistingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandatePersistingListener
     */
    protected function getMandatePersistingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\MandatePersistingListener'] = new \byrokrat\giroapp\Listener\MandatePersistingListener(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandateResponseListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandateResponseListener
     */
    protected function getMandateResponseListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\MandateResponseListener'] = new \byrokrat\giroapp\Listener\MandateResponseListener(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Mapper\DonorMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\DonorMapper
     */
    protected function getDonorMapperService()
    {
        return $this->privates['byrokrat\giroapp\Mapper\DonorMapper'] = new \byrokrat\giroapp\Mapper\DonorMapper(new \hanneskod\yaysondb\Collection(($this->privates['db_donor_engine'] ?? $this->getDbDonorEngineService())), ($this->privates['byrokrat\giroapp\Mapper\Schema\DonorSchema'] ?? $this->getDonorSchemaService()), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Mapper\Schema\DonorSchema' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\Schema\DonorSchema
     */
    protected function getDonorSchemaService()
    {
        return $this->privates['byrokrat\giroapp\Mapper\Schema\DonorSchema'] = new \byrokrat\giroapp\Mapper\Schema\DonorSchema(new \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema(), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()), ($this->privates['byrokrat\banking\AccountFactory'] ?? $this->privates['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()), ($this->privates['byrokrat\id\IdFactory'] ?? $this->getIdFactoryService()), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\State\StatePool' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\StatePool
     */
    protected function getStatePoolService()
    {
        return $this->privates['byrokrat\giroapp\State\StatePool'] = new \byrokrat\giroapp\State\StatePool(new \byrokrat\giroapp\State\ActiveState(), new \byrokrat\giroapp\State\ErrorState(), new \byrokrat\giroapp\State\InactiveState(), new \byrokrat\giroapp\State\NewMandateState(), new \byrokrat\giroapp\State\NewDigitalMandateState(), new \byrokrat\giroapp\State\MandateSentState(), new \byrokrat\giroapp\State\MandateApprovedState(new \byrokrat\giroapp\Builder\DateBuilder(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()))), new \byrokrat\giroapp\State\RevokeMandateState(), new \byrokrat\giroapp\State\RevocationSentState());
    }

    /**
     * Gets the private 'byrokrat\id\IdFactory' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getIdFactoryService()
    {
        return $this->privates['byrokrat\id\IdFactory'] = new \byrokrat\id\PersonalIdFactory(new \byrokrat\id\OrganizationIdFactory());
    }

    /**
     * Gets the private 'db_donor_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbDonorEngineService()
    {
        return $this->privates['db_donor_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/donors.json', ($this->privates['fs_user_dir'] ?? $this->getFsUserDirService()));
    }

    /**
     * Gets the private 'db_import_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbImportEngineService()
    {
        return $this->privates['db_import_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/imports.json', ($this->privates['fs_user_dir'] ?? $this->getFsUserDirService()));
    }

    /**
     * Gets the private 'db_log_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\LogEngine
     */
    protected function getDbLogEngineService()
    {
        return $this->privates['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('string:GIROAPP_PATH').'/var/log', new \byrokrat\giroapp\Setup\LogFormatter());
    }

    /**
     * Gets the private 'db_settings_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbSettingsEngineService()
    {
        return $this->privates['db_settings_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/settings.json', ($this->privates['fs_user_dir'] ?? $this->getFsUserDirService()));
    }

    /**
     * Gets the private 'fs_user_dir' shared service.
     *
     * @return \League\Flysystem\Filesystem
     */
    protected function getFsUserDirService()
    {
        $this->privates['fs_user_dir'] = $instance = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($this->getEnv('GIROAPP_PATH')));

        (new \byrokrat\giroapp\Setup\FilesystemConfigurator(array(0 => 'data/settings.json', 1 => 'data/donors.json', 2 => 'data/transactions.json', 3 => 'var/log', 4 => 'data/imports.json'), array(0 => 'plugins')))->createFiles($instance);

        return $instance;
    }

    /**
     * Gets the private 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\Bankgiro
     */
    protected function getOrganizationBgService()
    {
        return $this->privates['organization_bg'] = ($this->privates['byrokrat\banking\BankgiroFactory'] ?? $this->privates['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory())->createAccount(($this->services['db_settings_mapper'] ?? $this->getDbSettingsMapperService())->findByKey("bankgiro"));
    }

    public function getParameter($name)
    {
        $name = (string) $name;

        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = (string) $name;

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

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
        'fs.user_dir' => false,
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
            case 'fs.user_dir': $value = $this->getEnv('GIROAPP_PATH'); break;
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
            'env(GIROAPP_PATH)' => 'giroapp',
            'fs.internal_data_dir' => 'data',
            'fs.external_data_dir' => 'var',
            'fs.plugins_dir' => 'plugins',
            'fs.imports_dir' => 'var/imports',
            'db.settings' => 'data/settings.json',
            'db.donors' => 'data/donors.json',
            'db.transactions' => 'data/transactions.json',
            'db.log' => 'var/log',
            'db.imports' => 'data/imports.json',
        );
    }
}
