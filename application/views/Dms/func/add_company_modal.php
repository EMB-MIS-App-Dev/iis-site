
  <div class="row">
      <div class="col-md-12">
        <label>Region:</label>
  			<div class="col-md-5">
          <select id="adm_region_slctn" class="form-control" name="region">
            <?php
              echo '<option value="" selected>--</option>';
              foreach ($region as $key => $value) {
                echo '<option value="'.$value['rgnnum'].'">'.$value['rgnnam'].'</option>';
              }
            ?>
          </select>
        </div>
      </div>
      <br /><br /> <br /><br />
      <div class="col-md-12">
        <label>Company:</label>
        <div class="row">
          <!-- <div class="col-md-12"> -->
            <div class="col-md-8">
              <select id="adm_company_slctn" class="form-control select2" name="company">
                  <option value="" selected>--</option>
              </select>
            </div>
            <div class="col-md-2">
              <button id="adm_show_comp_dtls" type="button" class="btn btn-success">Show</button>
            </div>
          <!-- </div> -->
        </div>
      </div>
      <br /><br /> <br /><br />
      <div class="col-md-12">
        <label>Company Details:</label>
        <div id="adm_company_details" class="col-md-12">
        </div>
      </div>

  </div>

<script>

	$(document).ready(function() {
    var company_slct = $('#adm_company_slctn').select2();
    $('#adm_region_slctn').change(function() {
        var _this = $(this);
        $.ajax({
            url: '<?=base_url('Dms/Ajax_Data/get_company_list')?>',
            data: { 'region_id': _this.val() },
            type: 'POST',
            success: function(data){
                if (company_slct.hasClass("select2-hidden-accessible")){
                    company_slct.select2("destroy").empty().html(data).select2().change();
                } else {
                    company_slct.empty().html(data).change();
                }
            },
            error: function(){
                company_slct.select2("destroy").empty().html("<option value=''>--</option>").select2().change();
                console.log("ERROR");
            }
        })
    });

    $('#adm_show_comp_dtls').on('click', function() {
      $.ajax({
         url: Dms.base_url + 'Ajax_Data/show_comp_dtls',
         method: 'POST',
         data: { company_token : company_slct.val() },
         success: function(data) {
           $('div#adm_company_details').html(data);
         }
      });
    });

	} );



</script>
