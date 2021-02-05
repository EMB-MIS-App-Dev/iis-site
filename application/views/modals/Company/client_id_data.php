
<!-- <div class="slick-container-img">
<style media="screen">
  .slick-slider{
    position: unset!important;
  }
</style>

<script type="text/javascript">
$(document).ready(function(){
$('.single-item').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  adaptiveHeight: true,
  breakpoint: 1024,
});
});
</script>
<div class="single-item" >
  <?php //foreach ($clientdata as $key => $value): ?>
    <div><img src='../../../smr/uploads/users/user_attch_id/<?=$value['facility_id']?>/<?=$value['name']?>' alt=''></div>
  <?php //endforeach; ?>
</div>
</div> -->

<!-- <form class="" action="<?php //echo base_url(); ?>/" method="post">

</form> -->
  <div id="assign_company">
    <input type="hidden" name="userid" value="<?=$userid?>">
    <br>
    <label for="">COMPANY LIST</label>
    <div id="comp_per_reg">
      <select class="form-control" name="company" id="asscompid">
        <option value="">--</option>
          <?php foreach ($companies as $key => $compval): ?>
            <option value="<?= $compval['company_id']?>"><?= $compval['company_name']?></option>
          <?php endforeach; ?>
      </select>
    </div>
  </div>
  <script type="text/javascript">
  $('#asscompid').selectize();
</script>
