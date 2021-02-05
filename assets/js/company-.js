
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
  // alert(provid);
  $.ajax({
        url: base_url+"/Company/Add_company/select_city",
        type: 'POST',
        async : true,
        data: {"provid": provid},
        success:function(response)
          {
            $('#select_city_sample').remove();
            $('#select_comp_brgy_id option').remove();
            $("#select_comp_city_id").html(response);
          }

    });
}

function select_region(value){
    // $("#select_comp_province_id").remove();

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
    // $("#select_comp_province_id").remove();

  $.ajax({
        url: base_url+"/Company/Add_company/select_province",
        type: 'POST',
        async : true,
        data: {"rgnnum": value},
        success:function(response)
          {
            // console.log(response);
            // var data = JSON.parse(response);
            // var html = '';
            // var i;
            // for(i=0; i<data.length; i++){
            //   html +='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
            // }
            $("#select_comp_city_id select option").remove();
            $("#select_comp_brgy_id select option").remove();
            $('#select_prov_sample').remove();
            $("#select_comp_province_id").html(response);
          }

    });
}

function show_main_comp(){
  // $('#show_branch_comp_id').val('');
 $('#maincompname').attr('disabled',false);
 $("#show_branch_comp_id").prop("checked", false).val('');
 $("#show_main_comp_id").val('1');
 $('.main_comp').show();
 $(".branch_comp").hide();
 // for removing required of project name and main company
 $(".project_name").attr("required",false);
 $(".project_name").removeClass('required');
 // $("#main_comp_id").attr("required",false);
 // $("#main_comp_id").removeClass('required');
}
function show_branch_comp(){
  // $('#show_branch_comp_id').val(value);
  $('#show_branch_comp_id').val(2);
  $('#maincompname').attr('disabled',true).val('');
  $("#show_main_comp_id").prop("checked", false).removeAttr("checked").val('');
  $('.main_comp').hide();
  $(".branch_comp").show();
  // for adding required of project name and main company
  // $(".project_name").attr("required",true);
  // $(".project_name").addClass('required');
  // $("#main_comp_id").attr("required",true).addClass('required');

}
function samemadd(provid,cityid,brgyid){
  // console.log();
  $('#mailadd').attr('disabled',true);

}
function newmadd(){
$('#mailadd').removeAttr('disabled');
}


// function add_company_btn(){
//   $('.required').each(function(){1
//       if( $(this).val() == "" ){
//         alert('Please fill all required fields');
//         return false;
//       }
//   });
//   return true;
// };
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
function add_client_as_user(value){
  $('.slick-container-img').remove();
  $('#assign_company').remove();
  $.ajax({
        url: base_url+"/Company/Company_list/add_client_as_user_data",
        type: 'POST',
        async : true,
        data: {"user_id": value},
        success:function(response)
          {
             $('#add_client_as_user').after(response);
          }

    });
}


function assign_company(value){
  console.log(base_url);die();
  $('.slick-container-img').remove();
  $('#assign_company').remove();
  $.ajax({
        url: base_url+"/Company/Company_list/add_client_as_user_data",
        type: 'POST',
        async : true,
        data: {"user_id": value},
        success:function(response)
          {
             $('#assign_company_data').after(response);
          }

    });
}

// function select_comp_per_region(value){
//   $.ajax({
//         url: base_url+"/Company/Company_list/select_comp_per_region",
//         type: 'POST',
//         async : true,
//         data: {"region": value},
//         success:function(response)
//           {
//              $('#comp_per_reg').html(response);
//           }
//
//     });
// }
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
})
