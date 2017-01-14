<?php
/**
 * Just simple bootstrap app file.
 */
require_once __DIR__.'/../vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->addDefinitions(__DIR__.'/../configs/main.php');
$container = $builder->build();

$app = new Silly\Application();
$app->useContainer($container);
$app->command('run', [App\Commands\RunCommand::class, 'execute']);
$app->setDefaultCommand('run');

return $app;
