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
            'Symfony\\Component\\Workflow\\Definition' => 'getDefinitionService',
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
            'Crell\\Tukio\\OrderedProviderInterface' => true,
            'Fig\\EventDispatcher\\AggregateProvider' => true,
            'League\\Tactician\\CommandBus' => true,
            'League\\Tactician\\Handler\\CommandHandlerMiddleware' => true,
            'League\\Tactician\\Handler\\CommandNameExtractor\\ClassNameExtractor' => true,
            'League\\Tactician\\Handler\\Locator\\InMemoryLocator' => true,
            'League\\Tactician\\Handler\\MethodNameInflector\\HandleInflector' => true,
            'Money\\MoneyFormatter' => true,
            'Money\\MoneyParser' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Psr\\Log\\LoggerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\Filesystem\\Filesystem' => true,
            'Symfony\\Component\\Workflow\\DefinitionBuilder' => true,
            'Symfony\\Component\\Workflow\\WorkflowInterface' => true,
            'base_dir_reader' => true,
            'base_dir_repository' => true,
            'byrokrat\\autogiro\\Parser\\ParserFactory' => true,
            'byrokrat\\autogiro\\Parser\\ParserInterface' => true,
            'byrokrat\\autogiro\\Writer\\WriterFactory' => true,
            'byrokrat\\autogiro\\Writer\\WriterInterface' => true,
            'byrokrat\\banking\\AccountFactoryInterface' => true,
            'byrokrat\\banking\\BankgiroFactory' => true,
            'byrokrat\\giroapp\\Autogiro\\AutogiroVisitor' => true,
            'byrokrat\\giroapp\\Autogiro\\AutogiroWriterFactory' => true,
            'byrokrat\\giroapp\\CommandBus\\AddDonor' => true,
            'byrokrat\\giroapp\\CommandBus\\AddDonorHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\AttemptState' => true,
            'byrokrat\\giroapp\\CommandBus\\AttemptStateHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\CommandBus' => true,
            'byrokrat\\giroapp\\CommandBus\\CommandBusInterface' => true,
            'byrokrat\\giroapp\\CommandBus\\Commit' => true,
            'byrokrat\\giroapp\\CommandBus\\CommitHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\Export' => true,
            'byrokrat\\giroapp\\CommandBus\\ExportHandler' => true,
            'byrokrat\\giroapp\\CommandBus\\ForceRemoveDonor' => true,
            'byrokrat\\giroapp\\CommandBus\\ForceRemoveDonorHandler' => true,
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
            'byrokrat\\giroapp\\CommandBus\\UpdatePayerNumber' => true,
            'byrokrat\\giroapp\\CommandBus\\UpdatePayerNumberHandler' => true,
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
            'byrokrat\\giroapp\\Console\\EditAmountConsole' => true,
            'byrokrat\\giroapp\\Console\\EditConsole' => true,
            'byrokrat\\giroapp\\Console\\EditPayerNumberConsole' => true,
            'byrokrat\\giroapp\\Console\\EditStateConsole' => true,
            'byrokrat\\giroapp\\Console\\ExportConsole' => true,
            'byrokrat\\giroapp\\Console\\Helper\\InputReader' => true,
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => true,
            'byrokrat\\giroapp\\Console\\ImportConsole' => true,
            'byrokrat\\giroapp\\Console\\InitConsole' => true,
            'byrokrat\\giroapp\\Console\\ListConsole' => true,
            'byrokrat\\giroapp\\Console\\PauseConsole' => true,
            'byrokrat\\giroapp\\Console\\RemoveConsole' => true,
            'byrokrat\\giroapp\\Console\\RevokeConsole' => true,
            'byrokrat\\giroapp\\Console\\ShowConsole' => true,
            'byrokrat\\giroapp\\Console\\StatusConsole' => true,
            'byrokrat\\giroapp\\Console\\SymfonyCommandAdapter' => true,
            'byrokrat\\giroapp\\Console\\TransactionsConsole' => true,
            'byrokrat\\giroapp\\Db\\DonorEventEntry' => true,
            'byrokrat\\giroapp\\Db\\DonorEventStoreInterface' => true,
            'byrokrat\\giroapp\\Db\\DonorQueryDecorator' => true,
            'byrokrat\\giroapp\\Db\\DonorQueryInterface' => true,
            'byrokrat\\giroapp\\Db\\DonorRepositoryInterface' => true,
            'byrokrat\\giroapp\\Db\\DriverEnvironment' => true,
            'byrokrat\\giroapp\\Db\\DriverFactoryCollection' => true,
            'byrokrat\\giroapp\\Db\\DriverFactoryInterface' => true,
            'byrokrat\\giroapp\\Db\\DriverInterface' => true,
            'byrokrat\\giroapp\\Db\\ImportHistoryInterface' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDonorEventStore' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDonorRepository' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDriver' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonDriverFactory' => true,
            'byrokrat\\giroapp\\Db\\Json\\JsonImportHistory' => true,
            'byrokrat\\giroapp\\Domain\\Donor' => true,
            'byrokrat\\giroapp\\Domain\\DonorCollection' => true,
            'byrokrat\\giroapp\\Domain\\DonorFactory' => true,
            'byrokrat\\giroapp\\Domain\\FileThatWasImported' => true,
            'byrokrat\\giroapp\\Domain\\NewDonor' => true,
            'byrokrat\\giroapp\\Domain\\NewDonorProcessor' => true,
            'byrokrat\\giroapp\\Domain\\PostalAddress' => true,
            'byrokrat\\giroapp\\Domain\\State\\Active' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingPause' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingPayerNumberChange' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingPayerNumberChangeTransactionUpdate' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingRevocation' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingTransactionRegistration' => true,
            'byrokrat\\giroapp\\Domain\\State\\AwaitingTransactionUpdate' => true,
            'byrokrat\\giroapp\\Domain\\State\\Error' => true,
            'byrokrat\\giroapp\\Domain\\State\\MandateSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\NewDigitalMandate' => true,
            'byrokrat\\giroapp\\Domain\\State\\NewMandate' => true,
            'byrokrat\\giroapp\\Domain\\State\\PauseSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\Paused' => true,
            'byrokrat\\giroapp\\Domain\\State\\PayerNumberChangeSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\PayerNumberChangeTransactionUpdateSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\Removed' => true,
            'byrokrat\\giroapp\\Domain\\State\\RevocationSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\Revoked' => true,
            'byrokrat\\giroapp\\Domain\\State\\StateCollection' => true,
            'byrokrat\\giroapp\\Domain\\State\\TransactionDateFactory' => true,
            'byrokrat\\giroapp\\Domain\\State\\TransactionRegistrationSent' => true,
            'byrokrat\\giroapp\\Domain\\State\\TransactionUpdateSent' => true,
            'byrokrat\\giroapp\\Event\\AutogiroFileImported' => true,
            'byrokrat\\giroapp\\Event\\ChangesCommitted' => true,
            'byrokrat\\giroapp\\Event\\ChangesDiscarded' => true,
            'byrokrat\\giroapp\\Event\\DonorAdded' => true,
            'byrokrat\\giroapp\\Event\\DonorAmountUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorAttributeUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorCommentUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorEmailUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorNameUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorPayerNumberUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorPhoneUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorPostalAddressUpdated' => true,
            'byrokrat\\giroapp\\Event\\DonorRemoved' => true,
            'byrokrat\\giroapp\\Event\\DonorStateUpdated' => true,
            'byrokrat\\giroapp\\Event\\ExecutionStarted' => true,
            'byrokrat\\giroapp\\Event\\ExecutionStopped' => true,
            'byrokrat\\giroapp\\Event\\FileEvent' => true,
            'byrokrat\\giroapp\\Event\\FileExported' => true,
            'byrokrat\\giroapp\\Event\\FileImported' => true,
            'byrokrat\\giroapp\\Event\\Listener\\DonorEventNormalizer' => true,
            'byrokrat\\giroapp\\Event\\Listener\\DonorEventRecorder' => true,
            'byrokrat\\giroapp\\Event\\Listener\\DonorStateListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\FileDumpingListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\ImportHistoryListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\OutputtingListener' => true,
            'byrokrat\\giroapp\\Event\\LogEvent' => true,
            'byrokrat\\giroapp\\Event\\TransactionFailed' => true,
            'byrokrat\\giroapp\\Event\\TransactionPerformed' => true,
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
            'byrokrat\\giroapp\\Exception\\RuntimeException' => true,
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
            'byrokrat\\giroapp\\Filter\\NegatedFilter' => true,
            'byrokrat\\giroapp\\Filter\\PausedFilter' => true,
            'byrokrat\\giroapp\\Filter\\RevokedFilter' => true,
            'byrokrat\\giroapp\\Formatter\\CsvFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\FormatterCollection' => true,
            'byrokrat\\giroapp\\Formatter\\HumanFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\JsonFormatter' => true,
            'byrokrat\\giroapp\\Formatter\\ListFormatter' => true,
            'byrokrat\\giroapp\\Money\\SekNoSubunitMoneyFormatter' => true,
            'byrokrat\\giroapp\\Money\\SekNoSubunitMoneyParser' => true,
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
            'byrokrat\\giroapp\\Utils\\ClassIdExtractor' => true,
            'byrokrat\\giroapp\\Utils\\DispatchingLogger' => true,
            'byrokrat\\giroapp\\Utils\\LoggerFactory' => true,
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
            'byrokrat\\giroapp\\Workflow\\MarkingStore' => true,
            'byrokrat\\giroapp\\Workflow\\WorkflowConfigurator' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateProcessor' => true,
            'byrokrat\\giroapp\\Xml\\XmlObject' => true,
            'byrokrat\\id\\IdFactoryInterface' => true,
            'byrokrat\\id\\OrganizationIdFactory' => true,
            'default_command' => true,
            'export_dumper' => true,
            'fs_cwd' => true,
            'fs_exports' => true,
            'fs_imports' => true,
            'fs_plugins' => true,
            'import_dumper' => true,
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
        $this->services['Symfony\\Component\\Console\\Application'] = $instance = new \Symfony\Component\Console\Application('GiroApp', ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] ?? ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] = new \byrokrat\giroapp\Plugin\ApiVersion())));

        $a = new \Symfony\Component\Console\Command\ListCommand();
        $a->setName('default_command');
        $a->setHidden(true);

        $instance->add($a);
        $instance->setDefaultCommand('default_command');
        ($this->services['byrokrat\\giroapp\\Plugin\\EnvironmentInterface'] ?? $this->getEnvironmentInterfaceService())->configureApplication($instance);

        return $instance;
    }

    /**
     * Gets the public 'Symfony\Component\Workflow\Definition' shared autowired service.
     *
     * @return \Symfony\Component\Workflow\Definition
     */
    protected function getDefinitionService()
    {
        $a = new \Symfony\Component\Workflow\DefinitionBuilder(($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService())->getItemKeys());
        (new \byrokrat\giroapp\Workflow\WorkflowConfigurator([0 => ['EXPORT' => [0 => 'NEW_MANDATE', 1 => 'MANDATE_SENT']], 1 => ['EXPORT' => [0 => 'NEW_DIGITAL_MANDATE', 1 => 'MANDATE_SENT']], 2 => ['IMPORT_MANDATE_REGISTERED' => [0 => 'MANDATE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 3 => ['EXPORT' => [0 => 'AWAITING_TRANSACTION_REGISTRATION', 1 => 'TRANSACTION_REGISTRATION_SENT']], 4 => ['IMPORT_TRANSACTION_ACTIVE' => [0 => 'TRANSACTION_REGISTRATION_SENT', 1 => 'ACTIVE']], 5 => ['INITIATE_REVOCATION' => [0 => 'ACTIVE', 1 => 'AWAITING_REVOCATION']], 6 => ['EXPORT' => [0 => 'AWAITING_REVOCATION', 1 => 'REVOCATION_SENT']], 7 => ['IMPORT_MANDATE_REVOKED' => [0 => 'REVOCATION_SENT', 1 => 'REVOKED']], 8 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'REVOCATION_SENT', 1 => 'REVOCATION_SENT']], 9 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'REVOKED', 1 => 'REVOKED']], 10 => ['REMOVE' => [0 => 'REVOKED', 1 => 'REMOVED']], 11 => ['INITIATE_PAUSE' => [0 => 'ACTIVE', 1 => 'AWAITING_PAUSE']], 12 => ['EXPORT' => [0 => 'AWAITING_PAUSE', 1 => 'PAUSE_SENT']], 13 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'PAUSE_SENT', 1 => 'PAUSED']], 14 => ['INITIATE_RESTART' => [0 => 'PAUSED', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 15 => ['INITIATE_TRANSACTION_UPDATE' => [0 => 'ACTIVE', 1 => 'AWAITING_TRANSACTION_UPDATE']], 16 => ['EXPORT' => [0 => 'AWAITING_TRANSACTION_UPDATE', 1 => 'TRANSACTION_UPDATE_SENT']], 17 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'TRANSACTION_UPDATE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 18 => ['INITIATE_PAYER_NUMBER_CHANGE' => [0 => 'ACTIVE', 1 => 'AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE']], 19 => ['EXPORT' => [0 => 'AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE', 1 => 'PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT']], 20 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT', 1 => 'AWAITING_PAYER_NUMBER_CHANGE']], 21 => ['EXPORT' => [0 => 'AWAITING_PAYER_NUMBER_CHANGE', 1 => 'PAYER_NUMBER_CHANGE_SENT']], 22 => ['IMPORT_MANDATE_REGISTERED' => [0 => 'PAYER_NUMBER_CHANGE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']]]))->configureTransitions($a);

        return $this->services['Symfony\\Component\\Workflow\\Definition'] = $a->build();
    }

    /**
     * Gets the public 'byrokrat\giroapp\Plugin\EnvironmentInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Plugin\ConfiguringEnvironment
     */
    protected function getEnvironmentInterfaceService()
    {
        $a = new \byrokrat\giroapp\Utils\DispatchingLogger();

        $b = ($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService());

        $a->setEventDispatcher($b);
        $c = ($this->privates['byrokrat\\giroapp\\Db\\DonorQueryInterface'] ?? $this->getDonorQueryInterfaceService());
        $d = new \byrokrat\giroapp\Filter\FilterCollection();
        $e = new \byrokrat\giroapp\Formatter\FormatterCollection();
        $f = new \byrokrat\giroapp\Sorter\SorterCollection();

        $this->services['byrokrat\\giroapp\\Plugin\\EnvironmentInterface'] = $instance = new \byrokrat\giroapp\Plugin\ConfiguringEnvironment($a, ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] ?? ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] = new \byrokrat\giroapp\Plugin\ApiVersion())), $c, ($this->privates['Fig\\EventDispatcher\\AggregateProvider'] ?? $this->getAggregateProviderService()), ($this->privates['Crell\\Tukio\\OrderedProviderInterface'] ?? $this->getOrderedProviderInterfaceService()), ($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] ?? ($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] = new \byrokrat\giroapp\Db\DriverFactoryCollection())), $d, $e, $f, ($this->services['ini'] ?? $this->getIniService()));

        $g = ($this->privates['byrokrat\\giroapp\\CommandBus\\CommandBus'] ?? $this->getCommandBusService());
        $h = new \byrokrat\giroapp\Console\AddConsole();

        $i = ($this->privates['Money\\MoneyParser'] ?? ($this->privates['Money\\MoneyParser'] = new \byrokrat\giroapp\Money\SekNoSubunitMoneyParser()));

        $h->setAccountFactory(($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())));
        $h->setCommandBus($g);
        $h->setDonorRepository(($this->privates['byrokrat\\giroapp\\Db\\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService()));
        $h->setMoneyParser($i);
        $h->setIdFactory(($this->privates['byrokrat\\id\\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()));
        $j = new \byrokrat\giroapp\Console\EditConsole();
        $j->setCommandBus($g);
        $j->setDonorQuery($c);
        $k = new \byrokrat\giroapp\Console\EditAmountConsole();

        $l = ($this->privates['Money\\MoneyFormatter'] ?? ($this->privates['Money\\MoneyFormatter'] = new \byrokrat\giroapp\Money\SekNoSubunitMoneyFormatter()));

        $k->setCommandBus($g);
        $k->setMoneyFormatter($l);
        $k->setMoneyParser($i);
        $k->setDonorQuery($c);
        $m = new \byrokrat\giroapp\Console\EditPayerNumberConsole();
        $m->setCommandBus($g);
        $m->setDonorQuery($c);
        $n = new \byrokrat\giroapp\Console\EditStateConsole(($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService()));
        $n->setCommandBus($g);
        $n->setDonorQuery($c);
        $o = new \byrokrat\giroapp\Console\ExportConsole();
        $o->setCommandBus($g);
        $p = new \byrokrat\giroapp\Console\ImportConsole(($this->privates['fs_cwd'] ?? $this->getFsCwdService()));
        $p->setCommandBus($g);
        $q = new \byrokrat\giroapp\Console\ListConsole($d, $e, $f);
        $q->setDonorQuery($c);
        $r = new \byrokrat\giroapp\Console\PauseConsole();
        $r->setCommandBus($g);
        $r->setDonorQuery($c);
        $s = new \byrokrat\giroapp\Console\RemoveConsole();
        $s->setCommandBus($g);
        $s->setDonorQuery($c);
        $t = new \byrokrat\giroapp\Console\RevokeConsole();
        $t->setCommandBus($g);
        $t->setDonorQuery($c);
        $u = new \byrokrat\giroapp\Console\ShowConsole($e);
        $u->setDonorQuery($c);
        $v = new \byrokrat\giroapp\Console\StatusConsole();
        $v->setDonorQuery($c);
        $v->setMoneyFormatter($l);
        $w = new \byrokrat\giroapp\Console\TransactionsConsole();
        $w->setDonorQuery($c);
        $w->setDonorEventStore(($this->privates['byrokrat\\giroapp\\Db\\DonorEventStoreInterface'] ?? $this->getDonorEventStoreInterfaceService()));
        $x = new \byrokrat\giroapp\Formatter\CsvFormatter();
        $x->setMoneyFormatter($l);
        $y = new \byrokrat\giroapp\Formatter\HumanFormatter();
        $y->setMoneyFormatter($l);
        $z = new \byrokrat\giroapp\Formatter\JsonFormatter();
        $z->setMoneyFormatter($l);
        $aa = new \byrokrat\giroapp\Filesystem\StdFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("plugins_dir"), ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] ?? ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
        ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])))->createFiles($aa);

        $instance->setCommandBus($g);
        $instance->setEventDispatcher($b);
        (new \byrokrat\giroapp\Plugin\PluginCollection(new \byrokrat\giroapp\Plugin\CorePlugin($h, $j, $k, $m, $n, $o, $p, new \byrokrat\giroapp\Console\InitConsole(), $q, $r, $s, $t, $u, $v, $w, new \byrokrat\giroapp\Db\Json\JsonDriverFactory(), new \byrokrat\giroapp\Filter\ActiveFilter(), new \byrokrat\giroapp\Filter\RevokedFilter(), new \byrokrat\giroapp\Filter\ExportableFilter(), new \byrokrat\giroapp\Filter\ErrorFilter(), new \byrokrat\giroapp\Filter\PausedFilter(), new \byrokrat\giroapp\Filter\AwaitingResponseFilter(), new \byrokrat\giroapp\Formatter\ListFormatter(), $x, $y, $z, new \byrokrat\giroapp\Sorter\NullSorter(), new \byrokrat\giroapp\Sorter\NameSorter(), new \byrokrat\giroapp\Sorter\StateSorter(), new \byrokrat\giroapp\Sorter\PayerNumberSorter(), new \byrokrat\giroapp\Sorter\AmountSorter(), new \byrokrat\giroapp\Sorter\CreatedSorter(), new \byrokrat\giroapp\Sorter\UpdatedSorter()), new \byrokrat\giroapp\Plugin\FilesystemLoadingPlugin($aa)))->loadPlugin($instance);

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
     * Gets the private 'Crell\Tukio\OrderedProviderInterface' shared autowired service.
     *
     * @return \Crell\Tukio\OrderedListenerProvider
     */
    protected function getOrderedProviderInterfaceService()
    {
        $this->privates['Crell\\Tukio\\OrderedProviderInterface'] = $instance = new \Crell\Tukio\OrderedListenerProvider($this);

        $a = new \byrokrat\giroapp\Event\Listener\DonorEventNormalizer();
        $a->setMoneyFormatter(($this->privates['Money\\MoneyFormatter'] ?? ($this->privates['Money\\MoneyFormatter'] = new \byrokrat\giroapp\Money\SekNoSubunitMoneyFormatter())));
        $b = ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()));
        $c = new \byrokrat\giroapp\Filesystem\FilesystemFactory(($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] ?? ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));

        $d = $c->createFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("imports_dir"));

        $e = ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])));

        $e->createFiles($d);
        $f = new \byrokrat\giroapp\Filesystem\RenamingProcessor($b);

        $g = new \byrokrat\giroapp\Event\Listener\FileDumpingListener($d, $f);

        $h = ($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService());

        $g->setEventDispatcher($h);
        $i = $c->createFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("exports_dir"));
        $e->createFiles($i);

        $j = new \byrokrat\giroapp\Event\Listener\FileDumpingListener($i, $f);
        $j->setEventDispatcher($h);

        $instance->addListener(new \byrokrat\giroapp\Event\Listener\DonorEventRecorder(($this->privates['byrokrat\\giroapp\\Db\\DonorEventStoreInterface'] ?? $this->getDonorEventStoreInterfaceService()), $a, $b));
        $instance->addListener(new \byrokrat\giroapp\Event\Listener\ImportHistoryListener(($this->privates['byrokrat\\giroapp\\Db\\ImportHistoryInterface'] ?? $this->getImportHistoryInterfaceService())));
        $instance->addListener(new \byrokrat\giroapp\Event\Listener\LoggingListener(($this->privates['Psr\\Log\\LoggerInterface'] ?? $this->getLoggerInterfaceService())));
        $instance->addListener([0 => $g, 1 => 'onFileEvent'], 0, NULL, 'byrokrat\\giroapp\\Event\\FileImported');
        $instance->addListener([0 => $g, 1 => 'onExecutionStopped']);
        $instance->addListener([0 => $j, 1 => 'onFileEvent'], 0, NULL, 'byrokrat\\giroapp\\Event\\FileExported');
        $instance->addListener([0 => $j, 1 => 'onExecutionStopped']);

        return $instance;
    }

    /**
     * Gets the private 'Fig\EventDispatcher\AggregateProvider' shared autowired service.
     *
     * @return \Fig\EventDispatcher\AggregateProvider
     */
    protected function getAggregateProviderService()
    {
        $this->privates['Fig\\EventDispatcher\\AggregateProvider'] = $instance = new \Fig\EventDispatcher\AggregateProvider();

        $instance->addProvider(($this->privates['Crell\\Tukio\\OrderedProviderInterface'] ?? $this->getOrderedProviderInterfaceService()));

        return $instance;
    }

    /**
     * Gets the private 'Psr\EventDispatcher\EventDispatcherInterface' shared autowired service.
     *
     * @return \Crell\Tukio\Dispatcher
     */
    protected function getEventDispatcherInterfaceService()
    {
        $a = ($this->privates['Fig\\EventDispatcher\\AggregateProvider'] ?? $this->getAggregateProviderService());

        if (isset($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'])) {
            return $this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'];
        }

        return $this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] = new \Crell\Tukio\Dispatcher($a, ($this->privates['Psr\\Log\\LoggerInterface'] ?? $this->getLoggerInterfaceService()));
    }

    /**
     * Gets the private 'Psr\Log\LoggerInterface' shared autowired service.
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function getLoggerInterfaceService()
    {
        return $this->privates['Psr\\Log\\LoggerInterface'] = (new \byrokrat\giroapp\Utils\LoggerFactory())->createLogger(($this->services['ini'] ?? $this->getIniService())->getConfigValue("log_file"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("log_level"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("log_format"));
    }

    /**
     * Gets the private 'byrokrat\giroapp\CommandBus\CommandBus' shared autowired service.
     *
     * @return \byrokrat\giroapp\CommandBus\CommandBus
     */
    protected function getCommandBusService()
    {
        $a = new \byrokrat\giroapp\CommandBus\Helper\LoggingMiddleware();

        $b = ($this->privates['Psr\\EventDispatcher\\EventDispatcherInterface'] ?? $this->getEventDispatcherInterfaceService());

        $a->setEventDispatcher($b);
        $c = ($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService());

        $d = new \byrokrat\giroapp\CommandBus\AddDonorHandler(new \byrokrat\giroapp\Domain\NewDonorProcessor($c, ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock()))));

        $e = ($this->privates['byrokrat\\giroapp\\Db\\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService());

        $d->setEventDispatcher($b);
        $d->setDonorRepository($e);
        $f = new \byrokrat\giroapp\Workflow\MarkingStore();

        $g = new \Symfony\Component\Workflow\Workflow(($this->services['Symfony\\Component\\Workflow\\Definition'] ?? $this->getDefinitionService()), $f);

        $h = new \byrokrat\giroapp\CommandBus\UpdateStateHandler($g);
        $i = ($this->privates['byrokrat\\giroapp\\Db\\DriverInterface'] ?? $this->getDriverInterfaceService());

        $j = new \byrokrat\giroapp\CommandBus\CommitHandler($i);
        $j->setEventDispatcher($b);
        $k = $this->getOrganizationBgService();

        $l = new \byrokrat\giroapp\CommandBus\ExportHandler((new \byrokrat\giroapp\Autogiro\AutogiroWriterFactory(new \byrokrat\autogiro\Writer\WriterFactory()))->createWriter(($this->services['ini'] ?? $this->getIniService())->getConfig("org_bgc_nr"), $k));

        $m = new \byrokrat\giroapp\CommandBus\ForceRemoveDonorHandler();
        $m->setEventDispatcher($b);
        $m->setDonorRepository($e);
        $n = new \byrokrat\giroapp\CommandBus\ForceStateHandler($c);
        $n->setEventDispatcher($b);
        $n->setDonorRepository($e);
        $o = new \byrokrat\giroapp\Autogiro\AutogiroVisitor(($this->services['ini'] ?? $this->getIniService())->getConfig("org_bgc_nr"), $k);

        $p = new \byrokrat\giroapp\CommandBus\ImportAutogiroFileHandler((new \byrokrat\autogiro\Parser\ParserFactory())->createParser(), $o);
        $p->setEventDispatcher($b);
        $q = ($this->privates['byrokrat\\id\\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService());

        $r = new \byrokrat\giroapp\Xml\XmlMandateProcessor($q->createId(($this->services['ini'] ?? $this->getIniService())->getConfigValue("org_id")), $k);

        $s = new \byrokrat\giroapp\CommandBus\ImportXmlFileHandler($r);
        $s->setEventDispatcher($b);
        $t = new \byrokrat\giroapp\CommandBus\RemoveDonorHandler();

        $u = new \byrokrat\giroapp\CommandBus\RollbackHandler($i);
        $u->setEventDispatcher($b);
        $v = new \byrokrat\giroapp\CommandBus\UpdateAttributeHandler();
        $v->setEventDispatcher($b);
        $v->setDonorRepository($e);
        $w = new \byrokrat\giroapp\CommandBus\UpdateCommentHandler();
        $w->setEventDispatcher($b);
        $w->setDonorRepository($e);
        $x = new \byrokrat\giroapp\CommandBus\UpdateDonationAmountHandler();

        $y = new \byrokrat\giroapp\CommandBus\UpdateEmailHandler();
        $y->setEventDispatcher($b);
        $y->setDonorRepository($e);
        $z = new \byrokrat\giroapp\CommandBus\UpdateNameHandler();
        $z->setEventDispatcher($b);
        $z->setDonorRepository($e);
        $aa = new \byrokrat\giroapp\CommandBus\UpdatePayerNumberHandler();

        $ba = new \byrokrat\giroapp\CommandBus\UpdatePhoneHandler();
        $ba->setEventDispatcher($b);
        $ba->setDonorRepository($e);
        $ca = new \byrokrat\giroapp\CommandBus\UpdatePostalAddressHandler();
        $ca->setEventDispatcher($b);
        $ca->setDonorRepository($e);

        $this->privates['byrokrat\\giroapp\\CommandBus\\CommandBus'] = $instance = new \byrokrat\giroapp\CommandBus\CommandBus(new \League\Tactician\CommandBus([0 => $a, 1 => new \League\Tactician\Handler\CommandHandlerMiddleware(new \League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor(), new \League\Tactician\Handler\Locator\InMemoryLocator(['byrokrat\\giroapp\\CommandBus\\AddDonor' => $d, 'byrokrat\\giroapp\\CommandBus\\AttemptState' => new \byrokrat\giroapp\CommandBus\AttemptStateHandler($h, $g), 'byrokrat\\giroapp\\CommandBus\\Commit' => $j, 'byrokrat\\giroapp\\CommandBus\\Export' => $l, 'byrokrat\\giroapp\\CommandBus\\ForceRemoveDonor' => $m, 'byrokrat\\giroapp\\CommandBus\\ForceState' => $n, 'byrokrat\\giroapp\\CommandBus\\ImportAutogiroFile' => $p, 'byrokrat\\giroapp\\CommandBus\\ImportXmlFile' => $s, 'byrokrat\\giroapp\\CommandBus\\RemoveDonor' => $t, 'byrokrat\\giroapp\\CommandBus\\Rollback' => $u, 'byrokrat\\giroapp\\CommandBus\\UpdateAttribute' => $v, 'byrokrat\\giroapp\\CommandBus\\UpdateComment' => $w, 'byrokrat\\giroapp\\CommandBus\\UpdateDonationAmount' => $x, 'byrokrat\\giroapp\\CommandBus\\UpdateEmail' => $y, 'byrokrat\\giroapp\\CommandBus\\UpdateName' => $z, 'byrokrat\\giroapp\\CommandBus\\UpdatePayerNumber' => $aa, 'byrokrat\\giroapp\\CommandBus\\UpdatePhone' => $ba, 'byrokrat\\giroapp\\CommandBus\\UpdatePostalAddress' => $ca, 'byrokrat\\giroapp\\CommandBus\\UpdateState' => $h]), new \League\Tactician\Handler\MethodNameInflector\HandleInflector())]));

        $aa->setCommandBus($instance);
        $aa->setEventDispatcher($b);
        $aa->setDonorRepository($e);

        $x->setCommandBus($instance);
        $x->setEventDispatcher($b);
        $x->setDonorRepository($e);

        $t->setCommandBus($instance);

        $r->setAccountFactory(($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())));
        $r->setCommandBus($instance);
        $r->setDonorRepository($e);
        $r->setIdFactory($q);
        $da = ($this->privates['byrokrat\\giroapp\\Db\\DonorQueryInterface'] ?? $this->getDonorQueryInterfaceService());

        $o->setCommandBus($instance);
        $o->setEventDispatcher($b);
        $o->setDonorQuery($da);

        $l->setCommandBus($instance);
        $l->setEventDispatcher($b);
        $l->setDonorQuery($da);

        $f->setCommandBus($instance);

        return $instance;
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DonorEventStoreInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DonorEventStoreInterface
     */
    protected function getDonorEventStoreInterfaceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['byrokrat\\giroapp\\Db\\DonorEventStoreInterface'] = $this->createProxy('DonorEventStoreInterface_beb126f', function () {
                return \DonorEventStoreInterface_beb126f::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDonorEventStoreInterfaceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        return ($this->privates['byrokrat\\giroapp\\Db\\DriverInterface'] ?? $this->getDriverInterfaceService())->getDonorEventStore(($this->privates['byrokrat\\giroapp\\Db\\DriverEnvironment'] ?? $this->getDriverEnvironmentService()));
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

        return new \byrokrat\giroapp\Db\DonorQueryDecorator(($this->privates['byrokrat\\giroapp\\Db\\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService()));
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

        return ($this->privates['byrokrat\\giroapp\\Db\\DriverInterface'] ?? $this->getDriverInterfaceService())->getDonorRepository(($this->privates['byrokrat\\giroapp\\Db\\DriverEnvironment'] ?? $this->getDriverEnvironmentService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Db\DriverEnvironment' shared autowired service.
     *
     * @return \byrokrat\giroapp\Db\DriverEnvironment
     */
    protected function getDriverEnvironmentService()
    {
        return $this->privates['byrokrat\\giroapp\\Db\\DriverEnvironment'] = new \byrokrat\giroapp\Db\DriverEnvironment(($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), new \byrokrat\giroapp\Domain\DonorFactory(($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService()), ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())), ($this->privates['byrokrat\\id\\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()), ($this->privates['Money\\MoneyParser'] ?? ($this->privates['Money\\MoneyParser'] = new \byrokrat\giroapp\Money\SekNoSubunitMoneyParser()))), ($this->privates['Money\\MoneyFormatter'] ?? ($this->privates['Money\\MoneyFormatter'] = new \byrokrat\giroapp\Money\SekNoSubunitMoneyFormatter())));
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

        return [($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] ?? ($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] = new \byrokrat\giroapp\Db\DriverFactoryCollection()))->getDriverFactory(($this->services['ini'] ?? $this->getIniService())->getConfigValue("db_driver")), 'createDriver'](($this->services['ini'] ?? $this->getIniService())->getConfigValue("db_dsn"));
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

        return ($this->privates['byrokrat\\giroapp\\Db\\DriverInterface'] ?? $this->getDriverInterfaceService())->getImportHistory(($this->privates['byrokrat\\giroapp\\Db\\DriverEnvironment'] ?? $this->getDriverEnvironmentService()));
    }

    /**
     * Gets the private 'byrokrat\giroapp\Domain\State\StateCollection' shared autowired service.
     *
     * @return \byrokrat\giroapp\Domain\State\StateCollection
     */
    protected function getStateCollectionService()
    {
        return $this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] = new \byrokrat\giroapp\Domain\State\StateCollection(new \byrokrat\giroapp\Domain\State\Active(), new \byrokrat\giroapp\Domain\State\AwaitingPause(), new \byrokrat\giroapp\Domain\State\AwaitingPayerNumberChange(), new \byrokrat\giroapp\Domain\State\AwaitingPayerNumberChangeTransactionUpdate(), new \byrokrat\giroapp\Domain\State\AwaitingRevocation(), new \byrokrat\giroapp\Domain\State\AwaitingTransactionRegistration(new \byrokrat\giroapp\Domain\State\TransactionDateFactory(($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_day_of_month"), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_min_days_in_future"))), new \byrokrat\giroapp\Domain\State\AwaitingTransactionUpdate(), new \byrokrat\giroapp\Domain\State\Error(), new \byrokrat\giroapp\Domain\State\MandateSent(), new \byrokrat\giroapp\Domain\State\NewDigitalMandate(), new \byrokrat\giroapp\Domain\State\NewMandate(), new \byrokrat\giroapp\Domain\State\PauseSent(), new \byrokrat\giroapp\Domain\State\Paused(), new \byrokrat\giroapp\Domain\State\PayerNumberChangeSent(), new \byrokrat\giroapp\Domain\State\PayerNumberChangeTransactionUpdateSent(), new \byrokrat\giroapp\Domain\State\Removed(), new \byrokrat\giroapp\Domain\State\RevocationSent(), new \byrokrat\giroapp\Domain\State\Revoked(), new \byrokrat\giroapp\Domain\State\TransactionRegistrationSent(), new \byrokrat\giroapp\Domain\State\TransactionUpdateSent());
    }

    /**
     * Gets the private 'byrokrat\id\IdFactoryInterface' shared service.
     *
     * @return \byrokrat\id\PersonalIdFactory
     */
    protected function getIdFactoryInterfaceService()
    {
        return $this->privates['byrokrat\\id\\IdFactoryInterface'] = new \byrokrat\id\PersonalIdFactory(new \byrokrat\id\OrganizationIdFactory());
    }

    /**
     * Gets the private 'fs_cwd' shared autowired service.
     *
     * @return \byrokrat\giroapp\Filesystem\StdFilesystem
     */
    protected function getFsCwdService()
    {
        return $this->privates['fs_cwd'] = new \byrokrat\giroapp\Filesystem\StdFilesystem('.', ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] ?? ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
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

class DonorEventStoreInterface_beb126f implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DonorEventStoreInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder826af = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer12144 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties70dc9 = [
        
    ];

    public function addDonorEventEntry(\byrokrat\giroapp\Db\DonorEventEntry $entry) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'addDonorEventEntry', array('entry' => $entry), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->addDonorEventEntry($entry);
return;
    }

    public function readEntriesForMandateKey(string $mandateKey) : iterable
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'readEntriesForMandateKey', array('mandateKey' => $mandateKey), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->readEntriesForMandateKey($mandateKey);
    }

    public function readAllEntries() : iterable
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'readAllEntries', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->readAllEntries();
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

        $instance->initializer12144 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder826af) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorEventStoreInterface');
            $this->valueHolder826af = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__get', ['name' => $name], $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        if (isset(self::$publicProperties70dc9[$name])) {
            return $this->valueHolder826af->$name;
        }

        $targetObject = $this->valueHolder826af;

        $backtrace = debug_backtrace(false);
        trigger_error(
            sprintf(
                'Undefined property: %s::$%s in %s on line %s',
                'byrokrat\\giroapp\\Db\\DonorEventStoreInterface',
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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__isset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__unset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__clone', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af = clone $this->valueHolder826af;
    }

    public function __sleep()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__sleep', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return array('valueHolder826af');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer12144 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer12144;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'initializeProxy', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder826af;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder826af;
    }


}

class DonorQueryDecorator_48491f1 extends \byrokrat\giroapp\Db\DonorQueryDecorator implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder826af = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer12144 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties70dc9 = [
        
    ];

    public function findAll() : \byrokrat\giroapp\Domain\DonorCollection
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findAll', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->requireByPayerNumber($payerNumber);
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

        $instance->initializer12144 = $initializer;

        return $instance;
    }

    public function __construct(\byrokrat\giroapp\Db\DonorQueryInterface $decorated)
    {
        static $reflection;

        if (! $this->valueHolder826af) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorQueryDecorator');
            $this->valueHolder826af = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);

        }

        $this->valueHolder826af->__construct($decorated);
    }

    public function & __get($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__get', ['name' => $name], $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        if (isset(self::$publicProperties70dc9[$name])) {
            return $this->valueHolder826af->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder826af;

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

        $targetObject = $this->valueHolder826af;
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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder826af;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHolder826af;
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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__isset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder826af;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder826af;
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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__unset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder826af;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder826af;
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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__clone', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af = clone $this->valueHolder826af;
    }

    public function __sleep()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__sleep', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return array('valueHolder826af');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer12144 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer12144;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'initializeProxy', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder826af;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder826af;
    }


}

