
<?php
  $swal = $this->session->flashdata('swal_alert_data');

  if(!empty($swal)) {
?>
    <script>
      swal({
        title: "<?= $swal['title'] ?>",
        text: "<?= $swal['text'] ?>",
        type: "<?= $swal['type'] ?>",
        allowOutsideClick: false,
        customClass: 'swal-wide',
        confirmButtonClass: 'btn-success',
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
        onOpen: () => swal.getConfirmButton().focus()
      })
    </script>
<?php } ?>

<script>
  $(document).ready(function(){
  });
</script>
