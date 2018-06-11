<?php

class EditorConsole extends Console
{
  private $querySet = null;
  private $decoder = null;

  public function __construct($querySet)
  {
    $this->querySet = $querySet;
    $this->decoder = new Decoder();
  }

  public function run()
  {
    $this->start();

    do {
      $this->askPhrase();
      $next = $this->enterNextPhrase();
    }
    while ($next);

    $this->end();
  }

  private function start()
  {
    echo $this->bold('EDITOR MODE ON') . PHP_EOL;
    echo $this->bold('--------------') . PHP_EOL;
  }

  private function askPhrase()
  {
    echo $this->bold("Enter a phrase:");
    $phrase = trim(readline(' '));
    echo PHP_EOL;

    if (mb_strlen($phrase) <= 10) {
      echo $this->red('Phrase is too short') . PHP_EOL;
      return;
    }

    $isPhraseCorrect = $this->decoder->isTemplateCorrect($phrase);

    if (!$isPhraseCorrect) {
      echo $this->red('Incorrect phrase') . PHP_EOL;
      return;
    }

    $this->querySet->insertPhrase($phrase, 0);
  }

  private function enterNextPhrase()
  {
    echo $this->bold('Enter a next phrase? (y|n):');
    $answer = trim(readline(' '));
    echo PHP_EOL;

    $boolAnswer = ($answer === 'y');
    return $boolAnswer;
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('EDITOR MODE OFF') . PHP_EOL;
  }
}