class DonorRepositoryInterface_13c774f implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DonorRepositoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder826af = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer12144 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties70dc9 = [
        
    ];

    public function addNewDonor(\byrokrat\giroapp\Domain\Donor $newDonor) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'addNewDonor', array('newDonor' => $newDonor), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->addNewDonor($newDonor);
return;
    }

    public function deleteDonor(\byrokrat\giroapp\Domain\Donor $donor) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'deleteDonor', array('donor' => $donor), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->deleteDonor($donor);
return;
    }

    public function updateDonorName(\byrokrat\giroapp\Domain\Donor $donor, string $newName) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorName', array('donor' => $donor, 'newName' => $newName), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorName($donor, $newName);
return;
    }

    public function updateDonorState(\byrokrat\giroapp\Domain\Donor $donor, \byrokrat\giroapp\Domain\State\StateInterface $newState) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorState', array('donor' => $donor, 'newState' => $newState), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorState($donor, $newState);
return;
    }

    public function updateDonorPayerNumber(\byrokrat\giroapp\Domain\Donor $donor, string $newPayerNumber) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorPayerNumber', array('donor' => $donor, 'newPayerNumber' => $newPayerNumber), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorPayerNumber($donor, $newPayerNumber);
return;
    }

    public function updateDonorAmount(\byrokrat\giroapp\Domain\Donor $donor, \Money\Money $newAmount) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorAmount', array('donor' => $donor, 'newAmount' => $newAmount), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorAmount($donor, $newAmount);
