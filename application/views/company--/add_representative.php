<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">ADD NEW REPRESENTATIVE</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
    <form class="" action="<?php echo base_url(); ?>/Company/Representative/add_representative" method="post" enctype="multipart/form-data">
      <div class="row">
        <!-- comapny address -->
        <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ADD STAFF</h6>
          </div>
          <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0 font-weight-bold text-gray-800">LAST NAME:</div>
              <input type="text" name="lname" value="" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0 font-weight-bold text-gray-800">FIRST NAME:</div>
              <input type="text" name="fname" value="" class="form-control">
            </div>
            <div class="col-xl-12 mb-3">
              <div class="h5 mb-0 font-weight-bold text-gray-800">MIDDLE NAME:</div>
              <input type="text" name="mname" value="" class="form-control">
            </div>

              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0 font-weight-bold text-gray-800">Sex:</div>
                <div class="row">
                  <div class="col-xl-6">
                    <input type="radio" name="sex" value="male" class="btn btn-success btn-circle btn-sm">
                    <label for="">MALE</label>
                  </div>
                  <div class="col-xl-6">
                    <input type="radio" name="sex" value="female" class="btn btn-success btn-circle btn-sm">
                    <label for="">FEMALE</label>
                  </div>
                </div>
              </div>
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0 font-weight-bold text-gray-800">PERSONAL CONTACT #:</div>
                <input type="number" name="per_num" value="" class="form-control">
              </div>
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0 font-weight-bold text-gray-800">PERSONAL EMAIL:</div>
                <input type="text" name="per_email" value="" class="form-control">
              </div>
              <div class="col-xl-12 mb-3">
                <div class="h5 mb-0 font-weight-bold text-gray-800">DESIGNATION:</div>
                <input type="text" name="designation" value="" class="form-control">
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- Company information -->
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow py-2">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">COMPANY INFORMATION</h6>
          </div>
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col-xl-12 mb-3">
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Company Type:</div>
                <div class="row">
                  <div class="col-xl-6">
                    <input type="radio" name="comp_type" value="1" id="rep_show_main_comp_id" onclick="rep_show_main_comp()" class="btn btn-success btn-circle btn-sm" checked>
                    <label for="">MAIN</label>
                  </div>
                  <div class="col-xl-6">
                    <input type="radio" name="comp_type" value="2" id="rep_show_branch_comp_id" onclick="rep_show_branch_comp()" class="btn btn-success btn-circle btn-sm">
                    <label for="">BRANCH</label>
                  </div>
                </div>
              </div>
              <!-- for branch_comp -->
              <div class="col-xl-12 mb-3">
                <div class="col-xl-12 mb-3">
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Select Main Company: ( required )</div>
                  <select class="form-control" name="main_comp" id="main_comp_id">
                    <option value="">SELECT MAIN COMPANY</option>
                    <?php foreach ($companies as $key => $valuecmop): ?>
                        <option value="<?php echo $valuecmop['company_id']; ?>"><?php echo $valuecmop['company_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-xl-12 mb-3 rep_project_name" style="display:none">
                  <div class="h5 mb-0 font-weight-bold text-gray-800">Project Name: ( required ):</div>
                  <input type="text" name="project_name" value="" class="form-control" placeholder="Enter Project name">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-12 mb-3">
      <button type="submit" class="btn btn-success btn-icon-split" style="float:right"><span class="text">SAVE</span></button>
    </div>
    </form>
</div>

<script src="<?php echo base_url(); ?>assets/js/representative.js"></script>
