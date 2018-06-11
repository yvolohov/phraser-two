<?php

$dbSettings = [
  'host' => '127.0.0.1',
  'db' => '',
  'user' => '',
  'password' => '',
  'charset' => 'utf8'
];

require_once './settings.php';
require_once './app/Console.php';

$option = mb_strtolower(($argc > 1) ? $argv[1] : '');

switch ($option) {
  case '-e':
    break;

  case '-t':
    break;

  default:
    $console = new Console();
    $console->showHelp();
    break;
}
