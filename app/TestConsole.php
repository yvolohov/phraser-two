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

    print_r($phrases);
    
    $this->end();
  }

  private function start()
  {
    echo $this->bold('TEST MODE ON') . PHP_EOL;
    echo $this->bold('--------------') . PHP_EOL;
  }

  private function end()
  {
    echo $this->bold('---------------') . PHP_EOL;
    echo $this->bold('TEST MODE OFF') . PHP_EOL;
  }
}
