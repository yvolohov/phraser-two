<?php

class Decoder
{
  public function decodeTemplate($template)
  {
    $isCorrect = $this->isTemplateCorrect($template);

    if (!$isCorrect) {
      return false;
    }

    $sequence = [];
    $segment = '';
    $length = mb_strlen($template);

    for ($idx = 0; $idx < $length; $idx++) {
      $symbol = mb_substr($template, $idx, 1);

      // начало вариатора
      if ($symbol === '[') {
        if (mb_strlen($segment) > 0) {
          array_push($sequence, $segment);
          $segment = '';
        }
        array_push($sequence, []);
      }

      // конец сегмента вариатора или конец вариатора
      else if ($symbol === '|' || $symbol === ']') {
        $sequenceIdx = count($sequence) - 1;
        array_push($sequence[$sequenceIdx], $segment);
        $segment = '';
      }

      // очередной символ
      else {
        $segment .= $symbol;
      }
    }

    // конец шаблона
    if (mb_strlen($segment) > 0) {
      array_push($sequence, $segment);
      $segment = '';
    }
    return $sequence;
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

  public function starTemplate($decodedTemplate)
  {
    $starredTemplate = '';
    $count = count($decodedTemplate);

    for ($idx = 0; $idx < $count; $idx++) {
      $segment = $decodedTemplate[$idx];
      $type = gettype($segment);

      if ($type === 'string') {
        $starredTemplate .= $segment;
      }
      else if ($type === 'array') {
        $starredTemplate .= $this->starTemplateSegment($segment[0]);
      }
    }
    return $starredTemplate;
  }

  private function starTemplateSegment($segment)
  {
    $starredSegment = '';
    $length = mb_strlen($segment);

    for ($idx = 0; $idx < $length; $idx++) {
      $symbol = mb_substr($segment, $idx, 1);
      $isSpace = ($symbol === "\x9" || $symbol === "\x20");
      $starredSegment .= ($isSpace) ? $symbol : '*';
    }
    return $starredSegment;
  }
}
