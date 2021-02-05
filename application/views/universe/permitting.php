
    <div class="container-fluid">
      <div class="row">

        <!-- DATATABLES Card -->
        <div class="col-xl-12 col-lg-12">
          <div class="trans-layout card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary"><i class="fab fa-galactic-senate"></i> UNIVERSE - PERMITTING</h6>

            </div>

            <!-- Card Body -->
              <div class="univ-div card-body">

                <div class="row" >
                  <div class="table-responsive">
                    <table id="univ1" class="table table-striped table-hover" cellspacing="0" align="left">
                      <thead>
                        <tr align="left">
                          <th>#</th>
                          <th style="min-width:450px !important">Comp/Proj Name</th>
                          <th>encrypt</th>
                          <th>Address</th>
                          <th>proj_type</th>
                          <th>status</th>
                          <th>ECC</th>
                          <th>CNC</th>
                          <th>LUC</th>
                          <th>DP</th>
                          <th>PO</th>
                          <th>PCO</th>
                          <th>SQI</th>
                          <th>PICCS</th>
                          <th>CCO IC</th>
                          <th>CCO RG</th>
                          <th>COT</th>
                          <th>MNFST</th>
                          <th>PTT</th>
                          <th>TSD</th>
                          <th>HWGEN</th>
                          <th>TRC</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>

              </div>
            <!-- Card Body -->

          </div>

        </div>
      </div>
    </div>

  </div>

<script>

  $(document).ready(function() {
    var table = $('#univ1').DataTable( {
        order: [[ 0, "asc" ]],
        serverSide: true,
        autoWidth: true,
        scrollY: true,
        scrollX: true,
        fixedColumns: {
            leftColumns: 2
        },
        ajax: {
            "url": "<?php echo base_url('Universe/Datatables/permitting'); ?>",
        },
        processing: true,
        responsive: true,
        language:
        {
            processing: "<img src='"+'<?php echo base_url('assets/images/loader/embloader.gif'); ?>'+"' alt='embloader.gif' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='"+'<?php echo base_url('assets/images/loader/prcloader.gif'); ?>'+"' alt='prcloader.gif' style='width:120px; height:50px;' />",
        },
        columns: [
            { "data": "company_id"},
            {
                "data": "company_name",
                "render": function(data, type, row, meta) {
                    if(type === 'display') {
                        data = '<a href="<?php echo base_url('Company/Company_details?compid='); ?>'+ row.enc_compid +'" title="'+ row.address +'">' + data + '</a>';
                    }
                    return data;
                 }
            },
            { "data": "enc_compid", "visible": false},
            { "data": "address", "visible": false },
            { "data": "project_type", "visible": false },
            { "data": "status", "visible": false },
            { "data": "ecc", "render": function(data, type, row, meta){ return (type === 'display') ? iPermit(data) : ''; } },
            { "data": "cnc", "render": function(data, type, row, meta){ return (type === 'display') ? iPermit(data) : ''; } },
            { "data": "luc", "render": function(data, type, row, meta){ return (type === 'display') ? iPermit(data) : ''; } },
            { "data": "dp", "render": function(data, type, row, meta){ return (type === 'display') ? iPermit(data) : ''; } },
            { "data": "po", "render": function(data, type, row, meta){ return (type === 'display') ? iPermit(data) : ''; } },
            {
                "data": "pco",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        render = iPermit(data);
                    }
                    return render;
                 }
            },
            {
                "data": "sqi",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "piccs",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "ccoic",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "ccoreg",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "cot",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "mnfst",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "ptt",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "tsd",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "hwgen",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
            {
                "data": "trc",
                "className":"maincol",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        data = iPermit(data);
                    }
                    return data;
                 }
            },
        ]
    } );

    function iPermit(data)
    {
      var toggle = '';

      if(data != '0') {
          toggle += '<a href="#myModal" id="translist" role="button" class="btn" data-toggle="modal">';
      }
      else {
          toggle += '<a>';
      }

      switch(data) {
        case '0': toggle += '<input type="checkbox" disabled><span class="checkmark"></span>'; break;
        case '5': toggle += '<i class="fa fa-check" title="Approved"></i><span class="sr-only"></span> </a>'; break;
        case '6': toggle += '<span style="color:red;"><i class="fa fa-close" title="Disapproved"></i></span></a>'; break;
        case '9': toggle += '<span style="color:#ff7700;"><i class="fa fa-reply" title="For Return"></i></span></a>'; break;
        case '16': toggle += '<span style="font-size:4px; color:red;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"  title="For Releasing"></i></span></a>'; break;
        case '17': toggle += '<i class="fa fa-clock-o" aria-hidden="true" title="For Claiming"></i><span class="sr-only"></span></a>'; break;
        case '18': toggle += '<i class="fa fa-check-square-o" aria-hidden="true" title="Claimed"></i><span class="sr-only"></span></a>'; break;
        case '19': toggle += '<i class="fa fa-envelope-o" aria-hidden="true" title="Sent Via Courier"></i><span class="sr-only"></span></a>'; break;
        case '20': toggle += '<span style="color:red;"><i class="fa fa-refresh" aria-hidden="true" title="Returned"></i></span></a>'; break;
        case '21': toggle += '<b title="For Payment">&#8369;</b><span class="sr-only"></span></a>'; break;
        case '22': toggle += '<i class="fa fa-clock-o" aria-hidden="true" title="Paid/Approved/For Claiming"></i><span class="sr-only"></span></a>'; break;
        case '23': toggle += '<i class="fa fa-check-square-o" aria-hidden="true" title="Paid/Approved/Claimed"></i><span class="sr-only"></span></a>'; break;
        default: toggle += '<span style="font-size:4px; color:#4ed836;"><i class="fa fa-cog fa-spin fa-3x fa-fw" title="Processing"></i></span>'; break;
      }
      toggle += '</a>';

      return toggle;
    }
    //
    // $('#univ1 tbody').on( 'click', 'td', function () {
    //   var data = table.row( $(this).parents('tr') ).data();
    //   var aData = table.row( this ).data();
    //   var visIdx = $(this).index();
    //   if(visIdx > 2) {
    //       univCoid( data['coid'], visIdx, 0 );
    //   }
    // } );

    // $( '#diz th' ).on( 'click', function () {
    //     var data = table.row( $(this).parents('tr') ).data();
    //     univCoid( data['coid'], data['ttype'], 0 );
    // } );


  } );

</script>
