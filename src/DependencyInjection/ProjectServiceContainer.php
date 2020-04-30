<?php

namespace byrokrat\giroapp\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final
 */
class ProjectServiceContainer extends Container
{
    private $parameters = [];

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

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return [
            'Crell\\Tukio\\OrderedProviderInterface' => true,
            'Fig\\EventDispatcher\\AggregateProvider' => true,
            'League\\Tactician\\CommandBus' => true,
            'League\\Tactician\\Handler\\CommandHandlerMiddleware' => true,
            'League\\Tactician\\Handler\\CommandNameExtractor\\ClassNameExtractor' => true,
            'League\\Tactician\\Handler\\Locator\\InMemoryLocator' => true,
            'League\\Tactician\\Handler\\MethodNameInflector\\HandleInflector' => true,
            'Money\\Currencies' => true,
            'Money\\MoneyFormatter' => true,
            'Money\\MoneyParser' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Psr\\EventDispatcher\\EventDispatcherInterface' => true,
            'Psr\\Log\\LoggerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\Filesystem\\Filesystem' => true,
            'Symfony\\Component\\Workflow\\DefinitionBuilder' => true,
            'Symfony\\Component\\Workflow\\WorkflowInterface' => true,
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
            'byrokrat\\giroapp\\CommandBus\\RemoveAttribute' => true,
            'byrokrat\\giroapp\\CommandBus\\RemoveAttributeHandler' => true,
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
            'byrokrat\\giroapp\\Config\\DefaultsReader' => true,
            'byrokrat\\giroapp\\Config\\IniFileLoader' => true,
            'byrokrat\\giroapp\\Config\\IniRepository' => true,
            'byrokrat\\giroapp\\Config\\LazyConfig' => true,
            'byrokrat\\giroapp\\Config\\SimpleConfig' => true,
            'byrokrat\\giroapp\\Console\\AddConsole' => true,
            'byrokrat\\giroapp\\Console\\ConfConsole' => true,
            'byrokrat\\giroapp\\Console\\DeleteAttributeConsole' => true,
            'byrokrat\\giroapp\\Console\\EditAmountConsole' => true,
            'byrokrat\\giroapp\\Console\\EditConsole' => true,
            'byrokrat\\giroapp\\Console\\EditPayerNumberConsole' => true,
            'byrokrat\\giroapp\\Console\\EditStateConsole' => true,
            'byrokrat\\giroapp\\Console\\ExportConsole' => true,
            'byrokrat\\giroapp\\Console\\Helper\\InputReader' => true,
            'byrokrat\\giroapp\\Console\\Helper\\QuestionFactory' => true,
            'byrokrat\\giroapp\\Console\\ImportConsole' => true,
            'byrokrat\\giroapp\\Console\\ImportXmlMandateConsole' => true,
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
            'byrokrat\\giroapp\\Domain\\State\\MandateCreated' => true,
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
            'byrokrat\\giroapp\\Event\\DonorAttributeRemoved' => true,
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
            'byrokrat\\giroapp\\Event\\Listener\\ErrorListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\FileDumpingListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\ImportHistoryListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\LoggingListener' => true,
            'byrokrat\\giroapp\\Event\\Listener\\OutputtingListener' => true,
            'byrokrat\\giroapp\\Event\\LogEvent' => true,
            'byrokrat\\giroapp\\Event\\TransactionFailed' => true,
            'byrokrat\\giroapp\\Event\\TransactionPerformed' => true,
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
            'byrokrat\\giroapp\\Formatter\\MailStringFormatter' => true,
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
            'byrokrat\\giroapp\\Xml\\CommentFromAttributePass' => true,
            'byrokrat\\giroapp\\Xml\\CompilerConfigurator' => true,
            'byrokrat\\giroapp\\Xml\\DonationAmountFromAttributePass' => true,
            'byrokrat\\giroapp\\Xml\\EmailFromAttributePass' => true,
            'byrokrat\\giroapp\\Xml\\PayerNrFromPersonalIdPass' => true,
            'byrokrat\\giroapp\\Xml\\PhoneFromAttributePass' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandate' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateCompiler' => true,
            'byrokrat\\giroapp\\Xml\\XmlMandateParser' => true,
            'byrokrat\\giroapp\\Xml\\XmlObject' => true,
            'byrokrat\\id\\IdFactoryInterface' => true,
            'byrokrat\\id\\OrganizationIdFactory' => true,
            'default_command' => true,
            'defaults_repository' => true,
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
        class_exists($class, false) || class_alias(__NAMESPACE__."\\$class", $class, false);

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
        (new \byrokrat\giroapp\Workflow\WorkflowConfigurator([0 => ['NEW_MANDATE' => [0 => 'MANDATE_CREATED', 1 => 'NEW_MANDATE']], 1 => ['NEW_DIGITAL_MANDATE' => [0 => 'MANDATE_CREATED', 1 => 'NEW_DIGITAL_MANDATE']], 2 => ['EXPORT' => [0 => 'NEW_MANDATE', 1 => 'MANDATE_SENT']], 3 => ['EXPORT' => [0 => 'NEW_DIGITAL_MANDATE', 1 => 'MANDATE_SENT']], 4 => ['IMPORT_MANDATE_REGISTERED' => [0 => 'MANDATE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 5 => ['EXPORT' => [0 => 'AWAITING_TRANSACTION_REGISTRATION', 1 => 'TRANSACTION_REGISTRATION_SENT']], 6 => ['IMPORT_TRANSACTION_ACTIVE' => [0 => 'TRANSACTION_REGISTRATION_SENT', 1 => 'ACTIVE']], 7 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'ACTIVE', 1 => 'ACTIVE']], 8 => ['INITIATE_REVOCATION' => [0 => 'ACTIVE', 1 => 'AWAITING_REVOCATION']], 9 => ['EXPORT' => [0 => 'AWAITING_REVOCATION', 1 => 'REVOCATION_SENT']], 10 => ['IMPORT_MANDATE_REVOKED' => [0 => 'REVOCATION_SENT', 1 => 'REVOKED']], 11 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'REVOCATION_SENT', 1 => 'REVOCATION_SENT']], 12 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'REVOKED', 1 => 'REVOKED']], 13 => ['REMOVE' => [0 => 'REVOKED', 1 => 'REMOVED']], 14 => ['INITIATE_PAUSE' => [0 => 'ACTIVE', 1 => 'AWAITING_PAUSE']], 15 => ['EXPORT' => [0 => 'AWAITING_PAUSE', 1 => 'PAUSE_SENT']], 16 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'PAUSE_SENT', 1 => 'PAUSED']], 17 => ['INITIATE_RESTART' => [0 => 'PAUSED', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 18 => ['INITIATE_TRANSACTION_UPDATE' => [0 => 'ACTIVE', 1 => 'AWAITING_TRANSACTION_UPDATE']], 19 => ['EXPORT' => [0 => 'AWAITING_TRANSACTION_UPDATE', 1 => 'TRANSACTION_UPDATE_SENT']], 20 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'TRANSACTION_UPDATE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']], 21 => ['INITIATE_PAYER_NUMBER_CHANGE' => [0 => 'ACTIVE', 1 => 'AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE']], 22 => ['EXPORT' => [0 => 'AWAITING_PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE', 1 => 'PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT']], 23 => ['IMPORT_TRANSACTION_REMOVED' => [0 => 'PAYER_NUMBER_CHANGE_TRANSACTION_UPDATE_SENT', 1 => 'AWAITING_PAYER_NUMBER_CHANGE']], 24 => ['EXPORT' => [0 => 'AWAITING_PAYER_NUMBER_CHANGE', 1 => 'PAYER_NUMBER_CHANGE_SENT']], 25 => ['IMPORT_MANDATE_REGISTERED' => [0 => 'PAYER_NUMBER_CHANGE_SENT', 1 => 'AWAITING_TRANSACTION_REGISTRATION']]]))->configureTransitions($a);

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
        $g = ($this->services['ini'] ?? $this->getIniService());
        $h = ($this->privates['byrokrat\\id\\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService());

        $i = new \byrokrat\giroapp\Xml\XmlMandateParser($h->createId(($this->services['ini'] ?? $this->getIniService())->getConfigValue("org_id")), ($this->privates['organization_bg'] ?? $this->getOrganizationBgService()));

        $j = ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory()));

        $i->setAccountFactory($j);
        $i->setIdFactory($h);

        $k = new \byrokrat\giroapp\Xml\XmlMandateCompiler($i);

        $l = ($this->privates['Money\\MoneyParser'] ?? $this->getMoneyParserService());

        (new \byrokrat\giroapp\Xml\CompilerConfigurator(($this->services['ini'] ?? $this->getIniService())->getConfigValue("xml_mandate_payer_nr_strategy"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("xml_mandate_donation_amount_from_attribute"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("xml_mandate_phone_from_attribute"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("xml_mandate_email_from_attribute"), ($this->services['ini'] ?? $this->getIniService())->getConfigValue("xml_mandate_comment_from_attribute"), $l))->loadCompilerPasses($k);

        $this->services['byrokrat\\giroapp\\Plugin\\EnvironmentInterface'] = $instance = new \byrokrat\giroapp\Plugin\ConfiguringEnvironment($a, ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] ?? ($this->privates['byrokrat\\giroapp\\Plugin\\ApiVersion'] = new \byrokrat\giroapp\Plugin\ApiVersion())), $c, ($this->privates['Fig\\EventDispatcher\\AggregateProvider'] ?? $this->getAggregateProviderService()), ($this->privates['Crell\\Tukio\\OrderedProviderInterface'] ?? $this->getOrderedProviderInterfaceService()), ($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] ?? ($this->privates['byrokrat\\giroapp\\Db\\DriverFactoryCollection'] = new \byrokrat\giroapp\Db\DriverFactoryCollection())), $d, $e, $f, $g, $k);

        $m = ($this->privates['byrokrat\\giroapp\\CommandBus\\CommandBusInterface'] ?? $this->getCommandBusInterfaceService());
        $n = new \byrokrat\giroapp\Console\AddConsole();

        $o = ($this->privates['byrokrat\\giroapp\\Db\\DonorRepositoryInterface'] ?? $this->getDonorRepositoryInterfaceService());

        $n->setAccountFactory($j);
        $n->setCommandBus($m);
        $n->setDonorRepository($o);
        $n->setMoneyParser($l);
        $n->setIdFactory($h);
        $p = new \byrokrat\giroapp\Console\DeleteAttributeConsole();
        $p->setCommandBus($m);
        $p->setDonorQuery($c);
        $q = new \byrokrat\giroapp\Console\EditConsole();
        $q->setCommandBus($m);
        $q->setDonorQuery($c);
        $r = new \byrokrat\giroapp\Console\EditAmountConsole();

        $s = ($this->privates['Money\\MoneyFormatter'] ?? $this->getMoneyFormatterService());

        $r->setCommandBus($m);
        $r->setMoneyFormatter($s);
        $r->setMoneyParser($l);
        $r->setDonorQuery($c);
        $t = new \byrokrat\giroapp\Console\EditPayerNumberConsole();
        $t->setCommandBus($m);
        $t->setDonorQuery($c);
        $u = new \byrokrat\giroapp\Console\EditStateConsole(($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService()));
        $u->setCommandBus($m);
        $u->setDonorQuery($c);
        $v = new \byrokrat\giroapp\Console\ExportConsole();
        $v->setCommandBus($m);
        $w = ($this->privates['fs_cwd'] ?? $this->getFsCwdService());

        $x = new \byrokrat\giroapp\Console\ImportConsole($w, ($this->privates['byrokrat\\giroapp\\Event\\Listener\\ErrorListener'] ?? ($this->privates['byrokrat\\giroapp\\Event\\Listener\\ErrorListener'] = new \byrokrat\giroapp\Event\Listener\ErrorListener())));
        $x->setCommandBus($m);
        $x->setEventDispatcher($b);
        $y = new \byrokrat\giroapp\Console\ImportXmlMandateConsole($w, $k);
        $y->setAccountFactory($j);
        $y->setCommandBus($m);
        $y->setEventDispatcher($b);
        $y->setDonorRepository($o);
        $y->setMoneyFormatter($s);
        $y->setMoneyParser($l);
        $y->setIdFactory($h);
        $z = new \byrokrat\giroapp\Console\ListConsole($d, $e, $f);
        $z->setDonorQuery($c);
        $aa = new \byrokrat\giroapp\Console\PauseConsole();
        $aa->setCommandBus($m);
        $aa->setDonorQuery($c);
        $ba = new \byrokrat\giroapp\Console\RemoveConsole();
        $ba->setCommandBus($m);
        $ba->setDonorQuery($c);
        $ca = new \byrokrat\giroapp\Console\RevokeConsole();
        $ca->setCommandBus($m);
        $ca->setDonorQuery($c);
        $da = new \byrokrat\giroapp\Console\ShowConsole($e);
        $da->setDonorQuery($c);
        $ea = new \byrokrat\giroapp\Console\StatusConsole();
        $ea->setDonorQuery($c);
        $ea->setMoneyFormatter($s);
        $fa = new \byrokrat\giroapp\Console\TransactionsConsole();
        $fa->setDonorQuery($c);
        $fa->setDonorEventStore(($this->privates['byrokrat\\giroapp\\Db\\DonorEventStoreInterface'] ?? $this->getDonorEventStoreInterfaceService()));
        $ga = new \byrokrat\giroapp\Formatter\CsvFormatter();
        $ga->setMoneyFormatter($s);
        $ha = new \byrokrat\giroapp\Formatter\HumanFormatter();
        $ha->setMoneyFormatter($s);
        $ia = new \byrokrat\giroapp\Formatter\JsonFormatter();
        $ia->setMoneyFormatter($s);
        $ja = new \byrokrat\giroapp\Filesystem\StdFilesystem(($this->services['ini'] ?? $this->getIniService())->getConfigValue("plugins_dir"), ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] ?? ($this->privates['Symfony\\Component\\Filesystem\\Filesystem'] = new \Symfony\Component\Filesystem\Filesystem())));
        ($this->privates['setup_mkdir'] ?? ($this->privates['setup_mkdir'] = new \byrokrat\giroapp\Filesystem\FilesystemConfigurator([0 => '.'])))->createFiles($ja);

        $instance->setCommandBus($m);
        $instance->setEventDispatcher($b);
        (new \byrokrat\giroapp\Plugin\PluginCollection(new \byrokrat\giroapp\Plugin\CorePlugin($n, new \byrokrat\giroapp\Console\ConfConsole($g), $p, $q, $r, $t, $u, $v, $x, $y, new \byrokrat\giroapp\Console\InitConsole(), $z, $aa, $ba, $ca, $da, $ea, $fa, new \byrokrat\giroapp\Db\Json\JsonDriverFactory(), new \byrokrat\giroapp\Filter\ActiveFilter(), new \byrokrat\giroapp\Filter\RevokedFilter(), new \byrokrat\giroapp\Filter\ExportableFilter(), new \byrokrat\giroapp\Filter\ErrorFilter(), new \byrokrat\giroapp\Filter\PausedFilter(), new \byrokrat\giroapp\Filter\AwaitingResponseFilter(), new \byrokrat\giroapp\Formatter\ListFormatter(), $ga, $ha, $ia, new \byrokrat\giroapp\Formatter\MailStringFormatter(), new \byrokrat\giroapp\Sorter\NullSorter(), new \byrokrat\giroapp\Sorter\NameSorter(), new \byrokrat\giroapp\Sorter\StateSorter(), new \byrokrat\giroapp\Sorter\PayerNumberSorter(), new \byrokrat\giroapp\Sorter\AmountSorter(), new \byrokrat\giroapp\Sorter\CreatedSorter(), new \byrokrat\giroapp\Sorter\UpdatedSorter()), new \byrokrat\giroapp\Plugin\FilesystemLoadingPlugin($ja)))->loadPlugin($instance);

        return $instance;
    }

    /**
     * Gets the public 'ini' shared autowired service.
     *
     * @return \byrokrat\giroapp\Config\ConfigManager
     */
    protected function getIniService()
    {
        $this->services['ini'] = $instance = new \byrokrat\giroapp\Config\ConfigManager(new \byrokrat\giroapp\Config\IniRepository((new \byrokrat\giroapp\Config\DefaultsReader())->getRawDefaults()), new \byrokrat\giroapp\Config\ArrayRepository(['base_dir' => (new \byrokrat\giroapp\Config\BaseDirReader($this->getEnv('GIROAPP_INI')))->getBaseDir()]));

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
        $a->setMoneyFormatter(($this->privates['Money\\MoneyFormatter'] ?? $this->getMoneyFormatterService()));
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
        $instance->addListener(($this->privates['byrokrat\\giroapp\\Event\\Listener\\ErrorListener'] ?? ($this->privates['byrokrat\\giroapp\\Event\\Listener\\ErrorListener'] = new \byrokrat\giroapp\Event\Listener\ErrorListener())));
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
     * Gets the private 'Money\MoneyFormatter' shared autowired service.
     *
     * @return \Money\Formatter\DecimalMoneyFormatter
     */
    protected function getMoneyFormatterService()
    {
        return $this->privates['Money\\MoneyFormatter'] = new \Money\Formatter\DecimalMoneyFormatter(($this->privates['Money\\Currencies'] ?? ($this->privates['Money\\Currencies'] = new \Money\Currencies\ISOCurrencies())));
    }

    /**
     * Gets the private 'Money\MoneyParser' shared autowired service.
     *
     * @return \Money\Parser\DecimalMoneyParser
     */
    protected function getMoneyParserService()
    {
        return $this->privates['Money\\MoneyParser'] = new \Money\Parser\DecimalMoneyParser(($this->privates['Money\\Currencies'] ?? ($this->privates['Money\\Currencies'] = new \Money\Currencies\ISOCurrencies())));
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
     * Gets the private 'byrokrat\giroapp\CommandBus\CommandBusInterface' shared autowired service.
     *
     * @return \byrokrat\giroapp\CommandBus\CommandBus
     */
    protected function getCommandBusInterfaceService()
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
        $k = ($this->privates['organization_bg'] ?? $this->getOrganizationBgService());

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
        $q = new \byrokrat\giroapp\CommandBus\RemoveAttributeHandler();
        $q->setEventDispatcher($b);
        $q->setDonorRepository($e);
        $r = new \byrokrat\giroapp\CommandBus\RemoveDonorHandler();

        $s = new \byrokrat\giroapp\CommandBus\RollbackHandler($i);
        $s->setEventDispatcher($b);
        $t = new \byrokrat\giroapp\CommandBus\UpdateAttributeHandler();
        $t->setEventDispatcher($b);
        $t->setDonorRepository($e);
        $u = new \byrokrat\giroapp\CommandBus\UpdateCommentHandler();
        $u->setEventDispatcher($b);
        $u->setDonorRepository($e);
        $v = new \byrokrat\giroapp\CommandBus\UpdateDonationAmountHandler();

        $w = new \byrokrat\giroapp\CommandBus\UpdateEmailHandler();
        $w->setEventDispatcher($b);
        $w->setDonorRepository($e);
        $x = new \byrokrat\giroapp\CommandBus\UpdateNameHandler();
        $x->setEventDispatcher($b);
        $x->setDonorRepository($e);
        $y = new \byrokrat\giroapp\CommandBus\UpdatePayerNumberHandler();

        $z = new \byrokrat\giroapp\CommandBus\UpdatePhoneHandler();
        $z->setEventDispatcher($b);
        $z->setDonorRepository($e);
        $aa = new \byrokrat\giroapp\CommandBus\UpdatePostalAddressHandler();
        $aa->setEventDispatcher($b);
        $aa->setDonorRepository($e);

        $this->privates['byrokrat\\giroapp\\CommandBus\\CommandBusInterface'] = $instance = new \byrokrat\giroapp\CommandBus\CommandBus(new \League\Tactician\CommandBus([0 => $a, 1 => new \League\Tactician\Handler\CommandHandlerMiddleware(new \League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor(), new \League\Tactician\Handler\Locator\InMemoryLocator(['byrokrat\\giroapp\\CommandBus\\AddDonor' => $d, 'byrokrat\\giroapp\\CommandBus\\AttemptState' => new \byrokrat\giroapp\CommandBus\AttemptStateHandler($h, $g), 'byrokrat\\giroapp\\CommandBus\\Commit' => $j, 'byrokrat\\giroapp\\CommandBus\\Export' => $l, 'byrokrat\\giroapp\\CommandBus\\ForceRemoveDonor' => $m, 'byrokrat\\giroapp\\CommandBus\\ForceState' => $n, 'byrokrat\\giroapp\\CommandBus\\ImportAutogiroFile' => $p, 'byrokrat\\giroapp\\CommandBus\\RemoveAttribute' => $q, 'byrokrat\\giroapp\\CommandBus\\RemoveDonor' => $r, 'byrokrat\\giroapp\\CommandBus\\Rollback' => $s, 'byrokrat\\giroapp\\CommandBus\\UpdateAttribute' => $t, 'byrokrat\\giroapp\\CommandBus\\UpdateComment' => $u, 'byrokrat\\giroapp\\CommandBus\\UpdateDonationAmount' => $v, 'byrokrat\\giroapp\\CommandBus\\UpdateEmail' => $w, 'byrokrat\\giroapp\\CommandBus\\UpdateName' => $x, 'byrokrat\\giroapp\\CommandBus\\UpdatePayerNumber' => $y, 'byrokrat\\giroapp\\CommandBus\\UpdatePhone' => $z, 'byrokrat\\giroapp\\CommandBus\\UpdatePostalAddress' => $aa, 'byrokrat\\giroapp\\CommandBus\\UpdateState' => $h]), new \League\Tactician\Handler\MethodNameInflector\HandleInflector())]));

        $y->setCommandBus($instance);
        $y->setEventDispatcher($b);
        $y->setDonorRepository($e);

        $v->setCommandBus($instance);
        $v->setEventDispatcher($b);
        $v->setDonorRepository($e);

        $r->setCommandBus($instance);
        $ba = ($this->privates['byrokrat\\giroapp\\Db\\DonorQueryInterface'] ?? $this->getDonorQueryInterfaceService());

        $o->setCommandBus($instance);
        $o->setEventDispatcher($b);
        $o->setDonorQuery($ba);

        $l->setCommandBus($instance);
        $l->setEventDispatcher($b);
        $l->setDonorQuery($ba);

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
        return $this->privates['byrokrat\\giroapp\\Db\\DriverEnvironment'] = new \byrokrat\giroapp\Db\DriverEnvironment(($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), new \byrokrat\giroapp\Domain\DonorFactory(($this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] ?? $this->getStateCollectionService()), ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] ?? ($this->privates['byrokrat\\banking\\AccountFactoryInterface'] = new \byrokrat\banking\AccountFactory())), ($this->privates['byrokrat\\id\\IdFactoryInterface'] ?? $this->getIdFactoryInterfaceService()), ($this->privates['Money\\MoneyParser'] ?? $this->getMoneyParserService())), ($this->privates['Money\\MoneyFormatter'] ?? $this->getMoneyFormatterService()));
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
        return $this->privates['byrokrat\\giroapp\\Domain\\State\\StateCollection'] = new \byrokrat\giroapp\Domain\State\StateCollection(new \byrokrat\giroapp\Domain\State\Active(), new \byrokrat\giroapp\Domain\State\AwaitingPause(), new \byrokrat\giroapp\Domain\State\AwaitingPayerNumberChange(), new \byrokrat\giroapp\Domain\State\AwaitingPayerNumberChangeTransactionUpdate(), new \byrokrat\giroapp\Domain\State\AwaitingRevocation(), new \byrokrat\giroapp\Domain\State\AwaitingTransactionRegistration(new \byrokrat\giroapp\Domain\State\TransactionDateFactory(($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] ?? ($this->privates['byrokrat\\giroapp\\Utils\\SystemClock'] = new \byrokrat\giroapp\Utils\SystemClock())), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_day_of_month"), ($this->services['ini'] ?? $this->getIniService())->getConfig("trans_min_days_in_future"))), new \byrokrat\giroapp\Domain\State\AwaitingTransactionUpdate(), new \byrokrat\giroapp\Domain\State\Error(), new \byrokrat\giroapp\Domain\State\MandateCreated(), new \byrokrat\giroapp\Domain\State\MandateSent(), new \byrokrat\giroapp\Domain\State\NewDigitalMandate(), new \byrokrat\giroapp\Domain\State\NewMandate(), new \byrokrat\giroapp\Domain\State\PauseSent(), new \byrokrat\giroapp\Domain\State\Paused(), new \byrokrat\giroapp\Domain\State\PayerNumberChangeSent(), new \byrokrat\giroapp\Domain\State\PayerNumberChangeTransactionUpdateSent(), new \byrokrat\giroapp\Domain\State\Removed(), new \byrokrat\giroapp\Domain\State\RevocationSent(), new \byrokrat\giroapp\Domain\State\Revoked(), new \byrokrat\giroapp\Domain\State\TransactionRegistrationSent(), new \byrokrat\giroapp\Domain\State\TransactionUpdateSent());
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
        return $this->privates['organization_bg'] = (new \byrokrat\banking\BankgiroFactory())->createAccount(($this->services['ini'] ?? $this->getIniService())->getConfigValue("org_bg"));
    }

    public function getParameter(string $name)
    {
        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter(string $name, $value): void
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag(): ParameterBagInterface
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

    private function getDynamicParameter(string $name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    protected function getDefaultParameters(): array
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
    private $valueHoldere3ed2 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer7a10a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesac557 = [
        
    ];

    public function addDonorEventEntry(\byrokrat\giroapp\Db\DonorEventEntry $entry) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'addDonorEventEntry', array('entry' => $entry), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->addDonorEventEntry($entry);
return;
    }

    public function readEntriesForMandateKey(string $mandateKey) : iterable
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'readEntriesForMandateKey', array('mandateKey' => $mandateKey), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->readEntriesForMandateKey($mandateKey);
    }

    public function readAllEntries() : iterable
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'readAllEntries', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->readAllEntries();
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

        $instance->initializer7a10a = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHoldere3ed2) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorEventStoreInterface');
            $this->valueHoldere3ed2 = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__get', ['name' => $name], $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        if (isset(self::$publicPropertiesac557[$name])) {
            return $this->valueHoldere3ed2->$name;
        }

        $targetObject = $this->valueHoldere3ed2;

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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__isset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__unset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__clone', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2 = clone $this->valueHoldere3ed2;
    }

