<?php

require_once './app/Decoder.php';

$decoder = new Decoder();
$result = $decoder->isTemplateCorrect('abcde[f][]');

echo ($result) ? "correct\n" : "wrong\n";
