
function client_comp_list(id){
  $.ajax({
        url: base_url+"/Clients/Records/client_comp_list",
        type: 'POST',
        data:{'client_id':id},
        async : true,
        success:function(response)
          {
            // console.log(response);
            var html = '';
            var compdata = JSON.parse(response);
            if (compdata.length == 0) {
              html += '<tr><td>No records found !</td></tr>';
            }else {
              for (var i = 0; i < compdata.length; i++) {
                html += "<tr id = "+compdata[i].company_id+"><td>"+compdata[i].emb_id+"</td><td>"+compdata[i].company_name+"</td><td>"+compdata[i].first_name+" "+compdata[i].last_name+"</td><td>"+compdata[i].contact_no+"</td><td>"+compdata[i].email+"</td><td><button onClick='remove_comp_right("+compdata[i].company_id+")'><i class='fa fa-trash' aria-hidden='true'></i></button></td></tr>"
              }
            }

            $("#comp_data_container").html(html);
          }
    });
}

function remove_comp_right(company_id){
  if (confirm("Are you sure you want to remove this company on this client  ?")) {
    $.ajax({
          url: base_url+"/Clients/Records/remove_comp_rights",
          type: 'POST',
          data:{'company_id':company_id},
          async : true,
          success:function(response){
            alert('SUCCESSFULLY REMOVED !');
            $('#'+response).remove();
          }
      });
  }else {
    return false;
  }

}

function assign_comp_to_client(){
  console.log($(this).addClass('asd'));
}
// for smr assign emb employees
function remove_smr_user_right(userid){
    if (confirm("Are you sure you want to remove ?")) {
      $.ajax({
            url: base_url+"/Clients/Smr/remove_emb_emp_rights",
            type: 'POST',
            data:{'client_id':userid},
            async : true,
            success:function(response){
              // console.log(response);
              alert('SUCCESSFULLY REMOVED !');
               location.reload();
            }
        });
    }else {
      return false;
    }
  }

  function region_official_email(region){

    $.ajax({
          url: base_url+"/Clients/Smr/email_per_region",
          type: 'POST',
          data:{'region':region},
          async : true,
          success:function(response){
            var data = JSON.parse(response);
              if (data.length > 0) {
                $('#email_per_region').val(data[0].email);
                $('#email_id_per_region').val(data[0].idofficial_emails);
              }
          }
      });
  }

function resend_hwms_email(client_req_id){
  // alert(client_req_id);die();
  if (confirm("Are you sure you want to resend email HWMS credentials?")) {
    $.ajax({
      url: base_url + '/Clients/Clients/resend_verification_hwms',
      type: 'POST',
      data: {client_req_id:client_req_id},
      success:function(response)
        {
          // console.log( response);die();
          var newmsg = JSON.parse(response);
            if (newmsg.msg == 'sent') {
              alert('Successfully sent to '+newmsg.email+'')
              // location.reload(true);
                $('#approved_client_request').DataTable().ajax.reload();
            }else {
                    alert('ERROR !');
                    // location.reload(true);
            }

        }
    });
  }else {
    return false;
  }

}

function resent_client_credentials(client_id){
  if (confirm("Are you sure you want to resend user credentials?")) {
    $.ajax({
      url: base_url + '/Clients/Clients/resend_verification_email',
      type: 'POST',
      data: {client_id:client_id},
      success:function(response)
        {
          var newmsg = JSON.parse(response);
            if (newmsg.msg == 'sent') {
              alert('Successfully sent !')
              location.reload(true);
            }else {
                    alert('ERROR !');
                    // location.reload(true);
            }
        }
    });
  }else {
      return false;
  }

}

function submit_smr_by_admin(val){
  $('#res_smr_id').val(val);
}

function submit_smr_with_date(){
  // alert(1);die();
  var res_smr_id_date = $('#res_smr_id_date').val();
  var res_smr_id = $('#res_smr_id').val();
  var html_scs = '';
  var html_error = '';
  if (res_smr_id_date == '') {
    alert('Please input date !');
    return false;
  }else {
    $.ajax({
      url: base_url + '/Clients/Smr/resubmit_smr',
      type: 'POST',
      data: {res_smr_id_date:res_smr_id_date,res_smr_id:res_smr_id},
      success:function(response)
        {
          html_scs ="<div  class='alert alert-success' role='alert' >Succesfully Updated. Status is now For EMB Evaluation.</div>";
          html_error ="<div  class='alert alert-danger' role='alert' >Error ! , please contact Administrator !</div>";
          // alert(response);die();
          if (response == 'success') {
            $('#resubmit_smr_msg').html(html_scs);
            $('#smr_submitted_list').DataTable().ajax.reload();
          }
          if (response == 'error') {
            $('#resubmit_smr_msg').html(html_error);
          }
        }
    });
  }

}

function unbind_est_client(id,el){
  if (confirm("Are you sure you want to unbind this client to this establishment?")) {
    $('#unbind_est_modal').modal('show');
    $('#apr_est_id').val(id);
    $('#current_binded_client').text($(el).closest("tr").find("td:first-child").text()+' '+$(el).closest("tr").find("td:nth-child(2)").text());
    $('#selected_est_name').text($(el).closest("tr").find("td:nth-child(5)").text());
    $('#current_binded_client_email').text($(el).closest("tr").find("td:nth-child(3)").text())
  }else {
      return false;
  }
}

function rebind_new_client(){
  var approved_req_id = $('#apr_est_id').val();
  var new_client = $('#client_list').val();
  $.ajax({
    url: base_url + '/Clients/Clients/unbind_client_establishment',
    type: 'POST',
    data: {client_req_id:approved_req_id,new_client:new_client},
    success:function(response)
      {
        if (response == 'success') {
            alert("Successfully binded to new user !");
            $('#unbind_est_modal').modal('hide');
            $('#approved_client_request').DataTable().ajax.reload();
        }else {
          alert("Something's wrong, contact administrator !");
        }
      }
  });
}
