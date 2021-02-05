
  var base_url = window.location.origin+"/embis";

  function userfuncid(userid) {
    $.ajax({
          url: base_url+"/Admin/User_accounts/approved_user",
          type: 'POST',
          async : true,
          data: { userid : userid },
          success:function(response)
            {
              console.log(userid);
            }

      });
  }

  function rule_rows(number,mode) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/rule_rows",
          type: 'POST',
          async : true,
          data: { number : number },
          success:function(response)
            {
              if(mode == '1'){
                $("#rule_rows_body").html(response);
              }else if(mode == '2'){
                $("#edit_rule_rows_body").html(response);
              }else if(mode == '3'){
                $("#rule_rows_body_two").html(response);
              }
            }

      });
  }

  function rule_rows_edit(number) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_rule_rows",
          type: 'POST',
          async : true,
          data: { number : number },
          success:function(response)
            {
              $("#rule_rows_edit_body").html(response);
            }

      });
  }

  function ruledetails(rulename,mode) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/ruledetails",
          type: 'POST',
          async : true,
          data: { rulename : rulename, mode : mode},
          success:function(response)
            {
              $("#ruledetails_body").html(response);
            }

      });
  }

  function edit_ruledetails(rulename,mode) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/ruledetails",
          type: 'POST',
          async : true,
          data: { rulename : rulename, mode : mode },
          success:function(response)
            {
              $("#edit_ruledetails_body").html(response);
            }

      });
  }

  function sec_details(div_token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/sec_details",
          type: 'POST',
          async : true,
          data: { div_token : div_token },
          success:function(response)
            {
              $("#sec_user_val_body").html(response);
            }
      });
  }

  function transfer_sec_details(div_token,token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/transfer_sec_details",
          type: 'POST',
          async : true,
          data: { div_token : div_token, token : token },
          success:function(response)
            {
              $("#transfer_sec_details_"+token).html(response);
            }
      });
  }

  function _transfer_sec_details_(div_token,token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/rplctransfer_sec_details_",
          type: 'POST',
          async : true,
          data: { div_token : div_token, token : token },
          success:function(response)
            {
              $("#_transfer_sec_details_"+token).html(response);
            }
      });
  }

  function edit_sec_details(div_token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/sec_details",
          type: 'POST',
          async : true,
          data: { div_token : div_token },
          success:function(response)
            {
              $("#edit_sec_user_val_body").html(response);
            }
      });
  }

  function edit_sec_details_modal(div_token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_sec_details_modal",
          type: 'POST',
          async : true,
          data: { div_token : div_token },
          success:function(response)
            {
              $("#edit_sec_details_modal_body").html(response);
            }
      });
  }

  function view_account_details(user_id_val) {
    $.ajax({
          url: base_url+"/Admin/User_accounts/view_account_details",
          type: 'POST',
          async : true,
          data: { user_id_val : user_id_val },
          success:function(response)
            {
              $("#view_account_details_body").html(response);
            }

      });
  }

  function user_assignment(secno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/user_assignment",
         type: 'POST',
         async : true,
         data: { secno : secno },
         success:function(response)
           {
             $("#user_assignment_"+secno).html(response);
           }

     });
  }

  function dc_user_assignment(divno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/dc_user_assignment",
         type: 'POST',
         async : true,
         data: { divno : divno },
         success:function(response)
           {
             $("#dc_user_assignment"+divno).html(response);
           }

     });
  }

  function assign_employee(secno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/assign_employee",
         type: 'POST',
         async : true,
         data: { secno : secno },
         success:function(response)
           {
             $("#assign_employee_"+secno).html(response);
           }

     });
  }

  function assign_sc(secno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/assign_sc",
         type: 'POST',
         async : true,
         data: { secno : secno },
         success:function(response)
           {
             $("#sc_assignment_"+secno).html(response);
           }

     });
  }

  function edit_assign_sc(secno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/edit_assign_sc",
         type: 'POST',
         async : true,
         data: { secno : secno },
         success:function(response)
           {
             $("#edit_sc_assignment_"+secno).html(response);
           }

     });
  }

  function edit_details(secno){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/edit_details",
         type: 'POST',
         async : true,
         data: { secno : secno },
         success:function(response)
           {
             $("#edit_details_body").html(response);
           }

     });
  }

  function edit_plantilla_details(planpstn_id){
    $.ajax({
         url: base_url+"/Admin/User_accounts_ajax/edit_plantilla_details",
         type: 'POST',
         async : true,
         data: { planpstn_id : planpstn_id },
         success:function(response)
           {
             $("#edit_plantilla_details_body").html(response);
           }

     });
  }

  function under_sec_employee(secno) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/under_sec_employee",
          type: 'POST',
          async : true,
          data: { secno : secno },
          success:function(response)
            {
              $("#employee_body").html(response);
            }
      });
  }

  function employee_settings_comment(token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/employee_settings_comment",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#employee_settings_comment_body").html(response);
            }
      });
  }

  function emp_action_res(token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/emp_action_res",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#emp-act-res").html(response);
            }
      });
  }

  function notapplicablesecorunit(token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/notapplicablesecorunit",
          type: 'POST',
          async : true,
          data: {  },
          success:function(response)
            {
              $("#notapplicablebody").html(response);
            }
      });
  }

  function rmvsecorunitbtn(token) {
    if(token != ''){
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/rmvsecorunitbtn",
            type: 'POST',
            async : true,
            data: { token : token },
            success:function(response){ alert('Successfully removed.'); window.location.href = base_url+'/Admin/User_accounts/User_list'; }
        });
    }else{
      alert('Please select section or unit to be removed.');
    }

  }

  function rstrbtnntapp(token) {
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/rstrbtnntapp",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              alert('Successfully restored.'); window.location.href = base_url+'/Admin/User_accounts/User_list';
            }
      });
  }

  function edturfnctn(div,token,userid,row){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edturfnctn",
          type: 'POST',
          async : true,
          data: { div : div, token : token, userid : userid, row : row},
          success:function(response)
            {
              $("#edtdtlsfnctnur").html(response);
            }
      });
  }

  function sbmtedtfntn(token,des,div,sec,row){
    if(token != '' && des != '' && div != '' && sec != ''){
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/sbmtedtfntn",
            type: 'POST',
            async : true,
            data: { token : token, des : des, div : div, sec : sec, row : row },
            success:function(response){ alert('Successfully edited.'); window.location.href = base_url+'/Admin/User_accounts/User_list';
           }
        });
    }else{
      alert('All fields are required.');
    }
  }

  function sbmtedtfntnnw(token,des,div,sec){
    if(token != '' && des != '' && div != '' && sec != ''){
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/sbmtedtfntnnw",
            type: 'POST',
            async : true,
            data: { token : token, des : des, div : div, sec : sec },
            success:function(response){ alert('Successfully added.'); window.location.href = base_url+'/Admin/User_accounts/User_list';
           }
        });
    }else{
      alert('All fields are required.');
    }
  }

  function edtrmvdnctn(token){
    var r = confirm("Are you sure to delete this function?");
    if (r == true) {
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/edtrmvdnctn",
            type: 'POST',
            async : true,
            data: { token : token},
            success:function(response){ alert('Successfully removed.'); window.location.href = base_url+'/Admin/User_accounts/User_list';
           }
        });
    }else{
      alert('Cancelled.');
    }
  }

  function mdluptsadmn(){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/mdluptsadmn",
          type: 'POST',
          async : true,
          data: { },
          success:function(response)
            {
              $("#module_updates_administrative_body").html(response);
            }
      });
  }

  function chkhierarchy(token,action){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/chkhierarchy",
          type: 'POST',
          async : true,
          data: { token : token, action : action },
          success:function(response)
            {
              $("#chkhierarchy_body").html(response);
            }
      });
  }

  function chkdfltexstfnc(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/chkdfltexstfnc",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#chkdfltexstfnc_").html(response);
            }
      });
  }

  function chkdfltexstfncundr(token,other_token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/chkdfltexstfncundr",
          type: 'POST',
          async : true,
          data: { token : token, other_token : other_token },
          success:function(response)
            {
              $("#_chkdfltexstfnc").html(response);
            }
      });
  }

  function chkdfltexstfncundrrplc(token,other_token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/chkdfltexstfncundrrplc",
          type: 'POST',
          async : true,
          data: { token : token, other_token : other_token },
          success:function(response)
            {
              $("#_chkdfltexstfnc_").html(response);
            }
      });
  }



  function transhrchyslct(token,val,user){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/transhrchyslct",
          type: 'POST',
          async : true,
          data: { token : token, val : val, user : user },
          success:function(response)
            {
              if(val != ''){
                $("#rowsrslt_").html(response);
              }else{
                $("#dlfthrchy_").html(response);
              }
            }
      });
  }

  function transhrchyslct_(token,val,user){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/transhrchyslct_",
          type: 'POST',
          async : true,
          data: { token : token, val : val, user : user },
          success:function(response)
            {
              if(val != ''){
                $("#_rowsrslt_").html(response);
              }else{
                $("#_dlfthrchy_").html(response);
              }
            }
      });
  }

  function undothierchy(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/undothierchy",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#dlfthrchy_").html(response);
            }
      });
  }

  function undothierchy_(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/undothierchy_",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#_dlfthrchy_").html(response);
            }
      });
  }

  function undrprsnnlt(dflt,rplcmnt,val){
      $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/undrprsnnlt",
          type: 'POST',
          async : true,
          data: { dflt : dflt, rplcmnt : rplcmnt, val : val },
          success:function(response)
            {
              $("#undrprsnnlt_").html(response);
            }
      });
  }

  function rmvusrbtnusrlst(token){
    var r = confirm("Are you sure to remove this user?");
    if (r == true) {
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/rmvusrbtnusrlst",
            type: 'POST',
            async : true,
            data: { token : token},
            success:function(response){
              var obj = JSON.parse(response);
              if(obj.status == 'success'){
                swalalert('SUCCESS!','User successfully removed.','success');
                $('#user_accounts_table').DataTable().ajax.reload();
              }
              if(obj.status == 'failed'){
                swalalert('ERROR!','Action failed.','error');
              }
           }
        });
    }else{
      swalalert('ERROR!','Cancelled.','error');
    }
  }


  function trmsusrsdm(){
    $.ajax({
        url: base_url+"/Admin/Ajax_trans/trmsusrsdm",
        type: 'POST',
        async : true,
        data: { },
        success:function(response)
          {
            $("#trmsusrsdm_").html(response);
          }
    });
  }

  function trnorws(token, nr){
    $.ajax({
        url: base_url+"/Admin/Ajax_trans/trnorws",
        type: 'POST',
        async : true,
        data: { token : token, nr : nr },
        success:function(response)
          {
            $("#trnorws_").html(response);
          }
    });
  }



  //TRAVEL ORDER

  function travel_destination_option(_this, val) {
    $.ajax({
          url: base_url+"/Travel/Order/process_travel",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $(_this).closest('tr').find('#notacompanybody').html(response);
            }
      });
  }

  function process_travel(token) {
    $.ajax({
          url: base_url+"/Travel/Order/process_travel",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#travel-order-modal").html(response);
            }
      });
  }

  function disapprove(token) {
    $.ajax({
          url: base_url+"/Travel/Order/disapprove_travel",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#travel-order-modal").html(response);
            }
      });
  }

  function notinthelist(_this, value, row){
    if(value == "ifnotinthelist"){
      $.ajax({
          url: base_url+"/Travel/Order/notinthelist",
          type: 'POST',
          async : true,
          data: { value : value, row : row},
          success:function(response)
            {
              $(_this).closest('tr').find('#ifnotinthelistbody').html(response);
            }
      });
    }else{

    }

  }

  function notinthelist2(_this, value, row){
    if(value == "ifnotinthelist"){
      $.ajax({
          url: base_url+"/Travel/Order/notinthelist2",
          type: 'POST',
          async : true,
          data: { value : value, row : row},
          success:function(response)
            {
              $(_this).closest('tr').find('#ifnotinthelistbody').html(response);
            }
      });
    }else{

    }

  }

  function return_destination_dropdown(_this,row,travelcat){
    $.ajax({
          url: base_url+"/Travel/Order/return_destination_dropdown",
          type: 'POST',
          async : true,
          data: { row : row, travelcat : travelcat },
          success:function(response)
            {
              $(_this).closest('tr').find('#ifnotinthelistbody').html(response);
            }
      });
  }

  function return_destination_dropdown2(_this,row,travelcat,rand){
    $.ajax({
          url: base_url+"/Travel/Order/return_destination_dropdown2",
          type: 'POST',
          async : true,
          data: { row : row, travelcat : travelcat, rand : rand },
          success:function(response)
            {
              $(_this).closest('tr').find('#ifnotinthelistbody').html(response);
            }
      });
  }

  function coordinates_lat(_this, value){
    if(value != "ifnotinthelist"){
      $.ajax({
            url: base_url+"/Travel/Order/coordinates_lat",
            type: 'POST',
            async : true,
            data: { value : value },
            success:function(response)
              {
                $(_this).closest('tr').find('#latitude').html(response);
              }
        });
    }
  }


  function coordinates_lon(_this, value){
    if(value != "ifnotinthelist"){
      $.ajax({
            url: base_url+"/Travel/Order/coordinates_lon",
            type: 'POST',
            async : true,
            data: { value : value },
            success:function(response)
              {
                $(_this).closest('tr').find('#longitude').html(response);
              }
        });
    }
  }

  function input_coordinates_lat(_this, value){
    $.ajax({
          url: base_url+"/Travel/Order/coordinates_lat_input",
          type: 'POST',
          async : true,
          data: { value : value },
          success:function(response)
            {
              $(_this).closest('tr').find('#latitude').html(response);
            }
      });
  }


  function input_coordinates_lon(_this, value){
    $.ajax({
          url: base_url+"/Travel/Order/coordinates_lon_input",
          type: 'POST',
          async : true,
          data: { value : value },
          success:function(response)
            {
              $(_this).closest('tr').find('#longitude').html(response);
            }
      });
  }

  function add_row_destination(value, travelcat){
    $.ajax({
          url: base_url+"/Travel/Order/add_row_destination",
          type: 'POST',
          async : true,
          data: { value : value, travelcat : travelcat },
          success:function(response)
            {
              $('#add_row_destination_body').html(response);
            }
      });
  }

  function view_travel(token) {
    $.ajax({
          url: base_url+"/Travel/Order/view_travel",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#view_travel_body").html(response);
            }
      });
  }

  function ticket_travel(token) {
    $.ajax({
          url: base_url+"/Travel/Order/ticket_travel",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#ticket_travel_body").html(response);
            }
      });
  }

  function calendar_details_dashboard(token){
    $.ajax({
          url: base_url+"/Travel/Order/calendar_details",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#travel-order-modal-details").html(response);
            }
      });
  }

  function traveltype(type){
    $.ajax({
          url: base_url+"/Travel/Order/traveltype",
          type: 'POST',
          async : true,
          data: { type : type },
          success:function(response)
            {
              $("#traveltypebody").html(response);
            }
      });
  }

  function view_trans_travel_details(token){
    $.ajax({
          url: base_url+"/Travel/Order/view_trans_travel_details",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#view_alltrans_travel_details_body").html(response);
            }
      });
  }

  function notinlist_labor(token){

    if(token == 'ifnotinlist_labor'){
      $.ajax({
          url: base_url+"/Travel/Order/notinlist_labor",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#notinlist_labor_body").html(response);
            }
      });
    }

  }

  function return_laborers_dropdown(token){

    $.ajax({
        url: base_url+"/Travel/Order/return_laborers_dropdown",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response)
          {
            $("#notinlist_labor_body").html(response);
          }
    });

  }

  // function travel_date_validation(departure_date, arrival_date){
  //   var depdate = moment(departure_date, 'YYYY-MM-DD',true).isValid();
  //   var arrdate = moment(arrival_date, 'YYYY-MM-DD',true).isValid();
  //
  //   if(depdate == true && arrdate == true){
  //     if(departure_date <= arrival_date){
  //       document.getElementById("Process").disabled = false;
  //       document.getElementById("error_message").innerHTML = "";
  //     }else{
  //       document.getElementById("error_message").innerHTML = "*Arrival date should be greater or equal to Departure date*";
  //       document.getElementById("Process").disabled = true;
  //     }
  //   }else{
  //     console.log('Incorrect date format');
  //   }
  //
  // }

  function checkdate(token){
    $.ajax({
        url: base_url+"/Travel/Order/checkdate",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response)
        {
          var obj = JSON.parse(response);
          if(obj.status == 'failed'){
            alert('Selected departure date is invalid. Please select again.')
            document.getElementById("Process").disabled = true;
          }
          if(obj.status == 'success'){
            $('#Process').removeAttr('disabled');
          }
        }
    });
  }

  function add_travel_report(token) {
    $.ajax({
          url: base_url+"/Travel/Order/add_travel_report",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#add_travel_report_body").html(response);
            }
      });
  }

  function trvlrprtattchmnt(token,div,route_order) {
    $.ajax({
          url: base_url+"/Travel/Order/trvlrprtattchmnt",
          type: 'POST',
          async : true,
          data: { token : token, route_order : route_order },
          success:function(response)
            {
              $("#trvlrprtattchmntbody"+div).html(response);
            }
      });
  }

  function receive_transaction_travel(_this, trans_no){
    var rcv = 1;
    var request = $.ajax({
       url: base_url + '/Dms/Dms/receive_transaction',
       method: 'POST',
       data: { trans_no : trans_no },
       dataType: 'json',
       beforeSend: function(jqXHR, settings){
         _this.html('<span class="text">Please Wait...</span>').attr('disabled','disabled');
       }
    });

    request.done(function(data) {
      if (data.error == 1) {
        $('#save_draft_button').val('Save Status').removeAttr('disabled');
      }
    });

    request.fail(function(jqXHR, textStatus) {
      rcv = 0;
      alert( "Request failed: " + textStatus );
    });

    return rcv;
  }

  function touploadattachments(token){
    var form_data = new FormData();

    // Read selected files
    var totalfiles = document.getElementById('supporting_docs').files.length;
    for (var index = 0; index < totalfiles; index++) {
      form_data.append("supporting_docs[]", document.getElementById('supporting_docs').files[index]);
    }
    form_data.append("token", token);

    document.getElementById("tosupdocs").style.display = 'block';
    // AJAX request
    $.ajax({
     url: base_url+'/Travel/Order/touploadattachments',
     type: 'post',
     data: form_data,
     dataType: 'json',
     xhr: function() {
            var sendfilesXHR = $.ajaxSettings.xhr();
            if(sendfilesXHR.upload){
                sendfilesXHR.upload.addEventListener('progress',tosupprogress, false);
            }
            return sendfilesXHR;
    },
     cache: false,
     contentType: false,
     processData: false,
     success: function (response) {
       if(response.status == 'success'){
         alert('Attached file/s successfully uploaded.');
         document.getElementById("viewtouploadedfilesbtn").style.display = 'block';
         document.getElementById("supporting_docs").value = "";
       }if(response.status == 'failed'){
         alert('Attached file/s failed to upload. Please try again.');
       }
       document.getElementById("tosupdocs").style.display = 'none';
     }
    });
  }

  function tosupprogress(e){
      if(e.lengthComputable){
          var max = e.total;
          var current = e.loaded;

          var Percentage = (current * 100)/max;
          document.getElementById("tosupdocsuploadprogressbar_").style.width = Math.round(Percentage)+"%";
          var percent = document.getElementById("tosupdocsprogresspercentage_");
          percent.innerHTML = Math.round(Percentage)+"%";

          if(Percentage >= 100){ }
      }
 }

 function viewtouploadedfiles(token){
   $.ajax({
         url: base_url+"/Travel/Order/viewtouploadedfiles",
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response)
           {
             $("#viewtouploadedfiles_").html(response);
           }
     });
 }

 function removeuploadedto(token, filename, cnt){
   $.ajax({
         url: base_url+"/Travel/Order/removeuploadedto",
         type: 'POST',
         async : true,
         data: { token : token, filename : filename, cnt : cnt },
         success:function(response)
           {
             var obj = JSON.parse(response);
             if(obj.status == 'success'){
               alert('File selected successfully delete.');
               viewtouploadedfiles(obj.token);
             }
           }
     });
 }

 function stcmpvw(token){
   $.ajax({
         url: base_url+"/Travel/Order/stcmpvw",
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response)
           {
             $('#ifnotinthelistbody').html(response);
           }
     });
 }

 function view_travel_format(token){
   $.ajax({
         url: base_url+"/Travel/Order/view_travel_format",
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response)
           {
             $('#view_format_mdl_').html(response);
           }
     });
 }

  //Administrator

  function admin_change_region(val,ofc,opt){

    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/admin_change_region",
          type: 'POST',
          async : true,
          data: { val : val, ofc : ofc },
          success:function(response)
            {
              if(opt == '1'){ window.location= base_url+"/Admin/User_accounts/User_list"; }
              if(opt == '2'){ window.location= base_url+"/Admin/Uploads"; }

            }

      });


  }

  function edit_user_accounts_modal(userid){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_user_accounts_modal",
          type: 'POST',
          async : true,
          data: { userid : userid },
          success:function(response)
            {
              $("#edit_user_accounts_modal_body").html(response);
            }
      });
  }

  function edit_user_accounts_details_modal(userid){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_user_accounts_details_modal",
          type: 'POST',
          async : true,
          data: { userid : userid },
          success:function(response)
            {
              $("#edit_user_accounts_details_modal_body").html(response);
            }
      });
  }

  function view_user_accounts_modal(userid){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/view_user_accounts_modal",
          type: 'POST',
          async : true,
          data: { userid : userid },
          success:function(response)
            {
              $("#view_user_accounts_modal_body").html(response);
            }
      });
  }

  function delete_line_of_authority(description){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/delete_line_of_authority_token",
          type: 'POST',
          async : true,
          data: { description : description },
          success:function(response)
            {
              $("#delete_line_of_authority_body").html(response);
            }
      });
  }

  function edit_line_of_authority(description){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_line_of_authority_token",
          type: 'POST',
          async : true,
          data: { description : description },
          success:function(response)
            {
              $("#edit_line_of_authority_body").html(response);
            }
      });
  }

  function view_line_of_authority(description){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/view_line_of_authority_token",
          type: 'POST',
          async : true,
          data: { description : description },
          success:function(response)
            {
              $("#view_line_of_authority_body").html(response);
            }
      });
  }

  function edit_account_modal_dtls(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/edit_account_modal_dtls",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
            {
              $("#edit_account_modal_body").html(response);
            }
      });
  }

  function resetpassword(token){

    var r = confirm("Are you sure you want to reset this account?");
    if (r == true) {
      alert('Reset successfully.');
      $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/resetpassword",
            type: 'POST',
            async : true,
            data: { token : token},
            success:function(response){ }
      });
    } else {
      alert('Cancelled.');
    }

    var account_credentials = $('#account_credentials').DataTable();
    account_credentials.ajax.reload( null, false );
  }

  function encryptpassword(usertoken,token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/encryptpassword",
          type: 'POST',
          async : true,
          data: { usertoken : usertoken , token : token},
          success:function(response){
            var account_credentials = $('#account_credentials').DataTable();
            account_credentials.ajax.reload( null, false );
          }
    });
  }

  function changeview(token){
    $.ajax({
            url: base_url+"/Admin/User_accounts_ajax/changeview",
            type: 'POST',
            async : true,
            data: { token : token},
            success:function(response){ location.reload(); }
      });
  }

  function edithierarchy(token){
    $.ajax({
        url: base_url+"/Admin/User_accounts_ajax/edithierarchy",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#edithierarchy_body").html(response); }
    });
  }

  function Remove_esig_btn(token){
    $.ajax({
        url: base_url+"/Admin/Uploads_ajax/remove_esig_info",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#Remove_esig_div").html(response); }
    });
  }

  function edit_esig_btn(token){
    $.ajax({
        url: base_url+"/Admin/Uploads_ajax/edit_esig",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#edit_esig_div").html(response); }
    });
  }

  function usavedata(){

    var form_data = new FormData($('#uoptionsform')[0]);

    $.ajax({
        url: base_url+"/Admin/Uploads_ajax/usavedata",
        type: 'POST',
        async : true,
        data: form_data,
        contentType: false,
        processData: false,
        success:function(response){
          var obj = JSON.parse(response);
          if(obj.status == 'success'){
            alert('Signature positioning successfully updated.');
          }
          if(obj.status == 'failed'){
            alert('Update failed.');
          }
        }
    });
  }

  function check_hierarchy_name(token){
    $.ajax({
        url: base_url+"/Admin/Post_ajax/check_hierarchy_name",
        method: 'POST',
        data: { token: token },
        dataType: 'json',
        success:function(data){
          console.log(data);
          if(token != ''){
            if(data == false){
              $('#hierarchy_save_btn').prop("disabled", false);
                $('#error_msg_hierarchy').html('<i style="color:green;">(Description provided is unique.)</i>');
            }else{
              $('#hierarchy_save_btn').prop("disabled", true);
              $('#error_msg_hierarchy').html('<i style="color:red;">(Description provided is already taken.)</i>');
            }
          }else{
              $('#error_msg_hierarchy').html('');
          }

          // if(data[0]['rule_name'] != '')
        }
    });
  }



  //Notification

  $(document).ready(function() {
    // console.log(base_url);
    $.ajax({
       url: base_url+"/Notification/bilangin_ang_abiso",
       type: 'POST',
       async : true,
       data: { value : "tr" },
       success:function(response){
         var obj = JSON.parse(response);
         console.log(obj);
         var varmsc = (obj.msc > 0) ? obj.msc : 0;
         $("#msc_").html(varmsc);
         var varrtc = (obj.rtc > 0) ? obj.rtc : 0;
         $("#rtc_").html(varrtc);
         $("#rtc2_").html(varrtc);
         var varcrc = (obj.crc > 0) ? obj.crc : 0;
         $("#crc_").html(varcrc);
         $("#crc2_").html(varcrc);
         var vartoc = (obj.toc > 0) ? obj.toc : 0;
         $("#toc_").html(vartoc);
         var vartofa = (obj.tofa > 0) ? obj.tofa : 0;
         $("#tofa_").html(vartofa);
         var vartot = (obj.tot > 0) ? obj.tot : 0;
         $("#tot_").html(vartot);
         var varsfc = (obj.sfc > 0) ? obj.sfc : 0;
         $("#sfc_").html(varsfc);

         var varspc = (obj.spc > 0) ? obj.spc : 0;
         $(".spc_").html(varspc);
        }
    });

    // window.setInterval(function(){
    //   $.ajax({
    //       url: base_url+"/notification",
    //       type: 'POST',
    //       async : true,
    //       data: { value : "tr" },
    //       success:function(response){ $("#ticket_request_notif").html(response); }
    //   });
    // }, 5000);

  });

  //ADMIN RIGHTS

  function acc_rights(token,column,userid){
    var r = confirm("Are you sure to update this account?");
    if (r == true) {
      alert('Account successfully updated.');
      $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/acc_rights",
          type: 'POST',
          async : true,
          data: { token : token , column : column , userid : userid },
          success:function(response){ }
      });
    } else {
      alert('Cancelled.');
    }
  }

  function administrative_tab(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/administrative_tab",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ }
      });
  }

  function loginas(token){
    $.ajax({
          url: base_url+"/Admin/User_accounts_ajax/loginas",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response)
          {
            window.location.href = base_url+'/index/dashboard';
          }
      });
  }

  //Sweet Report

    function sw_process_report(token){
      $.ajax({
         url:  base_url+"/Swm/Sweet_ajax/process_details",
         method: 'POST',
         data: { trans_no : token },
         success: function(response) {
           $("#process_sweetreport_modal").html(response);
         }
      });
    }

    function sw_lgu_patrolled(token){
      $.ajax({
          url: base_url+"/Swm/Sweet_ajax/sw_barangay",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#sw_barangay_div").html(response); }
      });
    }

    function sw_others(token){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/sw_others",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#sw_others_div").html(response); }
        });

    }

    function swtom(token, dt_ptrl, rn, dt_ft, trans_no){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/swtom",
          type: 'POST',
          async : true,
          data: { token : token, dt_ptrl : dt_ptrl, rn : rn, dt_ft : dt_ft , trans_no : trans_no },
          success:function(response){ $("#swtom_div").html(response); }
        });

    }

    function swupdate_report(token, rn){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/swupdate_report",
          type: 'POST',
          async : true,
          data: { token : token, rn : rn },
          success:function(response){ $("#update_sw_report_body").html(response); }
        });

    }

    function lgufeedbackbtn(token){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/lgufeedbackbtn",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#lgufeedbackmodal_").html(response); chkfeedbacks(); }
        });

    }

    function chkfeedbacks(){
      $.ajax({
          url: base_url+"/Swm/Sweet_ajax/chklgufeedbacks",
          type: 'POST',
          async : true,
          data: { },
          success:function(response){
            $('#chklgufeedbacks_').html(response);
          }
        });
    }

    function view_sw_history(token){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/view_sw_history",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#view_sw_history_body").html(response); }
        });

    }

    function returnsw(token, rn){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/returnsw",
          type: 'POST',
          async : true,
          data: { token : token, rn : rn },
          success:function(response){ $("#disapproval-reason").html(response); }
        });

    }

    function swedit_report(token,cat){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/swedit_report",
          type: 'POST',
          async : true,
          data: { token : token, cat : cat },
          success:function(response){ $("#edit_report_body").html(response); }
        });
    }

    function swedit_report_evaluator(token){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/swedit_report_evaluator",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#edit_report_body").html(response); }
        });
    }

    function enable_upload_btn(token, reportdate, reportnumber){
      var htmldata = '<input type="file" class="form-control" name="edit_site_photo[]" id="edit_site_photo" accept="image/*">'+
                     '<button type="button" style="width: 135px; margin-left: 10px;" class="btn btn-success btn-sm" onclick=editswuploadphoto("'+token+'","'+reportdate+'","'+reportnumber+'");>'+
                      '<span class="fa fa-upload"></span>&nbsp;Upload photo'+
                     '</button>'+
                     '<button type="button" onclick=cancel_swupload("'+token+'","'+reportdate+'","'+reportnumber+'"); style="width: 135px; margin-left: 10px;" class="btn btn-danger btn-sm">'+
                      '<span class="fa fa-ban"></span>&nbsp;Cancel'+
                     '</button>';
      $('#sitephotobtns_').html(htmldata);
    }

    function cancel_swupload(token, reportdate, reportnumber){
      var htmldata = '<input type="file" class="form-control" disabled>'+
                     '<button type="button" onclick=enable_upload_btn("'+token+'","'+reportdate+'","'+reportnumber+'"); style="width: 135px; margin-left: 10px;" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span>&nbsp;Edit Attachment</button>';
      $('#sitephotobtns_').html(htmldata);
    }

    function editswuploadphoto(token,reportdate,reportnumber){
      var form_data = new FormData();

      // Read selected files
      var totalfiles = document.getElementById('edit_site_photo').files.length;
      for (var index = 0; index < totalfiles; index++) {
        form_data.append("edit_site_photo[]", document.getElementById('edit_site_photo').files[index]);
      }
      form_data.append("token", token);
      form_data.append("reportdate", reportdate);
      form_data.append("reportnumber", reportnumber);

      document.getElementById("sweditsitephoto_").style.display = 'block';
      // AJAX request
      $.ajax({
       url: base_url+'/Swm/Sweet_ajax/editswuploadphoto',
       type: 'post',
       data: form_data,
       dataType: 'json',
       xhr: function() {
              var sendfilesXHR = $.ajaxSettings.xhr();
              if(sendfilesXHR.upload){
                  sendfilesXHR.upload.addEventListener('progress',editswuserphotoprogress, false);
              }
              return sendfilesXHR;
      },
       cache: false,
       contentType: false,
       processData: false,
       success: function (response) {
         if(response.status == 'uploaded'){
           alert('Photo successfully uploaded.');
           var htmldata = '<input type="file" class="form-control" disabled>'+
                          '<button type="button" onclick=enable_upload_btn("'+response.token+'","'+response.reportdate+'","'+response.reportnumber+'"); style="width: 135px; margin-left: 10px;" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span>&nbsp;Edit Attachment</button>';
           $('#sitephotobtns_').html(htmldata);
         }else if(response.status == 'failed'){
           alert('File uploaded is not an image. Please retry.');
         }else if(response.status == 'empty'){
           alert('Please attach photo.');
         }
         document.getElementById("sweditsitephoto_").style.display = 'none';
       }
      });
    }

    function editswuserphotoprogress(e){
        if(e.lengthComputable){
            var max = e.total;
            var current = e.loaded;

            var Percentage = (current * 100)/max;
            document.getElementById("sweditsitephotouploadprogressbar_").style.width = Math.round(Percentage)+"%";
            var percent = document.getElementById("sweditsitephotoprogresspercentage_");
            percent.innerHTML = Math.round(Percentage)+"%";

            if(Percentage >= 100){ }
        }
   }

   function viewattachmentbtn(token){
       $.ajax({
         url: base_url+"/Swm/Sweet_ajax/viewattachmentbtn",
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response){ $("#previously_attached_body").html(response); }
       });
   }

   function prevviewattachmentbtn(token, reportnumber){
       $.ajax({
         url: base_url+"/Swm/Sweet_ajax/prevviewattachmentbtn",
         type: 'POST',
         async : true,
         data: { token : token, reportnumber : reportnumber },
         success:function(response){ $("#prevviewattachmentbtn_").html(response); }
       });
   }

    function filter_by_select(filter_by){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/filter_by_select",
          type: 'POST',
          async : true,
          data: { filter_by : filter_by },
          success:function(response){ $("#filter-by-body").html(response); }
        });
    }

    function assignsweet(){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/assignsweet",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){ $("#assignsweetbdy").html(response); }
      });
    }

    function swaddtemplate(){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/swaddtemplate",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){ $("#assignsweetbdy").html(response); }
      });
    }

    function swassignlgutouser(){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/swassignlgutouser",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){ $("#assignsweetbdy").html(response); }
      });
    }

    function swsavelgudata(){
      var swofficer = $('#sweetofficersselectize').val();
      var swlgu  = $('#sweetlguselectize').val();
      $.ajax({
        url: base_url+"/Swm/Sweet_postactions/swsavelgudata",
        type: 'POST',
        async : true,
        data: { swofficer : swofficer, swlgu : swlgu },
        success:function(response){
          var obj = JSON.parse(response);
          if(obj.status == 'success'){
            alert('LGU/s successfully assigned to SWEET Officer.');
            var table_gu_monitored = $('#sweet_lgu_monitored').DataTable();
            table_gu_monitored.ajax.reload( null, false );
          }else{
            alert('Error! Please try again.');
          }
        }
      });
    }

    function rmvassignedlgu(cnt){
      var r = confirm("Are you sure to remove this assignment?");
      if(r == true){
        $.ajax({
          url: base_url+"/Swm/Sweet_postactions/rmvassignedlgu",
          type: 'POST',
          async : true,
          data: { cnt : cnt},
          success:function(response){
            var obj = JSON.parse(response);
            if(obj.status == 'success'){
              alert('Assignment successfully removed.')
              var table_gu_monitored = $('#sweet_lgu_monitored').DataTable();
              table_gu_monitored.ajax.reload( null, false );
            }else{
              alert('Error! Please try again.');
            }
          }
        });
      }else{
        alert('Cancelled.');
      }

    }


    function assignswuser(){

      var token = $('#casehandlers_selectize_settings').val();
      var func  = $('#swfnc_selectize').val();
      if(token != '' && func != ''){
        $.ajax({
          url: base_url+"/Swm/Sweet_postactions/assignswuser",
          type: 'POST',
          async : true,
          data: { token : token, func : func },
          success:function(response){
            alert('Successfully assigned.');
            $("#assignsweetbdy").html(response);
            var table_settings_index = $('#sweet_settings_index').DataTable();
            table_settings_index.ajax.reload( null, false );
          }
        });
      }else{
        alert('Please fill required fields.');
      }
    }

    function assigntemplatesw(){

      var hname = $('#hname').val();
      var token = $("[name='usertoken[]']")
                .map(function(){return $(this).val();}).get();

      if(token != '' && hname != ''){
        $.ajax({
          url: base_url+"/Swm/Sweet_postactions/assigntemplatesw",
          type: 'POST',
          async : true,
          data: { token : token, hname : hname},
          success:function(result){
            if(result != ''){
              alert(result+' - hierarchy name already exist.');
            }else{
              alert('Successfully assigned.');
              $("#assignsweetbdy").html(result);
            }
            var sweet_settings_templates = $('#sweet_settings_templates').DataTable();
            sweet_settings_templates.ajax.reload( null, false );
          }
        });
      }else{
        alert('Please fill required fields.');
      }
    }

    function no_of_rows_sw(norows){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/no_of_rows_sw",
        type: 'POST',
        async : true,
        data: { norows : norows },
        success:function(response){ $("#result_sw_bdy_template").html(response); }
      });
    }

    function functemplatesw(token){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/functemplatesw",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#result_sw_bdy").html(response); }
      });
    }

    function rmvassngmntsw(token){
      var r = confirm("Are you sure to remove this assignment?");
      if(r == true){
        $.ajax({
          url: base_url+"/Swm/Sweet_postactions/rmvassngmntsw",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){
            alert('Successfully removed.');
            var table_settings_index = $('#sweet_settings_index').DataTable();
            table_settings_index.ajax.reload( null, false );
          }
        });
      }else{
        alert('Cancelled.');
      }
    }

    function rmvtemplatesw(token){
      var r = confirm("Are you sure to remove this template?");
      if(r == true){
        $.ajax({
          url: base_url+"/Swm/Sweet_postactions/rmvtemplatesw",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){
            alert('Successfully removed.');
            var sweet_settings_templates = $('#sweet_settings_templates').DataTable();
            sweet_settings_templates.ajax.reload( null, false );
          }
        });
      }else{
        alert('Cancelled.');
      }

    }

    function fnldspsl(token){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/fnldspsl",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#fnldspsl_bdy").html(response); }
      });
    }

    function fdsw_(token){
      if(token == 'Others'){
        $.ajax({
          url: base_url+"/Swm/Sweet_ajax/fdsw_",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){ $("#fdsw_bdy").html(response); }
        });
      }
    }

    function rtrntolistsw(){
      $.ajax({
        url: base_url+"/Swm/Sweet_ajax/rtrntolistsw",
        type: 'POST',
        async : true,
        data: { },
        success:function(response){ $("#fdsw_bdy").html(response); }
      });
    }

    function swuploadphoto(token){
      var form_data = new FormData();

      // Read selected files
      var totalfiles = document.getElementById('site_photo').files.length;
      for (var index = 0; index < totalfiles; index++) {
        form_data.append("site_photo[]", document.getElementById('site_photo').files[index]);
      }
      form_data.append("token", token);

      document.getElementById("swsitephoto_").style.display = 'block';
      // AJAX request
      $.ajax({
       url: base_url+'/Swm/Sweet_ajax/swuploadphoto',
       type: 'post',
       data: form_data,
       dataType: 'json',
       xhr: function() {
              var sendfilesXHR = $.ajaxSettings.xhr();
              if(sendfilesXHR.upload){
                  sendfilesXHR.upload.addEventListener('progress',swuserphotoprogress, false);
              }
              return sendfilesXHR;
      },
       cache: false,
       contentType: false,
       processData: false,
       success: function (response) {
         if(response.status == 'uploaded'){
           alert('Photo successfully uploaded.');
           var htmldata = '<a href="'+response.image_uploaded+'" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>'+
                          '<button type="button" style="width: 135px; margin-left: 10px;" onclick=swchangephoto("'+response.token+'","'+response.image_uploaded+'"); class="btn btn-warning btn-sm">'+
                               '<span class="fa fa-edit"></span>&nbsp;Change photo'+
                          '</button>';
            $('#swdvphotoattachment_').html(htmldata);
         }else if(response.status == 'failed'){
           alert('File uploaded is not an image. Please retry.');
         }else if(response.status == 'empty'){
           alert('Please attach photo.');
         }
         document.getElementById("swsitephoto_").style.display = 'none';
       }
      });
    }

    function swuserphotoprogress(e){
        if(e.lengthComputable){
            var max = e.total;
            var current = e.loaded;

            var Percentage = (current * 100)/max;
            document.getElementById("swsitephotouploadprogressbar_").style.width = Math.round(Percentage)+"%";
            var percent = document.getElementById("swsitephotoprogresspercentage_");
            percent.innerHTML = Math.round(Percentage)+"%";

            if(Percentage >= 100){ }
        }
   }

   function swchangephoto(token, img){
     var htmldata = '<input class="form-control" type="file" name="site_photo[]" id="site_photo" accept="image/*"/>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=swuploadphoto("'+token+'"); class="btn btn-success btn-sm">'+
                       '<span class="fa fa-upload"></span>&nbsp;Upload Photo'+
                    '</button>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=swucancelaction("'+token+'","'+img+'"); class="btn btn-danger btn-sm">'+
                       '<span class="fa fa-ban"></span>&nbsp;Cancel'+
                    '</button>';
    $('#swdvphotoattachment_').html(htmldata);
   }

   function swucancelaction(token, img){
     var htmldata = '<a href="'+img+'" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=swchangephoto("'+token+'","'+img+'"); class="btn btn-warning btn-sm">'+
                         '<span class="fa fa-edit"></span>&nbsp;Change photo'+
                    '</button>';
      $('#swdvphotoattachment_').html(htmldata);
   }

   function updtswuploadphoto(token, datecreated, reportnumber){
     var form_data = new FormData();

     // Read selected files
     var totalfiles = document.getElementById('updtsite_photo').files.length;
     for (var index = 0; index < totalfiles; index++) {
       form_data.append("updtsite_photo[]", document.getElementById('updtsite_photo').files[index]);
     }
     form_data.append("token", token);
     form_data.append("datecreated", datecreated);
     form_data.append("reportnumber", reportnumber);

     document.getElementById("updtswsitephoto_").style.display = 'block';
     // AJAX request
     $.ajax({
      url: base_url+'/Swm/Sweet_ajax/updtswuploadphoto',
      type: 'post',
      data: form_data,
      dataType: 'json',
      xhr: function() {
             var sendfilesXHR = $.ajaxSettings.xhr();
             if(sendfilesXHR.upload){
                 sendfilesXHR.upload.addEventListener('progress',uptswuserphotoprogress, false);
             }
             return sendfilesXHR;
     },
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        if(response.status == 'uploaded'){
          alert('Photo successfully uploaded.');
          var htmldata = '<a href="'+response.image_uploaded+'" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>'+
                         '<button type="button" style="width: 135px; margin-left: 10px;" onclick=updtswchangephoto("'+response.token+'","'+response.datecreated+'","'+response.reportnumber+'","'+response.image_uploaded+'"); class="btn btn-warning btn-sm">'+
                              '<span class="fa fa-edit"></span>&nbsp;Change photo'+
                         '</button>';
           $('#updtswdvphotoattachment_').html(htmldata);
        }else if(response.status == 'failed'){
          alert('File uploaded is not an image. Please retry.');
        }else if(response.status == 'empty'){
          alert('Please attach photo.');
        }
        document.getElementById("updtswsitephoto_").style.display = 'none';
      }
     });
   }

   function updtswchangephoto(token, datecreated, reportnumber, img){
     var htmldata = '<input class="form-control" type="file" name="updtsite_photo[]" id="updtsite_photo" accept="image/*"/>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=updtswuploadphoto("'+token+'","'+datecreated+'","'+reportnumber+'"); class="btn btn-success btn-sm">'+
                       '<span class="fa fa-upload"></span>&nbsp;Upload Photo'+
                    '</button>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=updtswucancelaction("'+token+'","'+datecreated+'","'+reportnumber+'","'+img+'"); class="btn btn-danger btn-sm">'+
                       '<span class="fa fa-ban"></span>&nbsp;Cancel'+
                    '</button>';
    $('#updtswdvphotoattachment_').html(htmldata);
   }

   function updtswucancelaction(token, datecreated, reportnumber, img){
     var htmldata = '<a href="'+img+'" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>'+
                    '<button type="button" style="width: 135px; margin-left: 10px;" onclick=updtswchangephoto("'+token+'","'+datecreated+'","'+reportnumber+'","'+img+'"); class="btn btn-warning btn-sm">'+
                         '<span class="fa fa-edit"></span>&nbsp;Change photo'+
                    '</button>';
    $('#updtswdvphotoattachment_').html(htmldata);
   }

   function uptswuserphotoprogress(e){
       if(e.lengthComputable){
           var max = e.total;
           var current = e.loaded;

           var Percentage = (current * 100)/max;
           document.getElementById("updtswsitephotouploadprogressbar_").style.width = Math.round(Percentage)+"%";
           var percent = document.getElementById("updtswsitephotoprogresspercentage_");
           percent.innerHTML = Math.round(Percentage)+"%";

           if(Percentage >= 100){ }
       }
  }

  function uactivetab(tabnumber){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/uactivetab",
      type: 'POST',
      async : true,
      data: { tabnumber : tabnumber },
      success:function(response){ }
    });
  }

  function chkcoordinatessw(lat, long){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/chkcoordinatessw",
      type: 'POST',
      async : true,
      data: { lat : lat, long : long },
      success:function(response){ $('#chkcoordinatessw_').html(response); }
    });
  }

  function divnovprcs(stat, tkn){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/divnovprcs",
      type: 'POST',
      async : true,
      data: { stat : stat, tkn : tkn },
      success:function(response){ $('#divnovprcs_').html(response); }
    });
  }

  function removenov(cnt){
    $.ajax({
      url: base_url+"/Swm/Sweet/removenov",
      type: 'POST',
      async : true,
      data: { cnt : cnt },
      success:function(response){ $('#removenov_').html(response); }
    });
  }

  function swmnoto(noto){
    $.ajax({
      url: base_url+"/Swm/Sweet/swmnoto",
      type: 'POST',
      async : true,
      data: { noto : noto },
      success:function(response){ $('#swmnoto_').html(response); }
    });
  }

  function viewgeocamphotos(token){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/viewgeocamphotos",
      type: 'POST',
      async : true,
      data: { token : token},
      success:function(response){
        $('#viewgeocamphotos_').html(response);
      }
    });
  }

  function filterswmall(token){
    if(token != ''){
      window.location.href = base_url+"/swm/reports?rfilter="+token;
    }
  }

  function editnovltr(token, reportnumber){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/editnovltr",
      type: 'POST',
      async : true,
      data: { token : token, reportnumber : reportnumber},
      success:function(response){
        $('#edit_nov_letter_body').html(response);
      }
    });
  }

  function editnovletterbutton(token, rn, px, fn, mi, ln, sx, dn, mc, wr, em, ci, ld, route){
    $.ajax({
      url: base_url+"/Swm/Sweet_ajax/editnovletterbutton",
      type: 'POST',
      async : true,
      data: { token : token, rn : rn, px : px, fn : fn, mi : mi, ln : ln, sx : sx, dn : dn, mc : mc, wr : wr, em : em, ci : ci, ld : ld, route : route},
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          swalalertwithredirect('SUCCESS!','Successfully edited.','success','/swm/dashboard');
        }else{
          swalalert('ERROR!','Action failed.','error');
        }
      }
    });
  }

    //CLIENT LOGS

    function vwattchmnt(token){
      $.ajax({
        url: base_url+"/Logs/Form/vwattchmnt",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#vwattchmnt_body_"+token).html(response); }
      });
    }

    function timeoutlog(token){
      $.ajax({
        url: base_url+"/Logs/Form/timeoutlog",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#timeoutlog_").html(response); }
      });
    }

    function chkcmpcll(token){
      $.ajax({
        url: base_url+"/Logs/Form/chkcmpcll",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#_chkcmpcll").html(response); }
      });
    }

    function cl_frdobtn(token){
      $.ajax({
        url: base_url+"/Logs/Form/cl_frdobtn",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#cl_frdobtn_").html(response); }
      });
    }

    function cl_srdobtn(token){
      $.ajax({
        url: base_url+"/Logs/Form/cl_srdobtn",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){ $("#cl_srdobtn_").html(response); }
      });
    }


    function rpvwattmnt(trans_no,token){
      $.ajax({
        url: base_url+"/Repository/Ajax/rpvwattmnt",
        type: 'POST',
        async : true,
        data: { trans_no : trans_no, token : token },
        success:function(response){ $("#rpvwattmnt_body_"+token).html(response); }
      });
    }

    //MESSAGING
  // $(document).ready(function(){
  //     $.ajax({
  //       url: base_url+"/Messages/Ajax/angmahiwagangmensahe",
  //       type: 'POST',
  //       dataType: 'json',
  //       async : true,
  //       success:function(response){
  //         var htmldata = "";
  //         for (var i = 0; i < response.title.length; i++) {
  //           htmldata += '<a type="button" onclick=vwmsgflt("'+response.token[i]+'","'+response.recipient[i]+'"); title="'+response.title[i]+'" id="float-chat-box-a-tag" href="#" class="btn btn-default btn-lg btn-circle">'+
  //                        '<img src="'+response.photo[i]+'" class="float-chat-box">'+
  //                       '</a>';
  //         }
  //         $("#angmahiwagangmensahe_").html(htmldata);
  //       }
  //     });
  //   });

  // function vwmsgflt(token, rcpnt){
  //   $.ajax({
  //     url: base_url+"/Messages/Ajax/o_o",
  //     type: 'POST',
  //     // dataType: 'json',
  //     async : true,
  //     data: { token : token, rcpnt : rcpnt },
  //     success:function(response){
  //       var obj = JSON.parse(response);
  //       var title = obj.title;
  //       var titlel = title.length;
  //       var length = 25;
  //       var headertitle = (titlel > 25) ? title.substring(0, length)+'...' : title.substring(0, length);
  //
  //       var subtitle = obj.subtitle;
  //       var subtitlel = subtitle.length;
  //       var slength = 27;
  //       var headersubtitle = (subtitlel > 27) ? subtitle.substring(0, slength)+'...' : subtitle.substring(0, slength);
  //       if(obj.responsedata.length > 0){
  //         document.getElementById("angmahiwagangmensahe_").style.display = "block";
  //       }else{
  //         document.getElementById("angmahiwagangmensahe_").style.display = "none";
  //       }
  //       htmldata = '<div class="card shadow mb-4">'+
  //                     '<div class="card-header py-3 d-flex flex-row">'+
  //                       '<img class="img-profile rounded-circle" src="'+obj.photo+'" style="height: 3rem; width: 3rem; border: 2px solid #EDEEF1;">'+
  //                       '<h6 class="m-0 font-weight-bold text-primary" style="width: 100%; margin-top: 5px!important; margin-left: 6px!important;">'+
  //                       '<span style="font-size: 12pt;" title="'+obj.title+'">'+headertitle+'</span><br><span style="color: #939598; font-size: 10pt;" title="'+obj.subtitle+'">'+headersubtitle+'</span></h6>'+
  //                       '<a href="#" class="btn btn-default btn-sm" style="margin-top: 5px;font-size: 15pt; border: 1px solid #E3E6F0; height: 40px;"><span class="fa fa-chevron-up"></span></a>'+
  //                     '</div>'+
  //                     '<div class="card-body dvfltcb">'+
  //                       '<div class="chat-lawas">';
  //
  //                       for (var i = 0; i < obj.responsedata.length; i++) {
  //                         if(obj.ssn_utoken == obj.responsedata[i].utoken){
  //                           htmldata += '<div class="row dvfltrw">'+
  //                                         '<div class="col-md-12" style="margin-top:5px;">'+
  //                                           '<div style="justify-content: flex-end!important;">'+
  //                                             '<div style="float:right;" id="chat-lawas-tuo">'+
  //                                               '<div class="fltdvcntntt">'+obj.responsedata[i].message+'</div>'+
  //                                             '</div>'+
  //                                           '</div>'+
  //                                         '</div>'+
  //                                       '</div>';
  //                         }else{
  //                           htmldata += '<div class="row dvfltrw">'+
  //                                         '<div class="col-md-12" style="margin-top:5px;">'+
  //                                           '<div style="justify-content: flex-end!important;">'+
  //                                             '<div id="chat-lawas-wala" style="display: flex;">'+
  //                                               '<div style="flex: 0 0 65%;max-width: 30px;">'+
  //                                                 '<img style="border-radius: 50px;height: 1.75rem;min-height: 1.75rem;width: 1.75rem;min-width: 1.75rem;position: absolute;bottom: 0;" src="'+obj.responsedata[i].photo+'" alt="">'+
  //                                               '</div>'+
  //                                               '<div class="fltdvcntntw">'+obj.responsedata[i].message+'</div>'+
  //                                             '</div>'+
  //                                           '</div>'+
  //                                         '</div>'+
  //                                       '</div>';
  //                         }
  //                       }
  //       htmldata +=     '</div>'+
  //                       '<div style="border-top: 1px solid; display: flex; margin-top: 5px; padding: 5px 10px 0px 10px;">'+
  //                         '<textarea style="min-height:0px!important; width: 85%; resize:none;"></textarea>'+
  //                         '<a style="margin-left: 5px;border: 1px solid; width: 13%;" href="#" class="btn btn-primary btn-sm">'+
  //                           '<span class="fa fa-paperclip" style="font-size: 20pt;margin-top: 7px;"></span>'+
  //                         '</a>'+
  //                       '</div>'+
  //                     '</div>'+
  //                   '</div>';
  //
  //       $("#dvfltcl").html(htmldata);
  //     }
  //   });
  // }
  //
  // var socket = io.connect('https://iis.emb.gov.ph:9696');

  //DTR
  function filterdtr(token){
    $.ajax({
      url: base_url+"/Admin/Dtr_ajax/filterdtr",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          window.location.href = base_url+'/Admin/DTR';
        }
      }
    });
  }

  //Scheduler
  function schedule_details(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/schedule_details",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#schedule-details').html(response);
      }
    });
  }

  function chkparticipants(token, id){
    $.ajax({
      url: base_url+"/Schedule/Ajax/chkparticipants",
      type: 'POST',
      async : true,
      data: { token : token, id : id },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          schedule_details(obj.token);
        }
      }
    });
  }

  function chkparticipantsedit(token, id){
    $.ajax({
      url: base_url+"/Schedule/Ajax/chkparticipants",
      type: 'POST',
      async : true,
      data: { token : token, id : id },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          editschedtwo(obj.token);
        }
      }
    });
  }

  function schedstat(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/schedstat",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#schedule-details').html(response);
      }
    });
  }

  function postponesched(token, reason){
    $.ajax({
      url: base_url+"/Schedule/Ajax/postponesched",
      type: 'POST',
      async : true,
      data: { token : token, reason : reason },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          alert('Schedule successfully updated.');
          window.location.href = base_url+'/Schedule/Dashboard';
        }
      }
    });
  }

  function startsched(token){
    var r = confirm("Are you sure to start this schedule?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Schedule/Ajax/startsched",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){
          var obj = JSON.parse(response);
          if(obj.status == 'success'){
            alert('Schedule successfully updated.');
            schedule_details(obj.token);
          }
        }
      });
    }else{
      alert('Action cancelled.');
    }

  }

  function sched_status(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/sched_status",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#schedstatus_').html(response);
      }
    });
  }

  function agreementsorminutes(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/agreementsorminutes",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#schedule-details').html(response);
      }
    });
  }

  function addagreementsorminutes(token, accountable, details){
    $.ajax({
      url: base_url+"/Schedule/Ajax/addagreementsorminutes",
      type: 'POST',
      async : true,
      data: { token : token, accountable : accountable, details : details },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          alert('Schedule successfully updated.');
          window.location.href = base_url+'/Schedule/Dashboard';
        }
      }
    });
  }

  function viewparticipants(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/viewparticipants",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#participantsview').html(response);
      }
    });
  }

  function viewparticipantss(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/viewparticipantss",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#participantsview_').html(response);
      }
    });
  }

  function viewparticipantsselectize(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/viewparticipantsselectize",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#participantsviewselectize_').html(response);
      }
    });
  }

  function viewparticipantsselectizee(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/viewparticipantsselectize",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#participantsviewselectizee_').html(response);
      }
    });
  }

  function removesched(token){
    var r = confirm("Are you sure to remove this schedule?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Schedule/Ajax/removesched",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){
          var obj = JSON.parse(response);
          if(obj.status == 'success'){
            alert('Schedule successfully updated.');
            window.location.href = base_url+'/Schedule/Dashboard';
          }
        }
      });
    }else{
      alert('Action cancelled.');
    }
  }

  function duplicatesched(token){
    var r = confirm("Are you sure to duplicate this schedule?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Schedule/Ajax/duplicatesched",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){
          $('#schedule-details').html(response);
        }
      });
    }else{
      alert('Action cancelled.');
    }
  }

  function editsched(token){
    var r = confirm("Are you sure to edit this schedule?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Schedule/Ajax/editsched",
        type: 'POST',
        async : true,
        data: { token : token },
        success:function(response){
          $('#schedule-details').html(response);
        }
      });
    }else{
      alert('Action cancelled.');
    }
  }

  function editschedtwo(token){
    $.ajax({
      url: base_url+"/Schedule/Ajax/editsched",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        $('#schedule-details').html(response);
      }
    });
  }

  function saveeditedsched(token, moreparticipants, subject, location, date_schedule, time_schedule){
    $.ajax({
      url: base_url+"/Schedule/Ajax/saveeditedsched",
      type: 'POST',
      async : true,
      data: { token : token, moreparticipants : moreparticipants, subject : subject, location : location, date_schedule : date_schedule, time_schedule : time_schedule },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          alert('Schedule successfully updated.');
          window.location.href = base_url+'/Schedule/Dashboard';
        }

        if(obj.status == 'failed'){
          alert('Action failed.');
        }
      }
    });
  }

  function rmvdisablesched(datesched){
    var startdate = document.getElementById('startdate').value;
    var dateschedule = new Date(datesched);
    var datestart = new Date($('#startdate').val());
    if(startdate != '' && datestart >= dateschedule){
      $('#enddate').removeAttr('disabled');
    }else{
      document.getElementById("enddate").disabled = true;
      if(datestart < dateschedule){
        document.getElementById('startdate').value = '';
        alert('Please select date greater than date schedule.');
      }
    }
  }

  function verifydatesched(){
    var startDate = new Date($('#startdate').val());
    var endDate = new Date($('#enddate').val());

    if (startDate <= endDate){

    }else{
      alert('Please select a valid date range. It should be equal or greater than start date.');
      document.getElementById('enddate').value = '';
    }
  }

  function addnewsched(token, startdate, enddate, timesched){
    $.ajax({
      url: base_url+"/Schedule/Ajax/addnewsched",
      type: 'POST',
      async : true,
      data: { token : token, startdate : startdate, enddate : enddate, timesched : timesched },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          alert('New schedule(s) successfully added.');
          window.location.href = base_url+'/Schedule/Dashboard';
        }
        if(obj.status == 'failed'){
          alert('Please provide date range which is in week range of date schedule.');
        }
      }
    });
  }

  function removepartcipant(cnt, token){
    var r = confirm("Are you sure to remove this participant?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Schedule/Ajax/removepartcipant",
        type: 'POST',
        async : true,
        data: { cnt : cnt, token : token },
        success:function(response){
          var obj = JSON.parse(response);
          if(obj.status == 'success'){
            alert('Participant successfully removed.');
            editschedtwo(cnt);
          }
          if(obj.status == 'failed'){
            alert('Action failed.');
          }
        }
      });
    }
  }

  function viewallonlineusers(){
    $.ajax({
      url: base_url+"/Index/viewallonlineusers",
      type: 'POST',
      async : true,
      data: { },
      success:function(response){
        $('#viewallonlineusers_').html(response);
      }
    });
  }

  function bulletinupload(token){
    var form_data = new FormData();

    // Read selected files
    var totalfiles = document.getElementById('bulletinfiles').files.length;
    if(totalfiles > 0){
      for (var index = 0; index < totalfiles; index++) {
        form_data.append("bulletinfiles[]", document.getElementById('bulletinfiles').files[index]);
      }
      form_data.append("token", token);

      document.getElementById("bulletinfiles_").style.display = 'block';
      // AJAX request
      $.ajax({
       url: base_url+'/Index/bulletinupload',
       type: 'post',
       data: form_data,
       dataType: 'json',
       xhr: function() {
              var sendfilesXHR = $.ajaxSettings.xhr();
              if(sendfilesXHR.upload){
                  sendfilesXHR.upload.addEventListener('progress',bulletinfilesprogress, false);
              }
              return sendfilesXHR;
      },
       cache: false,
       contentType: false,
       processData: false,
       success: function (response) {
         if(response.status == 'success'){
           swalalert('SUCCESS!','File successfully uploaded.','success');
           document.getElementById('attachmentcounter_').value = response.attachmentcounter;
           viewuploadedfilesbulletin(response.token);
         }else if(response.status == 'failed'){
           alert('Error! Please try again.');
         }else if(response.status == 'empty'){
           alert('Please attach photo.');
         }
         document.getElementById("bulletinfiles_").style.display = 'none';
         document.getElementById("bulletinfiles").value = '';
       }
      });
    }else{
      alert('Please attach file(s).');
    }
  }

  function swalalert(title, text, type){
    swal({
      title: title,
      text: text,
      type: type,
      allowOutsideClick: false,
      customClass: 'swal-wide',
      confirmButtonClass: 'btn-success',
      confirmButtonText: 'Confirm',
      onOpen: () => swal.getConfirmButton().focus()
    });
  }

  function swalalertwithredirect(title, text, type, redirect){
    swal({
      title: title,
      text: text,
      type: type,
      allowOutsideClick: false,
      customClass: 'swal-wide',
      confirmButtonClass: 'btn-success',
      confirmButtonText: 'Confirm',
      onOpen: () => swal.getConfirmButton().focus()
    }).then(okay => {
       if(okay) {
        window.location.href = base_url+redirect;
      }
    });
  }

  function bulletinfilesprogress(e){
      if(e.lengthComputable){
          var max = e.total;
          var current = e.loaded;

          var Percentage = (current * 100)/max;
          document.getElementById("bulletinfilesprogressbar_").style.width = Math.round(Percentage)+"%";
          var percent = document.getElementById("bulletinfilesprogresspercentage_");
          percent.innerHTML = Math.round(Percentage)+"%";

          if(Percentage >= 100){ }
      }
 }

 function viewuploadedfilesbulletin(token){
   $.ajax({
     url: base_url+"/Index/viewuploadedfilesbulletin",
     type: 'POST',
     async : true,
     data: { token : token },
     success:function(response){
       $('#uploadedfilesbulletin_').html(response);
     }
   });
 }

 function removeuploadedfilebulletin(token,file){
   var r = confirm("Are you sure to remove this file?");
    if (r == true) {
      $.ajax({
        url: base_url+"/Index/removeuploadedfilebulletin",
        type: 'POST',
        async : true,
        data: { token : token, file : file },
        success:function(response){
          var obj = JSON.parse(response);
          viewuploadedfilesbulletin(obj.token);
          viewbulletindetails(obj.etoken);
          document.getElementById("attachmentcounter_").value = obj.attachmentcntr;
          // alert('Successfully removed.');
          swalalert('SUCCESS!','Successfully removed.','success');
        }
      });
    } else {
      swalalert('SUCCESS!','Cancelled.','success');
    }
 }

 function createnewinbulletin(){
   $.ajax({
     url: base_url+"/Index/createnewinbulletin",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       $('#bulletincnt_').html(response);
     }
   });
 }

 function bulletinoptions(cnt,origin){
   $.ajax({
     url: base_url+"/Index/bulletinoptions",
     type: 'POST',
     async : true,
     data: {cnt : cnt, origin : origin },
     success:function(response){
       $('#bulletinoptions_').html(response);
     }
   });
 }

 function dntshwbltn(){
   $.ajax({
     url: base_url+"/Index/dntshwbltn",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       var obj = JSON.parse(response);
       if(obj.status == 'dismiss'){
         $('#Viewbulletinmdl').modal('hide');
       }
     }
   });
 }

 function removetobulletin(cnt){
   var r = confirm("Are you sure to remove this post?");
   if (r == true) {
     $.ajax({
       url: base_url+"/Index/removetobulletin",
       type: 'POST',
       async : true,
       data: {cnt : cnt },
       success:function(response){
         var obj = JSON.parse(response);
         if(obj.status == 'success'){
           swalalertwithredirect('SUCCESS!','Successfully removed to bulletin.','success','/dashboard');
         }else{
           alert('Sorry! Error occured while performing this action.');
           swalalert('ERROR!','Sorry! Error occured while performing this action.','error');
         }
       }
     });
   }else{
     swalalert('SUCCESS!','Cancelled.','success');
   }

 }



 function publishtobulletin(bltncnt, bltnttle, attchmntcntr, bltnwhere, bltnwhen){
   var ifnational = document.getElementById("visibletonational").checked;
   // document.getElementById("bulletinuploadprogress_").style.display = 'block';
   $.ajax({
     url: base_url+"/Index/publishtobulletin",
     type: 'POST',
     // xhr: function() {
     //        var sendfilesXHR = $.ajaxSettings.xhr();
     //        if(sendfilesXHR.upload){
     //            sendfilesXHR.upload.addEventListener('progress',publishprogress, false);
     //        }
     //        return sendfilesXHR;
     // },
     async : true,
     data: { bltncnt : bltncnt, bltnttle : bltnttle, attchmntcntr : attchmntcntr, visibletonational : ifnational, bltnwhere : bltnwhere, bltnwhen : bltnwhen,  },
     success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        // window.location.href = base_url+'/dashboard';
        swalalertwithredirect('SUCCESS!','Successfully posted.','success','/dashboard');
        // alert('Successfully posted.');
        // document.getElementById("bulletinuploadprogress_").style.display = 'none';
      }
      if(obj.status == 'failed'){
        swalalert('ERROR!','Please fill (*) required fields.','error');
      }
     }
   });
 }