return;
    }

    public function updateDonorAddress(\byrokrat\giroapp\Domain\Donor $donor, \byrokrat\giroapp\Domain\PostalAddress $newAddress) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorAddress', array('donor' => $donor, 'newAddress' => $newAddress), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorAddress($donor, $newAddress);
return;
    }

    public function updateDonorEmail(\byrokrat\giroapp\Domain\Donor $donor, string $newEmail) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorEmail', array('donor' => $donor, 'newEmail' => $newEmail), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorEmail($donor, $newEmail);
return;
    }

    public function updateDonorPhone(\byrokrat\giroapp\Domain\Donor $donor, string $newPhone) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorPhone', array('donor' => $donor, 'newPhone' => $newPhone), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorPhone($donor, $newPhone);
return;
    }

    public function updateDonorComment(\byrokrat\giroapp\Domain\Donor $donor, string $newComment) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'updateDonorComment', array('donor' => $donor, 'newComment' => $newComment), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->updateDonorComment($donor, $newComment);
return;
    }

    public function setDonorAttribute(\byrokrat\giroapp\Domain\Donor $donor, string $key, string $value) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'setDonorAttribute', array('donor' => $donor, 'key' => $key, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->setDonorAttribute($donor, $key, $value);
return;
    }

    public function deleteDonorAttribute(\byrokrat\giroapp\Domain\Donor $donor, string $key) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'deleteDonorAttribute', array('donor' => $donor, 'key' => $key), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->deleteDonorAttribute($donor, $key);
