<title>EMB - IIS (Integrated Information System)</title>
<link href="<?php echo base_url(); ?>assets/common/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">
<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo-denr.png">
<link rel="stylesheet" href="https://js.arcgis.com/4.16/esri/themes/light/main.css">

<script src="<?php echo base_url(); ?>assets/js/map.min.js"></script>

 <style>
   #viewmapdiv {
     padding: 0;
     margin: 0;
     height: 100%;
     width: 100%;
   }
   .regionlegendcolor{
      position: absolute;
      background-color: #0D131F;
      z-index: 100;
      padding: 5px;
      display: grid;
      top: 10%;
      left: 23px;
      padding: 5px 5px 0px 6px;
      border-radius: 3px;
   }
   .legendcircle{
      padding: 0px 9px 0px 8px;
      border-radius: 15px;
      border: 2px solid #FFF;
      margin-right: 5px;
   }
   .legendlabel{
     color:#FFF;
     padding-bottom: 6px;
   }
   .filterregion{
     position: absolute;
      z-index: 100;
      background-color: #0D131F;
      padding: 5px 5px 5px 5px;
      left: 60px;
      top: 23px;
   }
 </style>

  <script type="text/javascript">
    require([
    "esri/Map",
    "esri/views/MapView",
    "esri/Graphic",
    "esri/layers/GraphicsLayer"
    ], function(Map, MapView, Graphic, GraphicsLayer) {
      var map = new Map({
         //*** UPDATE ***//
         basemap: "hybrid"
       });

       var view = new MapView({
         container: "viewmapdiv",
         map: map,
         //*** UPDATE ***//
         center: [<?php echo preg_replace('/[^0-9,.]+/', '', $data[0]['longitude']); ?>, <?php echo preg_replace('/[^0-9,.]+/', '', $data[0]['latitude']); ?>],
         zoom: 10
       });

       var graphicsLayer = new GraphicsLayer();
       map.add(graphicsLayer);


       <?php
         for ($i=0; $i < sizeof($data); $i++) {
           if($data[$i]['region_name'] == 'R1'){
             $color = '168, 50, 50';
           }else if($data[$i]['region_name'] == 'R2'){
             $color = '168, 105, 50';
           }else if($data[$i]['region_name'] == 'R3'){
             $color = '168, 142, 50';
           }else if($data[$i]['region_name'] == 'R4A'){
             $color = '146, 168, 50';
           }else if($data[$i]['region_name'] == 'R4B'){
            $color = '76, 168, 50';
           }else if($data[$i]['region_name'] == 'R5'){
            $color = '50, 168, 93';
           }else if($data[$i]['region_name'] == 'R6'){
            $color = '50, 168, 154';
           }else if($data[$i]['region_name'] == 'R7'){
            $color = '50, 133, 168';
           }else if($data[$i]['region_name'] == 'R8'){
            $color = '50, 68, 168';
           }else if($data[$i]['region_name'] == 'R9'){
            $color = '107, 50, 168';
           }else if($data[$i]['region_name'] == 'R10'){
            $color = '168, 50, 166';
           }else if($data[$i]['region_name'] == 'R11'){
            $color = '168, 50, 101';
           }else if($data[$i]['region_name'] == 'R12'){
            $color = '168, 50, 60';
           }else if($data[$i]['region_name'] == 'R13'){
            $color = '87, 26, 51';
           }else if($data[$i]['region_name'] == 'NCR'){
            $color = '26, 53, 87';
           }else if($data[$i]['region_name'] == 'CAR'){
            $color = '26, 87, 82';
           }else{
             $color = '168, 50, 50';
           }

       ?>
         var simpleMarkerSymbol = {
           size: "12px",
           type: "simple-marker",
           color: [<?php echo $color; ?>],
           outline: {
             color: [255,255,255],
             width: 1.5
           }
         };

         var point<?php echo $data[$i]['cnt']; ?> = {
            type: "point",
            <?php
              $longitude = preg_replace('/[^0-9,.]+/', '', $data[$i]['longitude']);
              $latitude = preg_replace('/[^0-9,.]+/', '', $data[$i]['latitude']);
            ?>
            longitude: <?php echo str_replace(' ', '', $longitude); ?>,
            latitude: <?php echo str_replace(' ', '', $latitude); ?>
          };

          //*** ADD ***//
          // Create attributes
          var attributes = {
            Name: "<?php echo preg_replace('/[^ \w-]/', '', $data[$i]['company_name']);?>",
          };
          // Create popup template
          var popupTemplate = {
            title: "{Name}",
            content: "EMB ID: <b><?php echo $data[$i]['emb_id']; ?></b><br>"+
                     "Establishment Name: <b><?php $est_name = preg_replace('/[^ \w-]/', '', $data[$i]['establishment_name']);if(!empty($est_name)) { echo $est_name; } else { echo '--'; }?></b><br>"+
                     "House No. and Street: <b><?php if(!empty($data[$i]['street']) || !empty($data[$i]['house_no'])) {echo trim($data[$i]['house_no'].' '.$data[$i]['street']);} else{echo '--';} ?></b><br>"+
                     "Barangay: <b><?php echo $data[$i]['barangay_name']; ?></b><br>"+
                     "City: <b><?php echo $data[$i]['city_name']; ?></b><br>"+
                     "Province: <b><?php echo $data[$i]['province_name']; ?></b><br>"+
                     "Project Type: <b><?php echo preg_replace('/[^ \w-]/', '', $data[$i]['project_name']); ?></b><br>"
          };

          var pointGraphic<?php echo $data[$i]['cnt']; ?> = new Graphic({
            geometry: point<?php echo $data[$i]['cnt']; ?>,
            symbol: simpleMarkerSymbol,
            //*** ADD ***//
            attributes: attributes,
            popupTemplate: popupTemplate
          });

          graphicsLayer.add(pointGraphic<?php echo $data[$i]['cnt']; ?>);
      <?php } ?>

    });
  </script>
  <?php if($_SESSION['superadmin_rights'] == 'yes'){ ?>
    <div class="regionlegendcolor">
      <label class="legendlabel"><span class="legendcircle" style="background-color:#a83232;"></span>R1</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#A86932;"></span>R2</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#A88E32;"></span>R3</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#91A732;"></span>R4A</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#4CA832;"></span>R4B</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#32A85D;"></span>R5</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#32A89A;"></span>R6</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#3285A8;"></span>R7</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#3244A8;"></span>R8</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#6B32A8;"></span>R9</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#A832A6;"></span>R10</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#A83265;"></span>R11</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#A8323C;"></span>R12</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#571A33;"></span>R13</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#322D22;"></span>CAR</label>
      <label class="legendlabel"><span class="legendcircle" style="background-color:#1A3557;"></span>NCR</label>
    </div>
    <div class="filterregion">
      <label class="legendlabel">filter by region</label>
      <select class="form-control" id="regionmapselectize" onchange="filtercompanyregion(this.value);">
        <option value="<?php echo !empty($_GET['rtoken']) ? $_GET['rtoken'] : ''; ?>"><?php echo !empty($_GET['rtoken']) ? $this->encrypt->decode($_GET['rtoken']) : ''; ?></option>
        <?php for ($i=0; $i < sizeof($region); $i++) { ?>
          <option value="<?php echo $this->encrypt->encode($region[$i]['rgnnum']); ?>"><?php echo $region[$i]['rgnnum']; ?></option>
        <?php } ?>
        <option value="<?php echo $this->encrypt->encode('ALL'); ?>">ALL</option>
      </select>
    </div>
  <?php } ?>
 <div id="viewmapdiv"></div>

 <script type="text/javascript">
   var base_url = window.location.origin+"/embis";
   function filtercompanyregion(token){
     window.location.href = base_url+"/Company/Map?rtoken="+token;
   }
 </script>
