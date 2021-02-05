<?php

  switch ($system) {
    case 1: // ORD
      ?>
      <?php
      break;

    case 2: // ADMINISTRATIVE
      ?>
      <?php
      break;

    case 3: // FINANCIAL
      ?>
      <?php
      break;

    case 4: // PERMITTING
      ?>
        <div class="form-group">
          <label>Application Type:</label>
          <select class="form-control" id="appli_type">
            <option selected value="">--</option>
            <?php
              foreach ($application_type as $key => $value) {
                echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
              }
            ?>
          </select>
        </div>

        <div class="form-group" id="permit_no_id">
          <label><?php echo $type[0]['name']; ?> No.:</label>
          <input class="form-control" name="permit_no" value="" />
        </div>

        <script>
          $(document).ready(function (){
      			$("#appli_type").selectize({
      				onChange: function(value, isOnInitialize) {
      					console.log("Selectize event: Change on company_list");
      				}
      			});
          });
        </script>
      <?php
      break;

    case 5: // MONITORING
      ?>
      <?php
      break;

    default:
      break;
  }

?>
