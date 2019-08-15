<?php

namespace Bob\BuildConfig;

use Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;

task('default', ['test', 'phar', 'behat-phar']);

desc('Run all tests');
task('test', ['phpspec', 'behat', 'examples', 'phpstan', 'sniff']);

desc('Run phpspec unit tests');
task('phpspec', ['update_on_config_updates'], function () {
    shell('phpspec run');
    println('Phpspec unit tests passed');
});
task('phpspec.yml', ['phpspec']);

desc('Run behat feature tests');
task('behat', ['update_on_config_updates'], function () {
    shell('behat --stop-on-failure --suite=default');
    println('Behat feature tests passed');
});
task('behat.yml', ['behat']);

desc('Run behat feature tests in debug mode');
task('behat-debug', ['update_on_config_updates'], function () {
    shell('behat --stop-on-failure --suite=debug');
    println('Behat feature tests passed');
});

desc('Run behat feature tests using phar');
task('behat-phar', ['giroapp.phar'], function () {
    shell('behat --stop-on-failure --suite=phar');
    println('Behat feature tests using PHAR passed');
});

desc('Tests documentation examples');
task('examples', function () {
    shell('readme-tester README.md docs');
    println('Documentation examples valid');
});

desc('Run statical analysis using phpstan feature tests');
task('phpstan', function () {
    shell('phpstan analyze -c phpstan.neon -l 7 src');
    println('Phpstan analysis passed');
});
task('phpstan.neon', ['phpstan']);

desc('Run php code sniffer');
task('sniff', function () {
    shell('phpcs src --standard=PSR2 --ignore=src/DependencyInjection/ProjectServiceContainer.php');
    println('Syntax checker on src/ passed');
    shell('phpcs spec --standard=spec/ruleset.xml');
    println('Syntax checker on spec/ passed');
});

// *********************************** PHAR ************************************

desc('Build phar');
task('phar', function () {
    build_phar();
});

fileTask('giroapp.phar', ['giroapp.phar'], function () {
    build_phar();
});

function build_phar()
{
    shell('composer install --prefer-dist --no-dev');
    shell('box compile');
    shell('composer install');
    println('Phar generation done');
}

// ********************************* CONTAINER *********************************

desc('Build dependency injection container');
task('container', ['load_dependencies'], function () {
    build_container();
});

define('CONTAINER_PATH', 'src/DependencyInjection/ProjectServiceContainer.php');

fileTask(CONTAINER_PATH, fileList('*.yaml')->in([__DIR__ . '/etc']), function () {
    build_container();
});

function build_container()
{
    $dic = new ContainerBuilder;
    (new YamlFileLoader($dic, new FileLocator(__DIR__ . '/etc')))->load(basename('container.yaml'));
    $dic->compile();

    $dumper = new PhpDumper($dic);
    $dumper->setProxyDumper(new ProxyDumper);

    file_put_contents(CONTAINER_PATH, $dumper->dump([
        'namespace' => 'byrokrat\giroapp\DependencyInjection',
        'class' => 'ProjectServiceContainer'
    ]));

    println('Generated dependency injection container');
}

// ***************************** DONOR STATE GRAPH *****************************

define('STATE_GRAPH_PATH', 'docs/states.svg');

fileTask(STATE_GRAPH_PATH, fileList('workflow.yaml')->in([__DIR__ . '/etc']), function () {
    build_state_graph();
});

desc('Dump state graph');
task('dump_graph', ['load_dependencies'], function () {
    build_state_graph();
});

function build_state_graph()
{
    $container = new \byrokrat\giroapp\DependencyInjection\ProjectServiceContainer;

    $definition = $container->get(\Symfony\Component\Workflow\Definition::class);

    $dumper = new \Symfony\Component\Workflow\Dumper\GraphvizDumper();

    $process = proc_open(
        'dot -Tsvg -o ' . STATE_GRAPH_PATH,
        [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ],
        $pipes,
        __DIR__,
        []
    );

    fwrite($pipes[0], $dumper->dump($definition));
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);

    $output .= stream_get_contents($pipes[2]);
    fclose($pipes[2]);

    $output .= proc_close($process);

    println("Generated state graph. Graphviz said: $output");
}

// *********************************** MISC ************************************

task('update_on_config_updates', ['load_dependencies', CONTAINER_PATH, STATE_GRAPH_PATH]);

task('load_dependencies', ['vendor/autoload.php'], function () {
    require_once 'vendor/autoload.php';
});

fileTask('vendor/autoload.php', ['vendor/autoload.php'], function () {
    shell('composer install');
});

desc('Globally install development tools');
task('install_dev_tools', function () {
    shell('composer global require consolidation/cgr');
    shell('cgr phpspec/phpspec:^5');
    shell('cgr behat/behat:^3');
    shell('cgr hanneskod/readme-tester:^1.0@beta');
    shell('cgr phpstan/phpstan');
    shell('cgr squizlabs/php_codesniffer');
    shell('cgr humbug/box:^3');
});

function shell(string $command)
{
    return sh($command, null, ['failOnError' => true]);
}
