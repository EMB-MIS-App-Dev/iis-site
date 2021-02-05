
<style>
  div#dmsTipsModal img {
    display: block;
    margin: auto;
    width: auto;
    height: 550px  !important;
  }
  div#dmsTipsModal .card-header{
    color: rgb(88, 151, 225)
  }
  div#dmsTipsModal .card-header h5 {
    margin: auto;
  }
  div#dmsTipsModal p{
    text-align: center
  }

  /* OWL CAROUSEL PREVIOUS & NEXT BUTTONS */
  .owl-item {
      display: none;
  }
  .owl-prev {
      width: 15px;
      height: 100px;
      position: absolute;
      top: 40%;
      margin-left: -20px;
      display: block !important;
      border:0px solid black;
  }
  .owl-next {
      width: 15px;
      height: 100px;
      position: absolute;
      top: 40%;
      right: -25px;
      display: block !important;
      border:0px solid black;
  }
  .owl-prev i, .owl-next i {transform : scale(1,6); color: #ccc;}

  /* BUTTON LOADER */
  .btn-loading-overlay > .spinner-border,
  .btn-loading-overlay > .spinner-brow {
    vertical-align: middle;
  }
  .btn-loading-overlay {
    position: relative;
  }
  .btn-loading-overlay .btn-inner-text,
  .btn-loading-overlay .spinner {
    transition: 0.3s all ease;
  }
  .btn-loading-overlay .spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
  }
  .btn-loading-overlay .btn-inner-text {
    opacity: 1;
  }
  .btn-loading-overlay.btn-loading span.spinner {
    opacity: 1;
  }
  .btn-loading-overlay.btn-loading .btn-inner-text {
    opacity: 0;
  }
</style>

    <div id="dmsTipsModal" class="modal fade in" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div class="card-header">
                  <h5 class="modal-title">DMS Reopening Tips</h5>
                </div>
                <div class="modal-body">

                  <div id="loading-placeholder" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>
                  <div class="owl-carousel owl-theme owl-loaded your-class1">
                    <div class="owl-stage-outer">
                      <div class="owl-stage">
                        <div class="owl-item">
                            <img class="img-thumbnail" src="/iis-images/tips/filed_closed/reopen1.jpg" alt="DMS REOPEN TIPS" />
                            <br />
                            <p><b style="color: rgb(181, 46, 36)">Step 1:</b> Click on the "<b>Reopen Button</b>" denoted with the "<i class="fas fa-lock-open"></i>" icon.</p>
                        </div>
                        <div class="owl-item">
                            <img class="img-thumbnail" src="/iis-images/tips/filed_closed/reopen2.jpg" alt="DMS REOPEN TIPS" />
                            <br />
                            <p><b style="color: rgb(181, 46, 36)">Step 2:</b> A pop-up will appear showing the IIS Transaction number of the transaction to be opened for confirmation. You may also input remarks/reason for the reopening of the transaction. Click on "<b>Reopen Button</b>" to proceed.</p>
                        </div>
                        <div class="owl-item">
                            <img class="img-thumbnail" src="/iis-images/tips/filed_closed/reopen3.jpg" alt="DMS REOPEN TIPS" />
                            <br />
                            <p><b style="color: rgb(181, 46, 36)">Step 2-note:</b> If the action was successful, a pop-up will appear displaying a message that the action performed was a success.</p>
                        </div>
                        <div class="owl-item">
                            <img class="img-thumbnail" src="/iis-images/tips/filed_closed/reopen4.jpg" alt="DMS REOPEN TIPS" />
                            <br />
                            <p><b style="color: rgb(181, 46, 36)">Step 3:</b> Transactions reopened will automatically be forwarded to your account. Please proceed to your Inbox to process the Reopened Transaction.</p>
                        </div>
                      </div>
                    </div>
                    <div class="owl-controls">
                        <div class="owl-nav">
                            <div class="owl-prev"></div>
                            <div class="owl-next"></div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" style="text-align: center; padding-top: 15px">
                      <?php
                        if($filed_closed_tips[0]['filed_closed'] == 0) {
                          echo '<label> <input id="tipsCheckbox" type="checkbox"/> <span>Do not show these tips again.</span> </label><br />';
                        }
                      ?>
                      <button class="btn btn-primary btn-lg btn-loading-overlay" type="button" name="dmsTipsButton" data-dismiss="modal">
                        <span class="spinner">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                        <span class="btn-inner-text"><i class="fa fa-thumbs-up"></i> Okay.</span>
                      </button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?=base_url('assets/common/owlcarousel2-2.3.4/owl.carousel.min.js')?>"></script>

<script>
  $(document).ready(function(){

    <?php if($filed_closed_tips[0]['filed_closed'] == 0) { ?>
      $('#dmsTipsModal').modal('show');
    <?php } ?>

    $('#dmsTipsModal').on('shown.bs.modal', function (e) {
      var options = {
        items : 1,
        center: true,
        margin: 20,
        nav : true,
        navTe : ['<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-left fa-stack-1x fa-inverse"></i></span>','<span class="fa-stack"><i class="fa fa-circle fa-stack-1x"></i><i class="fa fa-chevron-circle-right fa-stack-1x fa-inverse"></i></span>'],
      };

      var tipsCarousel = $('.your-class1');
      tipsCarousel.on({
          'initialized.owl.carousel': function () {
               tipsCarousel.find('.owl-item').show();
               $('#loading-placeholder').find('.spinner-border').hide();
          }
      }).owlCarousel(options).trigger('to.owl.carousel', 0);
    })

    $('button[name="dmsTipsButton"]').click(function() {
        let button = $(this);
        let showTipsInput = $('input#tipsCheckbox[type="checkbox"]').is(':checked') == true ? 1 : 0;

        let request = $.ajax({
           url: '/embis/dms/data/ajax/showFiledClosedTips',
           method: 'POST',
           data: { input : showTipsInput },
    		   dataType: 'json',
           beforeSend: function(jqXHR, settings){
             button.addClass("btn-loading");
             button.attr("disabled", true);
           }
        });

        request.done(function(data) {
          button.removeClass("btn-loading");
          button.attr("disabled", false);
          $('#dmsTipsModal').modal('hide');
    		});

    		request.fail(function(jqXHR, textStatus) {
    		  alert( "Request failed: " + textStatus );
    		  console.log( "Request failed: " + textStatus );
          button.removeClass("btn-loading");
          button.attr("disabled", false);
    		});
    });
  });
</script>
