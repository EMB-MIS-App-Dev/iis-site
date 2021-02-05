var base_url = window.location.origin+"/embis";
// $.ajax({
//       url: base_url+"/Company/Add_company/select_province",
//       type: 'POST',
//       async : true,
//       success:function(response)
//         {
//           // console.log(response);
//           $('#select_prov_sample').remove();
//           $("#select_comp_province_id").html(response);
//         }
//   });

  function comp_project_type(value){
    $.ajax({
      url: base_url+"/Company/Add_company/category",
      type: 'POST',
      async : true,
      data:{'proid':value},
      success:function(response)
      {
        $("#comp_category_id").html(response);
      }
    });
    $.ajax({
      url: base_url+"/Company/Add_company/remarks",
      type: 'POST',
      async : true,
      data:{'proid':value},
      success:function(response2)
      {
        var data = JSON.parse(response2);
        $("#prsizrem").val(data[0]['rem']);
      }
    });
  }
// for selecting company city
function select_province(provid){
  $.ajax({
        url: base_url+"/Company/Add_company/select_city",
        type: 'POST',
        async : true,
        data: {"provid": provid},
        success:function(response)
          {
            $('#select_city_sample').remove();
            $('#select_city_sample_edit').remove();
            $('#select_comp_brgy_id option').remove();
            $("#select_comp_city_id").html(response);
          }

    });
}





  function select_comp_city(cityid){
    $.ajax({
          url: base_url+"/Company/Add_company/select_barangay",
          type: 'POST',
          async : true,
          data: {"cityid": cityid},
          success:function(response)
            {
              $('#select_brgy_sample').hide();
              $("#select_comp_brgy_id").html(response);
            }

      });
  }

  function select_region(value){
    $.ajax({
          url: base_url+"/Company/Add_company/select_province",
          type: 'POST',
          async : true,
          data: {"rgnnum": value},
          success:function(response)
            {
              $("#select_comp_city_id select option").remove();
              $("#select_comp_brgy_id select option").remove();
              $('#select_prov_sample').remove();
              $("#select_comp_province_id").html(response);
            }

      });
  }

    // function select_region_main(company_id = ''){
    //   var main_region = $('#region_comp_main_id').val();
    //   $.ajax({
    //         url: base_url+"/Company/Edit_company/data/"+company_id,
    //         type: 'POST',
    //         async : true,
    //         data: {"main_region": main_region},
    //         success:function(response)
    //           {
    //             location.reload();
    //             // $("#select_comp_city_id select option").remove();
    //             // $("#select_comp_brgy_id select option").remove();
    //             // $('#select_prov_sample').remove();
    //             // $("#select_comp_province_id").html(response);
    //           }
    //
    //     });
    // }

  function select_region_1(value){
    $.ajax({
          url: base_url+"/Company/Add_company/select_province_1",
          type: 'POST',
          async : true,
          data: {"rgnnum": value},
          success:function(response)
            {
              $("#select_comp_city_id select option").remove();
              $("#select_comp_brgy_id select option").remove();
              $('#select_prov_sample').remove();
              $("#select_comp_province_id_outside").html(response);
            }
      });
  }

    function select_region_edit(value){
      $.ajax({
            url: base_url+"/Company/Add_company/select_province_1",
            type: 'POST',
            async : true,
            data: {"rgnnum": value},
            success:function(response)
              {
                $("#select_city_sample option").remove();
                $("#select_brgy_sample option").remove();
                $("#select_comp_city_id select option").remove();
                $("#select_comp_brgy_id select option").remove();
                // for edit company
                $("#prov_containter_ext ").hide();
                $("#prov_containter_new ").show();
                $("#select_comp_province_id_edit").html(response);
              }
        });
    }

