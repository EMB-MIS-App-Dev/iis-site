<!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="row">
    </div>
    <div class="row">
      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">COMPANY LISTS</h6>
          </div>

          <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table table-hover" id="admin_company_lists" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Emb Id</th>
                      <th>Company Name</th>
                      <th>Date Registered</th>
                      <th>Location</th>
                      <th>Project Type</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($comp_details as $key => $value): ?>
                      <tr>
                          <td><?=$value['emb_id']?></td>
                          <td><?=$value['company_name']?></td>
                          <td><?=$value['input_date']?></td>
                          <td><?=$this->session->userdata('region').','.$value['province_name']?></td>
                          <td><?=$value['project_name']?></td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

            </div>

        </div>
      </div>
    </div>
