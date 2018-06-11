<?php

class QuerySet
{
  private $pdo = null;

  public function __construct($host, $db, $user, $password, $charset)
  {
    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

    try {
      $this->pdo = new \PDO($dsn, $user, $password);
    }
    catch (\Exception $e) {
      exit($e->getMessage() . PHP_EOL);
    }
  }

  public function __destruct()
  {
    $this->pdo = null;
  }
}