//  function publishprogress(e){
//      if(e.lengthComputable){
//          var max = e.total;
//          var current = e.loaded;
//
//          var Percentage = (current * 100)/max;
//          document.getElementById("bulletinuploadprogressbar_").style.width = Math.round(Percentage)+"%";
//          var percent = document.getElementById("bulletinuploadprogresspercentage_");
//          percent.innerHTML = "Please wait.."+Math.round(Percentage)+"%";
//
//          if(Percentage >= 100){ }
//      }
// }

 function checkdraft(){
   $.ajax({
     url: base_url+"/Index/checkdraft",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       var obj = JSON.parse(response);
       viewuploadedfilesbulletin(obj.token);
       document.getElementById("bulletintitle").value = obj.title;
       document.getElementById("attachmentcounter_").value = obj.attachmentcnt;
     }
   });
 }

 function viewbulletindetails(token){
   $.ajax({
     url: base_url+"/Index/bulletin_details",
     type: 'POST',
     async : true,
     data: { token : token },
     success:function(response){
       $('#bulletin-details_').html(response);
     }
   });
 }

 function localbltnsn(){
   $.ajax({
     url: base_url+"/Index/localbltnsn",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       $('#bulletin_notifr').remove();
     }
   });
 }

 function ntlbltnsn(){
   $.ajax({
     url: base_url+"/Index/ntlbltnsn",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       $('#bulletin_notifn').remove();
     }
   });
 }

 function chktimelog(token){
   $.ajax({
     url: base_url+"/Admin/DTR/chktimelog",
     type: 'POST',
     async : true,
     data: { token : token },
     success:function(response){
       $('#divtimelog_').html(response);
       document.getElementById('savetimelogsbtn').disabled = false;
     }
   });
 }

 function savetimelog(datelog, inam, outam, inpm, outpm, attachmentcounter, remarks){
   if(datelog != ''){
     $.ajax({
       url: base_url+"/Admin/DTR/savetimelog",
       type: 'POST',
       async : true,
       data: { datelog : datelog, inam : inam, outam : outam, inpm : inpm, outpm : outpm, attachmentcounter : attachmentcounter, remarks : remarks },
       success:function(response){
         var obj = JSON.parse(response);
         if(obj.status == 'success'){
           swalalertwithredirect('SUCCESS!','Successfully updated.','success','/dtr/dashboard');
         }else{
           swalalert('ERROR!','Error occured while performing this action.','error');
         }
       }
     });
   }else{
     swalalert('ERROR!','Please select a date.','error');
   }
 }

 function chkdtroptions(){
   $.ajax({
     url: base_url+"/Admin/DTR/chkdtroptions",
     type: 'POST',
     async : true,
     data: { },
     success:function(response){
       $('#chkdtroptions_').html(response);
     }
   });
 }

 function savetimelogoptions(earliest_in, latest_in, earliest_out, latest_out){
   $.ajax({
     url: base_url+"/Admin/DTR/savetimelogoptions",
     type: 'POST',
     async : true,
     data: { earliest_in : earliest_in, latest_in : latest_in, earliest_out : earliest_out, latest_out : latest_out, },
     success:function(response){
       var obj = JSON.parse(response);
       if(obj.status == 'success'){
         swalalertwithredirect('SUCCESS!','Successfully updated.','success','/dtr/dashboard');
       }

       if(obj.status == 'failed'){
         swalalert('ERROR!','Please fill up required field(s).','error');
       }

       if(obj.status == 'failedam'){
         swalalert('ERROR!','AM Time range is not right or out of range.','error');
       }

       if(obj.status == 'failedpm'){
         swalalert('ERROR!','PM Time range is not right or out of range.','error');
       }
     }
   });
 }

 function cscformrange(firstrange, secondrange, surpervisorselectize){
   $.ajax({
     url: base_url+"/Admin/DTR/cscformrange",
     type: 'POST',
     async : true,
     data: { firstrange : firstrange, secondrange : secondrange, surpervisorselectize : surpervisorselectize },
     success:function(response){
       $('#previewcsc_').html(response);
     }
   });
 }


 function dtruploadattachment(datelog){
   var form_data = new FormData();

   // Read selected files
   var totalfiles = document.getElementById('dtrattachment').files.length;
   for (var index = 0; index < totalfiles; index++) {
     form_data.append("dtrattachment[]", document.getElementById('dtrattachment').files[index]);
   }

   var category = $('#dtrcatselectize').val();

   form_data.append("category", category);
   form_data.append("datelog", datelog);

   document.getElementById("dtruploadfile_").style.display = 'block';
   // AJAX request
   $.ajax({
    url: base_url+'/Admin/DTR/dtrattachmentupload',
    type: 'post',
    data: form_data,
    dataType: 'json',
    xhr: function() {
           var sendfilesXHR = $.ajaxSettings.xhr();
           if(sendfilesXHR.upload){
               sendfilesXHR.upload.addEventListener('progress',dtrattachmentprogress, false);
           }
           return sendfilesXHR;
   },
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      if(response.status == 'success'){
        swalalert('SUCCESS!','File(s) successfully uploaded.','success');
        chkdtrattached(response.datelog);
      }

      if(response.status == 'failed'){
        swalalert('ERROR!','Error occured while performing this action.','error');
      }

      if(response.status == 'empty'){
        swalalert('ERROR!','Please attach file(s).','error');
      }
      $('#dtrattachment').val('');
      document.getElementById("dtruploadfile_").style.display = 'none';
      // if(response.status == 'uploaded'){
      //   alert('Photo successfully uploaded.');
      //   var htmldata = '<a href="'+response.image_uploaded+'" target="_blank" style="width: 100%;" class="btn btn-info btn-sm">View uploaded photo</a>'+
      //                  '<button type="button" style="width: 135px; margin-left: 10px;" onclick=swchangephoto("'+response.token+'","'+response.image_uploaded+'"); class="btn btn-warning btn-sm">'+
      //                       '<span class="fa fa-edit"></span>&nbsp;Change photo'+
      //                  '</button>';
      //    $('#swdvphotoattachment_').html(htmldata);
      // }else if(response.status == 'failed'){
      //   alert('File uploaded is not an image. Please retry.');
      // }else if(response.status == 'empty'){
      //   alert('Please attach photo.');
      // }
      // document.getElementById("swsitephoto_").style.display = 'none';
    }
   });
 }

 function dtrattachmentprogress(e){
     if(e.lengthComputable){
         var max = e.total;
         var current = e.loaded;

         var Percentage = (current * 100)/max;
         document.getElementById("dtruploadfileuploadprogressbar_").style.width = Math.round(Percentage)+"%";
         var percent = document.getElementById("dtruploadfileprogresspercentage_");
         percent.innerHTML = Math.round(Percentage)+"%";

         if(Percentage >= 100){ }
     }
}

