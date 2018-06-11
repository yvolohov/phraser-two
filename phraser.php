<?php

require_once './app/Decoder.php';

$decoder = new Decoder();
$result = $decoder->decodeTemplate('a[b]c[d|d]ee[fff|fff|fff]gggg');

print_r($result);
