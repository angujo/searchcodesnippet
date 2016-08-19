
<?php

function date_convert($dt, $tz1, $df1, $tz2, $df2) {
  $res = '';
  if(!in_array($tz1, timezone_identifiers_list())) { // check source timezone
    trigger_error(__FUNCTION__ . ': Invalid source timezone ' . $tz1, E_USER_ERROR);
  } elseif(!in_array($tz2, timezone_identifiers_list())) { // check destination timezone
    trigger_error(__FUNCTION__ . ': Invalid destination timezone ' . $tz2, E_USER_ERROR);
  } else {
    // create DateTime object
    $d = DateTime::createFromFormat($df1, $dt, new DateTimeZone($tz1));
    // check source datetime
    if($d && DateTime::getLastErrors()["warning_count"] == 0 && DateTime::getLastErrors()["error_count"] == 0) {
      // convert timezone
      $d->setTimeZone(new DateTimeZone($tz2));
      // convert dateformat
      $res = $d->format($df2);
    } else {
      trigger_error(__FUNCTION__ . ': Invalid source datetime ' . $dt . ', ' . $df1, E_USER_ERROR);
    }
  }
  return $res;
}

echo date_convert(date('Y-m-d H:i:s'), 'Europe/Athens', 'Y-m-d H:i:s', 'Europe/Athens', 'Y-m-d H:i:s'),'<p/>';