return;
    }

    public function findAll() : \byrokrat\giroapp\Domain\DonorCollection
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findAll', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->requireByPayerNumber($payerNumber);
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

        $instance->initializer12144 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder826af) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorRepositoryInterface');
            $this->valueHolder826af = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__get', ['name' => $name], $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        if (isset(self::$publicProperties70dc9[$name])) {
            return $this->valueHolder826af->$name;
        }

        $targetObject = $this->valueHolder826af;

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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__isset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__unset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__clone', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af = clone $this->valueHolder826af;
    }

    public function __sleep()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__sleep', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return array('valueHolder826af');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer12144 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer12144;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'initializeProxy', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder826af;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder826af;
    }


}

class DriverInterface_5855917 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DriverInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder826af = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer12144 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties70dc9 = [
        
    ];

    public function getDonorEventStore(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\DonorEventStoreInterface
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'getDonorEventStore', array('environment' => $environment), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->getDonorEventStore($environment);
    }

    public function getDonorRepository(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\DonorRepositoryInterface
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'getDonorRepository', array('environment' => $environment), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->getDonorRepository($environment);
    }

    public function getImportHistory(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\ImportHistoryInterface
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'getImportHistory', array('environment' => $environment), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->getImportHistory($environment);
    }

    public function commit() : bool
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'commit', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->commit();
    }

    public function rollback() : bool
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'rollback', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->rollback();
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

        $instance->initializer12144 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder826af) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DriverInterface');
            $this->valueHolder826af = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__get', ['name' => $name], $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        if (isset(self::$publicProperties70dc9[$name])) {
            return $this->valueHolder826af->$name;
        }

        $targetObject = $this->valueHolder826af;

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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__isset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__unset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__clone', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af = clone $this->valueHolder826af;
    }

    public function __sleep()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__sleep', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return array('valueHolder826af');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer12144 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer12144;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'initializeProxy', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder826af;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder826af;
    }


}

