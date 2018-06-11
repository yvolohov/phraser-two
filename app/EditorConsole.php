<?php

class EditorConsole extends Console
{
  private $querySet = null;

  public function __construct($querySet)
  {
    $this->querySet = $querySet;
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
