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
    $openedPhrase = $this->decoder->assemblePhrase($decodedTemplate, false);
    $variators = $this->getTemplateVariators($decodedTemplate);

    echo $this->bold('Number: ') . $this->green($questionNumber) . PHP_EOL;
    echo $this->bold('Phrase: ') . $this->green($starredPhrase) . PHP_EOL . PHP_EOL;

    $count = count($variators);

    for ($idx = 0; $idx < $count; $idx++) {
      $number = $idx + 1;
      $variator = $variators[$idx];
      $prompt = (count($variator) > 1) ? $this->green($variator[1]) : '';

      echo "#{$number}: {$prompt}" . PHP_EOL;
      $currentSegment = mb_strtolower(trim(readline()));

      if ($currentSegment !== $variator[0]) {
        $idx--;
        echo $this->red('wrong') . PHP_EOL;
        echo PHP_EOL;
        continue;
      }
      echo PHP_EOL;
    }

    $this->writeTest($row);
    echo $this->bold('Result: ') . $this->green($openedPhrase) . PHP_EOL;
    echo PHP_EOL;
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

  private function writeTest($phrase)
  {
    if ($phrase['test_exists'] > 0) {
      $this->querySet->updateTest($phrase['id'], $phrase['passages_cnt']);
    }
    else {
      $this->querySet->insertTest($phrase['id']);
    }
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('TEST MODE OFF') . PHP_EOL;
  }
}
