<div class="container-fluid">
  <style media="screen">
  .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{border:none!important}
  .nav-tabs .nav-item{margin-bottom: 0px!important;}
  </style>
  <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">

                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                      <ul class="nav" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link btn-primary active" id="u-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn-primary" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">Personnel</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link btn-primary" id="list-tab" data-toggle="tab" href="#p" role="tab" aria-controls="p" aria-selected="false">Permits</a>
                        </li>
                      </ul>
                      <h6 class="m-0 font-weight-bold text-primary"> Company Details - <?php echo $_SESSION['region']; ?></h6>
                  </div>

                  <!-- Card Body -->
                    <div class="card-body">
                      <div class="tab-content" id="myTabContent">
                        <!-- Area of Assignment -->
                        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="u-tab">
                          <div id="main_content">
                            <div class="row">
                              <div class="col-xl-6">
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">Company ID:</div>
                                  <input type="text"  value="<?php echo $company_data[0]['company_id']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Company Name:</div>
                                <input type="text"  value="<?php echo $company_data[0]['company_id']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">Project Type:</div>
                                  <input type="text"  value="<?php echo $company_data[0]['project_name']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Project Category:</div>
                                <input type="text"  value="<?php echo $company_data[0]['category']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">Company Tel:</div>
                                  <input type="text"  value="<?php echo $company_data[0]['contact_no']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Company Email:</div>
                                <input type="text"  value="<?php echo $company_data[0]['email']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">Company Address:</div>
                                  <input type="text"  value="<?php echo $company_data[0]['barangay_name'].$company_data[0]['city_name'].$company_data[0]['province_name']; ?>" class="form-control" disabled>
                              </div>
                              <div class="col-xl-6">
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Company Mailing Address:</div>
                                <input type="text"  value="<?php echo $company_data[0]['mailing_add']; ?>" class="form-control" disabled>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                          <div id="table-responsive" style="margin-top: 10px;">
                            <table class="table table-hover table-responsive-custom" id="region_sections" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>First Name</th>
                                  <th>Middle Name	</th>
                                  <th>Last Name</th>
                                  <th>Contact Number</th>
                                  <th>Email</th>
                                  <th>Designation</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
                          </div>
                        </div>
                        <!-- Section -->
                        <div class="tab-pane fade" id="p" role="tabpanel" aria-labelledby="list-tab">
                          <div id="table-responsive" style="margin-top: 10px;">
                            <table class="table table-hover table-responsive-custom" id="region_sections" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Transactions</th>
                                  <th>ID/Number</th>
                                  <th>Date Issued</th>
                                  <th>Date of Expiration</th>
                                  <th>Count</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>
                  <!-- Card Body -->

                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">COMPANY PHOTO</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myPieChart" width="301" height="245" class="chartjs-render-monitor" style="display: block; width: 301px; height: 245px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>
