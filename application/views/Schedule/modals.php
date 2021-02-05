
<style media="screen">
  .modal-content{
    border:none;
  }
</style>

<div class="modal fade" id="create_schedule" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraccountsModalLabel">Create Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?php echo base_url(); ?>Schedule/Postdata/create" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>* Subject</label>
              <input type="text" class="form-control" placeholder="e.g Division Meeting, Planning, etc.." name="subject" required>
            </div>
            <div class="col-md-6">
              <label>* Location</label>
              <input type="text" class="form-control" placeholder="e.g Conference Room, Web App, etc.." name="location" required>
            </div>
            <div class="col-md-3">
              <label>* Date Schedule</label>
              <input type="date" class="form-control" name="date_schedule" required>
            </div>
            <div class="col-md-3">
              <label>* Time Schedule</label>
              <input type="time" class="form-control" name="time_schedule" required>
            </div>
            <div class="col-md-12">
              <label>* Select Participants</label>
              <div id="participantsview" style="float: right;margin-top: 2px;">
                <button type="button" class="btn btn-info btn-sm" onclick="viewparticipants('<?php echo $this->encrypt->encode('national'); ?>'); viewparticipantsselectize('<?php echo $this->encrypt->encode('national'); ?>');">Switch to National View of Personnel</button>
              </div>
              <div id="participantsviewselectize_">
                <select id="participants_selectize" class="form-control" name="participants[]" required>
                  <option value="">-</option>
                  <?php for ($i=0; $i < sizeof($useraccounts); $i++) {
                    $title = (!empty($useraccounts[$i]['title'])) ? $useraccounts[$i]['title'].' ': '';
                    $mname = (!empty($useraccounts[$i]['mname'])) ? $useraccounts[$i]['mname'][0].'. ': '';
                    $suffix = (!empty($useraccounts[$i]['suffix'])) ? ' '.$useraccounts[$i]['suffix']: '';
                    $name = $title.$useraccounts[$i]['fname'].' '.$mname.$useraccounts[$i]['sname'].$suffix;
                    $section = (!empty($useraccounts[$i]['sect'])) ? ' ('.$useraccounts[$i]['sect'].')': '';
                  ?>
                    <optgroup label="<?php echo $useraccounts[$i]['divname'].$section; ?>">
                      <option value="<?php echo $this->encrypt->encode($useraccounts[$i]['userid']); ?>"><?php echo $name; ?></option>
                    </optgroup>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <label>Do you want to display this schedule to national calendar?</label>
              <select class="form-control" id="displayselectize" name="displayoptions" required>
                <option value="">-</option>
                <option value="<?php echo $this->encrypt->encode('Yes'); ?>">Yes</option>
                <option value="<?php echo $this->encrypt->encode('No'); ?>">No</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="float:left;" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Schedule Details -->
  <div class="modal fade" id="view_schedule" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="useraccountsModalLabel">Schedule Details</h5>
          <label style="display:flex;position:absolute;right: 55px;top: 23px;" id="schedstatus_"></label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div id="schedule-details"></div>

      </div>
    </div>
  </div>
<!-- Schedule Details -->

<script type="text/javascript">
  $('#participants_selectize').selectize({
      maxItems: null
  });
  $('#displayselectize').selectize();
</script>
