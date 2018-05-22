<?php

class Decoder
{
  public function decodeTemplate($template)
  {

  }

  public function isTemplateCorrect($template)
  {
    $isTemplateCorrect = true;
    $length = mb_strlen($template);
    $insideBraces = false;

    for ($idx = 0; $idx < $length; $idx++) {
      $symbol = mb_substr($template, $idx, 1);

      if ($symbol === '[' && $insideBraces) {
        $isTemplateCorrect = false;
        break;
      }
      else if ($symbol === '[') {
        $insideBraces = true;
      }
      else if (($symbol === ']' || $symbol === '|') && (!$insideBraces)) {
        $isTemplateCorrect = false;
        break;
      }
      else if ($symbol === ']') {
        $insideBraces = false;
      }
    }

    if ($insideBraces) {
      $isTemplateCorrect = false;
    }
    return $isTemplateCorrect;
  }
}
