<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Downloadables</h6>
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <!-- Card Body -->
          <div class="card-body">
            <table id="downloadablestable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Guide / Manual</th>
                  <th style="width:20%!important;text-align:center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="<?php echo base_url(); ?>../iis-images/downloadables/guides/IIS Geocam Guide.pdf" target="_blank">IIS Geocam (for Environmental Monitoring Officers, etc.)</a></td>
                  <td><a href="<?php echo base_url(); ?>../iis-images/downloadables/apk/app-debug.apk" target="_blank" class="btn btn-info btn-sm" style="width:100%!important;"><span class="fa fa-download"></span>&nbsp;Download APK</a></td>
                </tr>
                <tr>
                  <td><a href="<?php echo base_url(); ?>uploads/user_manuals/SMR.zip" target="_blank">SMR (Self Monitoring Report)</a></td>
                  <td><a href="<?php echo base_url(); ?>uploads/user_manuals/SMR.zip" target="_blank" class="btn btn-info btn-sm" style="width:100%!important;"><span class="fa fa-download"></span>&nbsp;Download manual</a></td>
                </tr>
                <tr>
                  <td><a href="<?php echo base_url(); ?>uploads/STEPS ON HOW TO USE COMPANY REGISTRATION SYSTEM FOR CLIENT.docx" target="_blank">CRS (Company Registration System)</a></td>
                  <td><a href="<?php echo base_url(); ?>uploads/STEPS ON HOW TO USE COMPANY REGISTRATION SYSTEM FOR CLIENT.docx" target="_blank" class="btn btn-info btn-sm" style="width:100%!important;"><span class="fa fa-download"></span>&nbsp;Download manual</a></td>
                </tr>
                <tr>
                  <td><a href="<?php echo base_url(); ?>../iis-images/downloadables/guides/SWEET-ENMO INVESTIGATION REPORT manual.pdf" target="_blank">SWEET-ENMO Investigation Report</a></td>
                  <td><a href="<?php echo base_url(); ?>../iis-images/downloadables/guides/SWEET-ENMO INVESTIGATION REPORT manual.pdf" target="_blank" class="btn btn-info btn-sm" style="width:100%!important;"><span class="fa fa-download"></span>&nbsp;Download manual</a></td>
                </tr>
              </tbody>
            </table>
            <script type="text/javascript">
              $(document).ready(function() {
                $('#downloadablestable').DataTable();
              } );
            </script>
          </div>
      </div>
    </div>
  </div>
</div>
