<script>
   function setDataTables(tableDiv, tableData, tableCols, postData) {
      let tableID = $('#'+tableDiv);
      let table = tableID.find('table').DataTable( {
         lengthMenu: [ [5, 15, -1], [5, 15, "All"] ],
         dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-1'<'region_slct'>><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'<'search_bar'>><'col-sm-12 col-md-1'<'search_btn'>>>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         language: {
            "infoFiltered": "",
            processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
         },
         serverSide: true,
         processing: true,
         responsive: true,
         scrollX: true,
         ajax: {
            "url": "<?=base_url('planner/table_data/')?>"+tableData,
            "type": 'POST',
            data: postData
         },
         columns: tableCols
      } );

      tableID.find("div.search_bar").html('<input class="search_bar search_fld form-control form-control-sm" />');
      tableID.find("div.search_btn").html('<button class="search_btn search_fld btn btn-sm btn-outline-primary" type="button"><i class="fas fa-search"></i></button><span class="search_spinner" style="display: none">&nbsp;<i class="fas fa-spinner fa-pulse"></i></span>');

      tableID.find(".search_btn").on('click', function() {
         console.log(tableID.find(".search_bar").val());
         table.settings()[0].jqXHR.abort();
         table.search(tableID.find(".search_bar").val()).draw();
         tableID.find('.search_spinner').show();
         tableID.find(".search_fld").prop('disabled', true);
      });

      table.on( 'draw', function() {
         tableID.find('.search_spinner').hide();
         tableID.find(".search_fld").prop('disabled', false);
      });
   }

   function initUserDesignationGroups(field_grouplist) {
      $.each(field_grouplist, function(index, field_group) {
         field_group = $(field_group);
         let region_slct = field_group.find('select.region');
         let division_slct = field_group.find('select.division');
         let section_slct = field_group.find('select.section');
         let personnel_slct = field_group.find('select.personnel');

         $.ajax({
            url: '<?=base_url("planner/ajax_data/get_region")?>',
            method: 'POST',
            success: function(response) {
               region_slct.html(response).selectize();
            },
            error: function(response) {
               region_slct.empty().html("<option value=''>-No Data-</option>").change();
               console.log("ERROR");
            },
         });

         region_slct.change(function() {
            let region_val = $(this).val();
            $.ajax({
               url: '<?=base_url("planner/ajax_data/get_division")?>',
               method: 'POST',
               data: {'region': region_val },
               success: function(response) {
                  let selectize = division_slct.selectize();
                  selectize[0].selectize.destroy();
                  division_slct.empty().html(response).selectize().change();
               },
               error: function(response) {
                  division_slct.empty().html("<option value=''>-No Data-</option>").change();
                  console.log("ERROR");
               },
            });
         }).change();

         division_slct.change(function() {
            let division_val = $(this).val();
            $.ajax({
               url: '<?=base_url("planner/ajax_data/get_section")?>',
               method: 'POST',
               data: {'region': region_slct.val(), 'division': division_val },
               success: function(response) {
                  let selectize = section_slct.selectize();
                  selectize[0].selectize.destroy();
                  section_slct.empty().html(response).selectize().change();
               },
               error: function(response) {
                  section_slct.empty().html("<option value=''>-No Data-</option>").change();
                  console.log("ERROR");
               },
            });
         }).change();

         section_slct.change(function() {
            let section_val = $(this).val();
            $.ajax({
               url: '<?=base_url("planner/ajax_data/get_personnel")?>',
               method: 'POST',
               data: {'region': region_slct.val(), 'division': division_slct.val(), 'section': section_val },
               success: function(response) {
                  let selectize = personnel_slct.selectize({ maxItems: null });
                  selectize[0].selectize.destroy();
                  personnel_slct.empty().html(response).selectize().change();
               },
               error: function(response) {
                  personnel_slct.empty().html("<option value=''>-No Data-</option>").change();
                  console.log("ERROR");
               },
            });
         }).change();
      });
   }
</script>
