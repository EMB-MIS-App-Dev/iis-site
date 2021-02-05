
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style2.css"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/simplelightbox.min.css">

<!-- JAVASCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/simple-lightbox.min.js"></script>
<style media="screen">

.container {
    max-width: 100%;
}
.container .gallery a img {
  float: left;
  min-height:250px;
  max-height: 250px;
  width: 20%;
  height: auto;
  border: 2px solid #fff;
  -webkit-transition: -webkit-transform .15s ease !important;
  -moz-transition: -moz-transform .15s ease !important;
  -o-transition: -o-transform .15s ease !important;
  -ms-transition: -ms-transform .15s ease !important;
  transition: transform .15s ease !important;
  position: relative;
}

.container .gallery a:hover img {
  -webkit-transform: scale(1.05);
  -moz-transform: scale(1.05);
  -o-transform: scale(1.05);
  -ms-transform: scale(1.05);
  transform: scale(1.05);
  z-index: 5;
}

.clear {
  clear: both;
  float: none;
  width: 100%;
}
</style>
  <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Content Row -->
      <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">GALLERY - <span>from mobile<a href="https://iis.emb.gov.ph/embis/../iis-images/downloadables/apk/app-debug.apk" style="text-decoration: underline;"> app</a></span></h6>
              <h7>
              <span style="color:red">Note:</span> You can only upload images itaken from the EMB geocam app.
              </h7>
            </div>
            <!-- Card Body -->
              <div class="card-body">
                <div class="container">
                  <div class="gallery">
                    <?php
                    $dir_images = 'https://iis.emb.gov.ph/emb/images/';
                    $i = 1;
                    foreach ($images as $key => $image) {?>
                      <a href="<?= $dir_images.$image['image'];?>">
                        <img src="<?= $dir_images.$image['image'];?>" alt="<?php echo $image['image'];?>">
                      </a>
                    <?php
                      if($i++%5 == 0) {
                        ?>
                        <div class="clear"></div>
                        <?php
                      }
                    }
                    ?>
                  </div>
                </div>

              </div>
          </div>
        </div>
      </div>


      	<script type='text/javascript'>
      		$(document).ready(function() {
      			$('.gallery a').simpleLightbox();
      		});
      	</script>