    public function __sleep()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__sleep', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return array('valueHoldere3ed2');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer7a10a = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer7a10a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'initializeProxy', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere3ed2;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldere3ed2;
    }


}

class DonorQueryDecorator_48491f1 extends \byrokrat\giroapp\Db\DonorQueryDecorator implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHoldere3ed2 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer7a10a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesac557 = [
        
    ];

    public function findAll() : \byrokrat\giroapp\Domain\DonorCollection
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findAll', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->requireByPayerNumber($payerNumber);
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

        $instance->initializer7a10a = $initializer;

        return $instance;
    }

    public function __construct(\byrokrat\giroapp\Db\DonorQueryInterface $decorated)
    {
        static $reflection;

        if (! $this->valueHoldere3ed2) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorQueryDecorator');
            $this->valueHoldere3ed2 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);

        }

        $this->valueHoldere3ed2->__construct($decorated);
    }

    public function & __get($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__get', ['name' => $name], $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        if (isset(self::$publicPropertiesac557[$name])) {
            return $this->valueHoldere3ed2->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere3ed2;

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

        $targetObject = $this->valueHoldere3ed2;
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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere3ed2;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHoldere3ed2;
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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__isset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere3ed2;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHoldere3ed2;
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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__unset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere3ed2;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHoldere3ed2;
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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__clone', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2 = clone $this->valueHoldere3ed2;
    }

    public function __sleep()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__sleep', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return array('valueHoldere3ed2');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\byrokrat\giroapp\Db\DonorQueryDecorator $instance) {
            unset($instance->decorated);
        }, $this, 'byrokrat\\giroapp\\Db\\DonorQueryDecorator')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer7a10a = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer7a10a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'initializeProxy', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere3ed2;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldere3ed2;
    }


}

