<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2><?= $company_photo[0]['company_name'] ?></h2>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php foreach ($company_photo as $key => $value): ?>

        <li data-target="#myCarousel" data-slide-to="<?= $key ?>" class="<?php if ($key == 0): ?>
          <?php echo "active"; ?>
        <?php endif; ?>"></li>
      <?php endforeach; ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <!-- <div class="item active">
        <img src="la.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="chicago.jpg" alt="Chicago" style="width:100%;">
      </div>

      <div class="item">
        <img src="ny.jpg" alt="New york" style="width:100%;">
      </div> -->
      <?php if (count($company_photo) == 0) : ?>
        <div class="item active">
          <img src="<?php  echo base_url(); ?>uploads/no_image.png" alt="NO IMAGE" style="width:100%;">
        </div>
      <?php else: ?>
        <?php foreach ($company_photo as $key => $value): ?>
              <div class="item <?php if ($key == 0): ?>
                <?php echo "active"; ?>
              <?php endif; ?>">
                <?php
                    $datetime = new DateTime($company_photo[0]['date_uploaded']);
                    $yearOnly  = $datetime->format('Y');
                ?>
                <?php echo $yearOnlyexit; ?>
                <img src="<?php echo base_url(); ?>uploads/company/<?=$yearOnly.'/'.$value['region'].'/'.$value['attachment_token'].'/'.$value['photo_name']; ?>" alt="New york" style="width:100%;">
              </div>
        <?php endforeach; ?>
      <?php endif; ?>


    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>
