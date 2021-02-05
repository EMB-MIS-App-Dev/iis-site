<?php
  // echo $yearly_transactions[0]['counter'];
  // echo "<br />";
  // echo $daily_transactions[0]['counter'];
  // echo "<br />";
  // echo $newly_created[0]['counter'];
  echo 'adasdd';

?>


<select>
   <?php
      $date_option = 2020;
      while($date_option <= date('Y')) {
         echo '<option value="'.$date_option.'">'.$date_option.'</option>';
         $date_option += 1;
      }
      // $date_option = 2020;
      // do{
      //    echo '<option value="'.$date_option.'">'.$date_option.'</option>';
      //    $date_option += $date_option+1;
      //    echo $date_option;
      // } while((int)$date_option <= (int)date('Y'));


   ?>
</select>
