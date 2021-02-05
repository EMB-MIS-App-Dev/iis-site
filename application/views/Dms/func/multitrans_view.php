<div class="col-md-12" style="text-align: center">
  <?php
    if(!empty($trans_history[0]['receiver_id']))
    {
    ?>
    <table class="table table-striped" style="zoom: 87%">
      <thead class="thead-dark">
        <tr>
          <th>Date Rcvd/Created</th>
          <th>Action</th>
          <th style="min-width: 5% !important; width: 17% !important;">Remarks</th>
          <th>From</th>
          <th>Status</th>
          <th>Assigned</th>
          <th>Date Forwarded</th>
          <th>View Attachment</th>
        </tr>
      </thead>
      <tbody>
          <?php
            // if($user_token=='515e12d4a186a84')
            // {
            //   echo '123123';
            //   echo '<pre>';
            //   print_r($attachment_view);
            // }
            $trns_date = date('Y', strtotime($trans_data[0]['start_date']));
            foreach ($trans_history as $key => $value) {
              $rcvr = (!empty(trim($value['receiver_name']))) ? $value['receiver_name'] : '--';
              $attach = '--';

              $trans_no_calculated = $value['trans_no'];
              $tnscalc=0;
              if($value['date_in'] < '2020-02-16') {
                $trans_no_calculated = $value['trans_no'] - 10000000;
                $tnscalc=1;
              }

              if(!empty($attachment_view[$key]))
              {
                if(sizeof($attachment_view[$key]) > 1)
                {
                  $attach = "<div class='dropdown'><button class='btn btn-info btn-sm waves-effect waves-light' type='button' data-toggle='dropdown'>View <i class='far fa-caret-square-down'></i></button> <ul class='dropdown-menu'>";

                  foreach ($attachment_view[$key] as $att_key => $att_value) {
                    if(!empty($prnl_onlowerthread) || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
                    {
                      $attach .= "<li><a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a></li>";
                    }
                    else {
                      $attach .= "<li>".$att_value['token']."</li>";
                    }
                  }
                  $attach .= "</ul></div>";
                  // BULK DOWNLOAD
                  if($special_view || !empty($prnl_onlowerthread) || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
                  {
                    $attach .= "<a title='Bulk Download' href='".base_url('Dms/Dms/bulk_download/'.$value['trans_no']."_".$trans_data[0]['main_multi_cntr']."_".$value['route_order']."_".$value['multi_cntr']."_".$trans_data[0]['region']."_".$tnscalc)."' target='_blank'><i class='fa fa-download' value=''></i></a>";
                  }



                }
                else {
                  $att_value = $attachment_view[$key][0];
                  if(!empty($prnl_onlowerthread) || !empty($prnl_inthread) || in_array($user_func['func'], array('Director', 'Assistant Director')) || $_SESSION['superadmin_rights'] == 'yes' || $_SESSION['dms_all_view_attachment'] == 'yes')
                  {
                    $attach = "<a title='".$att_value['file_name']."' href='".base_url('uploads/dms/'.$trns_date.'/'.$trans_data[0]['region'].'/'.$trans_no_calculated.'/'.$att_value['token'].'.'.pathinfo($att_value['file_name'], PATHINFO_EXTENSION))."' target='_blank'>".$att_value['token']."</a>";
                  }
                  else {
                    $attach = $att_value['token'];
                  }
                }
              }

              $date_out = (!empty($value['date_out']) && $value['date_out'] != '0000-00-00 00:00:00') ? date("M j Y, g:i a", strtotime($value['date_out'])) : '--';

              // if( $value['route_order'] != 0 && (!empty($value['receiver_id']) || $value['status'] == 24 || $value['type'] == 83) ) {
              if( $value['multiprc'] != 1 && $value['route_order'] != 0) {
                echo "<tr>
                  <td>".date("M j Y, g:i a", strtotime($value['date_in']))."</td>
                  <td>".$value['action_taken']."</td>
                  <td style='word-break: break-all !important'>".$value['remarks']."</td>
                  <td>".$from_name[$key].$value['sender_name']."</td>
                  <td>".$value['status_description']."</td>
                  <td>".$receiver_name[$key].$rcvr."</td>
                  <td>".$date_out."</td>
                  <td>".$attach."</td>
                </tr>";
              }
            }
          ?>
      </tbody>
    </table>
    <?php
    }
  ?>

  <?php
    if(!empty($multitrans_histo)) {
      echo '<span class="set_error">*This transaction was routed to multiple persons below*</span>';
      foreach ($multitrans_histo as $key => $value) {
        $multi_key = $value['trans_no'].'_'.$value['main_route_order'].'_'.$value['main_multi_cntr'].'_'.$value['multi_cntr'];
        echo '
          <button onclick="multitrans_div($(this))" style="color:#FFF;background-color:#08507E;" class="btn btn-default btn-sm " type="button" data-toggle="collapse" data-target="#multitrans_'.$multi_key.'" id="buttonassignsec">
            <span style="color: white">'.$value['main_multi_cntr'].' Person '.$value['multi_cntr'].'</span>
            <span class="fa fa-caret-down" id="btncaretsub"></span>
          </button>
          <div class="collapse" id="multitrans_'.$multi_key.'">
            <div id="multitrans_'.$multi_key.'_insert" class="row">
              <div class="col-md-12">- loader - </div>
            </div>
          </div>
        ';
      }
    }
  ?>
</div>

<script>
  function multitrans_div(_this = '')
  {
    $.ajax({
       url: '<?php echo base_url('Dms/');?>' + 'Dms/multitrans_history',
       method: 'POST',
       data: { multitrans : _this.data("target")},
       success: function(data) {
         var idx = _this.data("target").substring(1);
         $('div[id="'+idx+'_insert"]').html(data);

       }
    });
  };
</script>