function chkdtrattached(token){
  $.ajax({
    url: base_url+"/Admin/DTR/chkdtrattached",
    type: 'POST',
    async : true,
    data: {token : token},
    success:function(response){
      $('#dtrattached_').html(response);
    }
  });
}

function removeuploadedfiledtr(token,file){
  var r = confirm("Are you sure to remove this file?");
  if (r == true) {
    $.ajax({
      url: base_url+"/Admin/DTR/removeuploadedfiledtr",
      type: 'POST',
      async : true,
      data: { token : token, file : file },
      success:function(response){
        var obj = JSON.parse(response);
        chkdtrattached(obj.datelog);
        if(obj.status == 'success'){
          swalalert('SUCCESS!','Successfully removed.','success');
        }
        if(obj.status == 'failed'){
          swalalert('ERROR!','Error occured while performing this action.','error');
        }
        $('#attachmentcounter').val(obj.attachmentcntr);
      }
    });
  }else{
    swalalert('SUCCESS!','Cancelled.','success');
  }
}

function viewdtrattachments(token){
  $.ajax({
    url: base_url+"/Admin/DTR/viewdtrattachments",
    type: 'POST',
    async : true,
    data: {token : token},
    success:function(response){
      $('#dtrattchments_').html(response);
    }
  });
}