class ImportHistoryInterface_32011a6 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\ImportHistoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder826af = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer12144 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties70dc9 = [
        
    ];

    public function addToImportHistory(\byrokrat\giroapp\Filesystem\FileInterface $file) : void
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'addToImportHistory', array('file' => $file), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af->addToImportHistory($file);
return;
    }

    public function fileWasImported(\byrokrat\giroapp\Filesystem\FileInterface $file) : ?\byrokrat\giroapp\Domain\FileThatWasImported
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'fileWasImported', array('file' => $file), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return $this->valueHolder826af->fileWasImported($file);
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

        $instance->initializer12144 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder826af) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\ImportHistoryInterface');
            $this->valueHolder826af = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__get', ['name' => $name], $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        if (isset(self::$publicProperties70dc9[$name])) {
            return $this->valueHolder826af->$name;
        }

        $targetObject = $this->valueHolder826af;

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
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__isset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__unset', array('name' => $name), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $targetObject = $this->valueHolder826af;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__clone', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        $this->valueHolder826af = clone $this->valueHolder826af;
    }

    public function __sleep()
    {
        $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, '__sleep', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;

        return array('valueHolder826af');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer12144 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer12144;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer12144 && ($this->initializer12144->__invoke($valueHolder826af, $this, 'initializeProxy', array(), $this->initializer12144) || 1) && $this->valueHolder826af = $valueHolder826af;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder826af;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder826af;
    }


}
