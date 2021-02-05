
// <------------ FOR COMPANY LIST --------------->
  function editcompany(value,proid,provid,cityid,category,company_id){
    $.ajax({
      url: base_url+"/Company/Company_list/editcompany",
      type: 'POST',
      async : true,
      data: {"token": value,"provid": provid,"cityid": cityid,"cityid": cityid,"proid": proid},
      success:function(response)
      {
      $('#edi_company_container').html(response);
      }
    });
  }

  function edit_show_main_comp(){
    $("#edit_show_branch_comp_id").attr("checked", true);
    $("#edit_show_main_comp_id").attr("checked", false);
    $('.main_comp').show();
    $(".branch_comp").hide();
  }

  function edit_show_branch_comp(){
     $("#edit_show_branch_comp_id").attr("checked", false);
    $("#edit_show_main_comp_id").attr("checked", true);
    $('.main_comp').hide();
    $(".branch_comp").show();

  }
  function new_photo(){
    $('#add_new_photo').show();
    $('#current_comp_photo').hide();
  }
  function no_photo(){
    $('#add_new_photo').hide();
    $('#current_comp_photo').show();
  }
// for viewwing company
  function view_company(token){
    $.ajax({
      url: base_url+"/Company/Company_list/view_company",
      type: 'POST',
      async : true,
      data: {"token": token},
      success:function(response)
      {
        $('#view_company_data').html(response);
      }
    });
  }

  function update_main_company(company_id,company_type){
    // console.log(company_type);die();
    // console.log(company_id,company_type);
    // die();
    if (!confirm('Are you sure you want to update the main company ?')) {
       this.checked = false;
      return false;
    }else {
      $.ajax({
        url: base_url+"/Company/Edit_company/update_main_company",
        type: 'POST',
        async : true,
        data: {
          "company_id": company_id,
          "company_type": company_type
        },
        success:function(response)
        {
          // console.log(response);die();
          // console.log(response);
          if (response == 'success') {
            alert('MAIN COMPANY SUCCESSFULLY UPDATED');
          }else {
            alert("Something's wrong !, Please contact administrator - r7support@emb.gov.ph");
          }
          location.reload();
        }
      });
    }
  }