class DonorRepositoryInterface_13c774f implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DonorRepositoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHoldere3ed2 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer7a10a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesac557 = [
        
    ];

    public function addNewDonor(\byrokrat\giroapp\Domain\Donor $newDonor) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'addNewDonor', array('newDonor' => $newDonor), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->addNewDonor($newDonor);
return;
    }

    public function deleteDonor(\byrokrat\giroapp\Domain\Donor $donor) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'deleteDonor', array('donor' => $donor), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->deleteDonor($donor);
return;
    }

    public function updateDonorName(\byrokrat\giroapp\Domain\Donor $donor, string $newName) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorName', array('donor' => $donor, 'newName' => $newName), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorName($donor, $newName);
return;
    }

    public function updateDonorState(\byrokrat\giroapp\Domain\Donor $donor, \byrokrat\giroapp\Domain\State\StateInterface $newState) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorState', array('donor' => $donor, 'newState' => $newState), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorState($donor, $newState);
return;
    }

    public function updateDonorPayerNumber(\byrokrat\giroapp\Domain\Donor $donor, string $newPayerNumber) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorPayerNumber', array('donor' => $donor, 'newPayerNumber' => $newPayerNumber), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorPayerNumber($donor, $newPayerNumber);
return;
    }

    public function updateDonorAmount(\byrokrat\giroapp\Domain\Donor $donor, \Money\Money $newAmount) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorAmount', array('donor' => $donor, 'newAmount' => $newAmount), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorAmount($donor, $newAmount);
