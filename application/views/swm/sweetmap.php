   <title>EMB - IIS (Integrated Information System)</title>
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
      #note{
       position: fixed;
       top: 22px;
       background-color: #103255;
       color:#FFF;
       left: 41%;
       padding: 5px;
       font-size: 12px;
       border-radius: 3px;
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



        <?php for ($i=0; $i < sizeof($data); $i++) {
          $uncleanphoto = "https://iis.emb.gov.ph/iis-images/sweet_report/".date("Y", strtotime($data[$i]['date_created']))."/".$data[$i]['region']."/".$data[$i]['trans_no']."/".$data[$i]['attachment_name'];
          $color = ($data[$i]['report_type'] == 'Unclean') ? "179, 0, 0" : "0, 153, 0";
         ?>
           var simpleMarkerSymbol = {
             type: "simple-marker",
             color: [<?php echo $color; ?>],
             outline: {
               color: [255, 255, 255],
               width: 1
             }
           };

           var point<?php echo $data[$i]['cnt']; ?> = {
              type: "point",
              <?php $longitude = preg_replace('/[^0-9,.]+/', '', $data[$i]['longitude']); $latitude = preg_replace('/[^0-9,.]+/', '', $data[$i]['latitude']); ?>
              longitude: <?php echo str_replace(' ', '', $longitude); ?>,
              latitude: <?php echo str_replace(' ', '', $latitude); ?>
            };

            //*** ADD ***//
            // Create attributes
            var attributes = {
              Name: "<?php echo $data[$i]['lgu_patrolled_name'].' - '.$data[$i]['lgu_patrolled_id']; ?>", // The name of the
            };
            // Create popup template
            var popupTemplate = {
              title: "{Name}",
              content: "Barangay: <b><?php echo $data[$i]['barangay_name']; ?></b><br>Street: <b><?php echo $data[$i]['street']; ?></b><br>Type of Area: <b><?php echo str_replace(';','; ',$data[$i]['type_of_area_desc']); ?></b><br><br>Monitored by: <b><?php echo $data[$i]['creator_name']; ?></b><br><hr><img style='border:1px solid #000; width:100%; height: 260px;' src='<?php echo $uncleanphoto; ?>'>"
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
    <div id="viewmapdiv"></div>
    <div id="note"> <label>PLEASE CLICK RED/GREEN CIRCLE TO VIEW DETAILS</label> </div>
