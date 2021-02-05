<?php
  function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
    if (!defined('SATURDAY')) define('SATURDAY', 6);
    if (!defined('SUNDAY')) define('SUNDAY', 0);

    // Array of all public festivities
    $publicHolidays = array('01-01', '01-02', '01-06', '02-16', '02-24', '02-25', '03-29', '03-30', '03-31', '04-09', '05-01', '05-14', '06-12', '06-15', '08-06', '08-21', '08-27', '09-09', '11-01', '11-02', '11-30', '12-08', '12-24', '12-25', '12-30', '12-31');
    // The Patron day (if any) is added to public festivities
    if ($patron) {
      $publicHolidays[] = $patron;
    }

    /*
     * Array of all Easter Mondays in the given interval
     */
    $yearStart = date('Y', strtotime($date1));
    $yearEnd   = date('Y', strtotime($date2));

    for ($i = $yearStart; $i <= $yearEnd; $i++) {
      $easter = date('Y-m-d', easter_date($i));
      list($y, $m, $g) = explode("-", $easter);
      $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
      $easterMondays[] = $monday;
    }

    $start = strtotime($date1);
    $end   = strtotime($date2);
    $workdays = 0;
    for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
      $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
      $mmgg = date('m-d', $i);
      if ($day != SUNDAY &&
        !in_array($mmgg, $publicHolidays) &&
        !in_array($i, $easterMondays) &&
        !($day == SATURDAY && $workSat == FALSE)) {
          $workdays++;
      }
    }

    $workdays = ($workdays === 0 ? 1 : $workdays);

    return intval($workdays);
  }
?>