return;
    }

    public function updateDonorAddress(\byrokrat\giroapp\Domain\Donor $donor, \byrokrat\giroapp\Domain\PostalAddress $newAddress) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorAddress', array('donor' => $donor, 'newAddress' => $newAddress), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorAddress($donor, $newAddress);
return;
    }

    public function updateDonorEmail(\byrokrat\giroapp\Domain\Donor $donor, string $newEmail) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorEmail', array('donor' => $donor, 'newEmail' => $newEmail), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorEmail($donor, $newEmail);
return;
    }

    public function updateDonorPhone(\byrokrat\giroapp\Domain\Donor $donor, string $newPhone) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorPhone', array('donor' => $donor, 'newPhone' => $newPhone), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorPhone($donor, $newPhone);
return;
    }

    public function updateDonorComment(\byrokrat\giroapp\Domain\Donor $donor, string $newComment) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'updateDonorComment', array('donor' => $donor, 'newComment' => $newComment), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->updateDonorComment($donor, $newComment);
return;
    }

    public function setDonorAttribute(\byrokrat\giroapp\Domain\Donor $donor, string $key, string $value) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'setDonorAttribute', array('donor' => $donor, 'key' => $key, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->setDonorAttribute($donor, $key, $value);
return;
    }

    public function deleteDonorAttribute(\byrokrat\giroapp\Domain\Donor $donor, string $key) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'deleteDonorAttribute', array('donor' => $donor, 'key' => $key), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->deleteDonorAttribute($donor, $key);
