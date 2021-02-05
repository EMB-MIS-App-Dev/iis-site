<style media="screen">
  div.bg-primary{
    background-color: #08507E!important;
  }
  div.no-border-primary {
    padding:0px!important;
  }
  .mb-2{
    padding: 10px 10px 0px 10px;
    font-size: 9pt;
  }
  .rounded{
    border-radius: 0px!important;
    border: 1px solid #F5F6FA;
  }
  .attachmentfooter{
    padding: 0px 15px 10px 15px;
    background-color: #F5F6FA;
    color: #000;
    margin-top:0px!important;
  }
  div.py-3{
    padding: 0px!important;
  }
  div.form-row{
    background-color: #FFF!important;
  }
  div.message {
      margin-top: 1rem!important;
  }
  /* div.message-content{
    width:70%!important;
  } */
</style>
            <!-- Main Content -->
            <div class="main main-visible" data-mobile-height="">

                <!-- Chat -->
                <div id="chat-1" class="chat dropzone-form-js">

                    <!-- Chat: body -->
                    <?php
                      $divchatbody = ($contentheader[0]['ifremoved'] == 'yes') ?  '<div class="chat-body">' : '<div class="chat-body" onclick=snmsg("'.$msgtoken.'");>';
                      echo $divchatbody;
                    ?>
                        <!-- Chat: Header -->
                        <div class="chat-header border-bottom py-4 py-lg-6 px-lg-8">
                            <div class="container-xxl">

                                <div class="row align-items-center">

                                    <!-- Close chat(mobile) -->
                                    <div class="col-3 d-xl-none">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a class="text-muted px-0" href="<?php echo base_url(); ?>Messages" data-chat="open">
                                                    <i class="icon-md fe-chevron-left"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Chat photo -->
                                    <div class="col-6 col-xl-6" style="padding-left:0px;">
                                        <div class="media text-center text-xl-left">
                                            <div class="avatar avatar-sm d-none d-xl-inline-block mr-5">
                                                <img src="<?php echo $contentheader[0]['chat_photo']; ?>" class="avatar-img" alt="">
                                            </div>

                                            <div class="media-body align-self-center text-truncate">
                                                <h6 class="text-truncate mb-n1"><?= $contentheader[0]['chat_name']; ?></h6>

                                                <?php
                                                if($contentheader[0]['category'] == 'Single'){
                                                  $datetime = date("Y-m-d H:i"); $date = date("Y-m-d"); $currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
                                                  $active = 0;
                                                  for ($q=0; $q < sizeof($contentheader); $q++) {
                                                    if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($contentheader[$q]['timestamp']))) AND (date('Y-m-d', strtotime($contentheader[$q]['timestamp'])) == $date)) {
                                                      $active++;
                                                    }
                                                  }

                                                  if($active != 0){
                                                    echo '<small class="text-muted" style="color:green!important;">Active</small>';
                                                  }else{
                                                    echo '<small class="text-muted">Offline</small>';
                                                  }
                                                  echo '<small class="text-muted mx-2"> • </small>';
                                                  echo '<small class="text-muted">'.$contentheader[0]['designation'].'</small>';

                                                }

                                                if($contentheader[0]['category'] == 'Multiple'){
                                                  echo '<small class="text-muted">'.$cnttoken.'&nbsp;members</small>';
                                                  echo '<small class="text-muted mx-2"> • </small>';
                                                  echo '<small class="text-muted">'.$contentheader[0]['region_participants'].'</small>';
                                                }

                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chat toolbar -->
                                    <div class="col-3 col-xl-6 text-right">
                                        <ul class="nav justify-content-end">
                                          <?php if($_SESSION['userid'] == '1'){ ?>
                                            <li class="nav-item list-inline-item d-none d-xl-block mr-5">
                                                <a class="nav-link text-muted px-3" data-toggle="collapse" data-target="#chat-1-search" href="#" title="Search this chat">
                                                    <i class="icon-md fe-search"></i>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <li class="nav-item list-inline-item d-none d-xl-block mr-0">
                                                <a class="nav-link text-muted px-3" href="#" data-chat-sidebar-toggle="#chat-1-info" title="Details">
                                                    <i class="icon-md fe-more-vertical"></i>
                                                </a>
                                            </li>

                                            <!-- Mobile nav -->
                                            <li class="nav-item list-inline-item d-block d-xl-none">
                                                <div class="dropdown">
                                                    <a class="nav-link text-muted px-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-md fe-more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                      <?php if($_SESSION['userid'] == '1'){ ?>
                                                        <a class="dropdown-item d-flex align-items-center" data-toggle="collapse" data-target="#chat-1-search" href="#">
                                                            Search <span class="ml-auto pl-5 fe-search"></span>
                                                        </a>
                                                      <?php } ?>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" data-chat-sidebar-toggle="#chat-1-info">
                                                            Chat Info <span class="ml-auto pl-5 fe-more-horizontal"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Mobile nav -->
                                        </ul>
                                    </div>

                                </div><!-- .row -->

                            </div>
                        </div>
                        <!-- Chat: Header -->

                        <!-- Chat: Search -->
                        <div class="collapse border-bottom px-lg-8" id="chat-1-search">
                            <div class="container-xxl py-4 py-lg-6">

                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Search this chat" aria-label="Search this chat">

                                    <div class="input-group-append">
                                        <button class="btn btn-lg btn-ico btn-secondary btn-minimal" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Chat: Search -->

                        <!-- Chat: Content-->
                        <div class="chat-content px-lg-8" id="chatcontentbody" style="zoom: 85%;">
                            <div class="container-xxl py-6 py-lg-10" style="padding-top:0px!important;">

                              <?php if($countrows > 10){ ?>
                              <div style="text-align:center;border-top:1px solid#F6F7FB;">
                                <button type="button" class="btn btn-info btn-sm" style="border:1px solid#F6F7FB;border-top-left-radius:0px;border-top-right-radius:0px;border-top:none;width: 50%;height:19pt;padding:0px;" id="btnldmsgs" onclick="loadmoremessages('<?php echo $msgtoken; ?>',$('#messagebaserow').val());"><i id="ibtnldmsgs">Load more messages</i></button>
                              </div>
                              <?php } ?>
                              <input type="hidden" class="form-control" id="messagebaserow" value="<?php echo $baserow; ?>">
                              <div id="ldmrmsgs" style="margin-bottom:2rem;"></div>
                                <?php $cnt = 0; for ($i=0; $i < sizeof($messagecontent); $i++) {
                                  if($messagecontent[$i]['cnt'] <= $contentheader[0]['lastseen_msg_cnt']){
                                ?>
                                  <?php
                                    if(date("Y-m-d",strtotime($messagecontent[$i]['datetime_sent'])) == date("Y-m-d")){ $cnt++; $datesent = date("h:i a",strtotime($messagecontent[$i]['datetime_sent'])); }
                                    else{ $datesent = date("M d, Y h:i a",strtotime($messagecontent[$i]['datetime_sent'])); }
                                  ?>

                                  <?php if($messagecontent[$i]['by_useridtoken'] == $this->session->userdata('token')){ ?> <!-- Messages sent -->

                                    <?php if($cnt == '1'){ ?>
                                      <!-- Divider -->
                                      <div class="message-divider my-9 mx-lg-5" id="dvdrtdy">
                                          <div class="row align-items-center">

                                              <div class="col">
                                                  <hr>
                                              </div>

                                              <div class="col-auto">
                                                  <small class="text-muted">Today</small>
                                              </div>

                                              <div class="col">
                                                  <hr>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- Divider -->
                                    <?php } ?>

                                    <!-- Message -->
                                      <div class="message message-right">
                                          <!-- Avatar -->
                                          <div class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block">
                                              <img class="avatar-img" src="<?php echo $messagecontent[$i]['by_photo']; ?>" alt="">
                                          </div>

                                          <!-- Message: body -->
                                            <div class="message-body">

                                                <!-- Message: row -->
                                                <div class="message-row">
                                                    <div class="d-flex align-items-center justify-content-end">

                                                      <?php if(($this->session->userdata('userid') == $messagecontent[$i]['by_userid']) OR ($this->session->userdata('superadmin_rights') == 'yes')){ ?>
                                                        <!-- Message: dropdown -->
                                                        <div class="dropdown">
                                                            <a class="text-muted opacity-60 mr-3" href="#" onclick="msgoptn('<?php echo $messagecontent[$i]['token']; ?>');" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe-more-vertical"></i>
                                                            </a>

                                                            <div class="dropdown-menu">
                                                                <div id="message-option-zxc<?php echo $messagecontent[$i]['token']; ?>"></div>
                                                            </div>
                                                        </div>
                                                        <!-- Message: dropdown -->
                                                     <?php } ?>

                                                  <!-- Message: content -->
                                                    <?php
                                                      $msgscontent = ($messagecontent[$i]['status'] == 'Active') ? $messagecontent[$i]['message'] : '<i>Message removed</i>';
                                                      $explodeattachments = explode(';',$messagecontent[$i]['attachmenttitle']);
                                                      $explodeattachmentfiles = explode(';',$messagecontent[$i]['attachmentfile']);
                                                      $extattch = explode(';',strtolower($messagecontent[$i]['ext']));
                                                      $extattchfiles = explode(';',$messagecontent[$i]['ext']);
                                                      $countattachments = count($explodeattachments);
                                                      $filecon = (($countattachments-1) > 1) ? ($countattachments-1).' files' : 'a file';
                                                      $filestyle = (($countattachments-1) > 1) ? 'max-width:100%;max-height:100%;height:100px;' : '';
                                                      $colstyle = (($countattachments-1) > 1) ? 'max-width: 100px;' : '';
                                                      if($messagecontent[$i]['attachmenttitle'] != '' AND $messagecontent[$i]['status'] == 'Active'){
                                                        $msgheader = ($messagecontent[$i]['status'] == 'Active') ? 'message-content bg-primary text-white no-border-primary' : 'message-content bg-secondary text-black';
                                                        $footerclass = 'attachmentfooter';
                                                      }else{
                                                        $msgheader = ($messagecontent[$i]['status'] == 'Active') ? 'message-content bg-primary text-white' : 'message-content bg-secondary text-black';
                                                        $footerclass = '';
                                                      }
                                                    ?>
                                                        <div class="<?php echo $msgheader; ?>" id="message-received-headercontent<?php echo $messagecontent[$i]['token']; ?>">
                                                            <div id="message-received-content<?php echo $messagecontent[$i]['token']; ?>" style="white-space: pre-wrap;word-wrap: break-word;"><?php echo $msgscontent; ?></div>
                                                            <?php if($messagecontent[$i]['attachmenttitle'] != '' AND $messagecontent[$i]['status'] == 'Active'){ ?>
                                                              <h6 class="mb-2" id="attachmentitle<?php echo $messagecontent[$i]['token']; ?>" style="color:#FFF;">You shared <?php echo $filecon; ?>:</h6>
                                                              <div class="form-row py-3 form-right" id="attachmentbody<?php echo $messagecontent[$i]['token']; ?>">
                                                                <?php for ($a=0; $a < $countattachments-1; $a++) {
                                                                  if($extattch[$a] == 'png' || $extattch[$a] == 'jpeg' || $extattch[$a] == 'jpg' || $extattch[$a] == 'gif'){
                                                                    $imagefile = base_url().'uploads/messaging/'.$messagecontent[$i]['msg_token'].'/'.$explodeattachmentfiles[$a].".".$extattchfiles[$a];
                                                                  }else{
                                                                    $imagefile = base_url().'../iis-images/status-icons/attachment.png';
                                                                  }
                                                                  ?>
                                                                  <div class="col" style="<?php echo $colstyle; ?>">
                                                                      <a href="<?php echo base_url().'uploads/messaging/'.$messagecontent[$i]['msg_token'].'/'.$explodeattachmentfiles[$a].".".$extattchfiles[$a]; ?>" target="_blank"><img class="img-fluid rounded" style="<?php echo $filestyle; ?>" src="<?php echo $imagefile; ?>" title="<?php echo $explodeattachments[$a]; ?>" alt="<?php echo $explodeattachments[$a]; ?>"></a>
                                                                  </div>
                                                                <?php } ?>
                                                              </div>
                                                            <?php } ?>
                                                            <div class="mt-1 <?php echo $footerclass; ?>" style="font-size:10pt;">
                                                                <small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">You</small>
                                                                <small class="opacity-65"><?php echo $datesent; ?></small>
                                                            </div>
                                                        </div>
                                                    <!-- Message: content -->
                                                    </div>
                                                </div>
                                                <!-- Message: row --><br>
                                                <div style="float:left;margin-top:-23px;" id="snbyl<?php echo $messagecontent[$i]['token']?>">
                                                  <?php for ($ls=0; $ls < sizeof($lastseen); $ls++) { if($messagecontent[$i]['cnt'] == $lastseen[$ls]['lastseen_msg_cnt'] AND $lastseen[$ls]['creator_userid'] != $this->session->userdata('userid')){
                                                    $lastseenphoto = (!empty($lastseen[$ls]['user_photo'])) ? base_url().'uploads/profilepictures/'.$lastseen[$ls]['token'].'/'.$lastseen[$ls]['user_photo'] : base_url().'assets/images/default-user.png';
                                                  ?>
                                                      <img class="avatar-img" id="snimg<?php echo $lastseen[$ls]['creator_userid']; ?>" src="<?php echo $lastseenphoto; ?>" style="width:15px;" title="Seen by <?php echo $lastseen[$ls]['creator_fullname'] ?>">

                                                  <?php } } ?>
                                                </div>

                                            </div>
                                          <!-- Message: body -->
                                      </div>
                                    <!-- Message -->
                                  <?php }else if($messagecontent[$i]['by_useridtoken'] != $this->session->userdata('token') AND !empty($messagecontent[$i]['by_useridtoken'])){ ?> <!-- Messages received -->

                                    <?php if($cnt == '1'){ ?>
                                      <!-- Divider -->
                                      <div class="message-divider my-9 mx-lg-5">
                                          <div class="row align-items-center">

                                              <div class="col">
                                                  <hr>
                                              </div>

                                              <div class="col-auto">
                                                  <small class="text-muted">Today</small>
                                              </div>

                                              <div class="col">
                                                  <hr>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- Divider -->
                                    <?php } ?>

                                    <!-- Message -->
                                    <div class="message">
                                        <!-- Avatar -->
                                        <a class="avatar avatar-sm mr-4 mr-lg-5" href="#" data-chat-sidebar-toggle="#chat-1-user-profile">
                                            <img class="avatar-img" src="<?php echo $messagecontent[$i]['by_photo']; ?>" alt="">
                                        </a>

                                        <!-- Message: body -->
                                        <div class="message-body">

                                            <!-- Message: row -->
                                            <div class="message-row">
                                                <div class="d-flex align-items-center">

                                                    <!-- Message: content -->
                                                    <?php
                                                      $msgscontent = ($messagecontent[$i]['status'] == 'Active') ? $messagecontent[$i]['message'] : '<i>Message removed</i>';
                                                      $explodeattachments = explode(';',$messagecontent[$i]['attachmenttitle']);
                                                      $explodeattachmentfiles = explode(';',$messagecontent[$i]['attachmentfile']);
                                                      $extattch = explode(';',strtolower($messagecontent[$i]['ext']));
                                                      $extattchfiles = explode(';',$messagecontent[$i]['ext']);
                                                      $countattachments = count($explodeattachments);
                                                      $filecon = (($countattachments-1) > 1) ? ($countattachments-1).' files' : 'a file';
                                                      $msgcolor = ($messagecontent[$i]['status'] == 'Active') ? '#000' : '#7F808C';
                                                      $filestyle = (($countattachments-1) > 1) ? 'max-width:100%;max-height:100%;height:100px;' : '';
                                                      $colstyle = (($countattachments-1) > 1) ? 'max-width: 100px;' : '';
                                                      if($messagecontent[$i]['attachmenttitle'] != '' AND $messagecontent[$i]['status'] == 'Active'){
                                                        $msgheader = ($messagecontent[$i]['status'] == 'Active') ? 'message-content bg-light no-border-primary' : 'message-content bg-secondary text-black';
                                                        $footerclass = 'attachmentfooter';
                                                      }else{
                                                        $msgheader = ($messagecontent[$i]['status'] == 'Active') ? 'message-content bg-light' : 'message-content bg-secondary text-black';
                                                        $footerclass = '';
                                                      }
                                                    ?>

                                                    <div class="<?php echo $msgheader; ?>" id="message-received-headercontent<?php echo $messagecontent[$i]['token']; ?>">
                                                        <div id="message-received-content<?php echo $messagecontent[$i]['token']; ?>" style="white-space: pre-wrap;word-wrap: break-word; color:<?php echo $msgcolor; ?>;"><?php echo $msgscontent; ?></div>
                                                        <?php if($messagecontent[$i]['attachmenttitle'] != '' AND $messagecontent[$i]['status'] == 'Active'){ ?>
                                                          <h6 class="mb-2" id="attachmentitle<?php echo $messagecontent[$i]['token']; ?>" style="color:#000;"><?php echo $messagecontent[$i]['by']; ?> shared <?php echo $filecon; ?>:</h6>
                                                          <div class="form-row py-3" style="border-radius: 3px;" id="attachmentbody<?php echo $messagecontent[$i]['token']; ?>">
                                                            <?php for ($a=0; $a < $countattachments-1; $a++) {
                                                              if($extattch[$a] == 'png' || $extattch[$a] == 'jpeg' || $extattch[$a] == 'jpg' || $extattch[$a] == 'gif'){
                                                                $imagefile = base_url().'uploads/messaging/'.$messagecontent[$i]['msg_token'].'/'.$explodeattachmentfiles[$a].".".$extattchfiles[$a];
                                                              }else{
                                                                $imagefile = base_url().'../iis-images/status-icons/attachment.png';
                                                              }
                                                              ?>
                                                              <div class="col" style="<?php echo $colstyle; ?>">
                                                                  <a href="<?php echo base_url().'uploads/messaging/'.$messagecontent[$i]['msg_token'].'/'.$explodeattachmentfiles[$a].".".$extattchfiles[$a]; ?>" target="_blank"><img class="img-fluid rounded" style="<?php echo $filestyle; ?>" src="<?php echo $imagefile; ?>" title="<?php echo $explodeattachments[$a]; ?>" alt="<?php echo $explodeattachments[$a]; ?>"></a>
                                                              </div>
                                                            <?php } ?>
                                                          </div>
                                                        <?php } ?>
                                                        <div class="mt-1 <?php echo $footerclass; ?>" style="margin-top:5px!important;font-size:10pt;">
                                                          <small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;"><?php echo $datesent; ?></small>
                                                          <small class="opacity-65"><?php echo $sender = ($messagecontent[$i]['by_userid'] == '1') ? "Administrator" : $messagecontent[$i]['by']; ?></small>
                                                        </div>
                                                    </div>
                                                    <!-- Message: content -->

                                                    <?php if(($this->session->userdata('userid') == $messagecontent[$i]['by_userid'])){ ?>
                                                    <!-- Message: dropdown -->
                                                    <div class="dropdown">
                                                        <a class="text-muted opacity-60 ml-3" href="#" onclick="msgoptn('<?php echo $messagecontent[$i]['token']; ?>');" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe-more-vertical"></i>
                                                        </a>

                                                        <div class="dropdown-menu">
                                                            <div id="message-option-zxc<?php echo $messagecontent[$i]['token']; ?>"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Message: dropdown -->
                                                    <?php } ?>


                                                </div>

                                            </div>
                                            <!-- Message: row --><br>
                                            <div style="float:right;margin-top:-23px;" id="snbyr<?php echo $messagecontent[$i]['token']?>">
                                              <?php for ($ls=0; $ls < sizeof($lastseen); $ls++) { if($messagecontent[$i]['cnt'] == $lastseen[$ls]['lastseen_msg_cnt'] AND $lastseen[$ls]['creator_userid'] != $this->session->userdata('userid')){
                                                  $lastseenphoto = (!empty($lastseen[$ls]['user_photo'])) ? base_url().'uploads/profilepictures/'.$lastseen[$ls]['token'].'/'.$lastseen[$ls]['user_photo'] : base_url().'assets/images/default-user.png';
                                                ?>
                                                  <img class="avatar-img" id="snimg<?php echo $lastseen[$ls]['creator_userid']; ?>" src="<?php echo $lastseenphoto; ?>" style="width:15px;" title="Seen by <?php echo $lastseen[$ls]['creator_fullname'] ?>">

                                              <?php } } ?>
                                            </div>

                                        </div>
                                        <!-- Message: Body -->
                                    </div>
                                    <!-- Message -->
                                  <?php } ?>
                                <?php } } ?>

                                <div id="messages-feedback-zxc"></div>
                                <div id="messages-activity-zxc"></div>

                            </div>

                            <!-- Scroll to end -->
                            <div class="end-of-chat"></div>

                        </div>
                        <!-- Chat: Content -->

                        <div class="chat-files hide-scrollbar px-lg-8" id="attachemntvwheader_" style="display:none;padding:0px!important;">
                           <div class="container-xxl">
                               <div class="dropzone-previews-js form-row py-4" id="attachementsvw_">

                               </div>
                           </div>
                       </div>

                        <div style="text-align:center;" id="vwrcntmsgs"></div>

                          <!-- Chat: Footer -->
                          <div class="chat-footer border-top py-4 py-lg-6 px-lg-8" style="border-top: 1px solid#bcc2dc!important;">
                              <div class="container-xxl">

                                <?php if($contentheader[0]['ifremoved'] == 'yes'){ ?>
                                  <div class="row">
                                    <div class="col-md-12" style="text-align:center;">
                                      <i>You've been removed to this group.</i>
                                    </div>
                                  </div>
                                <?php }else{ ?>
                                  <form id="chat-id-1-form" action="#" data-emoji-form="">
                                      <div class="form-row align-items-center">
                                          <div class="col">
                                              <div class="input-group" style="border:1px solid#bcc2dc!important;border-radius:5px;">

                                                  <!-- Textarea -->
                                                  <textarea id="message-textarea-zxc" class="form-control bg-transparent border-0" placeholder="Type your message..." rows="1" data-emoji-input="" data-autosize="true"></textarea>

                                                  <!-- Emoji button -->
                                                  <div class="input-group-append">
                                                      <button class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0" type="button" data-emoji-btn="">
                                                          <img src="<?php echo base_url(); ?>assetsmsgs/images/smile.svg" data-inject-svg="" alt="">
                                                      </button>
                                                  </div>

                                                  <form method="post" action="#" enctype="multipart/form-data">
                                                  <!-- Upload button -->
                                                  <div class="input-group-append">
                                  										<button id="chat-upload-btn-1" class="btn btn-ico btn-secondary btn-minimal bg-transparent border-0 dropzone-button-js" type="button">
                                  												<img src="<?php echo base_url(); ?>assetsmsgs/images/paperclip.svg" data-inject-svg="" alt="">
                                  												<input id="upload-chat-photo" onchange="previewfile();" class="d-none" type="file" name="files[]" multiple>
                                  												<label class="stretched-label mb-0" for="upload-chat-photo"></label>
                                  										</button>
                                                  </div>
                                                  </form>

                                              </div>

                                          </div>

                                          <!-- Submit button -->
                                          <div class="col-auto">
                                            <button class="btn btn-ico btn-primary rounded-circle" style="background-color:#08507E;border:none;" type="button" id="message-send-zxc">
                                                <span class="fe-send"></span>
                                            </button>
                                          </div>

                                      </div>

                                  </form>
                                <?php } ?>

                              </div>
                          </div>
                          <!-- Chat: Footer -->

                    </div>
                    <!-- Chat: body -->

                    <!-- Chat Details -->
                    <div id="chat-1-info" class="chat-sidebar">
                        <div class="d-flex h-100 flex-column">

                            <!-- Header -->
                            <div class="border-bottom py-4 py-lg-6">
                                <div class="container-fluid">

                                    <ul class="nav justify-content-between align-items-center">
                                        <!-- Close sidebar -->
                                        <li class="nav-item list-inline-item">
                                            <a class="nav-link text-muted px-0" href="#" data-chat-sidebar-close="">
                                                <i class="icon-md fe-chevron-left"></i>
                                            </a>
                                        </li>

                                        <?php if($contentheader[0]['category'] == 'Multiple'){ ?>
                                        <!-- Dropdown -->
                                        <li class="nav-item list-inline-item">
                                            <div class="dropdown">
                                                <a class="nav-link text-muted px-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-md fe-sliders"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="addusrtocht('<?php echo $this->encrypt->encode($contentheader[0]['token']); ?>');" data-toggle="modal" data-target="#add_user_to_chat">
                                                        Add user to chat&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="ml-auto fe-user-plus"></span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="rmvusrtocht('<?php echo $this->encrypt->encode($contentheader[0]['token']); ?>');" data-toggle="modal" data-target="#remove_user_to_chat">
                                                        Remove user to chat&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <span class="ml-auto fe-user"><span class="ml-auto fe-trash-2"></span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>

                                </div>
                            </div>
                            <!-- Header -->

                            <!-- Body -->
                            <div class="hide-scrollbar flex-fill">

                                <div class="border-bottom text-center py-9 px-10">
                                    <!-- Photo -->
                                    <div class="avatar avatar-xl mx-5 mb-5">
                                        <img class="avatar-img" src="<?php echo $contentheader[0]['chat_photo']; ?>" alt="">
                                    </div>
                                    <h5><?= $contentheader[0]['chat_name']; ?></h5>
                                    <p class="text-muted"><?= $description = ($contentheader[0]['category'] == 'Multiple') ? $contentheader[0]['region_participants'] : $contentheader[0]['designation']; ?></p>
                                </div>

                                <!-- Navs -->
                                <ul class="nav nav-tabs nav-justified bg-light rounded-0" role="tablist">
                                    <li class="nav-item">
                                        <a href="#chat-id-1-members" class="nav-link active" data-toggle="tab" role="tab" aria-selected="true">Members</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#chat-id-1-files" class="nav-link" data-toggle="tab" role="tab" onclick="viewfiles('<?php echo $this->encrypt->encode($messagecontent[0]['msg_token']); ?>');">Files</a>
                                    </li>
                                </ul>
                                <!-- Navs -->

                                <div class="tab-content">
                                    <!-- Members -->
                                    <div id="chat-id-1-members" class="tab-pane fade show active">
                                        <ul class="list-group list-group-flush list-group-no-border-first">

                                          <?php for ($i=0; $i < sizeof($members); $i++) {
                                            $mname = (!empty($members[$i]['mname'])) ? $members[$i]['mname'][0].". " : "";
                        										$suffix = (!empty($members[$i]['suffix'])) ? " ".$members[$i]['suffix'] : "";
                        										$prefix = (!empty($members[$i]['title'])) ? $members[$i]['title']." " : "";
                        										$name = $prefix.ucwords($members[$i]['fname']." ".$mname.$members[$i]['sname']).$suffix;

                                            $datetime = date("Y-m-d H:i"); $date = date("Y-m-d"); $currenttimeminus5minutes = date('H:i',strtotime('-10 minute',strtotime($datetime)));
                                            if ((date('H:i', strtotime($currenttimeminus5minutes)) < date('H:i', strtotime($members[$i]['timestamp']))) AND (date('Y-m-d', strtotime($members[$i]['timestamp'])) == $date)) {
                                              $onlineavatar = "avatar-online";
                                            }else{
                                              $onlineavatar = "";
                                            }

                                            $user_photo = (!empty($members[$i]['user_photo'])) ? base_url().'uploads/profilepictures/'.$members[$i]['token'].'/'.$members[$i]['user_photo'] : base_url().'assets/images/default-user.png';
                                          ?>
                                            <!-- Member -->
                                            <li class="list-group-item py-6">
                                                <div class="media align-items-center">


                                                    <div class="avatar avatar-sm <?php echo $onlineavatar; ?>  mr-5">
                                                        <img class="avatar-img" src="<?php echo $user_photo; ?>">
                                                    </div>


                                                    <div class="media-body">
                                                        <h6 class="mb-0">
                                                            <a href="#" class="text-reset"><?php echo $name; ?></a>
                                                        </h6>
                                                        <small class="text-muted"><?php echo $members[$i]['designation']; ?></small>
                                                    </div>
                                                    <?php if($_SESSION['userid'] == '1'){ ?>
                                                    <div class="align-self-center ml-5">
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-ico btn-link text-muted w-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                                    Promote <span class="ml-auto fe-trending-up"></span>
                                                                </a>
                                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                                    Restrict <span class="ml-auto fe-trending-down"></span>
                                                                </a>
                                                                <a class="dropdown-item d-flex align-items-center" href="#">
                                                                    Delete <span class="ml-auto fe-user-x"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  <?php } ?>

                                                </div>
                                            </li>
                                            <!-- Member -->
                                            <?php } ?>

                                        </ul>
                                    </div>
                                    <!-- Members -->

                                    <!-- Files -->
                                    <div id="chat-id-1-files" class="tab-pane fade">

                                    </div>
                                    <!-- Files -->
                                </div>
                            </div>
                            <!-- Body -->

                        </div>
                    </div>
                    <!-- Chat Details -->

                    <!-- New members -->
                    <div id="chat-1-members" class="chat-sidebar">
                        <div class="d-flex h-100 flex-column">

                            <!-- Header -->
                            <div class="border-bottom py-4 py-lg-6">
                                <div class="container-fluid">

                                    <ul class="nav justify-content-between align-items-center">
                                        <!-- Close sidebar -->
                                        <li class="nav-item">
                                            <a class="nav-link text-muted px-0" href="#" data-chat-sidebar-close="">
                                                <i class="icon-md fe-chevron-left"></i>
                                            </a>
                                        </li>

                                        <!-- Dropdown -->
                                        <li class="nav-item">
                                            <div class="dropdown">
                                                <a class="nav-link text-muted px-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-md fe-sliders"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        Mute
                                                        <span class="ml-auto fe-bell"></span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        Delete
                                                        <span class="ml-auto fe-trash-2"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <!-- Header -->

                            <!-- Body -->
                            <div class="hide-scrollbar flex-fill">
                                <!-- Search -->
                                <div class="border-bottom py-7">
                                    <div class="container-fluid">

                                        <form action="#">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg" placeholder="Search for users..." aria-label="Search users...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-lg btn-ico btn-secondary btn-minimal" type="submit">
                                                        <i class="fe-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <!-- Search -->

                                <!-- Members -->
                                <form action="#">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">A</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">


                                                <div class="avatar avatar-sm avatar-online mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>


                                                <div class="media-body">
                                                    <h6 class="mb-0">Anna Bridges</h6>
                                                    <small class="text-muted">Online</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-1" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-1"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-1"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">B</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">



                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">Brian Dawson</h6>
                                                    <small class="text-muted">last seen 2 hours ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-2" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-2"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-2"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">L</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">

                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">Leslie Sutton</h6>
                                                    <small class="text-muted">last seen 3 days ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-3" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-3"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-3"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">M</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">

                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">Matthew Wiggins</h6>
                                                    <small class="text-muted">last seen 3 days ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-4" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-4"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-4"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">S</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">



                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">Simon Hensley</h6>
                                                    <small class="text-muted">last seen 3 days ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-5" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-5"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-5"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">W</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">



                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">William Wright</h6>
                                                    <small class="text-muted">last seen 3 days ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-6" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-6"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-6"></label>
                                        </li>
                                        <!-- Member -->
<!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">



                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">William Greer</h6>
                                                    <small class="text-muted">last seen 10 minutes ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-7" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-7"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-7"></label>
                                        </li>
                                        <!-- Member -->


                                        <li class="list-group-item py-4">
                                            <small class="text-uppercase">Z</small>
                                        </li>

                                        <!-- Member -->
                                        <li class="list-group-item py-6">
                                            <div class="media align-items-center">



                                                <div class="avatar avatar-sm mr-5">
                                                    <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>">
                                                </div>

                                                <div class="media-body">
                                                    <h6 class="mb-0">Zane Mayes</h6>
                                                    <small class="text-muted">last seen 3 days ago</small>
                                                </div>

                                                <div class="align-self-center ml-auto">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" id="id-add-user-chat-1-user-8" type="checkbox">
                                                        <label class="custom-control-label" for="id-add-user-chat-1-user-8"></label>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Label -->
                                            <label class="stretched-label" for="id-add-user-chat-1-user-8"></label>
                                        </li>
                                        <!-- Member -->

                                    </ul>
                                </form>
                                <!-- Members -->
                            </div>
                            <!-- Body -->

                            <!-- Button -->
                            <div class="border-top py-7">
                                <div class="container-fluid">
                                    <button class="btn btn-lg btn-block btn-primary d-flex align-items-center" type="submit">
                                        Add members
                                        <span class="fe-user-plus ml-auto"></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- New members -->

                    <!-- User's details -->
                    <div id="chat-1-user-profile" class="chat-sidebar">
                        <div class="d-flex h-100 flex-column">

                            <!-- Header -->
                            <div class="border-bottom py-4 py-lg-6">
                                <div class="container-fluid">

                                    <ul class="nav justify-content-between align-items-center">
                                        <!-- Close sidebar -->
                                        <li class="nav-item list-inline-item">
                                            <a class="nav-link text-muted px-0" href="#" data-chat-sidebar-close="">
                                                <i class="icon-md fe-chevron-left"></i>
                                            </a>
                                        </li>

                                        <!-- Dropdown -->
                                        <li class="nav-item list-inline-item">
                                            <div class="dropdown">
                                                <a class="nav-link text-muted px-0" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-md fe-sliders"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        Mute <span class="ml-auto fe-bell"></span>
                                                    </a>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        Delete <span class="ml-auto fe-trash-2"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <!-- Header -->

                            <!-- Body -->
                            <div class="hide-scrollbar flex-fill">

                                <div class="border-bottom text-center py-9 px-10">
                                    <!-- Photo -->
                                    <div class="avatar avatar-xl mx-5 mb-5">
                                        <img class="avatar-img" src="<?php echo $this->session->userdata('user_photo'); ?>" alt="">
                                        <div class="badge badge-sm badge-pill badge-primary badge-border-basic badge-top-right">
                                            <span class="text-uppercase">Pro</span>
                                        </div>
                                    </div>
                                    <h5>William Wright</h5>
                                    <p class="text-muted">Bootstrap is an open source toolkit for developing web with HTML, CSS, and JS.</p>
                                </div>

                                <ul class="list-group list-group-flush mb-8">
                                    <li class="list-group-item py-6">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <p class="small text-muted mb-0">Country</p>
                                                <p>Warsaw, Poland</p>
                                            </div>
                                            <i class="text-muted icon-sm fe-globe"></i>
                                        </div>
                                    </li>

                                    <li class="list-group-item py-6">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <p class="small text-muted mb-0">Phone</p>
                                                <p>+39 02 87 21 43 19</p>
                                            </div>
                                            <i class="text-muted icon-sm fe-mic"></i>
                                        </div>
                                    </li>

                                    <li class="list-group-item py-6">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <p class="small text-muted mb-0">Email</p>
                                                <p>anna@gmail.com</p>
                                            </div>
                                            <i class="text-muted icon-sm fe-mail"></i>
                                        </div>
                                    </li>

                                    <li class="list-group-item py-6">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <p class="small text-muted mb-0">Time</p>
                                                <p>10:03 am</p>
                                            </div>
                                            <i class="text-muted icon-sm fe-clock"></i>
                                        </div>
                                    </li>
                                </ul>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item py-6">
                                        <a href="#" class="media text-muted">
                                            <div class="media-body align-self-center">
                                                Twitter
                                            </div>
                                            <i class="icon-sm fe-twitter"></i>
                                        </a>
                                    </li>

                                    <li class="list-group-item py-6">
                                        <a href="#" class="media text-muted">
                                            <div class="media-body align-self-center">
                                            Facebook
                                            </div>
                                            <i class="icon-sm fe-facebook"></i>
                                        </a>
                                    </li>

                                    <li class="list-group-item py-6">
                                        <a href="#" class="media text-muted">
                                            <div class="media-body align-self-center">
                                                Github
                                            </div>
                                            <i class="icon-sm fe-github"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Body -->

                            <!-- Button -->
                            <div class="border-top py-7">
                                <div class="container-fluid">
                                    <button class="btn btn-lg btn-block btn-primary d-flex align-items-center" type="submit">
                                        Add friend
                                        <span class="fe-user-plus ml-auto"></span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- User's details -->

                </div>
                <!-- Chat -->

            </div>
            <!-- Main Content -->

            <!-- Active Users: Sidebar -->

            <!-- Active Users: Sidebar -->

        </div>
        <!-- Layout -->

        <!-- Modal: Invite friends -->
        <div class="modal fade" id="invite-friends" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <div class="media flex-fill">
                            <div class="icon-shape rounded-lg bg-primary text-white mr-5">
                                <i class="fe-users"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <h5 class="modal-title">Invite friends</h5>
                                <p class="small">Invite colleagues, clients and friends.</p>
                            </div>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="invite-email" class="small">Email</label>
                                <input type="text" class="form-control form-control-lg" id="invite-email">
                            </div>

                            <div class="form-group mb-0">
                                <label for="invite-message" class="small">Invitation message</label>
                                <textarea class="form-control form-control-lg" id="invite-message" data-autosize="true"></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-block btn-primary d-flex align-items-center">
                            Invite friend
                            <i class="fe-user-plus ml-auto"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal: Invite friends -->
