
var Universe = {

  base_url: '',

  accomp_filter: function(type)
  {
    var frm = $('#accomp_filter_form');
    $.ajax({
      url: frm.attr('action'),
      type: frm.attr('method'),
      data: frm.serialize() + "&type=" + type,
      dataType: 'json',
      success: function(data) {
        window.location = data.site;
      }
    });
  },

  // ----------------------------------           ------------------------------------------------- //

  select_region: function (region_name = '')
  {
    $.ajax({
        url: Universe.base_url+"Universe/select_region",
        type: 'POST',
        data: { region_name: region_name },
        dataType: 'json',
        success:function(data)
        {
          var html = '<option selected="" value="">--</option>';
          for( var i=0; i < data.length; i++) {
            html +='<option value="'+data[i]['divno']+'">'+data[i]['divname']+'</option>';
          }

          $("#division_id").html(html);
        }
    });
  },

  select_division: function (division_name = '')
  {
    var region_name = '';

    if($('#region_id').val()) {
      region_name = $('#region_id').val();
    }
      console.log(division_name);

    $.ajax({
          url: Universe.base_url+"Universe/select_division",
          type: 'POST',
          data: { division_name: division_name, region_name: region_name },
          dataType: 'json',
          success:function(data)
          {
            var html = '<option selected="" value="">--</option>';
            if(division_name)
            {
              html += '<option value="0">N/A</option>';
            }
            for( var i=0; i < data.length; i++){
              html +='<option value="'+data[i]['secno']+'">'+data[i]['sect']+'</option>';
            }

            $("#section_id").html(html);
          }
      });
  },

  select_section: function (section_name, _this = '')
  {
    var division_name = $('#division_id').val();
    var region_name = '';

    console.log(section_name);
    $.ajax({
      url: Universe.base_url+"Universe/select_section",
      type: 'POST',
      data: { section_name: section_name, division_name: division_name, region_name: region_name },
      dataType: 'json',
      success:function(data)
      {
        var html = '<option selected="" value="">--</option>';
        for( var i=0; i < data.length; i++){
          html +='<option value="'+data[i]['token']+'">'+data[i]['fname']+' '+data[i]['mname'][0]+' '+data[i]['sname']+'</option>';
        }
        $("#personnel_id").html(html);
      }
    });
  },


  // select_section: function (section_name, _this = '')
  // {
  //   var division_name = $('#division_id').val();
  //   var region_name = '';
  //
  //   if(_this == '') {
  //     if($('#region_id').val()) {
  //       region_name = $('#region_id').val();
  //     }
  //   }
  //   else {
  //     division_name = _this.closest('tr').find('.multi_division_id').val();
  //     region_name = _this.closest('tr').find('.multi_region_id').val();
  //   }
  //
  //   $.ajax({
  //         url: Universe.base_url+"Universe/select_section",
  //         type: 'POST',
  //         data: { section_name: section_name, division_name: division_name, region_name: region_name },
  //         dataType: 'json',
  //         success:function(data)
  //         {
  //           var html = '<option selected="" value="">--</option>';
  //           if(section_name){
  //             for( var i=0; i < data.length; i++){
  //               html +='<option value="'+data[i]['token']+'">'+data[i]['fname']+' '+data[i]['sname']+' '+data[i]['suffix']+'</option>';
  //             }
  //           }
  //
  //           if(_this == '') {
  //             $("#personnel_id").html(html);
  //           }
  //           else {
  //             _this.closest('tr').find('.multi_personnel_id').html(html);
  //           }
  //         }
  //     });
  // },
};
