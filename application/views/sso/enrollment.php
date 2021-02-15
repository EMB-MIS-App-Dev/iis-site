<div class="container-fluid">
    <?php if($this->session->flashdata('flashmsg')): ?> 
        <p style='color: red'><?php echo $this->session->flashdata('flashmsg'); ?></p>
    <?php endif; ?>


  <div class="row">
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">SSO Systems</h6>
          <h1><?php $_SESSION['userid']; ?></h1>
          <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <!-- Card Body -->
          <div class="card-body">

          <form action="<?= base_url('ssoenroll'); ?>" method="post" accept-charset="utf-8">
              <table>
                <tr>
                  <td>
                    <select class='form-control' name="selSubsystem" id="selSubsystem">
                        <option value="" selected="true">Select</option>
                        <option value="PCB|https://pcb.emb.gov.ph/home|<?php echo base_url().'assets/images/systems/pcb.png'?>" >PCB</option>
                        <option value="HWMS|https://hwms.emb.gov.ph/home|<?php echo base_url().'assets/images/systems/hwms.png'?>" >HWMS</option>
                        <option value="IIS|https://iis.emb.gov.ph/embis/dashboard|<?php echo base_url().'assets/images/systems/iis.png'?>" >IIS</option>
                    </select>
                  </td>
                  <td><input type="text" name="txtnickname" id="nickname" placeholder="Nickname" class="form-control"  /></td>
                  <td><input type="text" name="txtusernames" id="username" class="form-control" placeholder="Username" id="username"/></td>
                  <td><input type="password" name="txtpasswords" id="password" class="form-control" placeholder="Password" id="password"/></td>
                  <td><button type="submit" class="btn btn-primary btn-sm">
                      <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                      </span>
                      <span class="text">Add sub-system</span>
                    </button>
                  </td>
                </tr>
              </table>
          </form>
    
            <table id="tablesub" class="table table-striped table-bordered " style="width:100%">

              <thead>
                <tr>
                  <th>Sub-System</th>
                  <th>Nickname</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="subsystem" >
               
              </tbody>
            </table>

            

            <!-- <script type="text/javascript">
              $(document).ready(function() {
                $('#downloadablestable').DataTable();
              } );
            </script> -->
          </div>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function(){

    //get data subsystems
      function getList(){
        $.ajax({
            url: "<?php echo base_url(); ?>ssoget",
            dataType: 'json',
            type: 'get',
            cache:false,
            success: function(data){
                /*console.log(data);*/
                var event_data = '';
                $.each(data, function(index, value){
                    /*console.log(value);*/
                    event_data += '<tr>';
                    event_data += '<td><a href="'+value.subsys_link+'" target="_blank">'+value.subsys_id+'</a></td>';
                    event_data += '<td>'+value.nickname+'</td>';
                    event_data += '<td>'+value.username+'</td>';
                    event_data += '<td><i>(hidden)</i></td>';
                    event_data += '<td>'+
                                    '<a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>ssorem/'+value.sso_id+'">'+
                                        '<span class="icon text-white-50">'+
                                            '<i class="fas fa-trash"></i>'+
                                        '</span>'+
                                    '</a>'+
                                  '</td>';
                    event_data += '<tr>';
                });
                $(".subsystem").empty();
                $(".subsystem").append(event_data);
            },
            error: function(d){
                /*console.log("error");*/
                alert("404. Please wait until the File is Loaded.");
            }
        });
      }

      getList();
  });    

</script>
