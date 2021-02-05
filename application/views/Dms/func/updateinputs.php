<?php
  switch ($trans_data[0]['system']) {
    case 1: // ORD
    case 2: // ADMINISTRATIVE
    case 10: // LAB
    case 11: // EEIU
    case 12: // RECORDS
    case 13: // LEGAL
      if(count($sub_types) > 1)
      {
        ?>
        <div class="form-group">
          <label><?php echo ucwords(strtolower($trans_data[0]['type_description'])); ?> Type:</label>
          <select class="form-control" name="appli_type">
            <option selected value="">--</option>
            <?php
              foreach ($sub_types as $key => $value) {
                if($value['id'] == $system_types[0]['subtype_id']) {
                  echo '<option selected value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                }
                else {
                  echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                }
              }
            ?>
          </select>
        </div>
        <?php
          if(in_array($this->session->userdata('userid'), array(1, 51))) {
            if(in_array($type[0]['id'], array(12, 78, 79)))
            {
              $type_no = !empty($system_types[0]['type_no']) ? trim($system_types[0]['type_no']) : '';
              echo '<div class="form-group"><label>'.ucwords(strtolower($type[0]['name'])).' No:</label><input class="form-control" name="type_no" value="'.$type_no.'"></div>';
            }
          }
      }
      break;

    case 3: // FINANCIAL
      if(count($sub_types) > 1)
      {
        ?>
        <div class="form-group">
          <label><?php echo ucwords(strtolower($system_types[0]['sub_desc'])); ?> Category:</label>
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
                    if($value['id'] == $system_types[0]['subtype_id']) {
                      echo '<option selected value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                    }
                    else {
                      echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                    }
                  }
                }
                else {
                  if($head != 0) {
                    echo '</optgroup>';
                    $head = 0;
                  }

                  if($value['id'] == $system_types[0]['subtype_id']) {
                    echo '<option selected value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                  }
                  else {
                    echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                  }
                }
              }
            ?>
          </select>
        </div>
        <?php
      }
      break;

    case 4: // PERMITTING
      if(count($sub_types) > 1)
      {
        ?>
          <div class="form-group">
            <label>Application Type:</label>
            <select class="form-control" id="appli_type" name="appli_type">
              <option selected value="">--</option>
              <?php
                foreach ($sub_types as $key => $value) {
                  if($value['id'] == $system_types[0]['subtype_id']) {
                    echo '<option selected value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                  }
                  else {
                    echo '<option value="'.$value['id'].'" >'.$value['dsc'].'</option>';
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group" id="permit_no_id">
            <label><?php echo $system_types[0]['sub_desc']; ?> No.:</label>
            <input class="form-control" name="permit_no" value="<?php echo trim($system_types[0]['permit_no']); ?>" />
          </div>

          <div class="form-group" >
            <label>Start Date:</label>
            <input class="form-control" type="date" name="exp_start_date" value="<?php echo $system_types[0]['exp_start_date']; ?>" placeholder="yyyy-mm-dd"/>
          </div>


          <div class="form-group" >
            <label>End Date:</label>
            <input class="form-control" type="date" name="exp_end_date" value="<?php echo $system_types[0]['exp_end_date']; ?>" placeholder="yyyy-mm-dd"/>
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