function withattachmentcounter(){
  $.ajax({
    url: base_url+"/Admin/DTR/withattachmentcounter",
    type: 'POST',
    async : true,
    data: {token : token},
    success:function(response){
      $('#withattachmentcounter_').html(response);
    }
  });
}

function generatedtrrange(){
  var fromdtrroute = $('#fromdtrroute').val();
  var todtrroute = $('#todtrroute').val();
  if(fromdtrroute != '' && todtrroute != ''){
    $.ajax({
      url: base_url+"/Admin/DTR/generatedtrrange",
      type: 'POST',
      async : true,
      data: { from : fromdtrroute, to : todtrroute },
      success:function(response){
        $('#generatedtrrange_').html(response);
      }
    });
  }
}

function cscform48(){
  var fromdtrroute = $('#fromdtrroute').val();
  var todtrroute = $('#todtrroute').val();
  var signatorydtrselectize = $('#signatorydtrselectize').val();
  if(fromdtrroute != '' && todtrroute != '' && signatorydtrselectize != ''){
    $.ajax({
      url: base_url+"/Admin/DTR/cscform48",
      type: 'POST',
      async : true,
      data: { from : fromdtrroute, to : todtrroute, signatory : signatorydtrselectize },
      success:function(response){
        $('#cscform48_').html(response);
      }
    });
  }
}

