<?php
  switch ($system) {
    case 1: // ORD
    case 2: // ADMINISTRATIVE
      if(count($sub_types) > 1)
      {
        ?>
        <div class="form-group">
          <label><?php echo ucwords(mb_strtolower($type[0]['name'])); ?> Types:</label>
          <select class="form-control" >
            <option selected value="">--</option>
            <?php
              foreach ($sub_types as $key => $value) {
                echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
              }
            ?>
          </select>
        </div>
        <?php
      }
      break;

    case 3: // FINANCIAL
      if(count($sub_types) > 1)
      {
        ?>
        <div class="form-group">
          <label><?php echo ucwords(mb_strtolower($type[0]['name'])); ?> Category:</label>
          <select class="form-control" >
            <option selected value="">--</option>
            <?php
              $head = 0;
              foreach ($sub_types as $key => $value) {
                if($value['subcat1'] != 0)
                {
                  if($value['subcat1'] == $value['id']) {
                    if($head != 0) {
                      echo '</optgroup>';
                      echo '<optgroup label="'.$value['dsc'].'">';
                      $head = $value['subcat1'];
                    }
                    else {
                      $head = $value['subcat1'];
                      echo '<optgroup label="'.$value['dsc'].'">';
                    }
                  }
                  else {
                    echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                  }
                }
                else {
                  if($head != 0) {
                    echo '</optgroup>';
                    $head = 0;
                  }
                  echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                }
              }
            ?>
          </select>
        </div>
        <?php
      }
      break;

    case 4: // PERMITTING
    if(isset($sys_subtypes)){
      echo 'asdsad';
    }
    else if(count($sub_types) > 1)
      {
        ?>
          <div class="form-group">
            <label>Application Type:</label>
            <select class="form-control" id="appli_type" name="appli_type">
              <option selected value="">--</option>
              <?php
                foreach ($sub_types as $key => $value) {
                  echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                }
              ?>
            </select>
          </div>

          <div class="form-group" id="permit_no_id">
            <label><?php echo $type[0]['name']; ?> No.:</label>
            <input class="form-control" name="permit_no" value="" />
          </div>


          <div class="form-group" >
            <label>Start Date:</label>
            <input class="form-control" type="date" name="exp_start_date" value="" />
          </div>


          <div class="form-group" >
            <label>End Date:</label>
            <input class="form-control" type="date" name="exp_end_date" value="" />
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
      }
      break;

    case 5: // MONITORING
      ?>
      <?php
      break;

    default:
      break;
  }

?>
