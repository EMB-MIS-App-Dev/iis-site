

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/common/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->

  <script src="<?php echo base_url(); ?>assets/common/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/sb-admin-2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/socketio.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/systems.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/company.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/clients.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/edit_company.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/support.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Custom scripts for Universe-->
  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/FixedColumns/js/dataTables.fixedColumns.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/FixedColumns/js/fixedColumns.bootstrap4.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/Select-1.2.6/js/dataTables.select.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/CheckTable/js/dataTables.checkboxes.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/Buttons-1.5.4/js/buttons.bootstrap4.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/JSZip-2.5.0/jszip.min.js"></script>
  <!-- <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/pdfmake-0.1.36/pdfmake.min.js"></script> -->
  <!-- <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/pdfmake-0.1.36/vfs_fonts.js"></script> -->

  <script src="<?php echo base_url(); ?>assets/common/datatables/plugins/Buttons-1.5.4/js/buttons.html5.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/Dms.js"></script>
  <script type="text/javascript"> Dms.base_url = '<?php echo base_url('Dms/');?>'; </script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/vendor/slick/slick.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/chart.js/Chart.js-2.9.4/Chart.bundle.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/common/selectize/dist/js/selectizev2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/dropzone/dropzone.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/common/sweetalert2/js/sweetalert2.all.min.js"></script>


  <script src="<?php echo base_url(); ?>assets/common/js/underscore-min.js"></script>
  <!-- <script src="<?php echo base_url(); ?>assets/common/js/moment.min.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/common/jquery-validation-1.19.2/jquery.validate.min.js"></script>

  <script src="<?=base_url('assets/common/webshim-1.16.0/js-webshim/dev/polyfiller.js')?>"></script>
   <!-- <script type="text/javascript" src="https://www.datejs.com/build/date.js"></script> -->

  <?php
   if($_SESSION['acc_options']['sys_theme'] == 'christmas') {
     echo '<script src="'.base_url('assets/js/xmas.js').'"></script>';
   }
  ?>

    <script>
        webshim.activeLang('en');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>

  <!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script> -->


  <!-- <script>
    // Set the date we're counting down to
    var countDownDate = new Date("Nov 6, 2020 22:00:00").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"
      // days + "d " +
      document.getElementById("timer_cntdwn").innerHTML = hours + "h "
      + minutes + "m " + seconds + "s ";

      // If the count down is over, write some text
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer_cntdwn").innerHTML = "-time under evaluation-";
      }
    }, 1000);
  </script> -->

</body>

</html>