function cscform48prev(){
  var prevfromdate = $('#prevfromdate').val();
  var prevatodate = $('#prevatodate').val();
  if(prevfromdate != '' && prevatodate != ''){
    $.ajax({
      url: base_url+"/Admin/DTR/cscform48prev",
      type: 'POST',
      async : true,
      data: { from : prevfromdate, to : prevatodate},
      success:function(response){
        $('#prevcscform_').html(response);
      }
    });
  }
}

function checkalldtrroute(){
  var checkalldtrroute = document.getElementById("checkalldtrroute");
  if (checkalldtrroute.checked == true) {
    $("input:checkbox").attr('checked', true);
  } else {
    $("input:checkbox").attr('checked', false);
  }
}

function routedtrselected(from, to, routeto, signatory){
  if(from != '' && to != '' && routeto != ''){
    var token = [];
    $('.token:checked').each(function(i, e) {
        token.push($(this).val());
    });
    $.ajax({
      url: base_url+"/Admin/DTR/routedtrselected",
      type: 'POST',
      async : true,
      data: {
          'token[]': token.join(),
          from : from,
          to : to,
          routeto : routeto,
          signatory : signatory,
      },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          swalalertwithredirect('SUCCESS!','Successfully routed.','success','/dtr/dashboard');
        }

        if(obj.status == 'failed'){
          swalalert('ERROR!','Error while performing this action.','error');
        }

        if(obj.status == 'nodata'){
          swalalert('ERROR!','Please select time log(s).','error');
        }
      }
    });
  }else{
    swalalert('ERROR!','Please fill required fields.','error');
  }
}

