<?php

$dbSettings = [
  'host' => '127.0.0.1',
  'db' => '',
  'user' => '',
  'password' => '',
  'charset' => 'utf8'
];

require_once './settings.php';
require_once './app/QuerySet.php';
require_once './app/Console.php';
require_once './app/EditorConsole.php';
require_once './app/TestConsole.php';

$querySet = new QuerySet(
  $dbSettings['host'],
  $dbSettings['db'],
  $dbSettings['user'],
  $dbSettings['password'],
  $dbSettings['charset']
);

$option = mb_strtolower(($argc > 1) ? $argv[1] : '');

switch ($option) {
  case '-e':
    $console = new EditorConsole($querySet);
    $console->run();
    break;

  case '-t':
    $console = new TestConsole($querySet);
    $console->run();
    break;

  default:
    $console = new Console();
    $console->showHelp();
    break;
}
