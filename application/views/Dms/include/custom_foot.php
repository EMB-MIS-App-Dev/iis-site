
<?php
  $swal = $this->session->flashdata('swal_alert_data');
  if(!empty($swal)) {
    $btn_text = $swal['type'] == 'error' ? "Okay." : $swal['type'] == 'warning' ? "Noted." : "Great!";
?>
    <script>
      swal({
        title: "<?= $swal['title'] ?>",
        html: "<?= $swal['text'] ?>",
        type: "<?= $swal['type'] ?>",
        allowOutsideClick: false,
        customClass: 'swal-wide',
        confirmButtonClass: 'btn-success',
        confirmButtonText: '<?= $btn_text ?>',
        onOpen: () => swal.getConfirmButton().focus()
      })
    </script>
<?php } ?>

<script src="<?=base_url('assets/common/select2/js/select2.full.js')?>"></script>

<?php
  if( $this->session->userdata('token') != '3555e268703be3af')
  {
?>

<script src="<?=base_url('assets/common/jquery-validation-1.19.2/additional-methods.min.js')?>"></script>

<script>
  $(document).ready(function(){

      $('#dms_route_form input').keydown(function (e) {
           if (e.keyCode == 13) {
               e.preventDefault();
               return false;
           }
       });

       $.validator.addMethod("attachment_exists", function(value, element) {
        $.ajax({
             url: "<?=base_url('Dms/Dms/ajax_attachment_exists')?>",
            async: false,
            dataType:"html",
         success: function(msg)
         {
            // if the user exists, it returns a string "true"
            if(msg == "true")
               return false;  // already exists
            return true;      // username is free to use
         }
       })}, '<span class="error" style="color:red">( required )</span>');

      $('#dms_route_form').validate({  // initialize the plugin on your form
          ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
          errorClass:'errorTxt',
          rules: {
            system  : 'required',
            type    : 'required',
            subject : 'required',
            status  : 'required',
            company : 'required',
            action  : 'required',
          },
          errorPlacement: function(error, element) {
             error.insertBefore(element);
         }
          // highlight: function(element, errorClass, validClass) {
          //   $(this).parents("div.form-group").addClass(errorClass).removeClass(validClass);
          // },
          // unhighlight: function(element, errorClass, validClass) {
          //   $(element).parents(".error").removeClass(errorClass).addClass(validClass);
          // }
      });
      $.validator.messages.required = '<span class="error" style="color:red">( required )</span>';
      // $.validator.messages.remote = '<span class="error" style="color:red">( required )</span>';

      $('#dms_route_form button[name="save_draft"]').click(function () {
          $('#dms_route_form input, select, textbox').each(function () {
              $(this).rules('remove');
          });
          // $("#dms_route_form").valid();  // validation test only
          $("#dms_route_form").submit();  // validate and submit
      });

      $('#dms_route_form button[name="process_transaction"]').click(function () {
          var xstat = $('#dms_route_form select[name="status"]').val();
          $('#dms_route_form [name="division"], [name="section"], [name="receiver"]').each(function () {
              $(this).rules('add', {
                  required: function () {
                    if(_.contains(['17', '18', '19', '24', '27'], xstat)) {
                      return false;
                    }
                    else {
                      return !$("input[name='asgnto_multiple']").checked;
                    }
                  }
              });
          });

          $('#dms_route_form select[name="courier_type"]').each(function () {
              $(this).rules('add', {
                  required: function () {
                    return xstat == 19;
                  }
              });
          });

          $('#dms_route_form input[name="prev_uploads"]').each(function () {
              $(this).rules('add', {
                // required: true,
                  remote: {
                    // if(xstat == 24)
                    // {
                      url: "<?=base_url('Dms/Dms/ajax_attachment_exists')?>",
                      type: "POST",
                    // }
                  }
              });
          });

          $("#dms_route_form").submit();  // validate and submit
      });
  });
</script>

<?php
  }
?>