function routed_dtr_details(token){
  $.ajax({
    url: base_url+"/Admin/DTR/routed_dtr_details",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#routed_dtr_details_').html(response);
    }
  });
}

function checkrouted_dtr_details(token){
  $.ajax({
    url: base_url+"/Admin/DTR/checkrouted_dtr_details",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#checkrouted_dtr_details_').html(response);
    }
  });
}

function approve_routed_dtr_details(token, routeto, stat, remarks, daysworked){
  if(token != '' && routeto != '' && stat != ''){
    $.ajax({
      url: base_url+"/Admin/DTR/approve_routed_dtr_details",
      type: 'POST',
      async : true,
      data: { token : token, routeto : routeto, stat : stat, remarks : remarks, daysworked : daysworked },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          swalalertwithredirect('SUCCESS!','Successfully routed.','success','/dtr/dashboard');
        }

        if(obj.status == 'missing fields'){
          swalalert('ERROR!','Please fill required fields.','error');
        }

        if(obj.status == 'failed'){
          swalalert('ERROR!','Error encountered.','error');
        }
      }
    });
  }else{
    swalalert('ERROR!','Please fill required fields.','error');
  }
}

function viewrouteddtrattachments(token, cnt){
  $.ajax({
    url: base_url+"/Admin/DTR/viewrouteddtrattachments",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#viewrouteddtrattachments_'+cnt).html(response);
    }
  });
}

