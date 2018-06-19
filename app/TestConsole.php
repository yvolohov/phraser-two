<?php

class TestConsole extends Console
{
  private $querySet = null;

  public function __construct($querySet)
  {
    $this->querySet = $querySet;
    $this->decoder = new Decoder();
  }

  public function run($phrasesMaxCount)
  {
    $this->start();
    $phrases = $this->querySet->selectPhrases($phrasesMaxCount);
    $phrasesCount = count($phrases);

    for ($index = 0; $index < $phrasesCount; $index++) {
      $row = $phrases[$index];
      $success = $this->showQuestion($row, $index + 1, 1);

      if (!$success) {
        $this->showQuestion($row, $index + 1, 2);
      }
    }

    $this->end();
  }

  private function start()
  {
    echo $this->bold('TEST MODE ON') . PHP_EOL;
    echo $this->bold('--------------') . PHP_EOL;
  }

  private function showQuestion($row, $questionNumber, $tryNumber)
  {
    $decodedTemplate = $this->decoder->decodeTemplate($row['phrase']);
    $starredPhrase = $this->decoder->assemblePhrase($decodedTemplate, true);

    print($starredPhrase . PHP_EOL);
    return true;
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('TEST MODE OFF') . PHP_EOL;
  }
}
