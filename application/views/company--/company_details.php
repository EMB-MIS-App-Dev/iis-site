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
                  <h6 class="m-0 font-weight-bold text-primary"><?= $company_data[0]['company_name']; ?> </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <!-- <div class="dropdown-header">Dropdown Header:</div> -->
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" style="width:100%!important">
                          <a class="nav-link active" id="u-tab" data-toggle="tab" href="#u" role="tab" aria-controls="u" aria-selected="true" >About</a>
                        </li>
                        <li class="nav-item" style="width:100%!important">
                          <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">Personnel</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="tab-pane fade show active" id="u" role="tabpanel" aria-labelledby="u-tab">
                    <div id="main_content">
                      <div class="col-xl-12">
                              <div class="h4 m-0 font-weight-bold text-primary">ABOUT</div>
                              <hr>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Company ID: </div>
                          </div>
                          <div class="col-xl-6">
                            <?php //echo "<pre>";print_r($company_data); ?>
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['company_id']; ?></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Project Type: </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['project_name']; ?></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Project Category: </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"> - </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Company Tel. </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['contact_no']; ?> </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Company Email: </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['email']; ?> </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Company Address: </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['barangay_name'].',',$company_data[0]['city_name'].','.$company_data[0]['province_name']; ?> </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="row">
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-primary">Company Mailing Address: </div>
                          </div>
                          <div class="col-xl-6">
                          <div class="mb-0 font-weight-bold text-gray-800"><?= $company_data[0]['mailing_add']; ?> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                    <div id="main_content">
                      <h1>PERSONNEL</h1>
                    </div>
                  </div>
                </div>
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
