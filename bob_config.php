<?php

namespace Bob\BuildConfig;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;

task('default', ['test', 'sniff']);

desc('Build dependency injection container');
task('dic', ['load_dependencies', 'src/ProjectServiceContainer.php']);

desc('Run unit and feature tests');
task('test', ['phpspec', 'behat']);

desc('Run phpspec unit tests');
task('phpspec', ['dic'], function() {
    sh('phpspec run', null, ['failOnError' => true]);
    println('Phpspec unit tests passed');
});

desc('Run behat feature tests');
task('behat', ['dic'], function() {
    sh('behat --stop-on-failure', null, ['failOnError' => true]);
    println('Behat feature tests passed');
});

desc('Run php code sniffer');
task('sniff', function() {
    sh('phpcs src --standard=PSR2 --ignore=src/ProjectServiceContainer.php', null, ['failOnError' => true]);
    println('Syntax checker on src/ passed');
    sh('phpcs spec --standard=spec/ruleset.xml', null, ['failOnError' => true]);
    println('Syntax checker on spec/ passed');
});

$containerFiles = fileList('*.yaml')->in([__DIR__ . '/etc']);

fileTask('src/ProjectServiceContainer.php', $containerFiles, function($task) {
    $dic = new ContainerBuilder;
    (new YamlFileLoader($dic, new FileLocator(__DIR__ . '/etc')))->load(basename('container.yaml'));
    $dic->addCompilerPass(new RegisterListenersPass(EventDispatcher::CLASS, 'event_listener', 'event_subscriber'));
    $dic->compile();
    file_put_contents($task->name, (new PhpDumper($dic))->dump([
        'namespace' => 'byrokrat\giroapp',
        'class' => pathinfo($task->name, PATHINFO_FILENAME)
    ]));
    println('Generated dependency injection container');
});

fileTask('vendor/autoload.php', ['vendor/autoload.php'], function() {
    sh('composer install');
});

fileTask('composer.lock', ['composer.json'], function() {
    sh('composer update');
});

task('load_dependencies', ['vendor/autoload.php', 'composer.lock'], function () {
    require 'vendor/autoload.php';
});
