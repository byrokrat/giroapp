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
        $this->methodMap = array(
            'Symfony\\Component\\Console\\Application' => 'getApplicationService',
            'byrokrat\\giroapp\\Console\\AddCommand' => 'getAddCommandService',
            'byrokrat\\giroapp\\Console\\EditCommand' => 'getEditCommandService',
            'byrokrat\\giroapp\\Console\\ExportCommand' => 'getExportCommandService',
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => 'getQuestionFactoryService',
            'byrokrat\\giroapp\\Console\\ImportCommand' => 'getImportCommandService',
            'byrokrat\\giroapp\\Console\\LsCommand' => 'getLsCommandService',
            'byrokrat\\giroapp\\Console\\MigrateCommand' => 'getMigrateCommandService',
            'byrokrat\\giroapp\\Console\\PurgeCommand' => 'getPurgeCommandService',
            'byrokrat\\giroapp\\Console\\RemoveCommand' => 'getRemoveCommandService',
            'byrokrat\\giroapp\\Console\\RevokeCommand' => 'getRevokeCommandService',
            'byrokrat\\giroapp\\Console\\ShowCommand' => 'getShowCommandService',
            'byrokrat\\giroapp\\Console\\StatusCommand' => 'getStatusCommandService',
            'byrokrat\\giroapp\\Console\\ValidateCommand' => 'getValidateCommandService',
            'byrokrat\\giroapp\\Plugin\\EnvironmentInterface' => 'getEnvironmentInterfaceService',
            'configs' => 'getConfigsService',
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
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => true,
            'Symfony\\Component\\Filesystem\\Filesystem' => true,
            'byrokrat\\autogiro\\Parser\\ParserFactory' => true,
            'byrokrat\\autogiro\\Parser\\ParserInterface' => true,
            'byrokrat\\autogiro\\Writer\\WriterFactory' => true,
            'byrokrat\\autogiro\\Writer\\WriterInterface' => true,
            'byrokrat\\banking\\AccountFactoryInterface' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\AutogiroVisitor' => true,
            'byrokrat\\giroapp\\AutogiroWriterFactory' => true,
            'byrokrat\\giroapp\\Config\\ConfigManager' => true,
            'byrokrat\\giroapp\\Config\\IniFileLoader' => true,
            'byrokrat\\giroapp\\Config\\OrgBankgiroFactory' => true,
            'byrokrat\\giroapp\\Config\\OrgIdFactory' => true,
            'byrokrat\\giroapp\\Console\\Helper\\Validators' => true,
            'byrokrat\\giroapp\\Filesystem\\Filesystem' => true,
            'byrokrat\\giroapp\\Filesystem\\FilesystemConfigurator' => true,
            'byrokrat\\giroapp\\Filesystem\\FilesystemInterface' => true,
            'byrokrat\\giroapp\\Filesystem\\HashedFile' => true,
            'byrokrat\\giroapp\\Filesystem\\NullProcessor' => true,
            'byrokrat\\giroapp\\Filesystem\\RenamingProcessor' => true,
            'byrokrat\\giroapp\\Filesystem\\Sha256File' => true,
            'byrokrat\\giroapp\\Filter\\ExportableFilter' => true,
            'byrokrat\\giroapp\\Filter\\FilterContainer' => true,
            'byrokrat\\giroapp\\Filter\\InactiveFilter' => true,
            'byrokrat\\giroapp\\Filter\\NullFilter' => true,
            'byrokrat\\giroapp\\Formatter\\CsvFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\FormatterContainer' => true,
            'byrokrat\\giroapp\\Formatter\\HumanFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\JsonFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\ListFormatter' => true,
            'byrokrat\\giroapp\\Listener\\AutogiroImportingListener' => true,
            'byrokrat\\giroapp\\Listener\\CommittingListener' => true,
            'byrokrat\\giroapp\\Listener\\DonorPersistingListener' => true,
            'byrokrat\\giroapp\\Listener\\FileImportChecksumListener' => true,
            'byrokrat\\giroapp\\Listener\\FileImportingListener' => true,
            'byrokrat\\giroapp\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => true,
            'byrokrat\\giroapp\\Listener\\MonitoringListener' => true,
            'byrokrat\\giroapp\\Listener\\XmlImportingListener' => true,
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => true,
            'byrokrat\\giroapp\\Mapper\\FileChecksumMapper' => true,
            'byrokrat\\giroapp\\Mapper\\FlysystemConfigurator' => true,
            'byrokrat\\giroapp\\Mapper\\LogFormatter' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\FileChecksumSchema' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\PostalAddressSchema' => true,
            'byrokrat\\giroapp\\Model\\Builder\\DonorBuilder' => true,
            'byrokrat\\giroapp\\Model\\Builder\\MandateKeyFactory' => true,
            'byrokrat\\giroapp\\Plugin\\PluginLoader' => true,
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
            'byrokrat\\giroapp\\State\\TransactionDateFactory' => true,
            'byrokrat\\giroapp\\Utils\\SystemClock' => true,
            'byrokrat\\giroapp\\Xml\\XmlFormTranslator' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateParser' => true,
            'byrokrat\\id\\IdFactoryInterface' => true,
            'byrokrat\\id\\OrganizationIdFactory' => true,
            'db' => true,
            'db_donor_collection' => true,
            'db_donor_engine' => true,
            'db_import_collection' => true,
            'db_import_engine' => true,
            'db_log_collection' => true,
            'db_log_engine' => true,
            'file_export_cwd_dumper' => true,
            'file_export_dumper' => true,
            'file_import_dumper' => true,
            'flysystem_user_dir' => true,
            'flysystem_user_dir_adapter' => true,
            'fs_cwd' => true,
            'fs_exports' => true,
            'fs_imports' => true,
            'fs_plugins' => true,
            'fs_user_dir' => true,
            'organization_bg' => true,
            'organization_id' => true,
        );
    }

    /**
     * Gets the public 'Symfony\Component\Console\Application' shared autowired service.
     *
     * @return \Symfony\Component\Console\Application
     */
    protected function getApplicationService()
    {
        return $this->services['Symfony\Component\Console\Application'] = new \Symfony\Component\Console\Application('GiroApp', '$app_version$');
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\AddCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\AddCommand
     */
    protected function getAddCommandService()
    {
        $this->services['byrokrat\giroapp\Console\AddCommand'] = $instance = new \byrokrat\giroapp\Console\AddCommand(($this->privates['byrokrat\giroapp\Model\Builder\DonorBuilder'] ?? $this->getDonorBuilderService()));

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setValidators(($this->privates['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));

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
        $instance->setValidators(($this->privates['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ExportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ExportCommand
     */
    protected function getExportCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ExportCommand'] = $instance = new \byrokrat\giroapp\Console\ExportCommand((new \byrokrat\giroapp\AutogiroWriterFactory(new \byrokrat\autogiro\Writer\WriterFactory()))->createWriter(($this->services['configs'] ?? $this->getConfigsService())->getConfig("org_bgc_nr"), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService())), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()));

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
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
     * Gets the public 'byrokrat\giroapp\Console\ImportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ImportCommand
     */
    protected function getImportCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ImportCommand'] = $instance = new \byrokrat\giroapp\Console\ImportCommand(($this->privates['fs_cwd'] ?? $this->getFsCwdService()));

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\LsCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\LsCommand
     */
    protected function getLsCommandService()
    {
        $this->services['byrokrat\giroapp\Console\LsCommand'] = $instance = new \byrokrat\giroapp\Console\LsCommand(($this->privates['byrokrat\giroapp\Filter\FilterContainer'] ?? $this->privates['byrokrat\giroapp\Filter\FilterContainer'] = new \byrokrat\giroapp\Filter\FilterContainer()), ($this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] ?? $this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] = new \byrokrat\giroapp\Formatter\FormatterContainer()));

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

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\PurgeCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\PurgeCommand
     */
    protected function getPurgeCommandService()
    {
        $this->services['byrokrat\giroapp\Console\PurgeCommand'] = $instance = new \byrokrat\giroapp\Console\PurgeCommand();

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\RemoveCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\RemoveCommand
     */
    protected function getRemoveCommandService()
    {
        $this->services['byrokrat\giroapp\Console\RemoveCommand'] = $instance = new \byrokrat\giroapp\Console\RemoveCommand();

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->privates['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

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
        $instance->setValidators(($this->privates['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));
        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ShowCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ShowCommand
     */
    protected function getShowCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ShowCommand'] = $instance = new \byrokrat\giroapp\Console\ShowCommand(($this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] ?? $this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] = new \byrokrat\giroapp\Formatter\FormatterContainer()));

        $instance->setDonorMapper(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
        $instance->setValidators(($this->privates['byrokrat\giroapp\Console\Helper\Validators'] ?? $this->getValidatorsService()));

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
        return $this->services['byrokrat\giroapp\Console\ValidateCommand'] = new \byrokrat\giroapp\Console\ValidateCommand(new \byrokrat\giroapp\Filesystem\Filesystem($this->getEnv('GIROAPP_PATH'), ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? $this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())), ($this->privates['byrokrat\giroapp\Mapper\Schema\DonorSchema'] ?? $this->getDonorSchemaService())->getJsonSchema(), new \JsonSchema\Validator());
    }

    /**
     * Gets the public 'byrokrat\giroapp\Plugin\EnvironmentInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Plugin\Environment
     */
    protected function getEnvironmentInterfaceService()
    {
        $this->services['byrokrat\giroapp\Plugin\EnvironmentInterface'] = $instance = new \byrokrat\giroapp\Plugin\Environment(($this->services['Symfony\Component\Console\Application'] ?? $this->services['Symfony\Component\Console\Application'] = new \Symfony\Component\Console\Application('GiroApp', '$app_version$')), ($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()), ($this->privates['byrokrat\giroapp\Filter\FilterContainer'] ?? $this->privates['byrokrat\giroapp\Filter\FilterContainer'] = new \byrokrat\giroapp\Filter\FilterContainer()), ($this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] ?? $this->privates['byrokrat\giroapp\Formatter\FormatterContainer'] = new \byrokrat\giroapp\Formatter\FormatterContainer()), ($this->services['configs'] ?? $this->getConfigsService()), ($this->privates['byrokrat\giroapp\Xml\XmlFormTranslator'] ?? $this->privates['byrokrat\giroapp\Xml\XmlFormTranslator'] = new \byrokrat\giroapp\Xml\XmlFormTranslator()));

        $a = new \byrokrat\giroapp\Filesystem\Filesystem($this->getEnv('string:GIROAPP_PATH').'/plugins', ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? $this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem()));
        ($this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] ?? $this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator())->createCurrentDirectory($a);

        (new \byrokrat\giroapp\Plugin\PluginLoader($a))->loadPlugins($instance);

        return $instance;
    }

    /**
     * Gets the public 'configs' shared autowired service.
     *
     * @return \byrokrat\giroapp\Config\ConfigManager
     */
    protected function getConfigsService()
    {
        $this->services['configs'] = $instance = new \byrokrat\giroapp\Config\ConfigManager();

        (new \byrokrat\giroapp\Config\IniFileLoader($this->getEnv('GIROAPP_INI_FILE'), ($this->privates['fs_cwd'] ?? $this->getFsCwdService())))->loadIniFile($instance);

        return $instance;
    }

    /**
     * Gets the private 'Symfony\Component\EventDispatcher\EventDispatcherInterface' shared autowired service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcherInterfaceService()
    {
        $this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('EXECUTION_STARTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchDebug'), 10);
        $instance->addListener('EXECUTION_STOPED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchDebug'), 10);
        $instance->addListener('FILE_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('FILE_EXPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('FILE_FORCEFULLY_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('DONOR_ADDED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('DONOR_UPDATED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_APPROVED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_REVOKED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('DONOR_REMOVED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_INVALIDATED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = new \byrokrat\giroapp\Listener\MonitoringListener());
        }, 1 => 'dispatchWarning'), 10);
        $instance->addListener('ERROR', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('WARNING', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('INFO', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('FILE_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportChecksumListener'] ?? $this->getFileImportChecksumListenerService());
        }, 1 => 'onFILEIMPORTED'), 10);
        $instance->addListener('FILE_IMPORTED', array(0 => function () {
            return ($this->privates['file_import_dumper'] ?? $this->getFileImportDumperService());
        }, 1 => 'onFileEvent'), -10);
        $instance->addListener('FILE_FORCEFULLY_IMPORTED', array(0 => function () {
            return ($this->privates['file_import_dumper'] ?? $this->getFileImportDumperService());
        }, 1 => 'onFileEvent'), -10);
        $instance->addListener('FILE_EXPORTED', array(0 => function () {
            return ($this->privates['file_export_dumper'] ?? $this->getFileExportDumperService());
        }, 1 => 'onFileEvent'), -9);
        $instance->addListener('FILE_EXPORTED', array(0 => function () {
            return ($this->privates['file_export_cwd_dumper'] ?? $this->getFileExportCwdDumperService());
        }, 1 => 'onFileEvent'), -10);
        $instance->addListener('FILE_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportingListener'] ?? $this->privates['byrokrat\giroapp\Listener\FileImportingListener'] = new \byrokrat\giroapp\Listener\FileImportingListener());
        }, 1 => 'onFILEIMPORTED'));
        $instance->addListener('FILE_FORCEFULLY_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\FileImportingListener'] ?? $this->privates['byrokrat\giroapp\Listener\FileImportingListener'] = new \byrokrat\giroapp\Listener\FileImportingListener());
        }, 1 => 'onFileImported'));
        $instance->addListener('AUTOGIRO_FILE_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\AutogiroImportingListener'] ?? $this->getAutogiroImportingListenerService());
        }, 1 => 'onAUTOGIROFILEIMPORTED'));
        $instance->addListener('XML_FILE_IMPORTED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\XmlImportingListener'] ?? $this->getXmlImportingListenerService());
        }, 1 => 'onXMLFILEIMPORTED'));
        $instance->addListener('EXECUTION_STOPED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\CommittingListener'] ?? $this->getCommittingListenerService());
        }, 1 => 'onEXECUTIONSTOPED'));
        $instance->addListener('MANDATE_RESPONSE_RECEIVED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MandateResponseListener'] ?? $this->getMandateResponseListenerService());
        }, 1 => 'onMANDATERESPONSERECEIVED'));
        $instance->addListener('DONOR_ADDED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDONORADDED'));
        $instance->addListener('DONOR_REMOVED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDONORREMOVED'));
        $instance->addListener('DONOR_UPDATED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDonorUpdated'));
        $instance->addListener('MANDATE_APPROVED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDonorUpdated'));
        $instance->addListener('MANDATE_REVOKED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDonorUpdated'));
        $instance->addListener('MANDATE_INVALIDATED', array(0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] ?? $this->getDonorPersistingListenerService());
        }, 1 => 'onDonorUpdated'));

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\giroapp\Console\Helper\Validators' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\Validators
     */
    protected function getValidatorsService()
    {
        return $this->privates['byrokrat\giroapp\Console\Helper\Validators'] = new \byrokrat\giroapp\Console\Helper\Validators(($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? $this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory()), ($this->privates['byrokrat\banking\BankgiroFactory'] ?? $this->privates['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()), ($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Filesystem\RenamingProcessor' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\RenamingProcessor
     */
    protected function getRenamingProcessorService()
    {
        return $this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] = new \byrokrat\giroapp\Filesystem\RenamingProcessor(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\AutogiroImportingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\AutogiroImportingListener
     */
    protected function getAutogiroImportingListenerService()
    {
        $a = new \byrokrat\giroapp\AutogiroVisitor(($this->services['configs'] ?? $this->getConfigsService())->getConfig("org_bgc_nr"), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService()));
        $a->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $this->privates['byrokrat\giroapp\Listener\AutogiroImportingListener'] = new \byrokrat\giroapp\Listener\AutogiroImportingListener((new \byrokrat\autogiro\Parser\ParserFactory())->createParser(), $a);
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\CommittingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\CommittingListener
     */
    protected function getCommittingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\CommittingListener'] = new \byrokrat\giroapp\Listener\CommittingListener(new \hanneskod\yaysondb\Yaysondb(array('donors' => ($this->privates['db_donor_engine'] ?? $this->getDbDonorEngineService()), 'imports' => ($this->privates['db_import_engine'] ?? $this->getDbImportEngineService()), 'log' => ($this->privates['db_log_engine'] ?? $this->getDbLogEngineService()))));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\DonorPersistingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\DonorPersistingListener
     */
    protected function getDonorPersistingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\DonorPersistingListener'] = new \byrokrat\giroapp\Listener\DonorPersistingListener(($this->privates['byrokrat\giroapp\Mapper\DonorMapper'] ?? $this->getDonorMapperService()));
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
     * Gets the private 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getLoggingListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener(new \hanneskod\yaysondb\Collection(($this->privates['db_log_engine'] ?? $this->getDbLogEngineService())));
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
     * Gets the private 'byrokrat\giroapp\Listener\XmlImportingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\XmlImportingListener
     */
    protected function getXmlImportingListenerService()
    {
        $a = ($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService());

        return $this->privates['byrokrat\giroapp\Listener\XmlImportingListener'] = new \byrokrat\giroapp\Listener\XmlImportingListener(new \byrokrat\giroapp\Xml\XmlMandateParser((new \byrokrat\giroapp\Config\OrgIdFactory($a))->createId(($this->services['configs'] ?? $this->getConfigsService())->getConfig("org_id")), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService()), ($this->privates['byrokrat\giroapp\Model\Builder\DonorBuilder'] ?? $this->getDonorBuilderService()), ($this->privates['byrokrat\giroapp\Xml\XmlFormTranslator'] ?? $this->privates['byrokrat\giroapp\Xml\XmlFormTranslator'] = new \byrokrat\giroapp\Xml\XmlFormTranslator()), ($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? $this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory()), $a));
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
        return $this->privates['byrokrat\giroapp\Mapper\Schema\DonorSchema'] = new \byrokrat\giroapp\Mapper\Schema\DonorSchema(new \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema(), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()), ($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? $this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory()), ($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Model\Builder\DonorBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Model\Builder\DonorBuilder
     */
    protected function getDonorBuilderService()
    {
        return $this->privates['byrokrat\giroapp\Model\Builder\DonorBuilder'] = new \byrokrat\giroapp\Model\Builder\DonorBuilder(new \byrokrat\giroapp\Model\Builder\MandateKeyFactory(), ($this->privates['byrokrat\giroapp\State\StatePool'] ?? $this->getStatePoolService()), ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\State\StatePool' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\StatePool
     */
    protected function getStatePoolService()
    {
        return $this->privates['byrokrat\giroapp\State\StatePool'] = new \byrokrat\giroapp\State\StatePool(new \byrokrat\giroapp\State\ActiveState(), new \byrokrat\giroapp\State\ErrorState(), new \byrokrat\giroapp\State\InactiveState(), new \byrokrat\giroapp\State\NewMandateState(), new \byrokrat\giroapp\State\NewDigitalMandateState(), new \byrokrat\giroapp\State\MandateSentState(), new \byrokrat\giroapp\State\MandateApprovedState(new \byrokrat\giroapp\State\TransactionDateFactory(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? $this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()), ($this->services['configs'] ?? $this->getConfigsService())->getConfig("trans_day_of_month"), ($this->services['configs'] ?? $this->getConfigsService())->getConfig("trans_min_days_in_future"))), new \byrokrat\giroapp\State\RevokeMandateState(), new \byrokrat\giroapp\State\RevocationSentState());
    }

    /**
     * Gets the private 'byrokrat\id\IdFactoryInterface' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getIdFactoryInterfaceService()
    {
        return $this->privates['byrokrat\id\IdFactoryInterface'] = new \byrokrat\id\PersonalIdFactory(new \byrokrat\id\OrganizationIdFactory());
    }

    /**
     * Gets the private 'db_donor_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbDonorEngineService()
    {
        return $this->privates['db_donor_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/donors.json', ($this->privates['flysystem_user_dir'] ?? $this->getFlysystemUserDirService()));
    }

    /**
     * Gets the private 'db_import_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbImportEngineService()
    {
        return $this->privates['db_import_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/imports.json', ($this->privates['flysystem_user_dir'] ?? $this->getFlysystemUserDirService()));
    }

    /**
     * Gets the private 'db_log_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\LogEngine
     */
    protected function getDbLogEngineService()
    {
        return $this->privates['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('string:GIROAPP_PATH').'/var/log', new \byrokrat\giroapp\Mapper\LogFormatter());
    }

    /**
     * Gets the private 'file_export_cwd_dumper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileDumpingListener
     */
    protected function getFileExportCwdDumperService()
    {
        return $this->privates['file_export_cwd_dumper'] = new \byrokrat\giroapp\Listener\FileDumpingListener(($this->privates['fs_cwd'] ?? $this->getFsCwdService()), new \byrokrat\giroapp\Filesystem\NullProcessor());
    }

    /**
     * Gets the private 'file_export_dumper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileDumpingListener
     */
    protected function getFileExportDumperService()
    {
        $a = new \byrokrat\giroapp\Filesystem\Filesystem($this->getEnv('string:GIROAPP_PATH').'/var/exports', ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? $this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem()));
        ($this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] ?? $this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator())->createCurrentDirectory($a);

        return $this->privates['file_export_dumper'] = new \byrokrat\giroapp\Listener\FileDumpingListener($a, ($this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] ?? $this->getRenamingProcessorService()));
    }

    /**
     * Gets the private 'file_import_dumper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileDumpingListener
     */
    protected function getFileImportDumperService()
    {
        $a = new \byrokrat\giroapp\Filesystem\Filesystem($this->getEnv('string:GIROAPP_PATH').'/var/imports', ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? $this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem()));
        ($this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] ?? $this->privates['byrokrat\giroapp\Filesystem\FilesystemConfigurator'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator())->createCurrentDirectory($a);

        return $this->privates['file_import_dumper'] = new \byrokrat\giroapp\Listener\FileDumpingListener($a, ($this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] ?? $this->getRenamingProcessorService()));
    }

    /**
     * Gets the private 'flysystem_user_dir' shared autowired service.
     *
     * @return \League\Flysystem\Filesystem
     */
    protected function getFlysystemUserDirService()
    {
        $this->privates['flysystem_user_dir'] = $instance = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($this->getEnv('GIROAPP_PATH')));

        (new \byrokrat\giroapp\Mapper\FlysystemConfigurator(array(0 => 'data/donors.json', 1 => 'var/log', 2 => 'data/imports.json')))->createFiles($instance);

        return $instance;
    }

    /**
     * Gets the private 'fs_cwd' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\Filesystem
     */
    protected function getFsCwdService()
    {
        return $this->privates['fs_cwd'] = new \byrokrat\giroapp\Filesystem\Filesystem('.', ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? $this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem()));
    }

    /**
     * Gets the private 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\AccountNumber
     */
    protected function getOrganizationBgService()
    {
        return $this->privates['organization_bg'] = (new \byrokrat\giroapp\Config\OrgBankgiroFactory(($this->privates['byrokrat\banking\BankgiroFactory'] ?? $this->privates['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory())))->createAccount(($this->services['configs'] ?? $this->getConfigsService())->getConfig("org_bg"));
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
        'fs.plugins_dir' => false,
        'fs.imports_dir' => false,
        'fs.exports_dir' => false,
        'env(GIROAPP_INI_FILE)' => false,
        'app.ini_file_name' => false,
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
            case 'fs.plugins_dir': $value = $this->getEnv('string:GIROAPP_PATH').'/plugins'; break;
            case 'fs.imports_dir': $value = $this->getEnv('string:GIROAPP_PATH').'/var/imports'; break;
            case 'fs.exports_dir': $value = $this->getEnv('string:GIROAPP_PATH').'/var/exports'; break;
            case 'env(GIROAPP_INI_FILE)': $value = $this->getEnv('string:GIROAPP_PATH').'/giroapp.ini'; break;
            case 'app.ini_file_name': $value = $this->getEnv('GIROAPP_INI_FILE'); break;
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
            'fs.internal_data_dir' => 'data',
            'fs.external_data_dir' => 'var',
            'db.donors' => 'data/donors.json',
            'db.imports' => 'data/imports.json',
            'db.log' => 'var/log',
            'app.name' => 'GiroApp',
            'app.version' => '$app_version$',
            'env(GIROAPP_PATH)' => 'giroapp',
        );
    }
}
