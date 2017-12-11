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
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class ProjectServiceContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = array();
        $this->normalizedIds = array(
            'byrokrat\\banking\\accountfactory' => 'byrokrat\\banking\\AccountFactory',
            'byrokrat\\banking\\bankgirofactory' => 'byrokrat\\banking\\BankgiroFactory',
            'byrokrat\\giroapp\\applicationmonitor' => 'byrokrat\\giroapp\\ApplicationMonitor',
            'byrokrat\\giroapp\\builder\\donorbuilder' => 'byrokrat\\giroapp\\Builder\\DonorBuilder',
            'byrokrat\\giroapp\\console\\addcommand' => 'byrokrat\\giroapp\\Console\\AddCommand',
            'byrokrat\\giroapp\\console\\dropcommand' => 'byrokrat\\giroapp\\Console\\DropCommand',
            'byrokrat\\giroapp\\console\\editcommand' => 'byrokrat\\giroapp\\Console\\EditCommand',
            'byrokrat\\giroapp\\console\\exportcommand' => 'byrokrat\\giroapp\\Console\\ExportCommand',
            'byrokrat\\giroapp\\console\\helper\\inputreader' => 'byrokrat\\giroapp\\Console\\Helper\\InputReader',
            'byrokrat\\giroapp\\console\\helper\\questionfactory' => 'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory',
            'byrokrat\\giroapp\\console\\helper\\validators' => 'byrokrat\\giroapp\\Console\\Helper\\Validators',
            'byrokrat\\giroapp\\console\\importcommand' => 'byrokrat\\giroapp\\Console\\ImportCommand',
            'byrokrat\\giroapp\\console\\initcommand' => 'byrokrat\\giroapp\\Console\\InitCommand',
            'byrokrat\\giroapp\\console\\lscommand' => 'byrokrat\\giroapp\\Console\\LsCommand',
            'byrokrat\\giroapp\\console\\migratecommand' => 'byrokrat\\giroapp\\Console\\MigrateCommand',
            'byrokrat\\giroapp\\console\\revokecommand' => 'byrokrat\\giroapp\\Console\\RevokeCommand',
            'byrokrat\\giroapp\\console\\showcommand' => 'byrokrat\\giroapp\\Console\\ShowCommand',
            'byrokrat\\giroapp\\console\\statuscommand' => 'byrokrat\\giroapp\\Console\\StatusCommand',
            'byrokrat\\giroapp\\console\\validatecommand' => 'byrokrat\\giroapp\\Console\\ValidateCommand',
            'byrokrat\\giroapp\\listener\\committinglistener' => 'byrokrat\\giroapp\\Listener\\CommittingListener',
            'byrokrat\\giroapp\\listener\\exitstatuslistener' => 'byrokrat\\giroapp\\Listener\\ExitStatusListener',
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
            'byrokrat\\giroapp\\state\\statepool' => 'byrokrat\\giroapp\\State\\StatePool',
            'byrokrat\\giroapp\\utils\\systemclock' => 'byrokrat\\giroapp\\Utils\\SystemClock',
            'byrokrat\\id\\idfactory' => 'byrokrat\\id\\IdFactory',
            'symfony\\component\\console\\helper\\questionhelper' => 'Symfony\\Component\\Console\\Helper\\QuestionHelper',
            'symfony\\component\\console\\input\\inputinterface' => 'Symfony\\Component\\Console\\Input\\InputInterface',
            'symfony\\component\\eventdispatcher\\eventdispatcher' => 'Symfony\\Component\\EventDispatcher\\EventDispatcher',
        );
        $this->syntheticIds = array(
            'Symfony\\Component\\Console\\Helper\\QuestionHelper' => true,
            'Symfony\\Component\\Console\\Input\\InputInterface' => true,
            'err_out' => true,
            'std_in' => true,
            'std_out' => true,
        );
        $this->methodMap = array(
            'Symfony\\Component\\EventDispatcher\\EventDispatcher' => 'getEventDispatcherService',
            'byrokrat\\banking\\AccountFactory' => 'getAccountFactoryService',
            'byrokrat\\banking\\BankgiroFactory' => 'getBankgiroFactoryService',
            'byrokrat\\giroapp\\ApplicationMonitor' => 'getApplicationMonitorService',
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => 'getDonorBuilderService',
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
            'byrokrat\\giroapp\\Listener\\CommittingListener' => 'getCommittingListenerService',
            'byrokrat\\giroapp\\Listener\\ExitStatusListener' => 'getExitStatusListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => 'getImportingAutogiroListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingListener' => 'getImportingListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => 'getImportingXmlListenerService',
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => 'getInvalidNodeFilteringListenerService',
            'byrokrat\\giroapp\\Listener\\LoggingListener' => 'getLoggingListenerService',
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => 'getMandatePersistingListenerService',
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => 'getMandateResponseListenerService',
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => 'getOutputtingListenerService',
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => 'getDonorMapperService',
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => 'getDonorSchemaService',
            'byrokrat\\giroapp\\State\\StatePool' => 'getStatePoolService',
            'byrokrat\\giroapp\\Utils\\SystemClock' => 'getSystemClockService',
            'byrokrat\\id\\IdFactory' => 'getIdFactoryService',
            'db_donor_engine' => 'getDbDonorEngineService',
            'db_log_engine' => 'getDbLogEngineService',
            'db_settings_engine' => 'getDbSettingsEngineService',
            'db_settings_mapper' => 'getDbSettingsMapperService',
            'fs_user_dir' => 'getFsUserDirService',
            'organization_bg' => 'getOrganizationBgService',
        );
        $this->privates = array(
            'Symfony\\Component\\EventDispatcher\\EventDispatcher' => true,
            'byrokrat\\banking\\AccountFactory' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\ApplicationMonitor' => true,
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => true,
            'byrokrat\\giroapp\\Listener\\CommittingListener' => true,
            'byrokrat\\giroapp\\Listener\\ExitStatusListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => true,
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => true,
            'byrokrat\\giroapp\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => true,
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => true,
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => true,
            'byrokrat\\giroapp\\State\\StatePool' => true,
            'byrokrat\\giroapp\\Utils\\SystemClock' => true,
            'byrokrat\\id\\IdFactory' => true,
            'db_donor_engine' => true,
            'db_log_engine' => true,
            'db_settings_engine' => true,
            'fs_user_dir' => true,
            'organization_bg' => true,
        );

        $this->aliases = array();
    }

    public function getRemovedIds()
    {
        return array(
            'JsonSchema\\Validator' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Symfony\\Component\\Console\\Output\\OutputInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\EventDispatcher\\EventDispatcher' => true,
            'byrokrat\\autogiro\\Parser\\Parser' => true,
            'byrokrat\\autogiro\\Parser\\ParserFactory' => true,
            'byrokrat\\autogiro\\Writer\\Writer' => true,
            'byrokrat\\autogiro\\Writer\\WriterFactory' => true,
            'byrokrat\\banking\\AccountFactory' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\ApplicationMonitor' => true,
            'byrokrat\\giroapp\\Builder\\DateBuilder' => true,
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => true,
            'byrokrat\\giroapp\\Builder\\MandateKeyBuilder' => true,
            'byrokrat\\giroapp\\DI\\FilesystemConfigurator' => true,
            'byrokrat\\giroapp\\DI\\PluginLoader' => true,
            'byrokrat\\giroapp\\Listener\\CommittingListener' => true,
            'byrokrat\\giroapp\\Listener\\ExitStatusListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingListener' => true,
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => true,
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => true,
            'byrokrat\\giroapp\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => true,
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => true,
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => true,
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\DonorSchema' => true,
            'byrokrat\\giroapp\\Mapper\\Schema\\PostalAddressSchema' => true,
            'byrokrat\\giroapp\\Mapper\\SettingsMapper' => true,
            'byrokrat\\giroapp\\Mapper\\TransactionMapper' => true,
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
            'db_log_collection' => true,
            'db_log_engine' => true,
            'db_settings_collection' => true,
            'db_settings_engine' => true,
            'db_transaction_collection' => true,
            'db_transaction_engine' => true,
            'fs_cwd' => true,
            'fs_cwd_adapter' => true,
            'fs_cwd_reader' => true,
            'fs_user_dir' => true,
            'fs_user_dir_adapter' => true,
            'fs_user_dir_reader' => true,
            'organization_bg' => true,
            'organization_id' => true,
        );
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function isFrozen()
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 3.3 and will be removed in 4.0. Use the isCompiled() method instead.', __METHOD__), E_USER_DEPRECATED);

        return true;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\AddCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\AddCommand
     */
    protected function getAddCommandService()
    {
        $this->services['byrokrat\giroapp\Console\AddCommand'] = $instance = new \byrokrat\giroapp\Console\AddCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Builder\DonorBuilder']) ? $this->services['byrokrat\giroapp\Builder\DonorBuilder'] : $this->getDonorBuilderService()) && false ?: '_'});

        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(${($_ = isset($this->services['Symfony\Component\Console\Input\InputInterface']) ? $this->services['Symfony\Component\Console\Input\InputInterface'] : $this->get('Symfony\Component\Console\Input\InputInterface')) && false ?: '_'}, ${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\Console\Helper\QuestionHelper']) ? $this->services['Symfony\Component\Console\Helper\QuestionHelper'] : $this->get('Symfony\Component\Console\Helper\QuestionHelper')) && false ?: '_'})) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\DropCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\DropCommand
     */
    protected function getDropCommandService()
    {
        $this->services['byrokrat\giroapp\Console\DropCommand'] = $instance = new \byrokrat\giroapp\Console\DropCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\EditCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\EditCommand
     */
    protected function getEditCommandService()
    {
        $this->services['byrokrat\giroapp\Console\EditCommand'] = $instance = new \byrokrat\giroapp\Console\EditCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});
        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(${($_ = isset($this->services['Symfony\Component\Console\Input\InputInterface']) ? $this->services['Symfony\Component\Console\Input\InputInterface'] : $this->get('Symfony\Component\Console\Input\InputInterface')) && false ?: '_'}, ${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\Console\Helper\QuestionHelper']) ? $this->services['Symfony\Component\Console\Helper\QuestionHelper'] : $this->get('Symfony\Component\Console\Helper\QuestionHelper')) && false ?: '_'})) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ExportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ExportCommand
     */
    protected function getExportCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ExportCommand'] = new \byrokrat\giroapp\Console\ExportCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'}, call_user_func(array(new \byrokrat\autogiro\Writer\WriterFactory(), 'createWriter'), ${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->getDbSettingsMapperService()) && false ?: '_'}->findByKey("bgc_customer_number"), ${($_ = isset($this->services['organization_bg']) ? $this->services['organization_bg'] : $this->getOrganizationBgService()) && false ?: '_'}), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getStatePoolService()) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\InputReader' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\InputReader
     */
    protected function getInputReaderService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(${($_ = isset($this->services['Symfony\Component\Console\Input\InputInterface']) ? $this->services['Symfony\Component\Console\Input\InputInterface'] : $this->get('Symfony\Component\Console\Input\InputInterface')) && false ?: '_'}, ${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\Console\Helper\QuestionHelper']) ? $this->services['Symfony\Component\Console\Helper\QuestionHelper'] : $this->get('Symfony\Component\Console\Helper\QuestionHelper')) && false ?: '_'});
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
        return $this->services['byrokrat\giroapp\Console\Helper\Validators'] = new \byrokrat\giroapp\Console\Helper\Validators(${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getIdFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getStatePoolService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ImportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ImportCommand
     */
    protected function getImportCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ImportCommand'] = new \byrokrat\giroapp\Console\ImportCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'}, new \byrokrat\giroapp\Utils\FileReader(new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local('.'))), ${($_ = isset($this->services['std_in']) ? $this->services['std_in'] : $this->get('std_in')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\InitCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\InitCommand
     */
    protected function getInitCommandService()
    {
        $this->services['byrokrat\giroapp\Console\InitCommand'] = $instance = new \byrokrat\giroapp\Console\InitCommand(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->getDbSettingsMapperService()) && false ?: '_'});

        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(${($_ = isset($this->services['Symfony\Component\Console\Input\InputInterface']) ? $this->services['Symfony\Component\Console\Input\InputInterface'] : $this->get('Symfony\Component\Console\Input\InputInterface')) && false ?: '_'}, ${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\Console\Helper\QuestionHelper']) ? $this->services['Symfony\Component\Console\Helper\QuestionHelper'] : $this->get('Symfony\Component\Console\Helper\QuestionHelper')) && false ?: '_'})) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\LsCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\LsCommand
     */
    protected function getLsCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\LsCommand'] = new \byrokrat\giroapp\Console\LsCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\MigrateCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\MigrateCommand
     */
    protected function getMigrateCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\MigrateCommand'] = new \byrokrat\giroapp\Console\MigrateCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\RevokeCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\RevokeCommand
     */
    protected function getRevokeCommandService()
    {
        $this->services['byrokrat\giroapp\Console\RevokeCommand'] = $instance = new \byrokrat\giroapp\Console\RevokeCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getEventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});

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

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->getValidatorsService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\StatusCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\StatusCommand
     */
    protected function getStatusCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\StatusCommand'] = new \byrokrat\giroapp\Console\StatusCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ValidateCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ValidateCommand
     */
    protected function getValidateCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ValidateCommand'] = new \byrokrat\giroapp\Console\ValidateCommand(new \byrokrat\giroapp\Utils\FileReader(${($_ = isset($this->services['fs_user_dir']) ? $this->services['fs_user_dir'] : $this->getFsUserDirService()) && false ?: '_'}), ${($_ = isset($this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema']) ? $this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema'] : $this->getDonorSchemaService()) && false ?: '_'}->getJsonSchema(), new \JsonSchema\Validator());
    }

    /**
     * Gets the public 'db_settings_mapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\SettingsMapper
     */
    protected function getDbSettingsMapperService()
    {
        return $this->services['db_settings_mapper'] = new \byrokrat\giroapp\Mapper\SettingsMapper(new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_settings_engine']) ? $this->services['db_settings_engine'] : $this->getDbSettingsEngineService()) && false ?: '_'}));
    }

    /**
     * Gets the private 'Symfony\Component\EventDispatcher\EventDispatcher' shared autowired service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcherService()
    {
        $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getLoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getLoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getLoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'})) && false ?: '_'};
        }, 1 => 'onERROREVENT'), -10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'})) && false ?: '_'};
        }, 1 => 'onWARNINGEVENT'), -10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'})) && false ?: '_'};
        }, 1 => 'onINFOEVENT'), -10);
        $instance->addListener('DEBUG_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'})) && false ?: '_'};
        }, 1 => 'onDEBUGEVENT'), -10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ExitStatusListener']) ? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] : $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener()) && false ?: '_'};
        }, 1 => 'onFailure'));
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ExitStatusListener']) ? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] : $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener()) && false ?: '_'};
        }, 1 => 'onFailure'));
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingListener'] : $this->services['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener()) && false ?: '_'};
        }, 1 => 'onIMPORTEVENT'));
        $instance->addListener('IMPORT_AUTOGIRO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] : $this->getImportingAutogiroListenerService()) && false ?: '_'};
        }, 1 => 'onIMPORTAUTOGIROEVENT'));
        $instance->addListener('IMPORT_XML_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingXmlListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] : $this->getImportingXmlListenerService()) && false ?: '_'};
        }, 1 => 'onIMPORTXMLEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener']) ? $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] : $this->getInvalidNodeFilteringListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'), 10);
        $instance->addListener('EXECUTION_END_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\CommittingListener']) ? $this->services['byrokrat\giroapp\Listener\CommittingListener'] : $this->getCommittingListenerService()) && false ?: '_'};
        }, 1 => 'onEXECUTIONENDEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandateResponseListener']) ? $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] : $this->getMandateResponseListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'));
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATEADDEDEVENT'));
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATEDROPPEDEVENT'));
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getMandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor()) && false ?: '_'};
        }, 1 => 'dispatchWarning'), 10);
        (new \byrokrat\giroapp\DI\PluginLoader($this->getEnv('string:GIROAPP_PATH').'/plugins', ${($_ = isset($this->services['fs_user_dir']) ? $this->services['fs_user_dir'] : $this->getFsUserDirService()) && false ?: '_'}))->loadPlugins($instance);

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\banking\AccountFactory' shared autowired service.
     *
     * @return \byrokrat\banking\AccountFactory
     */
    protected function getAccountFactoryService()
    {
        return $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory();
    }

    /**
     * Gets the private 'byrokrat\banking\BankgiroFactory' shared autowired service.
     *
     * @return \byrokrat\banking\BankgiroFactory
     */
    protected function getBankgiroFactoryService()
    {
        return $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory();
    }

    /**
     * Gets the private 'byrokrat\giroapp\ApplicationMonitor' shared autowired service.
     *
     * @return \byrokrat\giroapp\ApplicationMonitor
     */
    protected function getApplicationMonitorService()
    {
        return $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Builder\DonorBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\DonorBuilder
     */
    protected function getDonorBuilderService()
    {
        return $this->services['byrokrat\giroapp\Builder\DonorBuilder'] = new \byrokrat\giroapp\Builder\DonorBuilder(new \byrokrat\giroapp\Builder\MandateKeyBuilder(), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getStatePoolService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\CommittingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\CommittingListener
     */
    protected function getCommittingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\CommittingListener'] = new \byrokrat\giroapp\Listener\CommittingListener(new \hanneskod\yaysondb\Yaysondb(array('settings' => ${($_ = isset($this->services['db_settings_engine']) ? $this->services['db_settings_engine'] : $this->getDbSettingsEngineService()) && false ?: '_'}, 'donors' => ${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->getDbDonorEngineService()) && false ?: '_'}, 'transactions' => new \hanneskod\yaysondb\Engine\FlysystemEngine('data/transactions.json', ${($_ = isset($this->services['fs_user_dir']) ? $this->services['fs_user_dir'] : $this->getFsUserDirService()) && false ?: '_'}), 'log' => ${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->services['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('string:GIROAPP_PATH').'/var/log')) && false ?: '_'})));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ExitStatusListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ExitStatusListener
     */
    protected function getExitStatusListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingAutogiroListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingAutogiroListener
     */
    protected function getImportingAutogiroListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] = new \byrokrat\giroapp\Listener\ImportingAutogiroListener(call_user_func(array(new \byrokrat\autogiro\Parser\ParserFactory(), 'createParser')));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingListener
     */
    protected function getImportingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingXmlListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingXmlListener
     */
    protected function getImportingXmlListenerService()
    {
        $a = ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getIdFactoryService()) && false ?: '_'};

        return $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] = new \byrokrat\giroapp\Listener\ImportingXmlListener(new \byrokrat\giroapp\Xml\XmlMandateParser($a->create(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->getDbSettingsMapperService()) && false ?: '_'}->findByKey("org_number")), ${($_ = isset($this->services['organization_bg']) ? $this->services['organization_bg'] : $this->getOrganizationBgService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Builder\DonorBuilder']) ? $this->services['byrokrat\giroapp\Builder\DonorBuilder'] : $this->getDonorBuilderService()) && false ?: '_'}, new \byrokrat\giroapp\Xml\CustomdataTranslator(new \byrokrat\giroapp\Xml\NullXmlMandateMigration()), ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()) && false ?: '_'}, $a));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\InvalidNodeFilteringListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\InvalidNodeFilteringListener
     */
    protected function getInvalidNodeFilteringListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] = new \byrokrat\giroapp\Listener\InvalidNodeFilteringListener(${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()) && false ?: '_'}, ${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->getDbSettingsMapperService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getLoggingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener(new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->services['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('string:GIROAPP_PATH').'/var/log')) && false ?: '_'}));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandatePersistingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandatePersistingListener
     */
    protected function getMandatePersistingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] = new \byrokrat\giroapp\Listener\MandatePersistingListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandateResponseListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandateResponseListener
     */
    protected function getMandateResponseListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] = new \byrokrat\giroapp\Listener\MandateResponseListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getDonorMapperService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getStatePoolService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\OutputtingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\OutputtingListener
     */
    protected function getOutputtingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Mapper\DonorMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\DonorMapper
     */
    protected function getDonorMapperService()
    {
        return $this->services['byrokrat\giroapp\Mapper\DonorMapper'] = new \byrokrat\giroapp\Mapper\DonorMapper(new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->getDbDonorEngineService()) && false ?: '_'}), ${($_ = isset($this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema']) ? $this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema'] : $this->getDonorSchemaService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Mapper\Schema\DonorSchema' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\Schema\DonorSchema
     */
    protected function getDonorSchemaService()
    {
        return $this->services['byrokrat\giroapp\Mapper\Schema\DonorSchema'] = new \byrokrat\giroapp\Mapper\Schema\DonorSchema(new \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema(), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getStatePoolService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getIdFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\State\StatePool' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\StatePool
     */
    protected function getStatePoolService()
    {
        return $this->services['byrokrat\giroapp\State\StatePool'] = new \byrokrat\giroapp\State\StatePool(new \byrokrat\giroapp\State\ActiveState(), new \byrokrat\giroapp\State\ErrorState(), new \byrokrat\giroapp\State\InactiveState(), new \byrokrat\giroapp\State\NewMandateState(), new \byrokrat\giroapp\State\NewDigitalMandateState(), new \byrokrat\giroapp\State\MandateSentState(), new \byrokrat\giroapp\State\MandateApprovedState(new \byrokrat\giroapp\Builder\DateBuilder(${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()) && false ?: '_'})), new \byrokrat\giroapp\State\RevokeMandateState(), new \byrokrat\giroapp\State\RevocationSentState());
    }

    /**
     * Gets the private 'byrokrat\giroapp\Utils\SystemClock' shared autowired service.
     *
     * @return \byrokrat\giroapp\Utils\SystemClock
     */
    protected function getSystemClockService()
    {
        return $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock();
    }

    /**
     * Gets the private 'byrokrat\id\IdFactory' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getIdFactoryService()
    {
        return $this->services['byrokrat\id\IdFactory'] = new \byrokrat\id\PersonalIdFactory(new \byrokrat\id\OrganizationIdFactory());
    }

    /**
     * Gets the private 'db_donor_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbDonorEngineService()
    {
        return $this->services['db_donor_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/donors.json', ${($_ = isset($this->services['fs_user_dir']) ? $this->services['fs_user_dir'] : $this->getFsUserDirService()) && false ?: '_'});
    }

    /**
     * Gets the private 'db_log_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\LogEngine
     */
    protected function getDbLogEngineService()
    {
        return $this->services['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('string:GIROAPP_PATH').'/var/log');
    }

    /**
     * Gets the private 'db_settings_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbSettingsEngineService()
    {
        return $this->services['db_settings_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/settings.json', ${($_ = isset($this->services['fs_user_dir']) ? $this->services['fs_user_dir'] : $this->getFsUserDirService()) && false ?: '_'});
    }

    /**
     * Gets the private 'fs_user_dir' shared service.
     *
     * @return \League\Flysystem\Filesystem
     */
    protected function getFsUserDirService()
    {
        $this->services['fs_user_dir'] = $instance = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local($this->getEnv('GIROAPP_PATH')));

        (new \byrokrat\giroapp\DI\FilesystemConfigurator(array(0 => 'data/settings.json', 1 => 'data/donors.json', 2 => 'data/transactions.json', 3 => 'var/log'), array(0 => 'plugins')))->createFiles($instance);

        return $instance;
    }

    /**
     * Gets the private 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\Bankgiro
     */
    protected function getOrganizationBgService()
    {
        return $this->services['organization_bg'] = ${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory()) && false ?: '_'}->createAccount(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->getDbSettingsMapperService()) && false ?: '_'}->findByKey("bankgiro"));
    }

    public function getParameter($name)
    {
        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            $name = $this->normalizeParameterName($name);

            if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
                throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
            }
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = $this->normalizeParameterName($name);

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

    private $normalizedParameterNames = array(
        'env(giroapp_path)' => 'env(GIROAPP_PATH)',
    );

    private function normalizeParameterName($name)
    {
        if (isset($this->normalizedParameterNames[$normalizedName = strtolower($name)]) || isset($this->parameters[$normalizedName]) || array_key_exists($normalizedName, $this->parameters)) {
            $normalizedName = isset($this->normalizedParameterNames[$normalizedName]) ? $this->normalizedParameterNames[$normalizedName] : $normalizedName;
            if ((string) $name !== $normalizedName) {
                @trigger_error(sprintf('Parameter names will be made case sensitive in Symfony 4.0. Using "%s" instead of "%s" is deprecated since version 3.4.', $name, $normalizedName), E_USER_DEPRECATED);
            }
        } else {
            $normalizedName = $this->normalizedParameterNames[$normalizedName] = (string) $name;
        }

        return $normalizedName;
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
            'env(GIROAPP_PATH)' => 'giroapp',
            'plugins.dir' => 'plugins',
        );
    }
}