return;
    }

    public function findAll() : \byrokrat\giroapp\Domain\DonorCollection
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findAll', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findAll();
    }

    public function findByMandateKey(string $mandateKey) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findByMandateKey', array('mandateKey' => $mandateKey), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'requireByMandateKey', array('mandateKey' => $mandateKey), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber) : ?\byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'findByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber) : \byrokrat\giroapp\Domain\Donor
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'requireByPayerNumber', array('payerNumber' => $payerNumber), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->requireByPayerNumber($payerNumber);
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

        $instance->initializer7a10a = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHoldere3ed2) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DonorRepositoryInterface');
            $this->valueHoldere3ed2 = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__get', ['name' => $name], $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        if (isset(self::$publicPropertiesac557[$name])) {
            return $this->valueHoldere3ed2->$name;
        }

        $targetObject = $this->valueHoldere3ed2;

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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__isset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__unset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__clone', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2 = clone $this->valueHoldere3ed2;
    }

    public function __sleep()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__sleep', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return array('valueHoldere3ed2');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer7a10a = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer7a10a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'initializeProxy', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere3ed2;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldere3ed2;
    }


}

class DriverInterface_5855917 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\DriverInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHoldere3ed2 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer7a10a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesac557 = [
        
    ];

    public function getDonorEventStore(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\DonorEventStoreInterface
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'getDonorEventStore', array('environment' => $environment), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->getDonorEventStore($environment);
    }

    public function getDonorRepository(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\DonorRepositoryInterface
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'getDonorRepository', array('environment' => $environment), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->getDonorRepository($environment);
    }

    public function getImportHistory(\byrokrat\giroapp\Db\DriverEnvironment $environment) : \byrokrat\giroapp\Db\ImportHistoryInterface
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'getImportHistory', array('environment' => $environment), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->getImportHistory($environment);
    }

    public function commit() : bool
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'commit', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->commit();
    }

    public function rollback() : bool
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'rollback', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->rollback();
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

        $instance->initializer7a10a = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHoldere3ed2) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\DriverInterface');
            $this->valueHoldere3ed2 = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__get', ['name' => $name], $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        if (isset(self::$publicPropertiesac557[$name])) {
            return $this->valueHoldere3ed2->$name;
        }

        $targetObject = $this->valueHoldere3ed2;

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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__isset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__unset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__clone', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2 = clone $this->valueHoldere3ed2;
    }

    public function __sleep()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__sleep', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return array('valueHoldere3ed2');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer7a10a = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer7a10a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'initializeProxy', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere3ed2;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldere3ed2;
    }


}

