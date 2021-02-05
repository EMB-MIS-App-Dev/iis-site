<?php
  $bth_alert = $this->session->flashdata('bthead_alert_data');
  if(!empty($bth_alert)) {
    $alert_class = 'alert-'.$bth_alert['type'];
?>
    <div class="alert <?=$alert_class?> alert-dismissible fade show" role="alert">
      <strong><?=$bth_alert['title']?>: </strong> <?=$bth_alert['text']?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
<?php } ?>