function processviewrouteddtrattachments(token){
  $.ajax({
    url: base_url+"/Admin/DTR/viewrouteddtrattachments",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#processviewrouteddtrattachments_').html(response);
    }
  });
}

function alterundertime(token, val, transno){
  $.ajax({
    url: base_url+"/Admin/DTR/alterundertime",
    type: 'POST',
    async : true,
    data: { token : token,  val : val,  transno : transno },
    success:function(response){ }
  });
}

function returntosenderdtr(token){
  $.ajax({
    url: base_url+"/Admin/DTR/returntosenderdtr",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#checkrouted_dtr_details_').html(response);
    }
  });
}

function returntosenderfooter(token){
  $.ajax({
    url: base_url+"/Admin/DTR/returntosenderfooter",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#checkrouted_dtr_footer_').html(response);
    }
  });
}

function returntosenderfooterdefault(token){
  $.ajax({
    url: base_url+"/Admin/DTR/returntosenderfooterdefault",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#checkrouted_dtr_footer_').html(response);
    }
  });
}

function dtrroutereturndoc(token, user, remarks){
  $.ajax({
    url: base_url+"/Admin/DTR/dtrroutereturndoc",
    type: 'POST',
    async : true,
    data: { token : token, user : user, remarks : remarks},
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalertwithredirect('SUCCESS!','Successfully returned.','success','/dtr/dashboard');
      }

      if(obj.status == 'missing fields'){
        swalalert('ERROR!','Please fill required fields.','error');
      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Error encountered.','error');
      }
    }
  });
}