class ImportHistoryInterface_32011a6 implements \ProxyManager\Proxy\VirtualProxyInterface, \byrokrat\giroapp\Db\ImportHistoryInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHoldere3ed2 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer7a10a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesac557 = [
        
    ];

    public function addToImportHistory(\byrokrat\giroapp\Filesystem\FileInterface $file) : void
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'addToImportHistory', array('file' => $file), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2->addToImportHistory($file);
return;
    }

    public function fileWasImported(\byrokrat\giroapp\Filesystem\FileInterface $file) : ?\byrokrat\giroapp\Domain\FileThatWasImported
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'fileWasImported', array('file' => $file), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return $this->valueHoldere3ed2->fileWasImported($file);
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

        $instance->initializer7a10a = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHoldere3ed2) {
            $reflection = $reflection ?? new \ReflectionClass('byrokrat\\giroapp\\Db\\ImportHistoryInterface');
            $this->valueHoldere3ed2 = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__get', ['name' => $name], $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        if (isset(self::$publicPropertiesac557[$name])) {
            return $this->valueHoldere3ed2->$name;
        }

        $targetObject = $this->valueHoldere3ed2;

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
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return $targetObject->$name = $value;
    }

    public function __isset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__isset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        return isset($targetObject->$name);
    }

    public function __unset($name)
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__unset', array('name' => $name), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $targetObject = $this->valueHoldere3ed2;

        unset($targetObject->$name);
return;
    }

    public function __clone()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__clone', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        $this->valueHoldere3ed2 = clone $this->valueHoldere3ed2;
    }

    public function __sleep()
    {
        $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, '__sleep', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;

        return array('valueHoldere3ed2');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializer7a10a = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializer7a10a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer7a10a && ($this->initializer7a10a->__invoke($valueHoldere3ed2, $this, 'initializeProxy', array(), $this->initializer7a10a) || 1) && $this->valueHoldere3ed2 = $valueHoldere3ed2;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere3ed2;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldere3ed2;
    }


}