function jurisdiction_type(value){
  // alert(value.value);
  if (value.value == 2) {
    $('#outside_jurisdiction_region_container').show();
    $('#outside_jurisdiction_container_province').show();
    $('#in_jurisdiction_container_province').hide();
  }else if (value.value == 1) {
    $('#outside_jurisdiction_region_container').hide();
    $('#outside_jurisdiction_container_province').hide();
    $('#in_jurisdiction_container_province').show();
  }
}
  // function select_region(value){
  //   $.ajax({
  //         url: base_url+"/Company/Add_company/select_province",
  //         type: 'POST',
  //         async : true,
  //         data: {"rgnnum": value},
  //         success:function(response)
  //           {
  //             $("#select_comp_city_id select option").remove();
  //             $("#select_comp_brgy_id select option").remove();
  //             $('#select_prov_sample').remove();
  //             $("#select_comp_province_id").html(response);
  //           }
  //
  //     });
  // }

  function show_main_comp(){
   $('#edit_main_compname').removeAttr("readonly");
   $('#maincompname').attr('disabled',false);
   $("#show_branch_comp_id").prop("checked", false).val('');
   $("#show_main_comp_id").val('1');
   $('.main_comp').show();
   $(".branch_comp").hide();
   $(".project_name").attr("required",false);
   $(".project_name").removeClass('required');
  }
  function show_branch_comp(){
    $('#edit_main_compname').attr('readonly','readonly');
    $('#show_branch_comp_id').val(2);
    $('#maincompname').attr('disabled',true);
    $("#show_main_comp_id").prop("checked", false).removeAttr("checked").val('');
    $('.main_comp').hide();
    $(".branch_comp").show();
  }

  function samemadd(provid,cityid,brgyid){
    $('#mailadd').attr('disabled',true);
  }

  function newmadd(){
  $('#mailadd').removeAttr('disabled');
  }

  function delete_company(token){
    var confirmation = confirm("are you sure you want to remove the item?");
     if (confirmation) {
       $.ajax({
             url: base_url+"/Company/Add_company/delete_company",
             type: 'POST',
             async : true,
             data: {"token": token},
             success:function(response)
               {
                 // console.log(1);
                 alert('success');
                  location.reload();
                  // swal("Done!", "It was succesfully deleted!", "success");
               }
         });
     }
  }
  // for assigning company if exist from emb
  // function assign_company(facility_id){
  //   // if (facility_id == 0) {
  //   //   $('#establishment_container').show();
  //   // }else {
  //   //     $('#establishment_container').hide();
  //     // var confirmation = confirm("are you sure you want to assign this company to this user?");
  //
  //     if (confirm("are you sure you want to assign this company to this user?")) {
  //       // $('#company-details-modal').modal('show');
  //       // console.log(1);
  //       $.ajax({
  //         url: base_url+"/Company/Company_list/emb_assign_existing_comp",
  //         type: 'POST',
  //         async : true,
  //         data: {"facility_data": facility_id},
  //         success:function(response)
  //         {
  //           // console.log(response);
  //           alert('SUCCESS');
  //           location.href = base_url+"/Company/Company_list/draft_company_list"
  //           // $('#assign_company_data').after(response);
  //         }
  //
  //       });
  //     }else {
  //       location.reload();
  //     }
  //   // }
  //   // alert(facility_id);die();
  // }
  // assign existing company requested from client_id// for assigning company if exist
  function assign_client_request_company(facility_data){
    // alert(facility_data);die();
    var confirmation = confirm("are you sure you want to assign this user to this company?");

     if (confirmation) {
       $.ajax({
             url: base_url+"/Company/Company_list/emb_assign_requested_comp",
             type: 'POST',
             async : true,
             data: {"facility_data": facility_data},
             success:function(response)
               {
                 alert('SUCCESS');
                 location.href = base_url+"/Company/Company_list/draft_company_list"
               }
         });
     }
  }

  function view_user_attch(user_id,req_id){
      $('#req_id').val(req_id);
    $.ajax({
          url: base_url+"/Company/Company_list/user_attch_id",
          type: 'POST',
          async : true,
          data: {"user_id": user_id},
          success:function(response)
            {
              var govid = '';
              var compid = '';
              var autorization = '';
              var user_id = JSON.parse(response);
              user_details = user_id.user_data;
              console.log(user_details);
              // if (user_details[1]['user_id'] === undefined) {       //if t=undefined, call tt
              //       console.log('error')      //call tt member from t
              // }
              compid += "<img src='../../../../crs/uploads/user_attch_id/company_id/"+user_details[0]['user_id']+"/comp_id.png' alt=''>";
              govid += "<img src='../../../../crs/uploads/user_attch_id/gov_id/"+user_details[0]['user_id']+"/gov_id.png' alt=''>";
              autorization += "<a target='_blank' href='../../../../crs/uploads/authorization_letter/"+req_id+"/authorization_letter.pdf'><i class='fa fa-eye' aria-hidden='true' style='padding-left:10px'></i></a>";
              $('#authorization_letter_id').html(autorization);
              $('#user_attch_compid').html(compid);
              $('#user_attch_govid').html(govid);
              $('#requ_fname').val(user_details[0]['first_name']);
              $('#requ_lname').val(user_details[0]['last_name']);
              $('#requ_cont').val(user_details[0]['contact_no']);
              $('#requ_position').val(user_details[0]['position']);
              $('#requ_region').val(user_id.region_name[0]['rgnnam']);
              $('#requ_email').val(user_details[0]['email']);
              $('#view_client_est_id').val(req_id);
              // if disapproved
              $('#userreqid').val(req_id);
            }

      });
  }

  function delete_est_req(req_id){
    var confirmation = confirm("are you sure you want to remove this request?");
     if (confirmation) {
       $.ajax({
         url: base_url+"/Company/Company_list/delete_client_est_request",
           type: 'POST',
         data:{"request_id": req_id},
         success:function(response){
           alert('SUCCESS');
           location.href = base_url+"/Company/Company_list/for_approval_company_request"
         }
       })
     }

    }
  // for disapproving client request
  function disapprove_request(req_id,email,token){
    $('#userreqid').val(req_id);
    $('#useremail').val(email);
    $('#reqtokenid').val(token);
  }

  function disaprove_facility(req_id){
    $('#req_id').val(req_id);
    $('#disapprove_ficility').css({'z-index':'9999'});
  }

  function view_disapprove_client_request (req_id){
    $.ajax({
      url: base_url+"/Company/Disapprove/view_disapprove_client_request",
      type: 'POST',
      data:{"request_id": req_id},
      success:function(response){
          $('#view_disapprove_client_request_reason').html(response);
      }
    });
  }

