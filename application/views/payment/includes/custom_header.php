
<style>
  .btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
  .btn-labeled {padding-top: 0;padding-bottom: 0;}
  .btn { margin-bottom:10px; }
</style>

<?php
  $bth_alert = $this->session->flashdata('bthead_alert_data');
  if(!empty($bth_alert)) {
    $alert_class = 'alert-';
    $alert_class .= $bth_alert['type']=='error'?'danger':$bth_alert['type'];

?>
    <div class="alert <?=$alert_class?> alert-dismissible fade show" role="alert">
      <strong><?=$bth_alert['title']?>: </strong> <?=$bth_alert['text']?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
<?php } ?>
