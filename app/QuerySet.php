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

  public function insertPhrase($phrase, $categoryId)
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO phrases (phrase, category_id)
      VALUES (:phrase, :category_id)"
    );
    $stmt->execute([
      ':phrase' => $phrase,
      ':category_id' => $categoryId
    ]);
  }

  public function __destruct()
  {
    $this->pdo = null;
  }
}
