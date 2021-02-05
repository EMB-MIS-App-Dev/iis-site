
<link href="<?=base_url('assets/common/select2/css/select2.min.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/common/owlcarousel2-2.3.4/assets/owl.carousel.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/common/owlcarousel2-2.3.4/assets/owl.theme.default.min.css')?>"/>

<style>
  .modal-backdrop
  {
      opacity:0.2 !important;
  }
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
