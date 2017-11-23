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
            'byrokrat\\giroapp\\state\\statepool' => 'byrokrat\\giroapp\\State\\StatePool',
            'byrokrat\\giroapp\\utils\\systemclock' => 'byrokrat\\giroapp\\Utils\\SystemClock',
            'byrokrat\\id\\idfactory' => 'byrokrat\\id\\IdFactory',
            'symfony\\component\\console\\helper\\questionhelper' => 'Symfony\\Component\\Console\\Helper\\QuestionHelper',
            'symfony\\component\\console\\input\\inputinterface' => 'Symfony\\Component\\Console\\Input\\InputInterface',
            'symfony\\component\\eventdispatcher\\eventdispatcher' => 'Symfony\\Component\\EventDispatcher\\EventDispatcher',
        );
        $this->methodMap = array(
            'Symfony\\Component\\EventDispatcher\\EventDispatcher' => 'getSymfony_Component_EventDispatcher_EventDispatcherService',
            'byrokrat\\banking\\AccountFactory' => 'getByrokrat_Banking_AccountFactoryService',
            'byrokrat\\banking\\BankgiroFactory' => 'getByrokrat_Banking_BankgiroFactoryService',
            'byrokrat\\giroapp\\ApplicationMonitor' => 'getByrokrat_Giroapp_ApplicationMonitorService',
            'byrokrat\\giroapp\\Builder\\DonorBuilder' => 'getByrokrat_Giroapp_Builder_DonorBuilderService',
            'byrokrat\\giroapp\\Console\\AddCommand' => 'getByrokrat_Giroapp_Console_AddCommandService',
            'byrokrat\\giroapp\\Console\\DropCommand' => 'getByrokrat_Giroapp_Console_DropCommandService',
            'byrokrat\\giroapp\\Console\\EditCommand' => 'getByrokrat_Giroapp_Console_EditCommandService',
            'byrokrat\\giroapp\\Console\\ExportCommand' => 'getByrokrat_Giroapp_Console_ExportCommandService',
            'byrokrat\\giroapp\\Console\\Helper\\InputReader' => 'getByrokrat_Giroapp_Console_Helper_InputReaderService',
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => 'getByrokrat_Giroapp_Console_Helper_QuestionFactoryService',
            'byrokrat\\giroapp\\Console\\Helper\\Validators' => 'getByrokrat_Giroapp_Console_Helper_ValidatorsService',
            'byrokrat\\giroapp\\Console\\ImportCommand' => 'getByrokrat_Giroapp_Console_ImportCommandService',
            'byrokrat\\giroapp\\Console\\InitCommand' => 'getByrokrat_Giroapp_Console_InitCommandService',
            'byrokrat\\giroapp\\Console\\LsCommand' => 'getByrokrat_Giroapp_Console_LsCommandService',
            'byrokrat\\giroapp\\Console\\MigrateCommand' => 'getByrokrat_Giroapp_Console_MigrateCommandService',
            'byrokrat\\giroapp\\Console\\RevokeCommand' => 'getByrokrat_Giroapp_Console_RevokeCommandService',
            'byrokrat\\giroapp\\Console\\ShowCommand' => 'getByrokrat_Giroapp_Console_ShowCommandService',
            'byrokrat\\giroapp\\Console\\StatusCommand' => 'getByrokrat_Giroapp_Console_StatusCommandService',
            'byrokrat\\giroapp\\Listener\\CommittingListener' => 'getByrokrat_Giroapp_Listener_CommittingListenerService',
            'byrokrat\\giroapp\\Listener\\ExitStatusListener' => 'getByrokrat_Giroapp_Listener_ExitStatusListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingAutogiroListener' => 'getByrokrat_Giroapp_Listener_ImportingAutogiroListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingListener' => 'getByrokrat_Giroapp_Listener_ImportingListenerService',
            'byrokrat\\giroapp\\Listener\\ImportingXmlListener' => 'getByrokrat_Giroapp_Listener_ImportingXmlListenerService',
            'byrokrat\\giroapp\\Listener\\InvalidNodeFilteringListener' => 'getByrokrat_Giroapp_Listener_InvalidNodeFilteringListenerService',
            'byrokrat\\giroapp\\Listener\\LoggingListener' => 'getByrokrat_Giroapp_Listener_LoggingListenerService',
            'byrokrat\\giroapp\\Listener\\MandatePersistingListener' => 'getByrokrat_Giroapp_Listener_MandatePersistingListenerService',
            'byrokrat\\giroapp\\Listener\\MandateResponseListener' => 'getByrokrat_Giroapp_Listener_MandateResponseListenerService',
            'byrokrat\\giroapp\\Listener\\OutputtingListener' => 'getByrokrat_Giroapp_Listener_OutputtingListenerService',
            'byrokrat\\giroapp\\Mapper\\DonorMapper' => 'getByrokrat_Giroapp_Mapper_DonorMapperService',
            'byrokrat\\giroapp\\State\\StatePool' => 'getByrokrat_Giroapp_State_StatePoolService',
            'byrokrat\\giroapp\\Utils\\SystemClock' => 'getByrokrat_Giroapp_Utils_SystemClockService',
            'byrokrat\\id\\IdFactory' => 'getByrokrat_Id_IdFactoryService',
            'db_donor_engine' => 'getDbDonorEngineService',
            'db_log_engine' => 'getDbLogEngineService',
            'db_settings_engine' => 'getDbSettingsEngineService',
            'db_settings_mapper' => 'getDbSettingsMapperService',
            'filesystem' => 'getFilesystemService',
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
            'byrokrat\\giroapp\\State\\StatePool' => true,
            'byrokrat\\giroapp\\Utils\\SystemClock' => true,
            'byrokrat\\id\\IdFactory' => true,
            'db_donor_engine' => true,
            'db_log_engine' => true,
            'db_settings_engine' => true,
            'filesystem' => true,
            'organization_bg' => true,
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
     * Gets the public 'byrokrat\giroapp\Console\AddCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\AddCommand
     */
    protected function getByrokrat_Giroapp_Console_AddCommandService()
    {
        $this->services['byrokrat\giroapp\Console\AddCommand'] = $instance = new \byrokrat\giroapp\Console\AddCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Builder\DonorBuilder']) ? $this->services['byrokrat\giroapp\Builder\DonorBuilder'] : $this->getByrokrat_Giroapp_Builder_DonorBuilderService()) && false ?: '_'});

        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->get('byrokrat\giroapp\Console\Helper\InputReader')) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->get('byrokrat\giroapp\Console\Helper\Validators')) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->get('byrokrat\giroapp\Console\Helper\QuestionFactory')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\DropCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\DropCommand
     */
    protected function getByrokrat_Giroapp_Console_DropCommandService()
    {
        $this->services['byrokrat\giroapp\Console\DropCommand'] = $instance = new \byrokrat\giroapp\Console\DropCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\EditCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\EditCommand
     */
    protected function getByrokrat_Giroapp_Console_EditCommandService()
    {
        $this->services['byrokrat\giroapp\Console\EditCommand'] = $instance = new \byrokrat\giroapp\Console\EditCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});
        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->get('byrokrat\giroapp\Console\Helper\InputReader')) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->get('byrokrat\giroapp\Console\Helper\Validators')) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->get('byrokrat\giroapp\Console\Helper\QuestionFactory')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ExportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ExportCommand
     */
    protected function getByrokrat_Giroapp_Console_ExportCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ExportCommand'] = new \byrokrat\giroapp\Console\ExportCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'}, call_user_func(array(new \byrokrat\autogiro\Writer\WriterFactory(), 'createWriter'), ${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->get('db_settings_mapper')) && false ?: '_'}->findByKey("bgc_customer_number"), ${($_ = isset($this->services['organization_bg']) ? $this->services['organization_bg'] : $this->getOrganizationBgService()) && false ?: '_'}), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getByrokrat_Giroapp_State_StatePoolService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\InputReader' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\InputReader
     */
    protected function getByrokrat_Giroapp_Console_Helper_InputReaderService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\InputReader'] = new \byrokrat\giroapp\Console\Helper\InputReader(${($_ = isset($this->services['Symfony\Component\Console\Input\InputInterface']) ? $this->services['Symfony\Component\Console\Input\InputInterface'] : $this->get('Symfony\Component\Console\Input\InputInterface')) && false ?: '_'}, ${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\Console\Helper\QuestionHelper']) ? $this->services['Symfony\Component\Console\Helper\QuestionHelper'] : $this->get('Symfony\Component\Console\Helper\QuestionHelper')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\QuestionFactory' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\QuestionFactory
     */
    protected function getByrokrat_Giroapp_Console_Helper_QuestionFactoryService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] = new \byrokrat\giroapp\Console\Helper\QuestionFactory();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\Helper\Validators' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\Helper\Validators
     */
    protected function getByrokrat_Giroapp_Console_Helper_ValidatorsService()
    {
        return $this->services['byrokrat\giroapp\Console\Helper\Validators'] = new \byrokrat\giroapp\Console\Helper\Validators(${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->getByrokrat_Banking_AccountFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->getByrokrat_Banking_BankgiroFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getByrokrat_Id_IdFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getByrokrat_Giroapp_State_StatePoolService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ImportCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ImportCommand
     */
    protected function getByrokrat_Giroapp_Console_ImportCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\ImportCommand'] = new \byrokrat\giroapp\Console\ImportCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'}, ${($_ = isset($this->services['std_in']) ? $this->services['std_in'] : $this->get('std_in')) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\InitCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\InitCommand
     */
    protected function getByrokrat_Giroapp_Console_InitCommandService()
    {
        $this->services['byrokrat\giroapp\Console\InitCommand'] = $instance = new \byrokrat\giroapp\Console\InitCommand(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->get('db_settings_mapper')) && false ?: '_'});

        $instance->setInputReader(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\InputReader']) ? $this->services['byrokrat\giroapp\Console\Helper\InputReader'] : $this->get('byrokrat\giroapp\Console\Helper\InputReader')) && false ?: '_'});
        $instance->setValidators(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\Validators']) ? $this->services['byrokrat\giroapp\Console\Helper\Validators'] : $this->get('byrokrat\giroapp\Console\Helper\Validators')) && false ?: '_'});
        $instance->setQuestionFactory(${($_ = isset($this->services['byrokrat\giroapp\Console\Helper\QuestionFactory']) ? $this->services['byrokrat\giroapp\Console\Helper\QuestionFactory'] : $this->get('byrokrat\giroapp\Console\Helper\QuestionFactory')) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\LsCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\LsCommand
     */
    protected function getByrokrat_Giroapp_Console_LsCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\LsCommand'] = new \byrokrat\giroapp\Console\LsCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\MigrateCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\MigrateCommand
     */
    protected function getByrokrat_Giroapp_Console_MigrateCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\MigrateCommand'] = new \byrokrat\giroapp\Console\MigrateCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'}, ${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'});
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\RevokeCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\RevokeCommand
     */
    protected function getByrokrat_Giroapp_Console_RevokeCommandService()
    {
        $this->services['byrokrat\giroapp\Console\RevokeCommand'] = $instance = new \byrokrat\giroapp\Console\RevokeCommand(${($_ = isset($this->services['Symfony\Component\EventDispatcher\EventDispatcher']) ? $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] : $this->getSymfony_Component_EventDispatcher_EventDispatcherService()) && false ?: '_'});

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\ShowCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\ShowCommand
     */
    protected function getByrokrat_Giroapp_Console_ShowCommandService()
    {
        $this->services['byrokrat\giroapp\Console\ShowCommand'] = $instance = new \byrokrat\giroapp\Console\ShowCommand();

        $instance->setDonorMapper(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Console\StatusCommand' shared autowired service.
     *
     * @return \byrokrat\giroapp\Console\StatusCommand
     */
    protected function getByrokrat_Giroapp_Console_StatusCommandService()
    {
        return $this->services['byrokrat\giroapp\Console\StatusCommand'] = new \byrokrat\giroapp\Console\StatusCommand(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});
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
    protected function getSymfony_Component_EventDispatcher_EventDispatcherService()
    {
        $this->services['Symfony\Component\EventDispatcher\EventDispatcher'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getByrokrat_Giroapp_Listener_LoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getByrokrat_Giroapp_Listener_LoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\LoggingListener']) ? $this->services['byrokrat\giroapp\Listener\LoggingListener'] : $this->getByrokrat_Giroapp_Listener_LoggingListenerService()) && false ?: '_'};
        }, 1 => 'onLogEvent'), 10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->getByrokrat_Giroapp_Listener_OutputtingListenerService()) && false ?: '_'};
        }, 1 => 'onERROREVENT'), -10);
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->getByrokrat_Giroapp_Listener_OutputtingListenerService()) && false ?: '_'};
        }, 1 => 'onWARNINGEVENT'), -10);
        $instance->addListener('INFO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->getByrokrat_Giroapp_Listener_OutputtingListenerService()) && false ?: '_'};
        }, 1 => 'onINFOEVENT'), -10);
        $instance->addListener('DEBUG_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\OutputtingListener']) ? $this->services['byrokrat\giroapp\Listener\OutputtingListener'] : $this->getByrokrat_Giroapp_Listener_OutputtingListenerService()) && false ?: '_'};
        }, 1 => 'onDEBUGEVENT'), -10);
        $instance->addListener('ERROR_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ExitStatusListener']) ? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] : $this->getByrokrat_Giroapp_Listener_ExitStatusListenerService()) && false ?: '_'};
        }, 1 => 'onFailure'));
        $instance->addListener('WARNING_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ExitStatusListener']) ? $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] : $this->getByrokrat_Giroapp_Listener_ExitStatusListenerService()) && false ?: '_'};
        }, 1 => 'onFailure'));
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingListener'] : $this->getByrokrat_Giroapp_Listener_ImportingListenerService()) && false ?: '_'};
        }, 1 => 'onIMPORTEVENT'));
        $instance->addListener('IMPORT_AUTOGIRO_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] : $this->getByrokrat_Giroapp_Listener_ImportingAutogiroListenerService()) && false ?: '_'};
        }, 1 => 'onIMPORTAUTOGIROEVENT'));
        $instance->addListener('IMPORT_XML_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\ImportingXmlListener']) ? $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] : $this->getByrokrat_Giroapp_Listener_ImportingXmlListenerService()) && false ?: '_'};
        }, 1 => 'onIMPORTXMLEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener']) ? $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] : $this->getByrokrat_Giroapp_Listener_InvalidNodeFilteringListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'), 10);
        $instance->addListener('EXECUTION_END_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\CommittingListener']) ? $this->services['byrokrat\giroapp\Listener\CommittingListener'] : $this->getByrokrat_Giroapp_Listener_CommittingListenerService()) && false ?: '_'};
        }, 1 => 'onEXECUTIONENDEVENT'));
        $instance->addListener('MANDATE_RESPONSE_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandateResponseListener']) ? $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] : $this->getByrokrat_Giroapp_Listener_MandateResponseListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATERESPONSEEVENT'));
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATEADDEDEVENT'));
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMANDATEDROPPEDEVENT'));
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\Listener\MandatePersistingListener']) ? $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] : $this->getByrokrat_Giroapp_Listener_MandatePersistingListenerService()) && false ?: '_'};
        }, 1 => 'onMandateUpdatedEvent'));
        $instance->addListener('IMPORT_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_ADDED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_EDITED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_APPROVED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_REVOKED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_DROPPED_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchInfo'), 10);
        $instance->addListener('MANDATE_INVALID_EVENT', array(0 => function () {
            return ${($_ = isset($this->services['byrokrat\giroapp\ApplicationMonitor']) ? $this->services['byrokrat\giroapp\ApplicationMonitor'] : $this->getByrokrat_Giroapp_ApplicationMonitorService()) && false ?: '_'};
        }, 1 => 'dispatchWarning'), 10);
        (new \byrokrat\giroapp\DI\PluginLoader($this->getEnv('GIROAPP_PATH').'/plugins', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'}))->loadPlugins($instance);

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\banking\AccountFactory' shared autowired service.
     *
     * @return \byrokrat\banking\AccountFactory
     */
    protected function getByrokrat_Banking_AccountFactoryService()
    {
        return $this->services['byrokrat\banking\AccountFactory'] = new \byrokrat\banking\AccountFactory();
    }

    /**
     * Gets the private 'byrokrat\banking\BankgiroFactory' shared autowired service.
     *
     * @return \byrokrat\banking\BankgiroFactory
     */
    protected function getByrokrat_Banking_BankgiroFactoryService()
    {
        return $this->services['byrokrat\banking\BankgiroFactory'] = new \byrokrat\banking\BankgiroFactory();
    }

    /**
     * Gets the private 'byrokrat\giroapp\ApplicationMonitor' shared autowired service.
     *
     * @return \byrokrat\giroapp\ApplicationMonitor
     */
    protected function getByrokrat_Giroapp_ApplicationMonitorService()
    {
        return $this->services['byrokrat\giroapp\ApplicationMonitor'] = new \byrokrat\giroapp\ApplicationMonitor();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Builder\DonorBuilder' shared autowired service.
     *
     * @return \byrokrat\giroapp\Builder\DonorBuilder
     */
    protected function getByrokrat_Giroapp_Builder_DonorBuilderService()
    {
        return $this->services['byrokrat\giroapp\Builder\DonorBuilder'] = new \byrokrat\giroapp\Builder\DonorBuilder(new \byrokrat\giroapp\Builder\MandateKeyBuilder(), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getByrokrat_Giroapp_State_StatePoolService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->getByrokrat_Giroapp_Utils_SystemClockService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\CommittingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\CommittingListener
     */
    protected function getByrokrat_Giroapp_Listener_CommittingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\CommittingListener'] = new \byrokrat\giroapp\Listener\CommittingListener(new \hanneskod\yaysondb\Yaysondb(array('settings' => ${($_ = isset($this->services['db_settings_engine']) ? $this->services['db_settings_engine'] : $this->getDbSettingsEngineService()) && false ?: '_'}, 'donors' => ${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->getDbDonorEngineService()) && false ?: '_'}, 'transactions' => new \hanneskod\yaysondb\Engine\FlysystemEngine('data/transactions.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'}), 'log' => ${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->getDbLogEngineService()) && false ?: '_'})));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ExitStatusListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ExitStatusListener
     */
    protected function getByrokrat_Giroapp_Listener_ExitStatusListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ExitStatusListener'] = new \byrokrat\giroapp\Listener\ExitStatusListener();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingAutogiroListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingAutogiroListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingAutogiroListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingAutogiroListener'] = new \byrokrat\giroapp\Listener\ImportingAutogiroListener(call_user_func(array(new \byrokrat\autogiro\Parser\ParserFactory(), 'createParser')));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\ImportingListener'] = new \byrokrat\giroapp\Listener\ImportingListener();
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportingXmlListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportingXmlListener
     */
    protected function getByrokrat_Giroapp_Listener_ImportingXmlListenerService()
    {
        $a = ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getByrokrat_Id_IdFactoryService()) && false ?: '_'};

        return $this->services['byrokrat\giroapp\Listener\ImportingXmlListener'] = new \byrokrat\giroapp\Listener\ImportingXmlListener(new \byrokrat\giroapp\Xml\XmlMandateParser($a->create(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->get('db_settings_mapper')) && false ?: '_'}->findByKey("org_number")), ${($_ = isset($this->services['organization_bg']) ? $this->services['organization_bg'] : $this->getOrganizationBgService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\Builder\DonorBuilder']) ? $this->services['byrokrat\giroapp\Builder\DonorBuilder'] : $this->getByrokrat_Giroapp_Builder_DonorBuilderService()) && false ?: '_'}, new \byrokrat\giroapp\Xml\CustomdataTranslator(new \byrokrat\giroapp\Xml\NullXmlMandateMigration()), ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->getByrokrat_Banking_AccountFactoryService()) && false ?: '_'}, $a));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\InvalidNodeFilteringListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\InvalidNodeFilteringListener
     */
    protected function getByrokrat_Giroapp_Listener_InvalidNodeFilteringListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\InvalidNodeFilteringListener'] = new \byrokrat\giroapp\Listener\InvalidNodeFilteringListener(${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->getByrokrat_Banking_BankgiroFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->get('db_settings_mapper')) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getByrokrat_Giroapp_Listener_LoggingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener(new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_log_engine']) ? $this->services['db_log_engine'] : $this->getDbLogEngineService()) && false ?: '_'}));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandatePersistingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandatePersistingListener
     */
    protected function getByrokrat_Giroapp_Listener_MandatePersistingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandatePersistingListener'] = new \byrokrat\giroapp\Listener\MandatePersistingListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MandateResponseListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MandateResponseListener
     */
    protected function getByrokrat_Giroapp_Listener_MandateResponseListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\MandateResponseListener'] = new \byrokrat\giroapp\Listener\MandateResponseListener(${($_ = isset($this->services['byrokrat\giroapp\Mapper\DonorMapper']) ? $this->services['byrokrat\giroapp\Mapper\DonorMapper'] : $this->getByrokrat_Giroapp_Mapper_DonorMapperService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getByrokrat_Giroapp_State_StatePoolService()) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\OutputtingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\OutputtingListener
     */
    protected function getByrokrat_Giroapp_Listener_OutputtingListenerService()
    {
        return $this->services['byrokrat\giroapp\Listener\OutputtingListener'] = new \byrokrat\giroapp\Listener\OutputtingListener(${($_ = isset($this->services['std_out']) ? $this->services['std_out'] : $this->get('std_out')) && false ?: '_'}, ${($_ = isset($this->services['err_out']) ? $this->services['err_out'] : $this->get('err_out')) && false ?: '_'});
    }

    /**
     * Gets the private 'byrokrat\giroapp\Mapper\DonorMapper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Mapper\DonorMapper
     */
    protected function getByrokrat_Giroapp_Mapper_DonorMapperService()
    {
        $a = ${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->getByrokrat_Giroapp_Utils_SystemClockService()) && false ?: '_'};

        return $this->services['byrokrat\giroapp\Mapper\DonorMapper'] = new \byrokrat\giroapp\Mapper\DonorMapper(new \hanneskod\yaysondb\Collection(${($_ = isset($this->services['db_donor_engine']) ? $this->services['db_donor_engine'] : $this->getDbDonorEngineService()) && false ?: '_'}), new \byrokrat\giroapp\Mapper\Schema\DonorSchema(new \byrokrat\giroapp\Mapper\Schema\PostalAddressSchema(), ${($_ = isset($this->services['byrokrat\giroapp\State\StatePool']) ? $this->services['byrokrat\giroapp\State\StatePool'] : $this->getByrokrat_Giroapp_State_StatePoolService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\banking\AccountFactory']) ? $this->services['byrokrat\banking\AccountFactory'] : $this->getByrokrat_Banking_AccountFactoryService()) && false ?: '_'}, ${($_ = isset($this->services['byrokrat\id\IdFactory']) ? $this->services['byrokrat\id\IdFactory'] : $this->getByrokrat_Id_IdFactoryService()) && false ?: '_'}, $a), $a);
    }

    /**
     * Gets the private 'byrokrat\giroapp\State\StatePool' shared autowired service.
     *
     * @return \byrokrat\giroapp\State\StatePool
     */
    protected function getByrokrat_Giroapp_State_StatePoolService()
    {
        return $this->services['byrokrat\giroapp\State\StatePool'] = new \byrokrat\giroapp\State\StatePool(new \byrokrat\giroapp\State\ActiveState(), new \byrokrat\giroapp\State\ErrorState(), new \byrokrat\giroapp\State\InactiveState(), new \byrokrat\giroapp\State\NewMandateState(), new \byrokrat\giroapp\State\NewDigitalMandateState(), new \byrokrat\giroapp\State\MandateSentState(), new \byrokrat\giroapp\State\MandateApprovedState(new \byrokrat\giroapp\Builder\DateBuilder(${($_ = isset($this->services['byrokrat\giroapp\Utils\SystemClock']) ? $this->services['byrokrat\giroapp\Utils\SystemClock'] : $this->getByrokrat_Giroapp_Utils_SystemClockService()) && false ?: '_'})), new \byrokrat\giroapp\State\RevokeMandateState(), new \byrokrat\giroapp\State\RevocationSentState());
    }

    /**
     * Gets the private 'byrokrat\giroapp\Utils\SystemClock' shared autowired service.
     *
     * @return \byrokrat\giroapp\Utils\SystemClock
     */
    protected function getByrokrat_Giroapp_Utils_SystemClockService()
    {
        return $this->services['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock();
    }

    /**
     * Gets the private 'byrokrat\id\IdFactory' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getByrokrat_Id_IdFactoryService()
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
        return $this->services['db_donor_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/donors.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
    }

    /**
     * Gets the private 'db_log_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\LogEngine
     */
    protected function getDbLogEngineService()
    {
        return $this->services['db_log_engine'] = new \hanneskod\yaysondb\Engine\LogEngine($this->getEnv('GIROAPP_PATH').'/var/log');
    }

    /**
     * Gets the private 'db_settings_engine' shared autowired service.
     *
     * @return \hanneskod\yaysondb\Engine\FlysystemEngine
     */
    protected function getDbSettingsEngineService()
    {
        return $this->services['db_settings_engine'] = new \hanneskod\yaysondb\Engine\FlysystemEngine('data/settings.json', ${($_ = isset($this->services['filesystem']) ? $this->services['filesystem'] : $this->getFilesystemService()) && false ?: '_'});
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
     * Gets the private 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\Bankgiro
     */
    protected function getOrganizationBgService()
    {
        return $this->services['organization_bg'] = ${($_ = isset($this->services['byrokrat\banking\BankgiroFactory']) ? $this->services['byrokrat\banking\BankgiroFactory'] : $this->getByrokrat_Banking_BankgiroFactoryService()) && false ?: '_'}->createAccount(${($_ = isset($this->services['db_settings_mapper']) ? $this->services['db_settings_mapper'] : $this->get('db_settings_mapper')) && false ?: '_'}->findByKey("bankgiro"));
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
