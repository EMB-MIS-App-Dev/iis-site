var Vehicle = {
  base_url: 'https://iis.emb.gov.ph/embis/Vehicle/',
  search_to_btw_date: function() {
    var dep_date  = $('#departure_date_vh').val();
    var arr_date  = $('#arrival_date_vh').val();
    $.ajax({
      url: Crs.base_url + 'Serverside/emp_with_to_table',
      type: 'GET',
      data: {arr_date:arr_date,dep_date:dep_date},
      success:function(response)
        {
        // $('#select_province_id').html(response);
          $('#user_list').DataTable().ajax.reload();
        }
    });
  }
}
