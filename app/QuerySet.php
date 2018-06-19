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
      ORDER BY last_passage
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

  public function insertTest($phraseId)
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO tests (phrase_id, passages_cnt, first_passage, last_passage)
      VALUES (:phrase_id, 1, NOW(), NOW())"
    );

    $stmt->execute([
      ':phrase_id' => $phraseId
    ]);
  }

  public function updateTest($phraseId, $passagesCnt)
  {
    $stmt = $this->pdo->prepare(
      "UPDATE tests SET passages_cnt = :passages_cnt, last_passage = NOW()
      WHERE phrase_id = :phrase_id"
    );

    $stmt->execute([
      ':phrase_id' => $phraseId,
      ':passages_cnt' => $passagesCnt + 1
    ]);
  }

  public function __destruct()
  {
    $this->pdo = null;
  }
}
