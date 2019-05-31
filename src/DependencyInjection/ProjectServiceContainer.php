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
    private $targetDirs = [];

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->methodMap = [
            'Symfony\\Component\\Console\\Application' => 'getApplicationService',
            'byrokrat\\giroapp\\Plugin\\EnvironmentInterface' => 'getEnvironmentInterfaceService',
            'ini' => 'getIniService',
        ];

        $this->aliases = [];
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
        return [
            'League\\Tactician\\CommandBus' => true,
            'League\\Tactician\\Handler\\CommandHandlerMiddleware' => true,
            'League\\Tactician\\Handler\\CommandNameExtractor\\ClassNameExtractor' => true,
            'League\\Tactician\\Handler\\Locator\\InMemoryLocator' => true,
            'League\\Tactician\\Handler\\MethodNameInflector\\HandleInflector' => true,
            'League\\Tactician\\Plugins\\LockingMiddleware' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\Log\\LoggerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => true,
            'Symfony\\Component\\Filesystem\\Filesystem' => true,
            'base_dir_reader' => true,
            'base_dir_repository' => true,
            'byrokrat\\autogiro\\Parser\\ParserFactory' => true,
            'byrokrat\\autogiro\\Parser\\ParserInterface' => true,
            'byrokrat\\autogiro\\Writer\\WriterFactory' => true,
            'byrokrat\\autogiro\\Writer\\WriterInterface' => true,
            'byrokrat\\banking\\AccountFactoryInterface' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\AutogiroVisitor' => true,
            'byrokrat\\giroapp\\AutogiroWriterFactory' => true,
            'byrokrat\\giroapp\\CommandBus\\AddDonor' => true,
            'byrokrat\\giroapp\\CommandBus\\AddDonorHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\CommandBus' => true,
            'byrokrat\\giroapp\\CommandBus\\CommandBusInterface' => true,
            'byrokrat\\giroapp\\CommandBus\\Commit' => true,
            'byrokrat\\giroapp\\CommandBus\\CommitHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\Export' => true,
            'byrokrat\\giroapp\\CommandBus\\ExportHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\ForceState' => true,
            'byrokrat\\giroapp\\CommandBus\\ForceStateHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\Helper\\LoggingMiddleware' => true,
            'byrokrat\\giroapp\\CommandBus\\ImportAutogiroFile' => true,
            'byrokrat\\giroapp\\CommandBus\\ImportAutogiroFileHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\ImportXmlFile' => true,
            'byrokrat\\giroapp\\CommandBus\\ImportXmlFileHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\RemoveDonor' => true,
            'byrokrat\\giroapp\\CommandBus\\RemoveDonorHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\Rollback' => true,
            'byrokrat\\giroapp\\CommandBus\\RollbackHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateAttribute' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateAttributeHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateComment' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateCommentHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateDonationAmount' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateDonationAmountHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateEmail' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateEmailHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateName' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateNameHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdatePhone' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdatePhoneHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdatePostalAddress' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdatePostalAddressHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateState' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdateStateHandler' => true,
            'byrokrat\\giroapp\\Config\\ArrayRepository' => true,
            'byrokrat\\giroapp\\Config\\BaseDirReader' => true,
            'byrokrat\\giroapp\\Config\\ConfigManager' => true,
            'byrokrat\\giroapp\\Config\\IniFileLoader' => true,
            'byrokrat\\giroapp\\Config\\IniRepository' => true,
            'byrokrat\\giroapp\\Config\\LazyConfig' => true,
            'byrokrat\\giroapp\\Config\\SimpleConfig' => true,
            'byrokrat\\giroapp\\Console\\AddConsole' => true,
            'byrokrat\\giroapp\\Console\\EditConsole' => true,
            'byrokrat\\giroapp\\Console\\EditStateConsole' => true,
            'byrokrat\\giroapp\\Console\\ExportConsole' => true,
            'byrokrat\\giroapp\\Console\\Helper\\InputReader' => true,
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => true,
            'byrokrat\\giroapp\\Console\\ImportConsole' => true,
            'byrokrat\\giroapp\\Console\\LsConsole' => true,
            'byrokrat\\giroapp\\Console\\PauseConsole' => true,
            'byrokrat\\giroapp\\Console\\RemoveConsole' => true,
            'byrokrat\\giroapp\\Console\\RevokeConsole' => true,
            'byrokrat\\giroapp\\Console\\ShowConsole' => true,
            'byrokrat\\giroapp\\Console\\StatusConsole' => true,
            'byrokrat\\giroapp\\Console\\SymfonyCommandAdapter' => true,
            'byrokrat\\giroapp\\Db\\DonorQueryDecorator' => true,
            'byrokrat\\giroapp\\Db\\DonorQueryInterface' => true,
            'byrokrat\\giroapp\\Db\\DonorRepositoryInterface' => true,
            'byrokrat\\giroapp\\Db\\DriverEnvironment' => true,
            'byrokrat\\giroapp\\Db\\DriverFactoryCollection' => true,
            'byrokrat\\giroapp\\Db\\DriverFactoryInterface' => true,
            'byrokrat\\giroapp\\Db\\DriverInterface' => true,
            'byrokrat\\giroapp\\Db\\ImportHistoryInterface' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDonorRepository' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDriver' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDriverFactory' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonImportHistory' => true,
            'byrokrat\\giroapp\\DependencyInjection\\ProjectServiceContainer' => true,
            'byrokrat\\giroapp\\Event\\AutogiroFileImported' => true,
            'byrokrat\\giroapp\\Event\\ChangesCommitted' => true,
            'byrokrat\\giroapp\\Event\\ChangesDiscarded' => true,
            'byrokrat\\giroapp\\Event\\DonorAdded' => true,
            'byrokrat\\giroapp\\Event\\DonorAmountUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorAttributeUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorCommentUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorEmailUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorEvent' => true,
            'byrokrat\\giroapp\\Event\\DonorNameUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorPhoneUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorPostalAddressUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorRemoved' => true,
            'byrokrat\\giroapp\\Event\\DonorStateUpdated' => true,
            'byrokrat\\giroapp\\Event\\ExecutionStarted' => true,
            'byrokrat\\giroapp\\Event\\ExecutionStopped' => true,
            'byrokrat\\giroapp\\Event\\ExportGenerated' => true,
            'byrokrat\\giroapp\\Event\\FileEvent' => true,
            'byrokrat\\giroapp\\Event\\LogEvent' => true,
            'byrokrat\\giroapp\\Event\\XmlFileImported' => true,
            'byrokrat\\giroapp\\Exception\\DonorAlreadyExistsException' => true,
            'byrokrat\\giroapp\\Exception\\DonorDoesNotExistException' => true,
            'byrokrat\\giroapp\\Exception\\FileAlreadyImportedException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidAutogiroFileException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidConfigException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidDataException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidPluginException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidStateTransitionException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidXmlException' => true,
            'byrokrat\\giroapp\\Exception\\InvalidXmlFormException' => true,
            'byrokrat\\giroapp\\Exception\\UnableToReadFileException' => true,
            'byrokrat\\giroapp\\Exception\\UnknownFileException' => true,
            'byrokrat\\giroapp\\Exception\\UnknownIdentifierException' => true,
            'byrokrat\\giroapp\\Exception\\UnsupportedVersionException' => true,
            'byrokrat\\giroapp\\Exception\\ValidatorException' => true,
            'byrokrat\\giroapp\\Filesystem\\FilesystemConfigurator' => true,
            'byrokrat\\giroapp\\Filesystem\\FilesystemFactory' => true,
            'byrokrat\\giroapp\\Filesystem\\HashedFile' => true,
            'byrokrat\\giroapp\\Filesystem\\NullFilesystem' => true,
            'byrokrat\\giroapp\\Filesystem\\NullProcessor' => true,
            'byrokrat\\giroapp\\Filesystem\\RenamingProcessor' => true,
            'byrokrat\\giroapp\\Filesystem\\Sha256File' => true,
            'byrokrat\\giroapp\\Filesystem\\StdFilesystem' => true,
            'byrokrat\\giroapp\\Filter\\ActiveFilter' => true,
            'byrokrat\\giroapp\\Filter\\AwaitingResponseFilter' => true,
            'byrokrat\\giroapp\\Filter\\CombinedFilter' => true,
            'byrokrat\\giroapp\\Filter\\ErrorFilter' => true,
            'byrokrat\\giroapp\\Filter\\ExportableFilter' => true,
            'byrokrat\\giroapp\\Filter\\FilterCollection' => true,
            'byrokrat\\giroapp\\Filter\\InactiveFilter' => true,
            'byrokrat\\giroapp\\Filter\\NegatedFilter' => true,
            'byrokrat\\giroapp\\Filter\\PausedFilter' => true,
            'byrokrat\\giroapp\\Formatter\\CsvFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\FormatterCollection' => true,
            'byrokrat\\giroapp\\Formatter\\HumanFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\JsonFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\ListFormatter' => true,
            'byrokrat\\giroapp\\Listener\\ImportHistoryListener' => true,
            'byrokrat\\giroapp\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Listener\\MonitoringListener' => true,
            'byrokrat\\giroapp\\Model\\Donor' => true,
            'byrokrat\\giroapp\\Model\\DonorCollection' => true,
            'byrokrat\\giroapp\\Model\\DonorFactory' => true,
            'byrokrat\\giroapp\\Model\\FileThatWasImported' => true,
            'byrokrat\\giroapp\\Model\\NewDonor' => true,
            'byrokrat\\giroapp\\Model\\NewDonorProcessor' => true,
            'byrokrat\\giroapp\\Model\\PostalAddress' => true,
            'byrokrat\\giroapp\\Plugin\\ApiVersion' => true,
            'byrokrat\\giroapp\\Plugin\\ApiVersionConstraint' => true,
            'byrokrat\\giroapp\\Plugin\\ConfiguringEnvironment' => true,
            'byrokrat\\giroapp\\Plugin\\CorePlugin' => true,
            'byrokrat\\giroapp\\Plugin\\FilesystemLoadingPlugin' => true,
            'byrokrat\\giroapp\\Plugin\\Plugin' => true,
            'byrokrat\\giroapp\\Plugin\\PluginCollection' => true,
            'byrokrat\\giroapp\\Sorter\\AmountSorter' => true,
            'byrokrat\\giroapp\\Sorter\\CreatedSorter' => true,
            'byrokrat\\giroapp\\Sorter\\DescendingSorter' => true,
            'byrokrat\\giroapp\\Sorter\\NameSorter' => true,
            'byrokrat\\giroapp\\Sorter\\NullSorter' => true,
            'byrokrat\\giroapp\\Sorter\\PayerNumberSorter' => true,
            'byrokrat\\giroapp\\Sorter\\SorterCollection' => true,
            'byrokrat\\giroapp\\Sorter\\StateSorter' => true,
            'byrokrat\\giroapp\\Sorter\\UpdatedSorter' => true,
            'byrokrat\\giroapp\\State\\Active' => true,
            'byrokrat\\giroapp\\State\\Error' => true,
            'byrokrat\\giroapp\\State\\Inactive' => true,
            'byrokrat\\giroapp\\State\\MandateApproved' => true,
            'byrokrat\\giroapp\\State\\MandateSent' => true,
            'byrokrat\\giroapp\\State\\NewDigitalMandate' => true,
            'byrokrat\\giroapp\\State\\NewMandate' => true,
            'byrokrat\\giroapp\\State\\PauseMandate' => true,
            'byrokrat\\giroapp\\State\\PauseSent' => true,
            'byrokrat\\giroapp\\State\\Paused' => true,
            'byrokrat\\giroapp\\State\\RevocationSent' => true,
            'byrokrat\\giroapp\\State\\RevokeMandate' => true,
            'byrokrat\\giroapp\\State\\StateCollection' => true,
            'byrokrat\\giroapp\\State\\TransactionDateFactory' => true,
            'byrokrat\\giroapp\\Utils\\ClassIdExtractor' => true,
            'byrokrat\\giroapp\\Utils\\LogFormatter' => true,
            'byrokrat\\giroapp\\Utils\\SystemClock' => true,
            'byrokrat\\giroapp\\Validator\\AccountValidator' => true,
            'byrokrat\\giroapp\\Validator\\BgcNumberValidator' => true,
            'byrokrat\\giroapp\\Validator\\CallbackValidator' => true,
            'byrokrat\\giroapp\\Validator\\ChoiceValidator' => true,
            'byrokrat\\giroapp\\Validator\\DonorKeyValidator' => true,
            'byrokrat\\giroapp\\Validator\\EmailValidator' => true,
            'byrokrat\\giroapp\\Validator\\IdValidator' => true,
            'byrokrat\\giroapp\\Validator\\NotEmptyValidator' => true,
            'byrokrat\\giroapp\\Validator\\NumericValidator' => true,
            'byrokrat\\giroapp\\Validator\\PayerNumberValidator' => true,
            'byrokrat\\giroapp\\Validator\\PhoneValidator' => true,
            'byrokrat\\giroapp\\Validator\\PostalCodeValidator' => true,
            'byrokrat\\giroapp\\Validator\\StringValidator' => true,
            'byrokrat\\giroapp\\Validator\\ValidatorCollection' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateParser' => true,
            'byrokrat\\giroapp\\Xml\\XmlObject' => true,
            'byrokrat\\id\\IdFactoryInterface' => true,
            'byrokrat\\id\\OrganizationIdFactory' => true,
            'file_export_dumper' => true,
            'file_import_dumper' => true,
            'fs_cwd' => true,
            'fs_exports' => true,
            'fs_imports' => true,
            'fs_plugins' => true,
            'organization_bg' => true,
            'organization_id' => true,
            'plugins' => true,
            'setup_mkdir' => true,
        ];
    }

    protected function createProxy($class, \Closure $factory)
    {
        class_exists($class, false) || class_alias("byrokrat\giroapp\DependencyInjection\\{$class}", $class, false);

        return $factory();
    }

    /**
     * Gets the public 'Symfony\Component\Console\Application' shared autowired service.
     *
     * @return \Symfony\Component\Console\Application
     */
    protected function getApplicationService()
    {
        $this->services['Symfony\Component\Console\Application'] = $instance = new \Symfony\Component\Console\Application('GiroApp', ($this->privates['byrokrat\giroapp\Plugin\ApiVersion'] ?? ($this->privates['byrokrat\giroapp\Plugin\ApiVersion'] = new \byrokrat\giroapp\Plugin\ApiVersion())));

        ($this->services['byrokrat\giroapp\Plugin\EnvironmentInterface'] ?? $this->getEnvironmentInterfaceService())->configureApplication($instance);

        return $instance;
    }

    /**
     * Gets the public 'byrokrat\giroapp\Plugin\EnvironmentInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Plugin\ConfiguringEnvironment
     */
    protected function getEnvironmentInterfaceService()
    {
        $a = ($this->privates['byrokrat\giroapp\Db\DonorQueryInterface'] ?? $this->getDonorQueryInterfaceService());
        $b = new \byrokrat\giroapp\Filter\FilterCollection();
        $c = new \byrokrat\giroapp\Formatter\FormatterCollection();
        $d = new \byrokrat\giroapp\Sorter\SorterCollection();
        $e = ($this->privates['byrokrat\giroapp\State\StateCollection'] ?? ($this->privates['byrokrat\giroapp\State\StateCollection'] = new \byrokrat\giroapp\State\StateCollection()));

        $this->services['byrokrat\giroapp\Plugin\EnvironmentInterface'] = $instance = new \byrokrat\giroapp\Plugin\ConfiguringEnvironment(($this->privates['byrokrat\giroapp\Plugin\ApiVersion'] ?? ($this->privates['byrokrat\giroapp\Plugin\ApiVersion'] = new \byrokrat\giroapp\Plugin\ApiVersion())), $a, ($this->privates['byrokrat\giroapp\Db\DriverFactoryCollection'] ?? ($this->privates['byrokrat\giroapp\Db\DriverFactoryCollection'] = new \byrokrat\giroapp\Db\DriverFactoryCollection())), $b, $c, $d, $e, ($this->services['ini'] ?? $this->getIniService()));

        $f = ($this->privates['byrokrat\giroapp\CommandBus\CommandBus'] ?? $this->getCommandBusService());
        $g = new \byrokrat\giroapp\Console\AddConsole();
        $g->setAccountFactory(($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? ($this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())));
        $g->setCommandBus($f);
        $g->setIdFactory(($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()));
        $h = new \byrokrat\giroapp\Console\EditConsole();
        $h->setCommandBus($f);
        $h->setDonorQuery($a);
        $i = new \byrokrat\giroapp\Console\EditStateConsole($e);
        $i->setCommandBus($f);
        $i->setDonorQuery($a);
        $j = new \byrokrat\giroapp\Console\ExportConsole();
        $j->setCommandBus($f);
        $k = new \byrokrat\giroapp\Console\ImportConsole(($this->privates['fs_cwd'] ?? $this->getFsCwdService()));
        $k->setCommandBus($f);
        $l = new \byrokrat\giroapp\Console\LsConsole($b, $c, $d);
        $l->setDonorQuery($a);
        $m = new \byrokrat\giroapp\Console\PauseConsole();
        $m->setCommandBus($f);
        $m->setDonorQuery($a);
        $n = new \byrokrat\giroapp\Console\RemoveConsole();
        $n->setCommandBus($f);
        $n->setDonorQuery($a);
        $o = new \byrokrat\giroapp\Console\RevokeConsole();
        $o->setCommandBus($f);
        $o->setDonorQuery($a);
        $p = new \byrokrat\giroapp\Console\ShowConsole($c);
        $p->setDonorQuery($a);
        $q = new \byrokrat\giroapp\Console\StatusConsole();
        $q->setDonorQuery($a);
        $r = new \byrokrat\giroapp\Filesystem\StdFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("plugins_dir"), ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? ($this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
        ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])))->createFiles($r);

        $instance->setCommandBus($f);
        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));
        (new \byrokrat\giroapp\Plugin\PluginCollection(new \byrokrat\giroapp\Plugin\CorePlugin($g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, new \byrokrat\giroapp\Db\Json\JsonDriverFactory(), new \byrokrat\giroapp\Filter\ActiveFilter(), new \byrokrat\giroapp\Filter\InactiveFilter(), new \byrokrat\giroapp\Filter\ExportableFilter(), new \byrokrat\giroapp\Filter\ErrorFilter(), new \byrokrat\giroapp\Filter\PausedFilter(), new \byrokrat\giroapp\Filter\AwaitingResponseFilter(), new \byrokrat\giroapp\Formatter\ListFormatter(), new \byrokrat\giroapp\Formatter\CsvFormatter(), new \byrokrat\giroapp\Formatter\HumanFormatter(), new \byrokrat\giroapp\Formatter\JsonFormatter(), new \byrokrat\giroapp\Sorter\NullSorter(), new \byrokrat\giroapp\Sorter\NameSorter(), new \byrokrat\giroapp\Sorter\StateSorter(), new \byrokrat\giroapp\Sorter\PayerNumberSorter(), new \byrokrat\giroapp\Sorter\AmountSorter(), new \byrokrat\giroapp\Sorter\CreatedSorter(), new \byrokrat\giroapp\Sorter\UpdatedSorter(), new \byrokrat\giroapp\State\Active(), new \byrokrat\giroapp\State\Error(), new \byrokrat\giroapp\State\Inactive(), new \byrokrat\giroapp\State\NewMandate(), new \byrokrat\giroapp\State\NewDigitalMandate(), new \byrokrat\giroapp\State\MandateSent(), new \byrokrat\giroapp\State\MandateApproved(new \byrokrat\giroapp\State\TransactionDateFactory(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? ($this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_day_of_month"), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_min_days_in_future"))), new \byrokrat\giroapp\State\RevokeMandate(), new \byrokrat\giroapp\State\RevocationSent(), new \byrokrat\giroapp\State\PauseMandate(), new \byrokrat\giroapp\State\PauseSent(), new \byrokrat\giroapp\State\Paused()), new \byrokrat\giroapp\Plugin\FilesystemLoadingPlugin($r)))->loadPlugin($instance);

        return $instance;
    }

    /**
     * Gets the public 'ini' shared autowired service.
     *
     * @return \byrokrat\giroapp\Config\ConfigManager
     */
    protected function getIniService()
    {
        $this->services['ini'] = $instance = new \byrokrat\giroapp\Config\ConfigManager(new \byrokrat\giroapp\Config\ArrayRepository(['base_dir' => (new \byrokrat\giroapp\Config\BaseDirReader($this->getEnv('GIROAPP_INI')))->getBaseDir()]));

        (new \byrokrat\giroapp\Config\IniFileLoader($this->getEnv('GIROAPP_INI'), ($this->privates['fs_cwd'] ?? $this->getFsCwdService())))->loadIniFile($instance);

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

        $instance->addListener('byrokrat\\giroapp\\Event\\ExecutionStarted', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ExecutionStopped', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], -10);
        $instance->addListener('byrokrat\\giroapp\\Event\\AutogiroFileImported', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\XmlFileImported', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ExportGenerated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorAdded', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorAmountUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorAttributeUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorCommentUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorEmailUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorNameUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorPhoneUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorPostalAddressUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorRemoved', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\DonorStateUpdated', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ChangesCommitted', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ChangesDiscarded', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\MonitoringListener'] ?? $this->getMonitoringListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\LogEvent', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\LoggingListener'] ?? $this->getLoggingListenerService());
        }, 1 => 'onLogEvent'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\AutogiroFileImported', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportHistoryListener'] ?? $this->getImportHistoryListenerService());
        }, 1 => 'onFileImported'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\XmlFileImported', [0 => function () {
            return ($this->privates['byrokrat\giroapp\Listener\ImportHistoryListener'] ?? $this->getImportHistoryListenerService());
        }, 1 => 'onFileImported'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\AutogiroFileImported', [0 => function () {
            return ($this->privates['file_import_dumper'] ?? $this->getFileImportDumperService());
        }, 1 => 'onFileEvent'], -10);
        $instance->addListener('byrokrat\\giroapp\\Event\\XmlFileImported', [0 => function () {
            return ($this->privates['file_import_dumper'] ?? $this->getFileImportDumperService());
        }, 1 => 'onFileEvent'], -10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ExecutionStopped', [0 => function () {
            return ($this->privates['file_import_dumper'] ?? $this->getFileImportDumperService());
        }, 1 => 'onExecutionStopped'], 10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ExportGenerated', [0 => function () {
            return ($this->privates['file_export_dumper'] ?? $this->getFileExportDumperService());
        }, 1 => 'onFileEvent'], -10);
        $instance->addListener('byrokrat\\giroapp\\Event\\ExecutionStopped', [0 => function () {
            return ($this->privates['file_export_dumper'] ?? $this->getFileExportDumperService());
        }, 1 => 'onExecutionStopped'], 10);

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\giroapp\CommandBus\CommandBus' shared autowired service.
     *
     * @return \byrokrat\giroapp\CommandBus\CommandBus
     */
    protected function getCommandBusService()
    {
        $a = new \byrokrat\giroapp\CommandBus\Helper\LoggingMiddleware();

        $b = ($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService());

        $a->setEventDispatcher($b);
        $c = ($this->privates['byrokrat\giroapp\State\StateCollection'] ?? ($this->privates['byrokrat\giroapp\State\StateCollection'] = new \byrokrat\giroapp\State\StateCollection()));

        $d = new \byrokrat\giroapp\CommandBus\AddDonorHandler(new \byrokrat\giroapp\Model\NewDonorProcessor($c, ($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? ($this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()))));

        $e = ($this->privates['byrokrat\giroapp\Db\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService());

        $d->setEventDispatcher($b);
        $d->setDonorRepository($e);
        $f = ($this->privates['byrokrat\giroapp\Db\DriverInterface'] ?? $this->getDriverInterfaceService());

        $g = new \byrokrat\giroapp\CommandBus\CommitHandler($f);
        $g->setEventDispatcher($b);
        $h = $this->getOrganizationBgService();

        $i = new \byrokrat\giroapp\CommandBus\ExportHandler((new \byrokrat\giroapp\AutogiroWriterFactory(new \byrokrat\autogiro\Writer\WriterFactory()))->createWriter(($this->services['ini'] ?? $this->getIniService())->getConfig("org_bgc_nr"), $h));

        $j = new \byrokrat\giroapp\CommandBus\ForceStateHandler($c);
        $j->setEventDispatcher($b);
        $j->setDonorRepository($e);
        $k = new \byrokrat\giroapp\AutogiroVisitor(($this->services['ini'] ?? $this->getIniService())->getConfig("org_bgc_nr"), $h);

        $l = new \byrokrat\giroapp\CommandBus\ImportAutogiroFileHandler((new \byrokrat\autogiro\Parser\ParserFactory())->createParser(), $k);
        $l->setEventDispatcher($b);
        $m = ($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService());

        $n = new \byrokrat\giroapp\CommandBus\ImportXmlFileHandler(new \byrokrat\giroapp\Xml\XmlMandateParser($m->createId(($this->services['ini'] ?? $this->getIniService())->getConfigValue("org_id")), $h, ($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? ($this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())), $m));

        $o = new \byrokrat\giroapp\CommandBus\RemoveDonorHandler();
        $o->setEventDispatcher($b);
        $o->setDonorRepository($e);
        $p = new \byrokrat\giroapp\CommandBus\RollbackHandler($f);
        $p->setEventDispatcher($b);
        $q = new \byrokrat\giroapp\CommandBus\UpdateAttributeHandler();
        $q->setEventDispatcher($b);
        $q->setDonorRepository($e);
        $r = new \byrokrat\giroapp\CommandBus\UpdateCommentHandler();
        $r->setEventDispatcher($b);
        $r->setDonorRepository($e);
        $s = new \byrokrat\giroapp\CommandBus\UpdateDonationAmountHandler();
        $s->setEventDispatcher($b);
        $s->setDonorRepository($e);
        $t = new \byrokrat\giroapp\CommandBus\UpdateEmailHandler();
        $t->setEventDispatcher($b);
        $t->setDonorRepository($e);
        $u = new \byrokrat\giroapp\CommandBus\UpdateNameHandler();
        $u->setEventDispatcher($b);
        $u->setDonorRepository($e);
        $v = new \byrokrat\giroapp\CommandBus\UpdatePhoneHandler();
        $v->setEventDispatcher($b);
        $v->setDonorRepository($e);
        $w = new \byrokrat\giroapp\CommandBus\UpdatePostalAddressHandler();
        $w->setEventDispatcher($b);
        $w->setDonorRepository($e);

        $this->privates['byrokrat\giroapp\CommandBus\CommandBus'] = $instance = new \byrokrat\giroapp\CommandBus\CommandBus(new \League\Tactician\CommandBus([0 => $a, 1 => new \League\Tactician\Plugins\LockingMiddleware(), 2 => new \League\Tactician\Handler\CommandHandlerMiddleware(new \League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor(), new \League\Tactician\Handler\Locator\InMemoryLocator(['byrokrat\\giroapp\\CommandBus\\AddDonor' => $d, 'byrokrat\\giroapp\\CommandBus\\Commit' => $g, 'byrokrat\\giroapp\\CommandBus\\Export' => $i, 'byrokrat\\giroapp\\CommandBus\\ForceState' => $j, 'byrokrat\\giroapp\\CommandBus\\ImportAutogiroFile' => $l, 'byrokrat\\giroapp\\CommandBus\\ImportXmlFile' => $n, 'byrokrat\\giroapp\\CommandBus\\RemoveDonor' => $o, 'byrokrat\\giroapp\\CommandBus\\Rollback' => $p, 'byrokrat\\giroapp\\CommandBus\\UpdateAttribute' => $q, 'byrokrat\\giroapp\\CommandBus\\UpdateComment' => $r, 'byrokrat\\giroapp\\CommandBus\\UpdateDonationAmount' => $s, 'byrokrat\\giroapp\\CommandBus\\UpdateEmail' => $t, 'byrokrat\\giroapp\\CommandBus\\UpdateName' => $u, 'byrokrat\\giroapp\\CommandBus\\UpdatePhone' => $v, 'byrokrat\\giroapp\\CommandBus\\UpdatePostalAddress' => $w, 'byrokrat\\giroapp\\CommandBus\\UpdateState' => new \byrokrat\giroapp\CommandBus\UpdateStateHandler($j)]), new \League\Tactician\Handler\MethodNameInflector\HandleInflector())]));

        $n->setCommandBus($instance);
        $n->setEventDispatcher($b);
        $x = ($this->privates['byrokrat\giroapp\Db\DonorQueryInterface'] ?? $this->getDonorQueryInterfaceService());

        $k->setCommandBus($instance);
        $k->setDonorQuery($x);

        $i->setCommandBus($instance);
        $i->setEventDispatcher($b);
        $i->setDonorQuery($x);

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DonorQueryInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DonorQueryDecorator
     */
    protected function getDonorQueryInterfaceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['byrokrat\\giroapp\\Db\\DonorQueryInterface'] = $this->createProxy('DonorQueryDecorator_48491f1', function () {
                return \DonorQueryDecorator_48491f1::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDonorQueryInterfaceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        return new \byrokrat\giroapp\Db\DonorQueryDecorator(($this->privates['byrokrat\giroapp\Db\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DonorRepositoryInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DonorRepositoryInterface
     */
    protected function getDonorRepositoryInterfaceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['byrokrat\\giroapp\\Db\\DonorRepositoryInterface'] = $this->createProxy('DonorRepositoryInterface_13c774f', function () {
                return \DonorRepositoryInterface_13c774f::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDonorRepositoryInterfaceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        return ($this->privates['byrokrat\giroapp\Db\DriverInterface'] ?? $this->getDriverInterfaceService())->getDonorRepository(($this->privates['byrokrat\giroapp\Db\DriverEnvironment'] ?? $this->getDriverEnvironmentService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DriverEnvironment' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DriverEnvironment
     */
    protected function getDriverEnvironmentService()
    {
        return $this->privates['byrokrat\giroapp\Db\DriverEnvironment'] = new \byrokrat\giroapp\Db\DriverEnvironment(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? ($this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), new \byrokrat\giroapp\Model\DonorFactory(($this->privates['byrokrat\giroapp\State\StateCollection'] ?? ($this->privates['byrokrat\giroapp\State\StateCollection'] = new \byrokrat\giroapp\State\StateCollection())), ($this->privates['byrokrat\banking\AccountFactoryInterface'] ?? ($this->privates['byrokrat\banking\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())), ($this->privates['byrokrat\id\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService())));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DriverInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DriverInterface
     */
    protected function getDriverInterfaceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['byrokrat\\giroapp\\Db\\DriverInterface'] = $this->createProxy('DriverInterface_5855917', function () {
                return \DriverInterface_5855917::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDriverInterfaceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        return [($this->privates['byrokrat\giroapp\Db\DriverFactoryCollection'] ?? ($this->privates['byrokrat\giroapp\Db\DriverFactoryCollection'] = new \byrokrat\giroapp\Db\DriverFactoryCollection()))->getDriverFactory(($this->services['ini'] ?? $this->getIniService())->getConfigValue("db_driver")), 'createDriver'](($this->services['ini'] ?? $this->getIniService())->getConfigValue("db_dsn"));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\ImportHistoryInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\ImportHistoryInterface
     */
    protected function getImportHistoryInterfaceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['byrokrat\\giroapp\\Db\\ImportHistoryInterface'] = $this->createProxy('ImportHistoryInterface_32011a6', function () {
                return \ImportHistoryInterface_32011a6::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getImportHistoryInterfaceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        return ($this->privates['byrokrat\giroapp\Db\DriverInterface'] ?? $this->getDriverInterfaceService())->getImportHistory(($this->privates['byrokrat\giroapp\Db\DriverEnvironment'] ?? $this->getDriverEnvironmentService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Filesystem\FilesystemFactory' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\FilesystemFactory
     */
    protected function getFilesystemFactoryService()
    {
        return $this->privates['byrokrat\giroapp\Filesystem\FilesystemFactory'] = new \byrokrat\giroapp\Filesystem\FilesystemFactory(($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? ($this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Filesystem\RenamingProcessor' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\RenamingProcessor
     */
    protected function getRenamingProcessorService()
    {
        return $this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] = new \byrokrat\giroapp\Filesystem\RenamingProcessor(($this->privates['byrokrat\giroapp\Utils\SystemClock'] ?? ($this->privates['byrokrat\giroapp\Utils\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\ImportHistoryListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\ImportHistoryListener
     */
    protected function getImportHistoryListenerService()
    {
        return $this->privates['byrokrat\giroapp\Listener\ImportHistoryListener'] = new \byrokrat\giroapp\Listener\ImportHistoryListener(($this->privates['byrokrat\giroapp\Db\ImportHistoryInterface'] ?? $this->getImportHistoryInterfaceService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\LoggingListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\LoggingListener
     */
    protected function getLoggingListenerService()
    {
        $a = new \Apix\Log\Logger\File(($this->services['ini'] ?? $this->getIniService())->getConfigValue("log_file"));
        $a->setMinLevel(($this->services['ini'] ?? $this->getIniService())->getConfigValue("log_level"));
        $a->setLogFormatter(new \byrokrat\giroapp\Utils\LogFormatter());

        return $this->privates['byrokrat\giroapp\Listener\LoggingListener'] = new \byrokrat\giroapp\Listener\LoggingListener($a);
    }

    /**
     * Gets the private 'byrokrat\giroapp\Listener\MonitoringListener' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\MonitoringListener
     */
    protected function getMonitoringListenerService()
    {
        $this->privates['byrokrat\giroapp\Listener\MonitoringListener'] = $instance = new \byrokrat\giroapp\Listener\MonitoringListener();

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
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
     * Gets the private 'file_export_dumper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileDumpingListener
     */
    protected function getFileExportDumperService()
    {
        $a = ($this->privates['byrokrat\giroapp\Filesystem\FilesystemFactory'] ?? $this->getFilesystemFactoryService())->createFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("exports_dir"));
        ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])))->createFiles($a);

        $this->privates['file_export_dumper'] = $instance = new \byrokrat\giroapp\Listener\FileDumpingListener($a, ($this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] ?? $this->getRenamingProcessorService()));

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the private 'file_import_dumper' shared autowired service.
     *
     * @return \byrokrat\giroapp\Listener\FileDumpingListener
     */
    protected function getFileImportDumperService()
    {
        $a = ($this->privates['byrokrat\giroapp\Filesystem\FilesystemFactory'] ?? $this->getFilesystemFactoryService())->createFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("imports_dir"));
        ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])))->createFiles($a);

        $this->privates['file_import_dumper'] = $instance = new \byrokrat\giroapp\Listener\FileDumpingListener($a, ($this->privates['byrokrat\giroapp\Filesystem\RenamingProcessor'] ?? $this->getRenamingProcessorService()));

        $instance->setEventDispatcher(($this->privates['Symfony\Component\EventDispatcher\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService()));

        return $instance;
    }

    /**
     * Gets the private 'fs_cwd' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\StdFilesystem
     */
    protected function getFsCwdService()
    {
        return $this->privates['fs_cwd'] = new \byrokrat\giroapp\Filesystem\StdFilesystem('.', ($this->privates['Symfony\Component\Filesystem\Filesystem'] ?? ($this->privates['Symfony\Component\Filesystem\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
    }

    /**
     * Gets the private 'organization_bg' shared autowired service.
     *
     * @return \byrokrat\banking\AccountNumber
     */
    protected function getOrganizationBgService()
    {
        return (new \byrokrat\banking\BankgiroFactory())->createAccount(($this->services['ini'] ?? $this->getIniService())->getConfigValue("org_bg"));
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

    private $loadedDynamicParameters = [];
    private $dynamicParameters = [];

    /**
     * Computes a dynamic parameter.
     *
     * @param string $name The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return [
            'env(GIROAPP_INI)' => 'giroapp.ini',
        ];
    }
}

class DonorQueryDecorator_48491f1 extends \byrokrat\giroapp\Db\DonorQueryDecorator implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder6b78f = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer15f90 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0efee = [
        
    ];

    public function findAll() : \byrokrat\giroapp\Model\DonorCollection
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findAll', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->requireByPayerNumber($payerNumber);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $instance, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($instance);

        $instance->initializer15f90 = $initializer;

        return $instance;
    }

    public function __construct(\byrokrat\giroapp\Db\DonorQueryInterface $decorated)
    {
        static $reflection;

        if (! $this->valueHolder6b78f) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorQueryDecorator');
            $this->valueHolder6b78f = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);

        }

        $this->valueHolder6b78f->__construct($decorated);
    }

    public function & __get($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__get', ['name' => $name], $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        if (isset(self::$publicProperties0efee[$name])) {
            return $this->valueHolder6b78f->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder6b78f;

            $backtrace = debug_backtrace(false);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    get_parent_class($this),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
            return;
        }

        $targetObject = $this->valueHolder6b78f;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder6b78f;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHolder6b78f;
        $accessor = function & () use ($targetObject, $name, $value) {
            return $targetObject->$name = $value;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__isset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder6b78f;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder6b78f;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__unset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder6b78f;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder6b78f;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __clone()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__clone', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f = clone $this->valueHolder6b78f;
    }

    public function __sleep()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__sleep', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return array('valueHolder6b78f');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer15f90 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer15f90;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'initializeProxy', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder6b78f;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder6b78f;
    }


}

class DonorRepositoryInterface_13c774f implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DonorRepositoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder6b78f = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer15f90 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0efee = [
        
    ];

    public function addNewDonor(\byrokrat\giroapp\Model\Donor $newDonor) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'addNewDonor', array('newDonor' => $newDonor), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->addNewDonor($newDonor);
return;
    }

    public function deleteDonor(\byrokrat\giroapp\Model\Donor $donor) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'deleteDonor', array('donor' => $donor), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->deleteDonor($donor);
return;
    }

    public function updateDonorName(\byrokrat\giroapp\Model\Donor $donor, string $newName) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorName', array('donor' => $donor, 'newName' => $newName), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorName($donor, $newName);
return;
    }

    public function updateDonorState(\byrokrat\giroapp\Model\Donor $donor, \byrokrat\giroapp\State\StateInterface $newState) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorState', array('donor' => $donor, 'newState' => $newState), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorState($donor, $newState);
return;
    }

    public function updateDonorPayerNumber(\byrokrat\giroapp\Model\Donor $donor, string $newPayerNumber) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorPayerNumber', array('donor' => $donor, 'newPayerNumber' => $newPayerNumber), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorPayerNumber($donor, $newPayerNumber);
return;
    }

    public function updateDonorAmount(\byrokrat\giroapp\Model\Donor $donor, \byrokrat\amount\Currency\SEK $newAmount) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorAmount', array('donor' => $donor, 'newAmount' => $newAmount), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorAmount($donor, $newAmount);
return;
    }

    public function updateDonorAddress(\byrokrat\giroapp\Model\Donor $donor, \byrokrat\giroapp\Model\PostalAddress $newAddress) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorAddress', array('donor' => $donor, 'newAddress' => $newAddress), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorAddress($donor, $newAddress);
return;
    }

    public function updateDonorEmail(\byrokrat\giroapp\Model\Donor $donor, string $newEmail) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorEmail', array('donor' => $donor, 'newEmail' => $newEmail), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorEmail($donor, $newEmail);
return;
    }

    public function updateDonorPhone(\byrokrat\giroapp\Model\Donor $donor, string $newPhone) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorPhone', array('donor' => $donor, 'newPhone' => $newPhone), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorPhone($donor, $newPhone);
return;
    }

    public function updateDonorComment(\byrokrat\giroapp\Model\Donor $donor, string $newComment) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'updateDonorComment', array('donor' => $donor, 'newComment' => $newComment), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->updateDonorComment($donor, $newComment);
return;
    }

    public function setDonorAttribute(\byrokrat\giroapp\Model\Donor $donor, string $key, string $value) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'setDonorAttribute', array('donor' => $donor, 'key' => $key, 'value' => $value), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->setDonorAttribute($donor, $key, $value);
return;
    }

    public function deleteDonorAttribute(\byrokrat\giroapp\Model\Donor $donor, string $key) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'deleteDonorAttribute', array('donor' => $donor, 'key' => $key), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->deleteDonorAttribute($donor, $key);
return;
    }

    public function findAll() : \byrokrat\giroapp\Model\DonorCollection
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findAll', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Model\Donor
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->requireByPayerNumber($payerNumber);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        $instance->initializer15f90 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder6b78f) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorRepositoryInterface');
            $this->valueHolder6b78f = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__get', ['name' => $name], $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        if (isset(self::$publicProperties0efee[$name])) {
            return $this->valueHolder6b78f->$name;
        }

        $targetObject = $this->valueHolder6b78f;

        $backtrace = debug_backtrace(false);
        trigger_error(
            sprintf(
                'Undefined property: %s::$%s in %s on line %s',
                'byrokrat\\giroapp\\Db\\DonorRepositoryInterface',
                $name,
                $backtrace[0]['file'],
                $backtrace[0]['line']
            ),
            \E_USER_NOTICE
        );
        return $targetObject->$name;
    }

    public function __set($name, $value)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__isset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__unset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__clone', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f = clone $this->valueHolder6b78f;
    }

    public function __sleep()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__sleep', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return array('valueHolder6b78f');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer15f90 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer15f90;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'initializeProxy', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder6b78f;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder6b78f;
    }


}

class DriverInterface_5855917 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DriverInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder6b78f = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer15f90 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0efee = [
        
    ];

    public function getDonorRepository(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\DonorRepositoryInterface
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'getDonorRepository', array('environment' => $environment), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->getDonorRepository($environment);
    }

    public function getImportHistory(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\ImportHistoryInterface
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'getImportHistory', array('environment' => $environment), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->getImportHistory($environment);
    }

    public function commit() : bool
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'commit', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->commit();
    }

    public function rollback() : bool
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'rollback', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->rollback();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        $instance->initializer15f90 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder6b78f) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DriverInterface');
            $this->valueHolder6b78f = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__get', ['name' => $name], $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        if (isset(self::$publicProperties0efee[$name])) {
            return $this->valueHolder6b78f->$name;
        }

        $targetObject = $this->valueHolder6b78f;

        $backtrace = debug_backtrace(false);
        trigger_error(
            sprintf(
                'Undefined property: %s::$%s in %s on line %s',
                'byrokrat\\giroapp\\Db\\DriverInterface',
                $name,
                $backtrace[0]['file'],
                $backtrace[0]['line']
            ),
            \E_USER_NOTICE
        );
        return $targetObject->$name;
    }

    public function __set($name, $value)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__isset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__unset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__clone', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f = clone $this->valueHolder6b78f;
    }

    public function __sleep()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__sleep', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return array('valueHolder6b78f');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer15f90 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer15f90;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'initializeProxy', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder6b78f;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder6b78f;
    }


}

class ImportHistoryInterface_32011a6 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\ImportHistoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder6b78f = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer15f90 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0efee = [
        
    ];

    public function addToImportHistory(\byrokrat\giroapp\Filesystem\FileInterface $file) : void
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'addToImportHistory', array('file' => $file), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f->addToImportHistory($file);
return;
    }

    public function fileWasImported(\byrokrat\giroapp\Filesystem\FileInterface $file) : ?\byrokrat\giroapp\Model\FileThatWasImported
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'fileWasImported', array('file' => $file), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return $this->valueHolder6b78f->fileWasImported($file);
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        $instance->initializer15f90 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder6b78f) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\ImportHistoryInterface');
            $this->valueHolder6b78f = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__get', ['name' => $name], $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        if (isset(self::$publicProperties0efee[$name])) {
            return $this->valueHolder6b78f->$name;
        }

        $targetObject = $this->valueHolder6b78f;

        $backtrace = debug_backtrace(false);
        trigger_error(
            sprintf(
                'Undefined property: %s::$%s in %s on line %s',
                'byrokrat\\giroapp\\Db\\ImportHistoryInterface',
                $name,
                $backtrace[0]['file'],
                $backtrace[0]['line']
            ),
            \E_USER_NOTICE
        );
        return $targetObject->$name;
    }

    public function __set($name, $value)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__isset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__unset', array('name' => $name), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $targetObject = $this->valueHolder6b78f;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__clone', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        $this->valueHolder6b78f = clone $this->valueHolder6b78f;
    }

    public function __sleep()
    {
        $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, '__sleep', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;

        return array('valueHolder6b78f');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer15f90 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer15f90;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer15f90 && ($this->initializer15f90->__invoke($valueHolder6b78f, $this, 'initializeProxy', array(), $this->initializer15f90) || 1) && $this->valueHolder6b78f = $valueHolder6b78f;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder6b78f;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder6b78f;
    }


}