function editdtrfulldetails(token){
  $.ajax({
    url: base_url+"/Admin/DTR/editdtrfulldetails",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#editrouted_dtr_details_').html(response);
    }
  });
}

function processeditdtrrouted(routeto, incharge, token, remarks){
  if(routeto != '' && incharge != '' && token != ''){
    $.ajax({
      url: base_url+"/Admin/DTR/processeditdtrrouted",
      type: 'POST',
      async : true,
      data: { routeto : routeto, incharge : incharge, token : token, remarks : remarks},
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          swalalertwithredirect('SUCCESS!','Successfully routed.','success','/dtr/dashboard');
        }

        if(obj.status == 'missing fields'){
          swalalert('ERROR!','Please fill required fields.','error');
        }
      }
    });
  }else{
    swalalert('ERROR!','Please fill required fields.','error');
  }
}

function savecredeb(item, type){
  $.ajax({
    url: base_url+"/Admin/DTR/savecredeb",
    type: 'POST',
    async : true,
    data: { item : item, type : type},
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalertwithredirect('SUCCESS!','Successfully inserted.','success','/dtr/dashboard');
      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Error encountered.','error');
      }

      if(obj.status == 'missing fields'){
        swalalert('ERROR!','Please fill required fields.','error');
      }
    }
  });
}

function editcredebbtm(cnt){
  $.ajax({
    url: base_url+"/Admin/DTR/editcredebbtm",
    type: 'POST',
    async : true,
    data: { cnt : cnt},
    success:function(response){
      $('#editcredeb_').html(response);
    }
  });
}

function dtrdyswrkd(token, val, dlyrt){
  $.ajax({
    url: base_url+"/Admin/DTR/dtrdyswrkd",
    type: 'POST',
    async : true,
    data: { token : token, val : val, dlyrt : dlyrt},
    success:function(response){
      var obj = JSON.parse(response);
      $('#gi'+obj.token).html(obj.gross_income);
    }
  });
}

function dtrdlyrt(token, val, empname, transno, dyswrkd){
  $.ajax({
    url: base_url+"/Admin/DTR/dtrdlyrt",
    type: 'POST',
    async : true,
    data: { token : token, val : val, empname : empname, transno : transno, dyswrkd : dyswrkd},
    success:function(response){
      var obj = JSON.parse(response);
      $('#gi'+obj.token).html(obj.gross_income);
    }
  });
}

function addondtr(token, tkn){
  $.ajax({
    url: base_url+"/Admin/DTR/addondtr",
    type: 'POST',
    async : true,
    data: { token : token, tkn : tkn },
    success:function(response){
      $('#addondtr_').html(response);
    }
  });
}

function deductiondtr(token, tkn){
  $.ajax({
    url: base_url+"/Admin/DTR/deductiondtr",
    type: 'POST',
    async : true,
    data: { token : token, tkn : tkn },
    success:function(response){
      $('#deductiondtr_').html(response);
    }
  });
}

function newaddondtr(token){
  $.ajax({
    url: base_url+"/Admin/DTR/newaddondtr",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#newaddondtr_').html(response);
    }
  });
}

function newdeductiondtr(token){
  $.ajax({
    url: base_url+"/Admin/DTR/newdeductiondtr",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#newdeductiondtr_').html(response);
    }
  });
}

function saveaddondtr(usertoken, token, addonval, transno){
  $.ajax({
    url: base_url+"/Admin/DTR/saveaddondtr",
    type: 'POST',
    async : true,
    data: { usertoken : usertoken, token : token, addonval : addonval, transno : transno },
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalert('SUCCESS!','Successfully updated.','success');
        addonchkr(obj.token);
        $('#addon'+obj.res).html(obj.total);
      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Please fill required fields.','error');
      }

      if(obj.status == 'existed'){
        swalalert('ERROR!','Item selected already added.','error');
      }
    }
  });
}

function savedeductiondtr(usertoken, token, addonval, transno){
  $.ajax({
    url: base_url+"/Admin/DTR/savedeductiondtr",
    type: 'POST',
    async : true,
    data: { usertoken : usertoken, token : token, addonval : addonval, transno : transno },
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalert('SUCCESS!','Successfully updated.','success');
        deductionchkr(obj.token,obj.transno);
        $('#deduction'+obj.res).html(obj.total);
        $('#total_deduction'+obj.res).html(obj.total_deductions);

      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Please fill required fields.','error');
      }

      if(obj.status == 'existed'){
        swalalert('ERROR!','Item selected already added.','error');
      }

    }
  });
}

function addonchkr(token, tkn){
  $.ajax({
    url: base_url+"/Admin/DTR/addonchkr",
    type: 'POST',
    async : true,
    data: { token : token, tkn : tkn },
    success:function(response){
      $('#addonchkr_').html(response);
    }
  });
}

function chkaddondtr(token){
  $.ajax({
    url: base_url+"/Admin/DTR/chkaddondtr",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#chkaddon_').html(response);
    }
  });
}

function chkaddondtradd(token){
  $.ajax({
    url: base_url+"/Admin/DTR/chkaddondtradd",
    type: 'POST',
    async : true,
    data: { token : token},
    success:function(response){
      $('#chkaddondtradd_').html(response);
    }
  });
}

function saveaddondtradd(token, item, val){
  $.ajax({
    url: base_url+"/Admin/DTR/saveaddondtradd",
    type: 'POST',
    async : true,
    data: { token : token, item : item, val : val},
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalert('SUCCESS!','Successfully updated.','success');
        window.location.href = base_url+'/dtr/dashboard';

      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Please fill required fields.','error');
      }

      if(obj.status == 'existed'){
        swalalert('ERROR!','Item selected already added.','error');
      }
    }
  });
}

function rmvaddondtrchk(token, val){
  var chk = confirm("Are you sure to remove this add-on?");
  if (chk == true) {
    $.ajax({
      url: base_url+"/Admin/DTR/rmvaddondtrchk",
      type: 'POST',
      async : true,
      data: { token : token, val : val },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
          swalalertwithredirect('SUCCESS!','Successfully removed.','success','/dtr/dashboard');
        }
      }
    });
  }else{
    alert('Cancelled.');
  }
}



function deductionchkr(token, tkn){
  $.ajax({
    url: base_url+"/Admin/DTR/deductionchkr",
    type: 'POST',
    async : true,
    data: { token : token, tkn : tkn },
    success:function(response){
      $('#deductionchkr_').html(response);
    }
  });
}

function saveeditedcredeb(item, token, type){
  $.ajax({
    url: base_url+"/Admin/DTR/saveeditedcredeb",
    type: 'POST',
    async : true,
    data: { item : item, token : token, type : type},
    success:function(response){
      var obj = JSON.parse(response);
      if(obj.status == 'success'){
        swalalertwithredirect('SUCCESS!','Successfully updated.','success','/dtr/dashboard');
      }

      if(obj.status == 'failed'){
        swalalert('ERROR!','Error encountered.','error');
      }

      if(obj.status == 'missing fields'){
        swalalert('ERROR!','Please fill required fields.','error');
      }
    }
  });
}

function rmvaddon(token, val, transno){
  var chk = confirm("Are you sure to remove this add-on?");
  if (chk == true) {
    $.ajax({
      url: base_url+"/Admin/DTR/rmvaddon",
      type: 'POST',
      async : true,
      data: { token : token, val : val, transno : transno },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.token != ''){
          addonchkr(obj.token);
          $('#addon'+obj.transno).html(obj.total);
          swalalert('SUCCESS!','Successfully removed.','success');
        }
      }
    });
  } else {
    alert('Cancelled.');
  }
}

function rmvdeduction(token, val, transno){
  var chk = confirm("Are you sure to remove this deduction?");
  if (chk == true) {
    $.ajax({
      url: base_url+"/Admin/DTR/rmvdeduction",
      type: 'POST',
      async : true,
      data: { token : token, val : val, transno : transno },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.token != ''){
          deductionchkr(obj.token,obj.transno);
          $('#deduction'+obj.trans_no).html(obj.total);

          swalalert('SUCCESS!','Successfully removed.','success');
        }
      }
    });
  } else {
    alert('Cancelled.');
  }
}

function dtrsummary(token){
  $.ajax({
    url: base_url+"/Admin/DTR/dtrsummary",
    type: 'POST',
    async : true,
    data: { token : token },
    success:function(response){
      $('#dtrsummarymdl_').html(response);
    }
  });
}

function dtrpayrollapprove(token){
  var chk = confirm("Are you sure perform this action?");
  if (chk == true) {
    $.ajax({
      url: base_url+"/Admin/DTR/dtrpayrollapprove",
      type: 'POST',
      async : true,
      data: { token : token },
      success:function(response){
        var obj = JSON.parse(response);
        if(obj.status == 'success'){
            swalalertwithredirect('SUCCESS!','Successfully approved.','success','/dtr/dashboard');
        }
        if(obj.status == 'failed'){
          swalalert('ERROR!','Sorry! Error occured while performing this action.','error');
        }
      }
    });
  }else{
    alert('Cancelled.');
  }
}

function prevempdtrrng(from, to){
  $.ajax({
    url: base_url+"/Admin/DTR/prevempdtrrng",
    type: 'POST',
    async : true,
    data: { from : from, to : to },
    success:function(response){
      $('#prevempdtrrng_').html(response);
    }
  });
}

function prevcscformbtn(){
  $.ajax({
    url: base_url+"/Admin/DTR/prevcscformbtn",
    type: 'POST',
    async : true,
    data: {  },
    success:function(response){
      $('#prevcscformbtn_').html(response);
    }
  });
}

function prevcscformbtnftr(from, to){
  $.ajax({
    url: base_url+"/Admin/DTR/prevcscformbtnftr",
    type: 'POST',
    async : true,
    data: { from : from, to : to },
    success:function(response){
      if(from != '' && to != ''){
        $('#prevcscformbtnftr_').html(response);
      }
    }
  });
}
