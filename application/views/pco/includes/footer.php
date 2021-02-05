
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
        confirmButtonText: 'Okay!',
        onOpen: () => swal.getConfirmButton().focus()
      })
    </script>
<?php } ?>

<script src="<?=base_url('assets/js/Pco.js')?>"></script>
<script src="<?=base_url('assets/common/jquery-validation-1.19.2/jquery.validate.min.js')?>"></script>
<script type="text/javascript">
  Pco.base_url='<?=base_url('Pco/');?>';
  Pco.page='<?=$step;?>';
  Pco.step='<?=$application[0]['step'];?>';
</script>
<script>(Pco.stepHeaderIdentifier());</script>

<script>
  $(document).ready(function() {
    $('form input').keydown(function (e) {
         if (e.keyCode == 13) {
             e.preventDefault();
             return false;
         }
     });

   $.validator.messages.required = '<span class="error" style="color:red">( required )</span>';
   $('#user_info_form').validate({
      ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
      errorClass:'errorTxt',
      rules: {
          last_name: "required",
          first_name: "required",
          sex: "required",
          citizenship: "required",
          position: "required",
          years_in_position: "required",
          cel_no: "required",
          email: "required",
          region_id: "required",
          prov_id: "required",
          city_id: "required",
          brgy_id: "required",
          zip_code: "required",
      },
      errorPlacement: function(error, element) {
        error.insertBefore(element);
      },
      submitHandler: function(form) {
          // optional callback function
          // only fires on a valid form submission
          // do something only if/when form is valid
          // like process the dropzone queue HERE instead
          // then use .ajax() OR .submit()
          form.submit()
      }
    });

    $('#establishment_details_form').validate({
     ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
     errorClass:'errorTxt',
     rules: {
         last_name: "required",
         first_name: "required",
         establishment_name: "required",
         nature_of_business: "required",
         establishment_category: "required",
         tel_no: "required",
         fax_no: "required",
         region_id: "required",
         prov_id: "required",
         city_id: "required",
         brgy_id: "required",
         zip_code: "required",
     },
     errorPlacement: function(error, element) {
       error.insertBefore(element);
     },
     submitHandler: function(form) {
         // optional callback function
         // only fires on a valid form submission
         // do something only if/when form is valid
         // like process the dropzone queue HERE instead
         // then use .ajax() OR .submit()
         form.submit()
     }
   });

    $('#educational_attainment_form').validate({
      ignore: [],
      errorClass:'errorTxt',
      rules: {
        received_prof_license: "required",
        type_of_license: {
          required: function() {return educ_prc_req()},
        },
        prc_license_no: {
          required: function() {return educ_prc_req()},
        },
        date_issued: {
          required: function() {return educ_prc_req()},
        },
        validity: {
          required: function() {return educ_prc_req()},
        },
        'school[]': "required",
        'address[]': "required",
        'inclusive_date[]': "required",
        'degree_units_earned[]': "required",
      },
      errorPlacement: function(error, element) {
        error.insertBefore(element);
      },
      submitHandler: function(form) {
          // optional callback function
          // only fires on a valid form submission
          // do something only if/when form is valid
          // like process the dropzone queue HERE instead
          // then use .ajax() OR .submit()
          form.submit()
      }
    });

    function educ_prc_req() {
      return ($('input[name="received_prof_license"]:checked', '#educational_attainment_form').val() == 1) ? true : false;
    }

    // $('#educational_attainment_form button[name="educ_attainment"]').on('click', function(){
    //     $('textarea[name="school[]"]').each(function(){
    //       $(this).rules('add', {
    //         required: true,
    //       });
    //     });
    //
    //     $('#educational_attainment_form').submit();
    // });

    $('#work_exp_form').validate({
      ignore: [],
      errorClass:'errorTxt',
      rules: {
        'company[]': "required",
        'position[]': "required",
        'inclusive_date[]': "required",
        'employment_status[]': "required",
      },
      errorPlacement: function(error, element) {
        error.insertBefore(element);
      },
      submitHandler: function(form) {
          // optional callback function
          // only fires on a valid form submission
          // do something only if/when form is valid
          // like process the dropzone queue HERE instead
          // then use .ajax() OR .submit()
          form.submit()
      }
    });

    $('#trainsem_attended_form').validate({
      ignore: [],
      errorClass:'errorTxt',
      rules: {
        'qualified[]': "required",
        'title[]': "required",
        'venue[]': "required",
        'conductor[]': "required",
        'date_conducted[]': "required",
        'no_hours[]': "required",
        'cert_no[]': "required",
      },
      errorPlacement: function(error, element) {
        error.insertBefore(element);
      },
      submitHandler: function(form) {
          // optional callback function
          // only fires on a valid form submission
          // do something only if/when form is valid
          // like process the dropzone queue HERE instead
          // then use .ajax() OR .submit()
          form.submit()
      }
    });

 });
</script>