// function approved_ext_requested_establishment(){
//   if (!confirm('Are you sure ?')) {
//     return false;
//   }else {
//     this.form.submit();
//   }
// }

    function viewallonlineusers_smr(){
      $.ajax({
        url: base_url+"/Index/viewallonlineusers_smr",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){
          $('#viewallonlineusers_smr_container').html(response);
        }
      });
    }
    // adding main company
    function add_main_company(main_company_id){

      if (!confirm('Are you sure you want to add this as main company ?')) {
        return false;
      }else {
        $.ajax({
          url: base_url+"/Company/Add_company/add_main_company",
          type: 'POST',
          async : true,
          data: {
            "main_company_id": main_company_id,
          },
          success:function(response)
          {
            var obj = JSON.parse(response);
            $('#add_main_company_name').val(obj[0]['company_name']);
            $('#add_main_company_id').val(obj[0]['company_id']);
            $('#add_main_company_modal').modal('hide');
          }
        });
      }
    }

    function regenerate_client_binded_companies(){
      $.ajax({
        url: base_url+"/Company/Company_list/regenerate_client_binded_companies",
        type: 'POST',
        async : true,
        success:function(response){
          console.log(response);
        }
      });
    }

    $(document).ready(function(){

    $('#comp_project_type_id').selectize();
    if ($('#show_branch_comp_id').is(':checked')) {
      $('.main_comp').hide();
      $(".branch_comp").show();
      $('#show_main_comp_id').val('').prop('checked',false);
      $('#maincompname').attr('disabled',true);
    }else {
      $('#show_main_comp_id').val('1').prop('checked',true);
    }

    $('#approved_ext_requested_establishment').on('click',function(){
      if (!confirm('Are you sure ?')) {
        return false;
      }else {
        this.form.submit();
      }

    });
    $('#approved_new_requested_establishment').on('click',function(){
      if (!confirm('Are you sure ?')) {
        return false;
      }else {
        this.form.submit();
      }

    });


  })
