
var Dms = {

  base_url: '',

  add_transaction: function()
  {
    $.ajax({
       url: Dms.base_url + 'Dms/create_transaction_no',
       success: function(data) {
         $('.trans-layout').html(data);
       }
    });
  },

  view_transaction: function(trans_no)
  {
    $.ajax({
       url: Dms.base_url + 'Dms/view_transaction',
       method: 'POST',
       data: { trans_no : trans_no },
       success: function(data) {
         $('#view_transaction_modal').html(data);
       }
    });
  },

  edit_transaction: function(trans_no)
  {
    $.ajax({
       url: Dms.base_url + 'Dms/edit_transaction',
       method: 'POST',
       data: { trans_no : trans_no },
       success: function(data) {
         $('.trans-layout').html(data);
       }
    });
  },

  receive_transaction: function(_this, trans_no)
  {
    var rcv = 1;
    var request = $.ajax({
       url: Dms.base_url + 'Dms/receive_transaction',
       method: 'POST',
       data: { trans_no : trans_no },
		   dataType: 'json',
       beforeSend: function(jqXHR, settings){
         _this.html('<span class="text">Receiving...</span>').attr('disabled','disabled');
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
  },

  route_transaction: function(trans_no)
  {
    $.ajax({
       url: Dms.base_url + 'Dms/route_transaction',
       method: 'POST',
       data: { trans_no : trans_no },
       success: function(data) {
         $('.trans-layout').html(data);
       }
    });
  },

  save_draft_data: function()
  {
    var frm = $('#input_transaction_form');

		var request = $.ajax({
			url: frm.find('#save_draft_button').attr('formAction'),
			type: frm.attr('method'),
			data: frm.serialize(),
			dataType: 'json',
			beforeSend: function(jqXHR, settings){
        $('#save_draft_button').html('<span class="text">Saving...</span>').attr('disabled','disabled');
        $('#process_transaction_button').attr('disabled','disabled');
      }
		});

		request.done(function(data) {
			if (data.error == 1)
			{
				$('#save_draft_button').val('Save Status').removeAttr('disabled');
			}
			else
			{
				setTimeout(function(){ window.location = data.site; }, 1000);
			}

		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Request failed: " + textStatus );
		});

		return false;
  },

  process_transaction: function()
  {
    var frm = $('#input_transaction_form');

		var request = $.ajax({
			url: frm.find('#process_transaction_button').attr('formAction'),
			type: frm.attr('method'),
			data: frm.serialize(),
			dataType: 'json',
			beforeSend: function(jqXHR, settings){
        $('#process_transaction_button').html('<span class="text">Processing...</span>').attr('disabled','disabled');
        $('#save_draft_button').attr('disabled','disabled');
      }
		});

		request.done(function(data) {
			if (data.error == 1)
			{
				$('#process_transaction_button').val('Save Status').removeAttr('disabled');
			}
			else
			{
				setTimeout(function(){ window.location = data.site; }, 2000);
			}
		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Request failed: " + textStatus );
		});

		return false;
	},

  update_transaction_data: function()
  {
    var frm = $('#add_transaction_form');
    frm.find('#save_draft_button').attr('formAction');
		var request = $.ajax({
			url: frm.find('#save_draft_button').attr('formAction'),
			type: frm.attr('method'),
			data: frm.serialize(),
			dataType: 'json',
			beforeSend: function(jqXHR, settings){
        $('#save_draft_button').html('<span class="text">Saving...</span>').attr('disabled','disabled');
        $('#process_trans_button').attr('disabled','disabled');
      }
		});

		request.done(function(data) {
			if (data.error == 1)
			{
				$('#save_draft_button').val('Save Status').removeAttr('disabled');
			}
			else
			{
				setTimeout(function(){ window.location = data.site; }, 2000);
			}

		});

		request.fail(function(jqXHR, textStatus) {
		  alert( "Request failed: " + textStatus );
		  $('#save_draft_button').val('Save Status').removeAttr('disabled');
		});

		return false;
  },

  system_select: function (system)
  {
    $.ajax({
          url: Dms.base_url+"Dms/system_select",
          type: 'POST',
          data: { system: system },
          dataType: 'json',
          success:function(data)
          {
            var html = '<option selected="" value="">--</option>';
            for( var i=0; i < data.length; i++){
              html +='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
            }
            $("#type").html(html);
          }
      });
  },

  select_division: function (division_name)
  {
    $.ajax({
          url: Dms.base_url+"Dms/select_division",
          type: 'POST',
          data: { division_name: division_name },
          dataType: 'json',
          success:function(data)
          {
            var html = '<option selected="" value="">--</option>';
            for( var i=0; i < data.length; i++){
              html +='<option value="'+data[i]['secno']+'">'+data[i]['sect']+'</option>';
            }
            $("#section_id").html(html);
          }
      });
  },

  select_section: function (section_name)
  {
    $.ajax({
          url: Dms.base_url+"Dms/select_section",
          type: 'POST',
          data: { section_name: section_name },
          dataType: 'json',
          success:function(data)
          {
            var html = '<option selected="" value="">--</option>';
            for( var i=0; i < data.length; i++){
              html +='<option value="'+data[i]['token']+'">'+data[i]['fname']+' '+data[i]['sname']+' '+data[i]['suffix']+'</option>';
            }
            $("#personnel_id").html(html);
          }
      });
  },

  additional_inputs: function(subsystem)
  {
    var system = $('#sys_main').val();
    $.ajax({
       url: Dms.base_url + 'Dms/additional_inputs',
       method: 'POST',
       data: { system: system, subsystem : subsystem },
       success: function(data) {
         $('#additional_inputs').html(data);
       }
    });
  },

  prcvw: function(transaction_id, staff_id, page_name)
  {
    $.ajax({
         url: Dms.base_url + 'Datatables/view_transaction',
         type: 'POST',
         data: { transaction_id: transaction_id, staff_id: staff_id, page_name: page_name },
         success: function(result) {
             $('#prcv').html(result);
         }
     });
   },

  mainSysClick: function(main_val, loc)
  {
    // (main_val) this.value
    // (loc) 0 - NEW TRANSACTION, 1 - PROCESS TRANSACTION
    $('#sysap_div'+loc).empty();
    $('#hwid_li'+loc).hide();
    $('#ptt_li'+loc).hide();
    $('#mnfst_li'+loc).hide();
    $('#cot_li'+loc).hide();
    $('#swtrpt'+loc).hide();


    $('#subfncediv'+loc).hide();
    $('#subfnceid'+loc).attr('required', false);

    $('#allsubcat_div'+loc).hide();

    $('#wnov_div'+loc).hide();
    $('#wnov_div'+loc+' select').attr('required', false);
    $('#wnovprmt_div'+loc).hide();
    document.getElementById('wnov'+loc).value = '';

    $('#ntrns_atch'+loc).attr("required", true);

    $('#atthere0').show();
    $("#inrlte"+loc).hide();

    var strURL2="hwms/subsys.php?id="+main_val+"&cnt="+loc+"&stfn="+stfn;
    var req2 = getXMLHTTP();

    if (req2) {

      req2.onreadystatechange = function() {
        if (req2.readyState == 4) {
          // only if "OK"
          if (req2.status == 200) {
            document.getElementById('transid'+loc).innerHTML=req2.responseText;
          } else {
            alert("Problem while using XMLHTTP:\n" + req2.statusText);
          }
        }
      }
      req2.open("GET", strURL2, true);
      req2.send(null);
    }

    $('#transid'+loc).attr('disabled', false);
  },

  subSysClick: function(sub_val, loc, main_val, func, sect)
  {
    // (main_val) main system value
    // (sub_val) this.value
    // (loc) 0 - NEW TRANSACTION, 1 - PROCESS TRANSACTION
    $('#sysap_div'+loc).empty();
    $('#treeplnt'+loc).hide();
    $("#treeplnt"+loc+" :input").attr("required", false);
    $("#inrlte"+loc).hide();

    $('#swtrpt'+loc).hide();
    document.getElementById('wnov'+loc).value = '';
    $('#wnovprmt_div'+loc).hide();

    $('#allsubcat_div'+loc).hide();

    if(sub_val == 52){
      $('#atthere'+loc).show();
      // $('#tonumber'+loc).show();
      $('#tonoselectize'+loc).attr("required", true);
      $('#ntrns_atch'+loc).attr("required", true);
    }else if(sub_val != 52 && sub_val != 51){
      // $('#tonumber'+loc).hide();
      $('#tonoselectize'+loc).attr("required", false);
    }

    if(sub_val == 50 || sub_val == 52 || sub_val == 51){
      $('#tonumber'+loc).show();
    }else if(sub_val != 50 || sub_val != 52 || sub_val != 51){
      $('#tonumber'+loc).hide();
    }

    if(sub_val == 51)
    {
      $('#swrinrelation'+loc).show();
      $('#swrinrltn'+loc).attr("required", true);
      $('#swstatus'+loc).attr("required", true);
      $('#swtrpt'+loc).show();
      $('#swdate_patrolled'+loc).attr("required", true);
      $('#swtime_patrolled'+loc).attr("required", true);
      $('#swlatitude'+loc).attr("required", true);
      $('#swlongitude'+loc).attr("required", true);
      $('#swdate_monitored'+loc).attr("required", true);
      $('#sweetfilesw'+loc).attr("required", true);
      $('#ptremarks'+loc).attr("required", true);
      $('#ttlarea'+loc).attr("required", true);
      $('#ntrns_atch'+loc).attr("required", false);
      $('#atthere0').hide();
      $('#tonoselectize'+loc).attr("required", true);
    }

    if(sub_val != 51)
    {
      $('#swrinrelation'+loc).hide();
      $('#swrinrltn'+loc).attr("required", false);
      $('#swstatus'+loc).attr("required", false);
      $('#swdate_patrolled'+loc).attr("required", false);
      $('#swtime_patrolled'+loc).attr("required", false);
      $('#swbrgy'+loc).attr("required", false);
      $('#swlatitude'+loc).attr("required", false);
      $('#swlongitude'+loc).attr("required", false);
      $('#swdate_monitored'+loc).attr("required", false);
      $('#sweetfilesw'+loc).attr("required", false);
      $('#ptremarks'+loc).attr("required", false);
      $('#ttlarea'+loc).attr("required", false);
    }

    if(sub_val == 23)
    {
      // $('#swdate_patrolled'+loc).attr("required", false);
      $('#montoreporting'+loc).show();
      $('#withtravel'+loc).attr("required", true);
    }
    if(sub_val != 23)
    {
      // $('#swdate_patrolled'+loc).attr("required", false);
      $('#montoreporting'+loc).hide();
      $('#withtravel'+loc).attr("required", false);
    }

    /* PERMITTING SYSTEM AND NOV Additional Input Fields */
    if(main_val == 4 || sub_val == 19 || sub_val == 54 || sub_val == 60)
    {
      $.ajax({
        url: "hwms/sysap.php",
        type: 'POST',
        data: { sid : sub_val, mid: main_val },
        success: function(result) {
          $('#sysap_div'+loc).show();
          $('#sysap_div'+loc).html(result);
          if(main_val == 4)
          {
            $('#sys_pno'+loc).hide();
          }
        }
      });
    }
    else
    {
      $('#sysap_div'+loc).hide();
      $('#sys_pno'+loc).hide();
    }

    if(sub_val == 23)
    {
      $('#wnov_div'+loc).show();
      $('#wnov_div'+loc+' select').attr('required', true);
    }
    else
    {
      $('#wnov_div'+loc).hide();
      $('#wnov_div'+loc+' select').attr('required', false);
    }

    if(main_val == 7)
    {
      if(document.getElementById('cmpnyid'+loc).value)
      {
        var coid = document.getElementById('cmpnyid'+loc).value;
        showHwmsTab(coid, loc, main_val, sub_val);
      }
    }

    if(main_val == 6)
    {
      $('#swmsubcat20').parent('div').hide();
      $('#swmsubcat30').parent('div').hide();
      $.ajax({
        url: "er/swmsubcat.php",
        type: 'POST',
        data: { val : sub_val, cat : 1 },
        success: function(result) {
          $('#allsubcat_div'+loc).show();
          $('#swmsubcat10').parent().show();
          $('#swmsubcat10').html(result);
          $('#swmsubcat2'+loc).parent('div').hide();
        }
      });
    }

    if(loc == 0) {
      ttypeChanget(sub_val, func, stfn, sect, loc );
    }

    $.ajax({
      url: "er/subfnce.php",
      type: 'POST',
      data: { id : sub_val, cnt: loc, stfn: stfn },
      success: function(result) {
        if(sub_val == 56)
        {
          $('#subfncediv'+loc).show();
          $('#subfnceid'+loc).attr('required', true);
          $('#subfnceid'+loc).html(result);
        }
        else
        {
          $('#subfncediv'+loc).hide();
          $('#subfnceid'+loc).attr('required', false);
        }
      }
    });
  },

  novwith: function(val)
  {
    $('#novwith_div0').hide();

    if(val == 2)
    {
      $.ajax({
        url: "hwms/sysap.php",
        type: 'POST',
        data: { novwval : val },
        success: function(result) {
          $('#novwith_div0').show();
          $('#novwith_div0').html(result);
        }
      });
    }
  },

  labSubCats: function(val, cat)
  {
    $('#novwith_div0').hide();
    $('#3rdsubdiv0').hide();
    $.ajax({
      url: "er/labres.php",
      type: 'POST',
      data: { novwval : val, categ : cat },
      success: function(result) {
        if(val == 3) {
          $('#novwith_div0').show();
          $('#novwith_div0').html(result);
        }
      }
    });
  },

  labSubSW: function(val, cat)
  {
    $('#3rdsubdiv0').hide();
    $.ajax({
      url: "er/labres.php",
      type: 'POST',
      data: { novwval : val, categ : cat },
      success: function(result) {
        $('#3rdsubdiv0').show();
        $('#3rdsubdiv0').html(result);
      }
    });
  },

  swmSubCat: function(val, cat)
  {
    $.ajax({
      url: "er/swmsubcat.php",
      type: 'POST',
      data: { val : val, cat : cat },
      success: function(result) {
        if(result != 0)
        {
          $('#swmsubcat'+cat+'0').parent('div').show();
          $('#swmsubcat'+cat+'0').html(result);
        }
        else
        {
          $('#swmsubcat'+cat+'0').parent('div').hide();
          $('#swmsubcat'+(cat+1)+'0').parent('div').hide();
        }
      }
    });
  },

  showHwmsTab: function(coid, loc, main_val, sub_val)
  {
    if(main_val == 7 && sub_val != 0 && coid)
    {
      $('#hwid_li'+loc).hide();
      $('#ptt_li'+loc).hide();
      $('#mnfst_li'+loc).hide();
      $('#cot_li'+loc).hide();

      if(sub_val == 37) {
        $('#hwid_li'+loc).show();
        hwms_type = '';
      }
      else if(sub_val == 29) {
        $('#ptt_li'+loc).show();
        hwms_type ='ptt';
      }
      else if(sub_val == 35) {
        $('#mnfst_li'+loc).show();
        hwms_type ='mnfst';
      }
      else if(sub_val == 36) {
        $('#cot_li'+loc).show();
        hwms_type ='cot';
      }

      var strURL="hwms/hazid.php?coid="+coid+"&hwms_type="+hwms_type;
      var req = getXMLHTTP();

      if (req)
      {
        req.onreadystatechange = function()
        {
          if (req.readyState == 4)
          {
            if (req.status == 200)
            {
              if(hwms_type != '')
              {
                document.getElementById('subid_'+hwms_type).innerHTML=req.responseText;
              }
            }
            else
            {
              alert("Problem while using XMLHTTP:\n" + req.statusText);
            }
          }
        }
        req.open("GET", strURL, true);
        req.send(null);
      }
    }
    else
    {
      $('#hwid_li'+loc).hide();
      $('#ptt_li'+loc).hide();
      $('#mnfst_li'+loc).hide();
      $('#cot_li'+loc).hide();
    }

    getComp2(coid);
  },

  brgyy: function(id) //FOR SWEET -added by EJD
  {
    var strURL="er/sweet/call/brgy.php?id="+id;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4)
        {
          // only if "OK"
          if (req.status == 200)
          {
            document.getElementById('brgybdy').innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  lgupatrolled: function(id) //FOR SWEET -added by EJD
  {
    var strURL="er/sweet/call/lgu_patrolled.php?id="+id;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4)
        {
          // only if "OK"
          if (req.status == 200)
          {
            document.getElementById('lgu_patrolleds').innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  inrelationto: function(id,qsinby) //FOR SWEET -added by EJD
  {
    var strURL="er/sweet/call/inrelationto.php?id="+id+"&qsinby="+qsinby;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4)
        {
          // only if "OK"
          if (req.status == 200)
          {
            document.getElementById('inrelationtobody').innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  idToWaste: function(hwmsid, hwms_type)
  {
    var strURL="hwms/hwaste.php?hwmsid="+hwmsid+"&hwms_type="+hwms_type;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4)
        {
          if (req.status == 200)
          {
            document.getElementById('hwaste_'+hwms_type).innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }

    // if(hwms_type == 'ptt')
    // {
      var strURL2="hwms/pttid.php?hwmsid="+hwmsid+"&hwms_type="+hwms_type;
      var req2 = getXMLHTTP();

      if (req2)
      {
        req2.onreadystatechange = function()
        {
          if (req2.readyState == 4)
          {
            if (req2.status == 200)
            {
              document.getElementById('pno_'+hwms_type).value = req2.responseText;
            }
            else
            {
              alert("Problem while using XMLHTTP:\n" + req2.statusText);
            }
          }
        }
        req2.open("GET", strURL2, true);
        req2.send(null);
      }
    // }
  },

  getDiv: function(divID, staff, cnt, cnt2)
  {
    // if(cnt2 != 0)
    // {
    //   var type=cnt2;
    // }
    // else
    // {
    var type = document.getElementById('transid'+cnt);

    if(type != null && type.value != '')
    {
      type = type.value;
    }
    else
    {
      type = '';
    }
    // }
    // alert(x);
    var strURL="er/addsec.php?divid="+divID+"&staff="+staff+"&type="+type;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4)
        {
          // only if "OK"
          if (req.status == 200)
          {
          document.getElementById('secslct'+cnt).innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  getSec: function(secID, staff, cnt, cnt2)
  {
    // if(cnt2 != 0)
    // {
    //   var type=cnt2;
    // }
    // else
    // {
    var type = document.getElementById('transid'+cnt);
    if(type != null && type.value != '')
    {
      type = type.value;
    }
    else
    {
      type = '';
    }
    // }

    var strURL="er/addunit.php?secid="+secID+"&staff="+staff+"&type="+type;
    var req = getXMLHTTP();

    if (req)
    {
      req.onreadystatechange = function()
      {
        if (req.readyState == 4) {
        // only if "OK"
          if (req.status == 200)
          {
            document.getElementById('personslct'+cnt).innerHTML=req.responseText;
          }
          else
          {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  getprcTtype: function(transType, cnt, coid, tnodmy, staff, secno)
  {
    var strURL="er/prcaddatype.php?ttype="+transType+"&prccnt="+cnt+"&coid="+coid+"&tnodmy="+tnodmy;
    var req = getXMLHTTP();

    if (req) {
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          // only if "OK"
          if (req.status == 200) {
            document.getElementById('prcatype'+cnt).innerHTML=req.responseText;
          } else {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }

    // // GITANGTANG FOR NOW, IBALIK RAH LATERZ
    // if(transType < 11)
    // {
    //   $("#prcatype"+cnt).attr("hidden", false);
    // }
    // else
    // {
    //   $("#prcatype"+cnt).attr("hidden", true);
    // }

    typeComp(transType);
    // if(transType === '11' || transType === '13')
    // {
    //   $("#authordiv"+cnt).attr("hidden", false);
    //   $("#authorinput"+cnt).attr("required", true);
    // }
    // else
    // {
    //   $("#authordiv"+cnt).attr("hidden", true);
    //   $("#authorinput"+cnt).attr("required", false);
    // }

    var strURL="er/adddiv.php?type="+transType+"&dzstf="+staff;
    var req = getXMLHTTP();

    if (req) {

      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          // only if "OK"
          if (req.status == 200) {
            document.getElementById('divslct'+cnt).innerHTML=req.responseText;
          } else {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
    document.getElementById('secslct'+cnt).innerHTML="<option selected='' value=''>Select Division First</option>";
    document.getElementById('personslct'+cnt).innerHTML="<option selected='' value=''>Select Section First</option>";


    if(transType ==='22')
    {
      $("#submoa"+cnt).attr("hidden", false);
      $("#subtransin"+cnt).attr("required", true);
    }
    else
    {
      $("#submoa"+cnt).attr("hidden", true);
      $("#subtransin"+cnt).attr("required", false);
    }

    if(transType ==='23' || transType ==='24' || transType ==='25')
    {
      // alert(ttype);
      $("#reporting"+cnt).attr("hidden", false);
      // $("#tchw"+cnt).attr("hidden", false);
      // $("#prcatype"+cnt).attr("hidden", true);
    }
    else
    {
      $("#reporting"+cnt).attr("hidden", true);
      // $("#tchw"+cnt).attr("hidden", true);
      // $("#prcatype"+cnt).attr("hidden", false);
    }

    // $("#prcmenutab1"+cnt).hide();
    $("#prcmenutab2"+cnt).hide();
    $("#eccrefinput"+cnt).attr("required", false);
    $("#eccdatinput"+cnt).attr("required", false);
    $("#cncrefinput"+cnt).attr("required", false);
    $("#cncdatinput"+cnt).attr("required", false);
    $("#ecctemppanel"+cnt).hide();
    $("#eccbdpanel"+cnt).hide();
    $("#cnctemppanel"+cnt).hide();
    $("#cncbdpanel"+cnt).hide();
    $("#potemppanel"+cnt).hide();
    $("#pobdpanel"+cnt).hide();
    $("#ccortemppanel"+cnt).hide();
    $("#ccorbdpanel"+cnt).hide();
    $("#hwidtemppanel"+cnt).hide();
    $("#hwidbdpanel"+cnt).hide();
  },

  witnov: function(nov_val, loc)
  {
    if(nov_val == 1)
    {
      $('#wnovprmt_div'+loc).show();
    }
    else
    {
      $('#wnovprmt_div'+loc).hide();
    }
  },

  adreqChange: function(adrqc, loc)
  {
    $('#treeplnt'+loc).hide();
    $("#treeplnt"+loc+" :input").attr("required", false);
    if(adrqc == 2)
    {
      $('#treeplnt'+loc).show();
      $("#treeplnt"+loc+" :input").attr("required", true);
    }
  },

  prcgetCity: function(provinceID, c)
  {
    var strURL="er/prcadrs/prcacity.php?prov="+provinceID+"&cnt="+c;
    var req = getXMLHTTP();

    if (req) {

      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          // only if "OK"
          if (req.status == 200) {
            document.getElementById('prcct'+c).innerHTML=req.responseText;
          } else {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  prcgetBrgy: function(cityID, c)
  {
    // alert('asd');
    var strURL="er/prcadrs/prcabrgy.php?city="+cityID+"&cnt="+c;
    var req = getXMLHTTP();
    // alert('citd sod');
    if (req) {

      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          // only if "OK"
          if (req.status == 200) {
            document.getElementById('prcbrgy'+c).innerHTML=req.responseText;
          } else {
            alert("Problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send(null);
    }
  },

  yRadio: function(c)
  {
    for(var i = 0; i < 3; i++)
    {
      $("#prcxpinput"+i+c).attr("disabled", false);
      $("#prcxpinput"+i+c).attr("required", true);
    }
  },

  nRadio: function(c)
  {
    for(var i = 0; i < 3; i++)
    {
      $("#prcxpinput"+i+c).attr("disabled", true);
      $("#prcxpinput"+i+c).attr("required", false);
    }
  },

  eccRef: function(v, s)
  {
    document.getElementById('eccref'+s).innerHTML = v;
  },

  cncRef: function(v, s)
  {
    document.getElementById('cncref'+s).innerHTML = v;
  },

  prcTstat: function(stat, cnt)
  {
    if( ( stat > 16 && stat < 20 ) || stat === '24' || stat === 44 || stat == 0 || stat == 27 )
    {
      $("#divslct"+cnt).attr("required", false);
      $("#secslct"+cnt).attr("required", false);
      $("#personslct"+cnt).attr("required", false);
      $("#returnsender").hide();
      $("#assto"+cnt).hide();
      $("#assgnd"+cnt).hide();
      $("#asstolbl"+cnt).hide();
    }
    else
    {
      $("#divslct"+cnt).attr("required", true);
      $("#secslct"+cnt).attr("required", true);
      $("#personslct"+cnt).attr("required", true);
      $("#returnsender").hide();
      $("#assto"+cnt).show();
      $("#assgnd"+cnt).show();
      $("#asstolbl"+cnt).show();
    }
  },

  onLoop: function(ttype, cnt, staff, secno)
  {

    if(ttype ===23 || ttype ===24 || ttype ===25)
    {
      $("#reporting"+cnt).attr("hidden", false);
      // $("#tchw"+cnt).attr("hidden", false);
      // $("#prcatype"+cnt).attr("hidden", true);
    }
    else
    {
      $("#reporting"+cnt).attr("hidden", true);
      // $("#tchw"+cnt).attr("hidden", true);
      // $("#prcatype"+cnt).attr("hidden", false);
    }

    if(staff != 1 || staff != '2' && staff != '3' && staff != '4' && staff != '5' && secno != '9' && staff != '15' && staff != '16' && staff != '9' && staff != '19' && staff != '46' && secno != '1' && secno != '2' && secno != '6') {
      $("#inlongp"+cnt).attr("required", true);
      $("#inlatp"+cnt).attr("required", true);
      if(ttype < '11') { // all permitting type transactions
        $("#prmt"+cnt).attr("required", true);
        $("#prmtspan"+cnt).attr("hidden", false);
      }
      else {
        $("#prmt"+cnt).attr("required", false);
        $("#prmtspan"+cnt).attr("hidden", true);
      }
    }
    else {
      $("#prmt"+cnt).attr("required", false);
      $("#prmtspan"+cnt).attr("hidden", true);
      $("#inlongp"+cnt).attr("required", false);
      $("#inlatp"+cnt).attr("required", false);
    }

    if(ttype < 11)
    {
      $("#prcatype"+cnt).attr("hidden", false);
    }
    else
    {
      $("#prcatype"+cnt).attr("hidden", true);
    }



    if(staff =='16')
    {
      $("#floci"+cnt).show();
      $("#floc"+cnt).attr("required", true);
    }
    else
    {
      $("#floci"+cnt).hide();
      $("#floc"+cnt).attr("required", false);
    }
  },

  secRep: function(ttype, sec, cnt)
  {
    if(ttype === 23 || ttype === 24 || ttype === 25) {
      // $('#tchw'+cnt).hide();
      $("#tchw"+cnt).attr("hidden", true);
      alert(cnt);
      if(sec == '4') {
        // $('#tchw'+cnt).show();
        $("#tchw"+cnt).attr("hidden", false);
      }
    }
    else
    {
      $("#tchw"+cnt).attr("hidden", false);
    }
  },

  onAmend: function(obj, val, cnt)
  {
    if($(obj).is(":checked")){
      // alert("Yes checked"); //when checked
      // $("#page-header-inner").addClass("sticky");
      if(val === '1')
      {
        $("#prcn"+cnt).attr("readonly", false);
      }
      if(val === '2')
      {
        // $(".prloc"+cnt).attr("required", false);
        $("#prlocr"+cnt).hide();
        $("#prlocd"+cnt).show();
      }

    }else{
      // alert("Not checked"); //when not checked

      if(val === '1')
      {
        $("#prcn"+cnt).attr("readonly", true);
      }
      if(val === '2')
      {
        // $(".prloc"+cnt).attr("required", true);
        $("#prlocr"+cnt).show();
        $("#prlocd"+cnt).hide();
      }
    }
  },

  emtTotal: function(val, cnt)
  {
    val+= val;
    document.getElementById("emtesttotal"+cnt).value =val;
  },

  returnSender: function(stat, cnt)
  {
    var x = document.getElementById("returnsender");
    document.getElementById("returnclient").style.display = "none";

    if (x.style.display === "none") {
      if( ( stat > 16 && stat < 20 ) || stat === 24 || stat === 44 )
      {
        $("#divslct"+cnt).attr("required", false);
        $("#secslct"+cnt).attr("required", false);
        $("#personslct"+cnt).attr("required", false);
        document.getElementById('rtsnd').value = 1;
        $("#assgnd"+cnt).hide();
        x.style.display = "block";
      }
    } else {
      if( ( stat > 16 && stat < 20 ) || stat === 24 || stat === 44 )
      {
        $("#divslct"+cnt).attr("required", true);
        $("#secslct"+cnt).attr("required", true);
        $("#personslct"+cnt).attr("required", true);
        document.getElementById('rtsnd').value = 0;
        $("#assgnd"+cnt).show();
        x.style.display = "none";
      }
    }
  },

  returnClient: function(stat, cnt)
  {
    var x = document.getElementById("returnclient");
    document.getElementById("returnsender").style.display = "none";

    if (x.style.display === "none") {
      if( ( stat > 16 && stat < 20 ) || stat === 24 || stat === 44 )
      {
        $("#divslct"+cnt).attr("required", false);
        $("#secslct"+cnt).attr("required", false);
        $("#personslct"+cnt).attr("required", false);
        document.getElementById('rtsnd').value = 2;
        $("#assgnd"+cnt).hide();
        x.style.display = "block";
      }
    } else {
      if( ( stat > 16 && stat < 20 ) || stat === 24 || stat === 44 )
      {
        $("#divslct"+cnt).attr("required", true);
        $("#secslct"+cnt).attr("required", true);
        $("#personslct"+cnt).attr("required", true);
        document.getElementById('rtsnd').value = 0;
        $("#assgnd"+cnt).show();
        x.style.display = "none";
      }
    }
  },

  pofee: function(unit)
  {
    var addfind = document.createElement('div');
    var xc = $(this).closest('#pohiddenjutsu').value;
    addfind.innerHTML = document.getElementById('poaddfind').innerHTML;
    document.getElementById('poaddfindhere').appendChild(addfind);
  },

  emtest: function(cnt)
  {
    // alert('asd');
    var addemt = document.createElement('tr');
    // var xc = $(this).closest('#addpoemtest').value;
    addemt.innerHTML = document.getElementById('addpoemtest').innerHTML;
    // alert('asd');
    document.getElementById('addpoemtesthere'+cnt).appendChild(addemt);
    // alert('asd');
  },

  permit: function()
  {
    var addfind = document.createElement('div');
    var xc = $(this).closest('#pohiddenjutsu').value;
    addfind.innerHTML = document.getElementById('poaddfind').innerHTML;
    document.getElementById('poaddfindhere').appendChild(addfind);
  },

  adtrnsatt: function(cnt)
  {
    var adtrnsatt = document.createElement('div');
    // var xc = $(this).closest('#pohiddenjutsu').value;
    adtrnsatt.innerHTML = document.getElementById('thisatt').innerHTML;
    document.getElementById('atthere'+cnt).appendChild(adtrnsatt);
  },

  pototal: function(cnt)
  {
    var tot = 0;
    var tcnge = document.getElementsByClassName('poff'+cnt);
      for(var i = 0; i < tcnge.length; i++)
      {
        tot += new Number(tcnge[i].value);
      }
    document.getElementById("emtesttotal"+cnt).value = tot;
  },

};
