<?php

class TestConsole extends Console
{
  private $querySet = null;

  public function __construct($querySet)
  {
    $this->querySet = $querySet;
  }

  public function run($phrasesMaxCount)
  {
    $this->start();
    $phrases = $this->querySet->selectPhrases($phrasesMaxCount);
    $phrasesCount = count($phrases);

    for ($index = 0; $index < $phrasesCount; $index++) {
      $phrase = $phrases[$index];
      $success = $this->showQuestion($phrase, $index + 1, 1);

      if (!$success) {
        $this->showQuestion($phrase, $index + 1, 2);
      }
    }

    $this->end();
  }

  private function start()
  {
    echo $this->bold('TEST MODE ON') . PHP_EOL;
    echo $this->bold('--------------') . PHP_EOL;
  }

  private function showQuestion($phrase, $questionNumber, $tryNumber)
  {
    // print_r($phrase);
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('TEST MODE OFF') . PHP_EOL;
  }
}
