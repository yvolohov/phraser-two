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

  public function selectPhrases($count)
  {
    $stmt = $this->pdo->prepare(
      "SELECT
      phrases.id,
      phrases.phrase,
      phrases.category_id,
      IFNULL(tests.passages_cnt, 0) AS passages_cnt,
      IFNULL(tests.first_passage, '0000-00-00 00:00:00') AS first_passage,
      IFNULL(tests.last_passage, '0000-00-00 00:00:00') AS last_passage,
      IF(tests.phrase_id IS NULL, 0, 1) AS test_exists
      FROM phrases
      LEFT JOIN tests
      ON (phrases.id = tests.phrase_id)
      LIMIT :phrases_count"
    );

    $stmt->bindValue(':phrases_count', $count, \PDO::PARAM_INT);
    $stmt->execute();
    $phrases = $stmt->fetchAll();
    return $phrases;
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
