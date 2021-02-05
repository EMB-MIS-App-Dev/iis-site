
<script>
    var address = $('.address-selections');
    $.each(address, function(index, group){
      var group = $(group);

      const params = {
        // options: [],
        dropdownParent: "body",
        placeholder: '--',
        valueField: 'value',
        labelField: 'text',
        searchField: ['text', 'optgroup'],
        create: false
      };

      var region_slct = group.find('.region-select').selectize(params);
      var province_slct = group.find('.province-select').selectize(params);
      var city_slct = group.find('.city-select').selectize(params);
      var barangay_slct = group.find('.barangay-select').selectize(params);

      region_slct.change(function() {
        var region_val = $(this).val();
        $.ajax({
            url: "<?=base_url('Pco/Data/get_province')?>",
            method: 'POST',
            data: { 'selected': province_slct.data('selected'), 'region': region_val }, // 'fieldname': province.attr('name'),
            dataType: 'json',
            success: function(res) {
              var response = res.data;
              var htmldata = '';
              if (response[0] != undefined) {
                  // re-fill html select option field
                  province_slct.html(htmldata);
                  // re-fill/set the selectize values
                  var selectize = province_slct[0].selectize;

                  selectize.clear();
                  selectize.clearOptions();
                  selectize.addOption(response);
                  console.log(response.value);
                  selectize.setValue(response.value = res.selected);
                  //When closing empty dropdown, set the grabbed value
                  selectize.on('blur', function() {
                    if(this.getValue() == '') {
                      this.setValue(response[0].value);
                    }
                  });
              }
            },
            error: function(response) {
              // province_slct.empty().html(response).change(); // make a foreach
              province_slct.empty().html("<option value=''>-No Data-</option>").change();
              console.log("ERROR");
            },
        });
      }).change();

      province_slct.change(function() {
        var province_val = $(this).val();
        $.ajax({
            url: "<?=base_url('Pco/Data/get_city')?>",
            method: 'POST',
            data: { 'selected': city_slct.data('selected'), 'province': province_val }, // 'fieldname': city.attr('name'),
            dataType: 'json',
            success: function(res) {
              var response = res.data;
              var htmldata = '';
              if (response[0] != undefined) {
                  // re-fill html select option field
                  city_slct.html(htmldata);
                  // re-fill/set the selectize values
                  var selectize = city_slct[0].selectize;

                  selectize.clear();
                  selectize.clearOptions();
                  selectize.addOption(response);
                  selectize.setValue(response.value = res.selected);
                  // When closing empty dropdown, set the grabbed value
                  selectize.on('blur', function() {
                    if(this.getValue() == '') {
                      this.setValue(response[0].value);
                    }
                  });
              }
            },
            error: function(response) {
              // city_slct.empty().html(response).change(); // make a foreach
              city_slct.empty().html("<option value=''>-No Data-</option>").change();
              console.log("ERROR");
            },
        });
      });

      city_slct.change(function() {
        var city_val = $(this).val();
        $.ajax({
            url: "<?=base_url('Pco/Data/get_barangay')?>",
            method: 'POST',
            data: { 'selected': barangay_slct.data('selected'), 'city': city_val }, // 'fieldname': barangay.attr('name'),
            dataType: 'json',
            success: function(res) {
              var response = res.data;
              var htmldata = '';
              if (response[0] != undefined) {
                  // re-fill html select option field
                  barangay_slct.html(htmldata);
                  // re-fill/set the selectize values
                  var selectize = barangay_slct[0].selectize;

                  selectize.clear();
                  selectize.clearOptions();
                  selectize.addOption(response);
                  selectize.setValue(response.value = res.selected);
                  //When closing empty dropdown, set the grabbed value
                  selectize.on('blur', function() {
                    if(this.getValue() == '') {
                      this.setValue(response[0].value);
                    }
                  });
              }
              else {
                // barangay_slct.empty().html(response).change(); // make a foreach
                barangay_slct.empty().html("<option value=''>-No Data-</option>").change();
                console.log("Error: Unidentified response[0]");
              }
            },
            error: function(response) {
              barangay_slct.empty().html("<option value=''>-No Data-</option>").change();
              console.log("ERROR");
            },
        });
      });
    });
</script>
