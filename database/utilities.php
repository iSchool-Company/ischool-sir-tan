<?php

class Utilities
{

  static function trWeek($dateTime)
  {

    $output = '';

    $dateDiff = (strtotime($dateTime)) - strtotime(date('Y-m-d H:i:s'));
    $weeks = 0;
    $days = 0;
    $hours = 0;
    $minutes = 0;
    $seconds = 0;

    $output = '(';

    if ($dateDiff >= (86400 * 7)) {
      $weeks = intval($dateDiff / (86400 * 7));
      $dateDiff -= $weeks * (86400 * 7);
    } else {
      $weeks = 0;
    }

    $output .=  $weeks . 'w ';

    if ($dateDiff >= 86400) {
      $days = intval($dateDiff / 86400);
      $dateDiff -= $days * 86400;
    } else {
      $days = 0;
    }

    $output .=  $days . 'd ';

    if ($dateDiff >= 3600) {
      $hours = intval($dateDiff / 3600);
      $dateDiff -= $hours * 3600;
    } else {
      $hours = 0;
    }

    $output .=  $hours . 'h ';

    if ($dateDiff >= 60) {
      $minutes = intval($dateDiff / 60);
      $dateDiff -= $minutes * 60;
    } else {
      $minutes = 0;
    }

    $output .= $minutes . 'm ';

    if ($dateDiff >= 0) {
      $seconds = $dateDiff;
      $output .= $seconds . 's';
      $output .= ')';
    }

    return $output;
  }

  static function dateDiff($dateTime)
  {
    return (strtotime($dateTime)) - strtotime(date('Y-m-d H:i:s'));
  }

  static function dateDiff2($dateTime)
  {
    return strtotime(date('Y-m-d H:i:s')) - (strtotime($dateTime));
  }
}
