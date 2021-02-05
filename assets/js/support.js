  // for updating ticket
  function view_support_request(value){
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Main_support/view_support_request",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              var data = JSON.parse(response);
              var support_details = data.support_details;
              var support_attachments =  data.support_attachments;
              var html = '';
              $('#support_establishment').text(support_details[0]['establishment']);
              $('#support_system').text(support_details[0]['system']);
              $('#support_client_contact_no').text(support_details[0]['contact_no']);
              $('#support_date').text(support_details[0]['date']);
              $('#support_client_email').text(support_details[0]['email']);
              $('#support_system_inquiry').text(support_details[0]['sys_inquery']);
              $('#support_client_name').text(support_details[0]['name']);
              $('#support_remarks').text(support_details[0]['sys_remarks']);
              for (var i = 0; i < support_attachments.length; i++) {
                html += "<a target='_blank' class='dropdown-item' href='../../../../support/uploads/"+support_attachments[i].supp_ticket_id+"/"+support_attachments[i].name+"'>"+support_attachments[i].name+"</a>";
              }
              $('#support_attachments_id').html(html);
            }

      });
  }
  function res_view_support_request(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Main_support/res_view_support_request",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                var data = JSON.parse(response);
                // console.log(data);die();
                var support_details = data.support_details;
                var resolution = data.resolution;
                var support_attachments =  data.support_attachments;
                var html = '';

                var res_support_attachments =  data.res_support_attachments;
                // console.log(res_support_attachments);die();
                var html1 = '';
                $('#res_support_establishment').text(support_details[0]['establishment']);
                $('#res_support_system').text(support_details[0]['system']);
                $('#res_support_client_contact_no').text(support_details[0]['contact_no']);
                $('#res_support_date').text(support_details[0]['date']);
                $('#res_support_client_email').text(support_details[0]['email']);
                $('#res_support_system_inquiry').text(support_details[0]['sys_inquery']);
                $('#res_support_client_name').text(support_details[0]['name']);
                $('#res_support_remarks').text(support_details[0]['sys_remarks']);
                $('#res_support_resolution').text(resolution[0]['resolution']);
                for (var i = 0; i < support_attachments.length; i++) {
                  html += "<a target='_blank' class='dropdown-item' href='../../../../support/uploads/"+support_attachments[i].supp_ticket_id+"/"+support_attachments[i].name+"'>"+support_attachments[i].name+"</a>";
                }
                $('#res_support_attachments_id_1').html(html);
                for (var i = 0; i < res_support_attachments.length; i++) {
                  html1 += "<a target='_blank' class='dropdown-item' href="+base_url+"/uploads/support/"+res_support_attachments[i].supp_ticket_id+"/"+res_support_attachments[i].name+">"+res_support_attachments[i].name+"</a>";
                }
                $('#res_support_attachments_id').html(html1);
              }

        });
    }
  function process_ticket(value){
  // alert(1);
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Main_support/process_ticket_request",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              if (response == 'success'){
                $('#user_accounts').DataTable().ajax.reload();
              }else {
                alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
              }
            }

      });
  }
  function cancel_process_ticket(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Main_support/cancel_process_ticket",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                if (response == 'success'){
                  $('#user_accounts').DataTable().ajax.reload();
                }else {
                  alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
                }
              }

        });
    }


  function add_resolution(value){
      base_url = 'https://iis.emb.gov.ph/embis';
        $.ajax({
              url: base_url+"/Support/Main_support/input_resolution",
              type: 'POST',
              async : true,
              data: {"supp_ticket_id": value},
              success:function(response)
                {
                  var data = JSON.parse(response);
                  var support_details = data.support_details;
                  var support_attachments =  data.support_attachments;
                  var html = '';
                  $('#supp_ticket_id_res').val(support_details[0]['support_id']);
                  $('#support_establishment_res').text(support_details[0]['establishment']);
                  $('#support_system_res').text(support_details[0]['system']);
                  $('#support_client_contact_no_res').text(support_details[0]['contact_no']);
                  $('#support_date_res').text(support_details[0]['date']);
                  $('#support_client_email_res').text(support_details[0]['email']);
                  $('#support_system_inquiry_res').text(support_details[0]['sys_inquery']);
                  $('#support_client_name_res').text(support_details[0]['name']);
                  $('#support_remarks_res').text(support_details[0]['sys_remarks']);
                }

          });
      }

