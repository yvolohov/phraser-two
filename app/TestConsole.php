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
      $this->showQuestion($row, $index + 1);
    }

    $this->end();
  }

  private function start()
  {
    echo $this->bold('TEST MODE ON') . PHP_EOL;
    echo $this->bold('--------------') . PHP_EOL;
  }

  private function showQuestion($row, $questionNumber)
  {
    $decodedTemplate = $this->decoder->decodeTemplate($row['phrase']);
    $starredPhrase = $this->decoder->assemblePhrase($decodedTemplate, true);
    $variators = $this->getTemplateVariators($decodedTemplate);

    echo $this->bold('Number: ') . $questionNumber . PHP_EOL;
    echo $this->bold('Phrase: ') . $starredPhrase . PHP_EOL;

  }

  private function getTemplateVariators($decodedTemplate)
  {
    $variators = [];
    $count = count($decodedTemplate);

    for ($idx = 0; $idx < $count; $idx++) {
      $segment = $decodedTemplate[$idx];
      $type = gettype($segment);

      if ($type === 'array') {
        $segment[0] = mb_strtolower(trim($segment[0]));
        array_push($variators, $segment);
      }
    }
    return $variators;
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('TEST MODE OFF') . PHP_EOL;
  }
}
