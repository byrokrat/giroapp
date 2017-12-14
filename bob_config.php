<?php

namespace Bob\BuildConfig;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

task('default', ['test', 'sniff']);

desc('Run unit and feature tests');
task('test', ['phpspec', 'behat']);

desc('Run phpspec unit tests');
task('phpspec', ['update_container'], function() {
    sh('phpspec run', null, ['failOnError' => true]);
    println('Phpspec unit tests passed');
});

desc('Run behat feature tests');
task('behat', ['update_container'], function() {
    sh('behat --stop-on-failure', null, ['failOnError' => true]);
    println('Behat feature tests passed');
});

desc('Run php code sniffer');
task('sniff', function() {
    sh('phpcs src --standard=PSR2 --ignore=src/DependencyInjection/ProjectServiceContainer.php', null, ['failOnError' => true]);
    println('Syntax checker on src/ passed');
    sh('phpcs spec --standard=spec/ruleset.xml', null, ['failOnError' => true]);
    println('Syntax checker on spec/ passed');
});

desc('Run statical analysis using phpstan feature tests');
task('phpstan', function() {
    sh('phpstan analyze -c phpstan.neon -l 7 src', null, ['failOnError' => true]);
    println('Phpstan analysis passed');
});

desc('Build dependency injection container');
task('container', ['load_dependencies'], __NAMESPACE__.'\build_container');

task('update_container', ['load_dependencies', 'src/DependencyInjection/ProjectServiceContainer.php']);

$containerFiles = fileList('*.yaml')->in([__DIR__ . '/etc']);

fileTask('src/DependencyInjection/ProjectServiceContainer.php', $containerFiles, __NAMESPACE__.'\build_container');

function build_container()
{
    $dic = new ContainerBuilder;
    (new YamlFileLoader($dic, new FileLocator(__DIR__ . '/etc')))->load(basename('container.yaml'));
    $dic->addCompilerPass(new RegisterListenersPass(Dispatcher::CLASS, 'event_listener', 'event_subscriber'));
    $dic->compile();
    file_put_contents('src/DependencyInjection/ProjectServiceContainer.php', (new PhpDumper($dic))->dump([
        'namespace' => 'byrokrat\giroapp\DependencyInjection',
        'class' => 'ProjectServiceContainer'
    ]));
    println('Generated dependency injection container');
}

fileTask('vendor/autoload.php', ['vendor/autoload.php'], function() {
    sh('composer install');
});

fileTask('composer.lock', ['composer.json'], function() {
    sh('composer update');
});

task('load_dependencies', ['vendor/autoload.php', 'composer.lock'], function () {
    require_once 'vendor/autoload.php';
});