// for EMB TICKET SUPPORT
// creating ticket
  function emb_process_ticket(value){
  // alert(1);die(value);
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Emb_support/process_ticket_request",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              // console.log(response);
              if (response == 'success'){
                $('#for_assistance_table').DataTable().ajax.reload();
                $('#sec_support_table').DataTable().ajax.reload();
              }else {
                alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
              }
            }

      });
  }
  function cancel_emb_process_ticket(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/cancel_process_ticket",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                if (response == 'success'){
                  $('#for_assistance_table').DataTable().ajax.reload();
                }else {
                  alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
                }
              }

        });
    }

    function cancel_emb_forward_ticket(value){
      // alert(value);die();
      base_url = 'https://iis.emb.gov.ph/embis';
        $.ajax({
              url: base_url+"/Support/Emb_support/cancel_emb_forward_ticket",
              type: 'POST',
              async : true,
              data: {"supp_ticket_id": value},
              success:function(response)
                {
                  console.log(response);
                  // if (response == 'success'){
                  //   $('#for_assistance_table').DataTable().ajax.reload();
                  // }else {
                  //   alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
                  // }
                }

          });
      }


  function emb_add_resolution(value){
      base_url = 'https://iis.emb.gov.ph/embis';
        $.ajax({
              url: base_url+"/Support/Emb_support/input_resolution",
              type: 'POST',
              async : true,
              data: {"supp_ticket_id": value},
              success:function(response)
                {
                  var data = JSON.parse(response);
                  var supp_details = data.support_details;
                  var supp_date = data.supp_date;
                  var sp_attachments = data.sp_attachment_container_solved;
                  $('#emb_supp_category').text(supp_details[0].ctype);
                  $('#emb_supp_specification').text(supp_details[0].csdsc);
                  $('#emb_supp_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
                  $('#emb_supp_date').text(supp_date);
                  $('#emb_supp_remarks').text(supp_details[0].remarks);
                  $('#emb_supp_ticket_id_res').val(supp_details[0].ticket_ass_id);
                  var spattach = '';
                  if (sp_attachments.length > 0) {
                    for (var i = 0; i < sp_attachments.length; i++) {
                      spattach += '<a target="_blank" href="'+base_url+'/uploads/support/assistance/'+sp_attachments[i]['ticket_no_id']+'/'+sp_attachments[i]['name']+'">'+sp_attachments[i]['name']+'</a><br>'
                    }
                  }else {
                    spattach += '<a target="_blank" href="#">No attachment found !</a><br>'
                  }

                  $('#sp_attachment_container_solved').html(spattach);
                }

          });
      }
  function pending_process_ticket(value){
        base_url = 'https://iis.emb.gov.ph/embis';
          $.ajax({
                url: base_url+"/Support/Emb_support/pending_process_ticket",
                type: 'POST',
                async : true,
                data: {"supp_ticket_id": value},
                success:function(response)
                  {
                    var data = JSON.parse(response);
                    var supp_details = data.support_details;
                    var supp_date = data.supp_date;
                    $('#emb_supp_pending_category').text(supp_details[0].ctype);
                    $('#emb_supp_pending_specification').text(supp_details[0].csdsc);
                    $('#emb_supp_pending_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
                    $('#emb_supp_pending_date').text(supp_date);
                    $('#emb_supp_pending_remarks').text(supp_details[0].remarks);
                    $('#emb_supp_pending_ticket_id_res').val(supp_details[0].ticket_ass_id);
                  }

            });
        }
  function sp_select_category(value){
base_url = 'https://iis.emb.gov.ph/embis';
  $.ajax({
        url: base_url+"/Support/Emb_support/sp_select_category",
        type: 'POST',
        async : true,
        data: {"category": value},
        success:function(response)
          {
            var html = '';
            var data = JSON.parse(response);
            var sp_category_spc  = data['sp_category_spc'];
            var sp_category = data['sp_category'];
            for (var i = 0; i < sp_category_spc.length; i++) {
              // console.log(sp_category_spc);
              html += '<option value='+sp_category_spc[i].csno+'>'+sp_category_spc[i].csdsc+'</option>';
            }
            $('#sp_category_specification').html(html);
            $('#sp_category_specification_label').text(sp_category[0].ctype);
          }
    });
 }
// for editing main assistance category
  function update_sub_cat_assistance(val,status){
    var status_name = '';
    switch (status) {
      case 1:
        status_name = 'activate';
        break;
      case 2:
        status_name = 'update';
        break;
      case 3:
        status_name = 'delete';
        break;
      default:
    }
  var confirmation = confirm("are you sure you want to "+status_name+" this sub-category?");
  if (confirmation) {
    $.ajax({
          url: base_url+"/Support/Emb_support/update_sub_cat_assistance",
          type: 'POST',
          async : true,
          data: {"sub_cat_id": val,"sub_cat_status": status},
          success:function(response)
            {
              // console.log(response);
              if (response == 'success') {
                  $('#sub_cat_msg_id').show().text('Successfully Updated !');
                  setTimeout(function() { $("#sub_cat_msg_id").hide(); }, 5000);
                  $('#table_assistance_specification').DataTable().ajax.reload();
              }
            }
      });
  }else {
    return false;
  }

}
  function add_sub_cat_assistance(value){
  if (value == 0) {
    $('.new-sub-cat-assistance-row').show();
    $('#sub-cat-assistance-section').show();
  }else {
    $('.new-sub-cat-assistance-row').hide();
    $('#sub-cat-assistance-section').hide();
  }
}
// for hardware
  function add_brand_per_hardware_cat(value){
  var main_hardware_id = $('#main_cat_hardware_id').val();
    if (value == 0) {
      $('.new-brand-row').show();
      $('#new-brand-section').show();
      $('#model_per_brand').hide();
      $('.new-model-row').hide();
    }else {
      $.ajax({
            url: base_url+"/Support/Emb_support/get_models_per_brand",
            type: 'POST',
            async : true,
            data: {"brand_id": value,"main_cat_id": main_hardware_id},
            success:function(response)
              {
                var html  = '';
                var data = JSON.parse(response);
                var models_per_selected_brand  = data['models_per_selected_brand'];
                var brand_name_main_hardware = data['brand_name_main_hardware'];
                if (models_per_selected_brand.length > 0) {
                  html +='<option value="">---</option><option value="0">Add New Model</option>';
                  for (var i = 0; i < models_per_selected_brand.length; i++) {
                    html += '<option value='+models_per_selected_brand[i].sp_cat_brand_id+'>'+models_per_selected_brand[i].name+'<button>x</button></option>';
                  }
                }else {
                  html += ' <option value="">---</option><option value="0">Add New Model</option>';
                }
                  $('#models_per_selected_brand').html(html);
                  $('#selected_brand_name').text(brand_name_main_hardware[0].name);
              }

        });

      $('#model_per_brand').show();
      $('.new-brand-row').hide();
      $('#new-brand-section').hide();
    }
  }
  function add_model_per_brand(value){
    if (value == 0) {
      $('.new-model-row').show();
      $('#new-model-section').show();
    }else {
      $('.new-model-row').hide();
      $('#new-model-section').hide();
    }
  }
  function edit_main_cat_hardware(val){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/get_main_cat_hardware_data",
            type: 'POST',
            async : true,
            data: {"category": val},
            success:function(response)
              {
                var html = '';
                var data = JSON.parse(response);
                var sp_main_category_hardware  = data['sp_main_category_hardware'];
                var sp_brand_per_hardware = data['sp_brand_per_hardware'];
                // console.log(sp_main_category_hardware[0].name);
                if (sp_brand_per_hardware.length > 0) {
                  html +='<option value="">---</option><option value="0">Add New Brand</option>';
                  for (var i = 0; i < sp_brand_per_hardware.length; i++) {
                    html += '<option value='+sp_brand_per_hardware[i].sp_cat_brand_id+'>'+sp_brand_per_hardware[i].name+'</option> <button type="button" name="button">X</button>';
                  }
                }else {
                  html += ' <option value="">---</option><option value="0">Add New Brand</option>';
                }

                $('#add_brand_per_hardware_cat_id').html(html);
                $('#selected_main_cat_hardware').text(sp_main_category_hardware[0].name);
                $('#main_cat_hardware_id').val(sp_main_category_hardware[0].sp_hardware_id);
              }
    });
  }
  // for updating ticket
  function emb_view_support_request(value){
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Emb_support/view_support_request",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              // console.log(response);die();
              var data = JSON.parse(response);
              // console.log(data);
              var supp_details = data.support_details;
              var supp_date = data.supp_date;
              var resolution = data.resolution;
              var resolution_from_staff = data.resolution_from_staff;
              var pending_reason = data.pending_reason;
              var sp_attachments = data.sp_attachments;
              var sp_forwaded_data = data.sp_forwaded_data;
              // console.log(sp_forwaded_data[0].from_reg);
              $('#view_emb_supp_category').text(supp_details[0].ctype);
              $('#view_emb_supp_specification').text(supp_details[0].csdsc);
              $('#view_emb_supp_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
              $('#view_emb_supp_date').text(supp_date);
              $('#view_emb_supp_remarks').text(supp_details[0].remarks);
              $('#view_emb_supp_ticket_id_res').val(supp_details[0].ticket_ass_id);


              if (resolution.length > 0) {
                var resolution_html = '';
                for (var i = 0; i < resolution.length; i++) {
                  resolution_html += "<textarea  class='form-control' name='view_emb_support_resolution' rows='4' style='width:100%' readonly>"+resolution[i]['resolution']+"</textarea>"
                }
                $('#view_emb_support_resolution').html(resolution_html);
                $('#view_resolution').show();
              }else {
                  $('#view_resolution').hide();
                  $('#view_emb_support_resolution').html('');
              }

              if (resolution_from_staff.length > 0) {
                var resolution_html_staff = '';
                for (var i = 0; i < resolution_from_staff.length; i++) {
                  resolution_html_staff += "<textarea  class='form-control' name='view_emb_support_resolution' rows='4' style='width:100%' readonly>"+resolution_from_staff[i]['comment']+"</textarea>"
                }
                $('#view_comment_from_staff_id').show();
                $('#view_comment_from_staff').html(resolution_html_staff);
              }else {
                  $('#view_comment_from_staff_id').hide();
                  $('#view_comment_from_staff').text('');
              }

              if (pending_reason.length > 0) {
                $('#view_reason_pending_id').show();
                $('#view_reason_pending').text(pending_reason[0].reason);
              }else {
                  $('#view_reason_pending_id').hide();
                  $('#view_reason_pending').text('');
              }


              if (sp_forwaded_data.length > 0) {
                $('#sender_name').text(sp_forwaded_data[0].fname+' '+sp_forwaded_data[0].sname+' ('+sp_forwaded_data[0].from_reg+')');
                $('#view_remarks_forward_cont').show();
                $('#view_remarks_forward').text(sp_forwaded_data[0].remarks);
              }else {
                  $('#view_remarks_forward_cont').hide();
                  $('#view_remarks_forward').text('');
              }

              var spattach = '';

              if (sp_attachments.length > 0) {
                for (var i = 0; i < sp_attachments.length; i++) {
                  spattach += '<a target="_blank" href="'+base_url+'/uploads/support/assistance/'+sp_attachments[i]['ticket_no_id']+'/'+sp_attachments[i]['name']+'">'+sp_attachments[i]['name']+'</a><br>'
                }
              }else {
                spattach += '<a target="_blank" href="#">No attachment found !</a><br>'
              }
              $('#sp_attachment_container').html(spattach);
            }

      });
  }
  function add_res_from_staff(value){
    // alert(value);die();
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/add_res_from_staff_request",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                var data = JSON.parse(response);
                var supp_details = data.support_details;
                var supp_date = data.supp_date;
                var resolution = data.resolution;
                $('#add_res_from_staff_supp_ticket_ass_id').val(supp_details[0].ticket_ass_id);
                $('#add_res_from_staff_supp_category').text(supp_details[0].ctype);
                $('#add_res_from_staff_supp_specification').text(supp_details[0].csdsc);
                $('#add_res_from_staff_supp_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
                $('#add_res_from_staff_supp_date').text(supp_date);
                $('#add_res_from_staff_supp_remarks').text(supp_details[0].remarks);
                $('#add_res_from_staff_supp_ticket_id_res').val(supp_details[0].ticket_ass_id);
                // $('#add_res_from_staff_support_resolution').text(resolution[0].resolution);
                var reshtml = '';
                for (var i = 0; i < resolution.length; i++) {
                reshtml +="<textarea  class='form-control' name='view_emb_support_resolution' rows='4' style='width:100%' readonly>"+resolution[i]['resolution']+"</textarea><hr>";
                }
                $('#add_res_from_staff_support_resolution').html(reshtml);
              }

        });
    }
  function emb_view_support_request_borrow(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/view_support_request_borrow",
            type: 'POST',
            async : true,
            data: {"tno": value},
            success:function(response)
              {
                var data = JSON.parse(response);
                var supp_details = data.support_details;
                var return_date = data.return_date;
                var borrow_date = data.borrow_date;
                var resolution = data.resolution;
                var resolution_from_staff = data.resolution_from_staff;

                $('#borrow_view_emb_supp_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
                $('#borrow_view_emb_supp_category').text(supp_details[0].name);
                $('#borrow_view_emb_borrow_date').text(borrow_date);
                $('#borrow_view_emb_return_date').text(return_date);
                $('#borrow_view_emb_supp_remarks').text(supp_details[0].remarks);
                if (resolution.length > 0) {
                  $('#borrow_view_resolution').show();
                  $('#borrow_view_emb_support_resolution').text(resolution[0].resolution);
                }else {
                    $('#borrow_view_resolution').hide();
                    $('#borrow_view_emb_support_resolution').text('');
                }


              }

        });
    }
  // for hardware borrow
  function cancel_emb_process_ticket_borrow(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/cancel_process_ticket_borrow",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                // console.log(response);
                if (response == 'success'){
                  $('#for_borrow_data_table').DataTable().ajax.reload();
                }else {
                  alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
                }
              }

        });
    }
  function sp_select_borrow_category(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/get_brand_per_hardware_borrow",
            type: 'POST',
            async : true,
            data: {"category": value},
            success:function(response)
              {
                var data = JSON.parse(response);
                var html = '';
                  html +='<option value="">---</option>';
                  for (var i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].sp_cat_brand_id+'>'+data[i].name+'</option>';
                  }
                  $('#sp_brand_list_per_hardware_id').html(html);

              }
    });
  }
  function emb_process_ticket_borrow(value){
    // alert(1);die(value);
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/process_ticket_request_borrow",
            type: 'POST',
            async : true,
            data: {"tno": value},
            success:function(response)
              {
                // console.log(response);
                if (response == 'success'){
                  $('#for_borrow_data_table').DataTable().ajax.reload();
                }else {
                  alert('ERROR, PLEASE CONTACT ADMINISTRATOR !');
                }
              }

        });
    }
  function emb_supp_add_resolution_borrow(value){
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/input_resolution_borrow",
            type: 'POST',
            async : true,
            data: {"supp_ticket_id": value},
            success:function(response)
              {
                // console.log(response);die();
                var data = JSON.parse(response);
                var supp_details = data.support_details;
                var borrow_date = data.borrow_date;
                var return_date = data.return_date;
                $('#borrow_emb_supp_category').text(supp_details[0].name);
                $('#borrow_emb_supp_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
                $('#borrow_emb_borrow_date').text(borrow_date);
                $('#borrow_emb_return_date').text(return_date);
                $('#borrow_emb_supp_remarks').text(supp_details[0].remarks);
                $('#borrow_emb_supp_ticket_id_res').val(supp_details[0].tno);
              }

        });
    }
  // for seleting model per brand
  function sp_brand_list_per_hardware(value){
  var main_cat_id = $('#sp_select_borrow_category_id').children("option:selected").val();
    base_url = 'https://iis.emb.gov.ph/embis';
      $.ajax({
            url: base_url+"/Support/Emb_support/get_model_per_brand_borrow",
            type: 'POST',
            async : true,
            data: {"brand": value,"main_cat_id":main_cat_id},
            success:function(response)
              {
                var html = '';
                var data = JSON.parse(response);
                // console.log(response);
                  html +='<option value="">---</option>';
                  for (var i = 0; i < data.length; i++) {
                    html += '<option value='+data[i].model_id+'>'+data[i].name+'</option>';
                  }
                  $('#sp_model_list_per_brand').html(html);

              }
    });
  }
  // for adding new sub category assisstance
  function add_new_sub_cat_btn(el){
    var new_sub_cat = $('#new_sub_cat').val();
    if (new_sub_cat == '') {
      alert('Please fill new sub-category');
    }else {
      var confirmation = confirm("are you sure you want to add this sub-category?");
      if (confirmation) {
        $.ajax({
              url: base_url+"/Support/Emb_support/add_sp_sub_category",
              type: 'POST',
              async : true,
              data: {"main_cat_id": el.value,"new_sub_cat_name": new_sub_cat},
              success:function(response)
                {
                  if (response == 'success') {
                    $('#new_sub_cat').val('');
                    $('#sub_cat_msg_id').show().text('Successfully Added !');
                    setTimeout(function() { $("#sub_cat_msg_id").hide(); }, 5000);
                    $('#table_assistance_specification').DataTable().ajax.reload();
                  }else {
                    $('#sub_cat_msg_id_error').show().text("Something's Wrong !");
                    setTimeout(function() { $("#sub_cat_msg_id_error").hide(); }, 5000);
                    $('#table_assistance_specification').DataTable().ajax.reload();
                  }
                }
          });
      }else {
        return false;
      }
    }
  }

  function update_main_cat_data(){
    var main_cat_id = $('#main_cat_assistance_unq_id').val();
    var main_cat_new_name = $('#main_cat_assistance_name').val();
    var confirmation = confirm("are you sure you want to update this category?");
      if (confirmation) {
        $.ajax({
              url: base_url+"/Support/Emb_support/update_main_cat_assistance",
              type: 'POST',
              async : true,
              data: {"main_cat_id": main_cat_id,"name": main_cat_new_name},
              success:function(response)
                {
                    var data = JSON.parse(response);
                    var cat_data = data.cat_data;
                    var msg = data.msg;
                      $('#emb_category_table_assistance').DataTable().ajax.reload();
                    // $('#main_cat_assistance_name').val(cat_data.ctype);
                    if (msg == 'success') {
                      alert("Successfully Updated !");
                    }else {
                      alert("Something's wrong, please contact administrator !");
                    }
                }
          });
      }else {
        return false;
      }

  }

  function main_cat_ast_active_inactive(id,status){
    var confirmation = confirm("are you sure you want to update this category?");
      if (confirmation) {
        $.ajax({
              url: base_url+"/Support/Emb_support/main_cat_ast_active_inactive",
              type: 'POST',
              async : true,
              data: {"main_cat_id": id,"status": status},
              success:function(response)
                {
                  // console.log(response);die();
                  var data = JSON.parse(response);
                  var cat_data = data.cat_data;
                  var msg = data.msg;
                  if (msg == 'success') {
                    alert("Successfully Updated !");
                    $('#emb_category_table_assistance').DataTable().ajax.reload();
                  }else {
                    alert("Something's wrong, please contact administrator !");
                  }
                }
          });
      }else {
        return false;
      }

  }


  function emb_forward_ticket(value){
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Emb_support/view_support_request_frwd",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              var data = JSON.parse(response);
              var supp_details = data.support_details;
              var supp_date = data.supp_date;
              var sp_attachments = data.sp_attachments;
              // console.log(sp_attachments);
              $('#emb_forward_supp_pending_category').text(supp_details[0].ctype);
              $('#emb_forward_supp_pending_specification').text(supp_details[0].csdsc);
              $('#emb_forward_supp_pending_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
              $('#emb_forward_supp_pending_date').text(supp_date);
              $('#emb_forward_supp_pending_remarks').text(supp_details[0].remarks);
              $('#emb_forward_supp_pending_ticket_id_res').val(value);

              var spattach = '';

              if (sp_attachments.length > 0) {
                for (var i = 0; i < sp_attachments.length; i++) {
                  spattach += '<a target="_blank" href="'+base_url+'/uploads/support/assistance/'+sp_attachments[i]['ticket_no_id']+'/'+sp_attachments[i]['name']+'">'+sp_attachments[i]['name']+'</a><br>'
                }
              }else {
                spattach += '<a target="_blank" href="#">No attachment found !</a><br>'
              }
              $('#sp_attachment_container_solved_forward').html(spattach);

            }

      });
  }

  function change_subcat_ass(val,el){
    var new_name = $(el).val();
    $.ajax({
          url: base_url+"/Support/Emb_support/update_sub_cat_assistance_name",
          type: 'POST',
          async : true,
          data: {"new_name": new_name,"sub_cat_id": val},
          success:function(response)
            {
              console.log(response);
              // console.log('success');
            }
      });
  }


  // for forwarding ticket to CH
  function emb_forward_ticket_to_section(value){
    // alert(1);die();
  base_url = 'https://iis.emb.gov.ph/embis';
    $.ajax({
          url: base_url+"/Support/Emb_support/view_support_request_frwd_ch",
          type: 'POST',
          async : true,
          data: {"supp_ticket_id": value},
          success:function(response)
            {
              var data = JSON.parse(response);
              // console.log(data);die();
              var supp_details = data.support_details;
              var supp_date = data.supp_date;
              var sp_attachments = data.sp_attachments;
              var frwd_data = data.frwd_data;

              // console.log(frwd_data);
              $('#emb_forward_to_ch_fwrd_id').val(frwd_data[0]['sp_frwd_id']);
              $('#emb_forward_to_ch_ticket_ass_id').val(supp_details[0].ticket_ass_id);
              $('#emb_forward_to_ch_supp_pending_category').text(supp_details[0].ctype);
              $('#emb_forward_to_ch_supp_pending_specification').text(supp_details[0].csdsc);
              $('#emb_forward_to_ch_supp_pending_staff').text(supp_details[0].fname +' '+ supp_details[0].sname);
              $('#emb_forward_to_ch_region').text(frwd_data[0].from_reg);

              $('#emb_forward_to_ch_supp_pending_date').text(supp_date);
              $('#emb_forward_to_ch_supp_pending_remarks').text(supp_details[0].remarks);
              $('#emb_forward_to_ch_supp_pending_ticket_id_res').val(value);

              var spattach = '';

              if (sp_attachments.length > 0) {
                for (var i = 0; i < sp_attachments.length; i++) {
                  spattach += '<a target="_blank" href="'+base_url+'/uploads/support/assistance/'+sp_attachments[i]['ticket_no_id']+'/'+sp_attachments[i]['name']+'">'+sp_attachments[i]['name']+'</a><br>'
                }
              }else {
                spattach += '<a target="_blank" href="#">No attachment found !</a><br>'
              }
              $('#sp_attachment_to_ch_container_forward').html(spattach);

            }

      });
  }
