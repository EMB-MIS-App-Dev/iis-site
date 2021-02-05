</div>
<!-- Layout -->


<!-- Scripts -->
<script src="<?php echo base_url(); ?>assetsmsgs/js/libs/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assetsmsgs/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assetsmsgs/js/plugins/plugins.bundle.js"></script>
<script src="<?php echo base_url(); ?>assetsmsgs/js/template.js"></script>
<script src="<?php echo base_url(); ?>assets/js/systems.min.js"></script>
<script src="<?php echo base_url(); ?>assets/common/selectize/dist/js/selectize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/socketio.js"></script>
<!-- Scripts -->

<script type="text/javascript">
 $(document).ready(function(){
   kilid();
   $("#message-textarea-zxc").focus();
    if (!("Notification" in window)) {
      // alert("This browser does not support desktop notification");
    }
    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
      // If it's okay let's create a notification
    }
    Notification.requestPermission(function (permission) {
      // Whatever the user answers, we make sure we store the information
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }
      // If the user is okay, let's create a notification
      if (permission === "granted") { }
    });

 });
  var socket = io.connect('https://iis.emb.gov.ph:9696');
  //messages
  var base_url = window.location.origin+"/embis";
  var msg = document.getElementById("message-textarea-zxc");
  var msgfdbk = document.getElementById("messages-feedback-zxc");
  var msgacvty = document.getElementById("messages-activity-zxc");
  var msgtoken = "<?php echo $this->encrypt->decode($msgtoken); ?>";
  var usrtoken = "<?php echo ($this->session->userdata('token')); ?>";
  var uid = "<?php echo ($this->session->userdata('userid')); ?>";
  var countrows = "<?php echo $countrows; ?>";
  var ifremoved = "<?php echo $ifremoved; ?>";

      if(msgtoken != '' && ifremoved != 'yes'){
        document.getElementById("message-send-zxc").addEventListener("click", function(){
          if(msg.value != ''){
            $.ajax({
              url: base_url+"/Messages/index/transmitdata",
              type: 'POST',
              async : true,
              data: { msg : msg.value, token : msgtoken},
              success:function(response){
                var obj = JSON.parse(response);
                if(obj.msg != '' && obj.msgtoken != '' && obj.token != '' && obj.timelog != '' && obj.userimage != '' && obj.fullname != '' && obj.content_token != ''){
                  socket.emit('chat', {
                    msg: obj.msg,
                    msgtokenen : obj.msgtokenen,
                    msgtoken: obj.msgtoken,
                    token: obj.token,
                    timelog: obj.timelog,
                    userimage: obj.userimage,
                    fullname : obj.fullname,
                    content_token : obj.content_token,
                    uid : obj.uid,
                  });
                  msg.value = '';
                }
              }
            });
            document.getElementById('message-textarea-zxc').style.height = "50px";
            $("#message-textarea-zxc").focus();
          }
        });

        $(msg).on('keypress', function (e) {
          if(e.keyCode === 13 && !e.shiftKey){
            if(msg.value != ''){
              $.ajax({
                url: base_url+"/Messages/index/transmitdata",
                type: 'POST',
                async : true,
                data: { msg : msg.value, token : msgtoken},
                success:function(response){
                  var obj = JSON.parse(response);
                  if(obj.msg != '' && obj.msgtoken != '' && obj.token != '' && obj.timelog != '' && obj.userimage != '' && obj.fullname != '' && obj.content_token != ''){
                    socket.emit('chat', {
                      msg: obj.msg,
                      msgtokenen : obj.msgtokenen,
                      msgtoken: obj.msgtoken,
                      token: obj.token,
                      timelog: obj.timelog,
                      userimage: obj.userimage,
                      fullname : obj.fullname,
                      content_token : obj.content_token,
                      uid : obj.uid,
                    });
                    msg.value = '';
                  }
                }
              });
              document.getElementById('message-textarea-zxc').style.height = "50px";
              $("#message-textarea-zxc").focus();
              document.getElementById("message-textarea-zxc").value = '';
            }
            return false;
          } if(e.keyCode === 13 && e.shiftKey){ }
        });
      }

      socket.on('chat', function(data){
        if(data.msgtoken == msgtoken  && ifremoved != 'yes'){
          if(data.token == usrtoken && data.msgtoken == msgtoken){
            datadiv = '<div class="message message-right" style="margin-top:2rem;">';
              datadiv += '<div class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block"><img class="avatar-img" src="'+data.userimage+'" alt=""></div>';
              datadiv += '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center justify-content-end">';
                datadiv += '<div class="dropdown"><a class="text-muted opacity-60 mr-3" href="#" onclick=msgoptn("'+data.content_token+'"); data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe-more-vertical"></i></a>';
                datadiv += '<div class="dropdown-menu"><div id="message-option-zxc'+data.content_token+'"></div></div></div>';
                datadiv += '<div class="message-content bg-primary text-white" id="message-received-headercontent'+data.content_token+'">';
                  datadiv += '<div id="message-received-content'+data.content_token+'" style="white-space: pre-wrap;">'+data.msg+'</div>';
                  datadiv += '<div class="mt-1" style="font-size:10pt;"><small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">You</small><small class="opacity-65">'+data.timelog+'</small></div>';
                datadiv += '</div>';
              datadiv += '</div><div style="float:left;margin-top:-23px;" id="snbyl'+data.content_token+'"></div>';
              datadiv += '</div></div>';
            datadiv += '</div>';
          }else{
            datadiv = '<div class="message" style="margin-top:2rem;">';
              datadiv += '<a class="avatar avatar-sm mr-4 mr-lg-5" href="#" data-chat-sidebar-toggle="#chat-1-user-profile"><img class="avatar-img" src="'+data.userimage+'" alt=""></a>';
              datadiv += '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center">';
                datadiv += '<div class="message-content bg-light" id="message-received-headercontent'+data.content_token+'">';
                  datadiv += '<div id="message-received-content'+data.content_token+'" style="white-space: pre-wrap; color:#000;">'+data.msg+'</div>';
                  datadiv += '<div class="mt-1" style="margin-top:5px!important;font-size:10pt;"><small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">'+data.timelog+'</small><small class="opacity-65">'+data.fullname+'</small></div>';
                  datadiv += '</div>';
                  datadiv += '<div class="dropdown"><a class="text-muted opacity-60 mr-3" href="#" onclick=msgoptn("'+data.content_token+'"); data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe-more-vertical"></i></a>';
                  datadiv += '<div class="dropdown-menu"><div id="message-option-zxc'+data.content_token+'"></div></div></div>';
                datadiv += '</div>';
                datadiv += '<div style="float:right;margin-top:-23px;" id="snbyr'+data.content_token+'"></div>';
              datadiv += '</div></div></div>';
            datadiv += '</div>';
          }
          msgacvty.innerHTML = '';
          msgfdbk.innerHTML += datadiv;
          var chatcontent = document.getElementById('chatcontentbody');
          var cntrws = $('#messagebaserow').val();
          if(countrows == cntrws){
            chatcontent.scrollTop = chatcontent.scrollHeight;
          }

          if(data.token != usrtoken){
            if (Notification.permission === "granted") {
              var options = {
                    body: "Message: "+data.msg,
                    icon: "https://iis.emb.gov.ph/embis/assets/images/logo-denr.png",
                    dir : "ltr"
                };
              var notification = new Notification(data.fullname,options);
              notification.onclick = function () {
                window.open(base_url+"/Messages/View/index/"+data.msgtokenen);
              };
            }
          }
          kilid();
          document.getElementById("newchatdot").style.display = "block";
        }

      });

      if(msgtoken != '' && ifremoved != 'yes'){
        document.getElementById("message-textarea-zxc").addEventListener("keyup", function(){
          var datatyping = $("#message-textarea-zxc").val();
            var fullnamedata = "<?php echo ($this->session->userdata('name', TRUE)); ?>";
            socket.emit('typing', {
              fullname: fullnamedata,
              string: datatyping,
              token: msgtoken
            });
        });
      }
      socket.on('typing', function(data){
        if(data.token == msgtoken && ifremoved != 'yes'){
          var fullname = data.fullname;
          var name = fullname.replace(/ .*/,'');
          datadiv = '<div class="message" style="margin-top:2rem;">';
            datadiv += '<a class="avatar avatar-sm mr-4 mr-lg-5" href="#" data-chat-sidebar-toggle="#chat-1-user-profile"><img class="avatar-img" src="https://iis.emb.gov.ph/embis/assets/images/default-user.png" alt=""></a>';
            datadiv += '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center">';
              datadiv += '<div class="message-content bg-light">';
                datadiv += '<div>'+name+' is typing<span class="typing-dots"><span>.</span><span>.</span><span>.</span></span></div>';
                datadiv += '</div>';
              datadiv += '</div>';
            datadiv += '</div></div></div>';
          datadiv += '</div>';
          if(data.string != ''){
            msgacvty.innerHTML = datadiv;
          }else{
            msgacvty.innerHTML = '';
          }
          var chatcontent = document.getElementById('chatcontentbody');
          var cntrws = $('#messagebaserow').val();
          if(countrows == cntrws){
            chatcontent.scrollTop = chatcontent.scrollHeight;
          }
        }
      });

      function kilid(){
        $.ajax({
          url: base_url+"/Messages/index/kilid",
          type: 'POST',
          async : true,
          data: { },
          success:function(response){
            $('#kilid_').html(response);
          }
        });
      }

      function msgoptn(msgcnt){
        $.ajax({
          url: base_url+"/Messages/index/messageoption",
          type: 'POST',
          async : true,
          data: { msgcnt : msgcnt},
          success:function(response){
            $('#message-option-zxc'+msgcnt).html(response);

          }
        });
      }

      function dltmsg(contenttoken, msgtoken, econtenttoken){
          var popup = confirm("Are you sure to delete this message?");
          if (popup == true) {
              $.ajax({
                url: base_url+"/Messages/index/dltmsg",
                type: 'POST',
                async : true,
                data: { contenttoken : contenttoken, msgtoken : msgtoken, econtenttoken : econtenttoken},
                success:function(response){
                  var obj = JSON.parse(response);
                  if(obj.status == 'deleted'){
                    alert('Message successfully deleted.');
                    socket.emit('messagedeleted', {
                      cnt: contenttoken,
                      filetitle: obj.filetitle,
                      msg_token: obj.msg_token,
                      contenttoken: obj.contenttoken,
                      userimage: obj.userimage,
                    });
                  }
                }
              });
            }else{
              alert('Action cancelled.')
            }
      }

      function rstrmsg(contenttoken, msgtoken, econtenttoken){
        var popup = confirm("Are you sure to restore this message?");
        if (popup == true) {
            $.ajax({
              url: base_url+"/Messages/index/rstrmsg",
              type: 'POST',
              async : true,
              data: { contenttoken : contenttoken, msgtoken : msgtoken, econtenttoken : econtenttoken},
              success:function(response){
                var obj = JSON.parse(response);
                if(obj.status == 'restored'){
                  alert('Message successfully restored.');
                  socket.emit('messagerestored', {
                    cnt: contenttoken,
                    msgcontent: obj.message,
                    token: obj.usertoken,
                    filename: obj.filename,
                    filetitle: obj.filetitle,
                    filetype: obj.filetype,
                    sendername: obj.sendername,
                    msg_token: obj.msg_token,
                    contenttoken: obj.contenttoken,
                  });
                }
              }
            });
          }else{
            alert('Action cancelled.')
          }
      }

      socket.on('messagedeleted', function(data){
        if(data.msg_token == msgtoken){
          if(data.filetitle != ''){
            $('#attachmentitle'+data.cnt).remove();
            $('#attachmentbody'+data.contenttoken).remove();
            $('#message-received-content'+data.contenttoken).next().removeClass('attachmentfooter');
            // $('#message-received-content'+data.contenttoken).next().firstChild.text('');
          }
          var context = '<i>Message removed</i>';
          $('#message-received-content'+data.cnt).html(context);
          var div = document.getElementById('message-received-content'+data.cnt);
          div.style.color="";
          document.getElementById("message-received-headercontent"+data.cnt).className = "message-content bg-secondary text-black";

        }
      });

      socket.on('messagerestored', function(data){
        if(data.msg_token == msgtoken){
          if(data.filename != ''){
            if((data.filename.length-1) > 1){
              var file = 'You shared '+(data.filename.length-1)+' files:';
              var colstyle = 'max-width: 100px;';
              var imgstyle = 'max-width: 100%;max-height: 100%;height: 100px;';
              var rfile = data.sendername+' shared '+(data.filename.length-1)+' files:';
            }else{
              var file = 'You shared a file:';
              var colstyle = '';
              var imgstyle = '';
              var rfile = data.sendername+' shared a file';
            }
              if(usrtoken == data.token){
                var context = '<h6 class="mb-2" id="attachmentitle'+data.cnt+'" style="color:#FFF;">'+file+'</h6>';
                context += '<div class="form-row py-3 form-right" id="attachmentbody'+data.cnt+'">';
              }else{
                var context = '<h6 class="mb-2" id="attachmentitle'+data.cnt+'">'+rfile+'</h6>';
                context += '<div class="form-row py-3" style="border-radius: 3px;" id="attachmentbody'+data.cnt+'">';
              }

                for (var i = 0; i < data.filename.length; i++) {
                  var filetype = data.filetype[i].toLowerCase();
                  if((filetype == 'png' || filetype == 'jpeg' || filetype == 'jpg' || filetype == 'gif') && filetype != ''){
                  context +=    '<div class="col" style="'+colstyle+'">'+
                                   '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'.'+data.filetype[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'.'+data.filetype[i]+'" title="'+data.filetitle[i]+'"></a>'+
                                '</div>';
                  }else if(filetype != ''){
                  context +=   '<div class="col" style="'+colstyle+'">'+
                                   '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'.'+data.filetype[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/../iis-images/status-icons/attachment.png" title="'+data.filetitle[i]+'"></a>'+
                               '</div>';
                  }
                }
            context += '</div>';
            $('#message-received-content'+data.contenttoken).next().addClass('attachmentfooter');
            var div = document.getElementById('message-received-content'+data.cnt);
            if(usrtoken == data.token){
              document.getElementById("message-received-headercontent"+data.cnt).className = "message-content bg-primary text-white no-border-primary";
            }else{
              div.style.color="black";
              document.getElementById("message-received-headercontent"+data.cnt).className = "message-content bg-secondary text-black no-border-primary";
            }
          }else{
            var div = document.getElementById('message-received-content'+data.cnt);
            if(usrtoken == data.token){
              document.getElementById("message-received-headercontent"+data.cnt).className = "message-content bg-primary text-white";
            }else{
              div.style.color="black";
              document.getElementById("message-received-headercontent"+data.cnt).className = "message-content bg-secondary text-black";
            }
            var context = data.msgcontent;
          }
          $('#message-received-content'+data.cnt).html(context);

        }
      });

      function pflvw(){
        $.ajax({
          url: base_url+"/Messages/Ajax/pflvw",
          type: 'POST',
          async : true,
          data: { },
          success:function(response){ $('#prflvw_').html(response); }
        });
      }

      function edtinfousr(editcat, div, cat){
        var dsplynamtxtbx = document.getElementById('dsplynamtxtbx');
        $.ajax({
          url: base_url+"/Messages/Ajax/edtinfousr",
          type: 'POST',
          async : true,
          data: { editcat : editcat },
          success:function(response){
            $('#'+div).html(response);
            if(cat == 'display_name'){
              document.getElementById('dsplynamtxtbx').disabled = false;
              dsplynamtxtbx.style.backgroundColor="white";
            }
            if(cat == 'undo_display_name'){
              document.getElementById('dsplynamtxtbx').disabled = true;
              dsplynamtxtbx.style.backgroundColor="#EDEEF6";
            }
          }
        });
      }

      function svinfousr(txtbx){
        $.ajax({
          url: base_url+"/Messages/Ajax/svinfousr",
          type: 'POST',
          async : true,
          data: { txtbx : txtbx },
          success:function(response){
            var obj = JSON.parse(response);
            if(obj.status == 'updated'){
              document.getElementById('dsplynamtxtbx').disabled = true;
              dsplynamtxtbx.style.backgroundColor="#EDEEF6";
            }
          }
        });
      }

      function crtcht(){
        $.ajax({
          url: base_url+"/Messages/Ajax/crtcht",
          type: 'POST',
          async : true,
          data: { },
          success:function(response){ $('#createchat_').html(response); }
        });
      }

      function snmsg(token){
        $.ajax({
          url: base_url+"/Messages/Ajax/snmsg",
          type: 'POST',
          async : true,
          data: { token : token },
          success:function(response){
            if(response != ''){
              var obj = JSON.parse(response);
              if(obj.status == 'seen'){
                socket.emit('seenmessage', {
                  msgstoken : obj.msgtoken,
                  sendertoken: obj.sendertoken,
                  userimage: obj.userimage,
                  name : obj.name,
                  token : obj.token,
                  uid : obj.uid,
                  status : obj.status,
                });
                kilid();
              }
            }
          }
        });
      }

      socket.on('seenmessage', function(data){
        if(msgtoken == data.msgstoken){
          var context = '<img class="avatar-img" id="snimg'+data.uid+'" src="'+data.userimage+'" style="width:15px;" title="Seen by '+data.name+'">';
          var snbyl = document.getElementById("snbyl"+data.token);
          var snbyr = document.getElementById("snbyr"+data.token);
          if(data.sendertoken == usrtoken){
            if(data.uid != uid){
              var oldseenimage = document.getElementById("snimg"+data.uid);
              if(oldseenimage){
                oldseenimage.remove();
              }
              snbyl.innerHTML = context;
            }
          }
        }
      });

      function loadmoremessages(msgtok, baserow){
        $.ajax({
          url: base_url+"/Messages/Ajax/ld",
          type: 'POST',
          async : true,
          data: { msgtoken : msgtok, baserow : baserow },
          success:function(response){
            var obj = JSON.parse(response);
            datadiv = '';
            for (var i = 0; i < obj.length; i++) {
              if(obj[i].msg_token == msgtoken){
                if(obj[i].by_useridtoken == usrtoken){
                  datadiv = '<div class="message message-right" style="margin-top:2rem;">';
                    datadiv += '<div class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block"><img class="avatar-img" src="https://iis.emb.gov.ph/embis/assets/images/default-user.png" alt=""></div>';
                    datadiv += '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center justify-content-end">';
                      datadiv += '<div class="dropdown"><a class="text-muted opacity-60 mr-3" href="#" onclick=msgoptn("'+obj[i].token+'"); data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe-more-vertical"></i></a>';
                      datadiv += '<div class="dropdown-menu"><div id="message-option-zxc'+obj[i].token+'"></div></div></div>';
                      datadiv += '<div class="message-content bg-primary text-white" id="message-received-headercontent'+obj[i].token+'">';
                        datadiv += '<div id="message-received-content'+obj[i].token+'" style="white-space: pre-wrap;">'+obj[i].message+'</div>';
                        datadiv += '<div class="mt-1" style="font-size:10pt;"><small class="opacity-65">'+obj[i].timesent+'</small></div>';
                      datadiv += '</div>';
                    datadiv += '</div><div style="float:left;margin-top:-23px;" id="snbyl'+obj[i].token+'"></div>';
                    datadiv += '</div></div>';
                  datadiv += '</div>';
                }else{
                  datadiv = '<div class="message" style="margin-top:2rem;">';
                    datadiv += '<a class="avatar avatar-sm mr-4 mr-lg-5" href="#" data-chat-sidebar-toggle="#chat-1-user-profile"><img class="avatar-img" src="https://iis.emb.gov.ph/embis/assets/images/default-user.png" alt=""></a>';
                    datadiv += '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center">';
                      datadiv += '<div class="message-content bg-light" id="message-received-headercontent'+obj[i].token+'">';
                        datadiv += '<div id="message-received-content'+obj[i].token+'" style="white-space: pre-wrap; color:#000;">'+obj[i].message+'</div>';
                        datadiv += '<div class="mt-1" style="margin-top:5px!important;font-size:10pt;"><small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">'+obj[i].timesent+'</small><small class="opacity-65">'+obj[i].by+'</small></div>';
                        datadiv += '</div>';
                        // datadiv += '<div class="dropdown"><a class="text-muted opacity-60 mr-3" href="#" onclick=msgoptn("'+obj[i].token+'"); data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe-more-vertical"></i></a>';
                        // datadiv += '<div class="dropdown-menu"><div id="message-option-zxc'+obj[i].token+'"></div></div></div>';
                      datadiv += '</div>';
                      datadiv += '<div style="float:right;margin-top:-23px;" id="snbyr'+obj[i].token+'"></div>';
                    datadiv += '</div></div></div>';
                  datadiv += '</div>';
                }
                $('#ldmrmsgs').prepend(datadiv);
              }
            }
            $('#dvdrtdy').html('');
            var messagesleft = $('#messagebaserow').val() - 10;
            if(messagesleft < 0){ count = 0; }else{ count = messagesleft;}
            document.getElementById("messagebaserow").value = count;

            if(count == 0){
              document.getElementById("btnldmsgs").disabled = true;
              $('#ibtnldmsgs').html('');
              document.getElementById("btnldmsgs").className = "btn btn-default btn-sm";
            }

            //View recent messages button
            var vwrcntmsgs = '<button type="button" class="btn btn-default btn-sm" style="background-color:#138496;color:#FFF;border:1px solid#ACA29E;border-bottom-left-radius:0px;border-bottom-right-radius:0px;border:none;width:50%;height:19pt;padding:0px;zoom:85%;" onclick="vwrcntmsgs();"><i>View recent messages</i></button>';
            $('#vwrcntmsgs').html(vwrcntmsgs);
          }
        });
      }

      function vwrcntmsgs(){
        var chatcontent = document.getElementById('chatcontentbody');
        chatcontent.scrollTop = chatcontent.scrollHeight;
        $('#vwrcntmsgs').html('');
        $('#ldmrmsgs').html('');
        document.getElementById("btnldmsgs").disabled = false;
        document.getElementById("btnldmsgs").className = "btn btn-info btn-sm";
        $('#ibtnldmsgs').html('Load more messages');
        document.getElementById("messagebaserow").value = countrows;
      }

      function previewfile(){
        var input = document.getElementById('upload-chat-photo');
        var output = document.getElementById('attachementsvw_');
        var children = "";
        var ext = "";
          for (var i = 0; i < input.files.length; ++i) {
              ext = input.files.item(i).name.split('.').pop();
              extension = ext.toLowerCase();
              var totalBytes = input.files.item(i).size;
              if(totalBytes < 1000000){
                 var _size = Math.floor(totalBytes/1000) + 'KB';

              }else{
                 var _size = Math.floor(totalBytes/1000000) + 'MB';
              }
              children += '<div class="col-lg-2 my-3 dz-processing dz-success dz-complete">'+
                            '<div class="card bg-light">'+
                               '<div class="media align-items-center">'+
                                '<div class="dropzone-file-preview">'+
                                  '<div class="avatar avatar rounded bg-secondary text-basic-inverse d-block mr-5">';
                                  if(extension == "gif" || extension == "png" || extension == "jpeg" || extension == "jpg"){
              children +=          '<i class="fe-image"></i>'
                                  }else{
              children +=          '<i class="fe-paperclip"></i>'
                                  }
              children +=        '</div>'+
                                '</div>'+
                                '<div class="media-body overflow-hidden">'+
                                  '<h6 class="text-truncate small mb-0">'+
                                    input.files.item(i).name+
                                  '</h6>'+
                                  '<p class="extra-small">'+
                                    _size+
                                  '</p>'+
                                '</div>'+
                               '</div>'+
                             '</div>'+
                           '</div>';
          }
          output.innerHTML = children+
                            '<div class="col-md-12">'+
                              '<div class="row" id="uploadoptions_">'+
                                  '<div class="col-md-6"><button class="btn btn-danger btn-sm" style="width:100%;margin-top:5px;" onclick="removefiles();"><span class="fa fa-window-close"></span>&nbsp;Remove</button></div>'+
                                  '<div class="col-md-6"><button class="btn btn-success btn-sm" style="width:100%;margin-top:5px;" onclick="uploadfiles();"><span class="fa fa-upload"></span>&nbsp;Upload</button></div>'+
                              '</div>'+
                              '<div class="col-md-12" style="margin:8px 0px 8px 0px;display: none;" id="divuploadfilestochat"><div class="progress">'+
                              '<div class="progress-bar progress-bar-striped progress-bar-animated" id="progress_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span id="progressdata_"></span></div>'
                              '</div></div>'+
                            '</div>';
          var divheader = document.getElementById('attachemntvwheader_');
          document.getElementById("attachemntvwheader_").style.display = "block";
          divheader.style.backgroundColor="#EDEEF6";
      }

      function removefiles(){
        $("#upload-chat-photo").val("");
        $("#attachementsvw_").html('');
      }

      function uploadfiles(){

        var form_data = new FormData();

        // Read selected files
        var totalfiles = document.getElementById('upload-chat-photo').files.length;
        for (var index = 0; index < totalfiles; index++) {
          form_data.append("files[]", document.getElementById('upload-chat-photo').files[index]);
        }
          form_data.append("token", msgtoken);
        $('#uploadoptions_').html('');
        document.getElementById("divuploadfilestochat").style.display = "block";
        // AJAX request
        $.ajax({
         url: base_url+'/Messages/Ajax/uploadfiles',
         type: 'post',
         data: form_data,
         dataType: 'json',
         xhr: function() {
                var sendfilesXHR = $.ajaxSettings.xhr();
                if(sendfilesXHR.upload){
                    sendfilesXHR.upload.addEventListener('progress',progress, false);
                }
                return sendfilesXHR;
        },
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
           if(Object.keys(response[0].upload_status) == 1){
             alert('The file you uploaded: '+response[0].filename+' failed. Not allowed file type or size is too big.');
           }else{
             $('#attachementsvw_').html('');
             socket.emit('chatwithattachments', {
               content_token: response[0].content_token,
               msg_token :response[0].msg_token,
               user_token :response[0].user_token,
               fullname :response[0].fullname,
               userimage :response[0].userimage,
               timelog :response[0].timelog,
               uploaded : response.uploaded,
               filetype : response.filetype,
               filename : response.filename,
             });
           }
         }
        });
      }

      function progress(e){
          if(e.lengthComputable){
              var max = e.total;
              var current = e.loaded;

              var Percentage = (current * 100)/max;
              document.getElementById("progress_").style.width = Math.round(Percentage)+"%";
              var percent = document.getElementById("progressdata_");
              percent.innerHTML = Math.round(Percentage)+"%";

              if(Percentage >= 100){ }
          }
     }

       socket.on('chatwithattachments', function(data){
         if(data.msg_token == msgtoken){
           if(data.uploaded.length > 1){
             var file = 'You shared '+data.uploaded.length+' files:';
             var colstyle = 'max-width: 100px;';
             var imgstyle = 'max-width: 100%;max-height: 100%;height: 100px;';
             var rfile = data.fullname+' shared '+data.uploaded.length+' files:';
             var notifmsg = 'shared '+data.uploaded.length+' files';
           }else{
             var file = 'You shared a file:';
             var colstyle = '';
             var imgstyle = '';
             var rfile = data.fullname+' shared a file';
             var notifmsg = 'shared a file:';
           }
           if(data.user_token == usrtoken && data.msg_token == msgtoken){
             datadiv = '<div class="message message-right" style="margin-top:2rem;">'+
                          '<div class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block"><img class="avatar-img" src="'+data.userimage+'" alt=""></div>'+
                          '<div class="message-body"><div class="message-row">'+
                            '<div class="d-flex align-items-center justify-content-end">'+
                              '<div class="dropdown">'+
                                '<a class="text-muted opacity-60 mr-3" href="#" onclick=msgoptn("'+data.content_token+'"); data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe-more-vertical"></i></a>'+
                                '<div class="dropdown-menu"><div id="message-option-zxc'+data.content_token+'"></div></div>'+
                              '</div>'+
                              '<div class="message-content bg-primary text-white no-border-primary" id="message-received-headercontent'+data.content_token+'">'+
                                '<div id="message-received-content'+data.content_token+'" style="white-space: pre-wrap;" class="mb-2">';

            datadiv +=          '<h6 class="mb-2" style="color:#FFF;padding:2px 10px 0px 3px;" id="attachmenttitle'+data.content_token+'">'+file+'</h6></div>'+
                                '<div class="form-row py-3 form-right" id="attachmentbody'+data.content_token+'">';
            for (var i = 0; i < data.uploaded.length; i++) {
              var filetype = data.filetype[i].toLowerCase();
              if(filetype == 'png' || filetype == 'jpeg' || filetype == 'jpg' || filetype == 'gif'){
                datadiv +=            '<div class="col" style="'+colstyle+'">'+
                                         '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" title="'+data.uploaded[i]+'"></a>'+
                                      '</div>';
              }else{
                datadiv +=            '<div class="col" style="'+colstyle+'">'+
                                         '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/../iis-images/status-icons/attachment.png" title="'+data.uploaded[i]+'"></a>'+
                                      '</div>';
              }
            }
             datadiv +=          '</div>'+
                                '<div class="mt-1 attachmentfooter" style="font-size:10pt;"><small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">You</small><small class="opacity-65">'+data.timelog+'</small></div>'+
                              '</div>'+
                            '</div>'+
                            '<div style="float:left;margin-top:-23px;" id="snbyl'+data.content_token+'"></div>'+
                          '</div></div>'+
                        '</div>';
           }else{
             datadiv = '<div class="message" style="margin-top:2rem;">'+
                          '<a class="avatar avatar-sm mr-4 mr-lg-5" href="#" data-chat-sidebar-toggle="#chat-1-user-profile"><img class="avatar-img" src="'+data.userimage+'" alt=""></a>'+
                          '<div class="message-body"><div class="message-row"><div class="d-flex align-items-center">'+
                            '<div class="message-content bg-light no-border-primary" id="message-received-headercontent'+data.content_token+'">'+
                              '<div id="message-received-content'+data.content_token+'" style="white-space: pre-wrap; color:#000;">';
              datadiv +=      '<h6 class="mb-2" style="color:#000;" id="attachmenttitle'+data.content_token+'">'+rfile+'</h6></div>'+
                                '<div class="form-row py-3" style="border-radius: 3px;" id="attachmentbody'+data.content_token+'">';
                for (var i = 0; i < data.uploaded.length; i++) {
                  var filetype = data.filetype[i].toLowerCase();
                  if(filetype == 'png' || filetype == 'jpeg' || filetype == 'jpg' || filetype == 'gif'){
                    datadiv +=            '<div class="col" style="'+colstyle+'">'+
                                             '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" title="'+data.uploaded[i]+'"></a>'+
                                          '</div>';
                  }else{
                    datadiv +=            '<div class="col" style="'+colstyle+'">'+
                                             '<a href="'+base_url+'/uploads/messaging/'+data.msg_token+'/'+data.filename[i]+'" target="_blank"><img class="img-fluid rounded" style="'+imgstyle+'" src="'+base_url+'/../iis-images/status-icons/attachment.png" title="'+data.uploaded[i]+'"></a>'+
                                          '</div>';
                  }
                }
                 datadiv +=       '</div>'+
                              '<div class="mt-1 attachmentfooter" style="margin-top:5px!important;font-size:10pt;"><small class="opacity-65" style="float:right;margin-top:3px;margin-left:10px;">'+data.timelog+'</small><small class="opacity-65">'+data.fullname+'</small></div>'+
                              '</div>'+
                            '</div>'+
                            '<div style="float:right;margin-top:-23px;" id="snbyr'+data.content_token+'"></div>'+
                          '</div></div></div>'+
                        '</div>';
           }
           msgacvty.innerHTML = '';
           msgfdbk.innerHTML += datadiv;
           var chatcontent = document.getElementById('chatcontentbody');
           var cntrws = $('#messagebaserow').val();
           if(countrows == cntrws){
             chatcontent.scrollTop = chatcontent.scrollHeight;
           }

           if(data.token != usrtoken){
             if (Notification.permission === "granted") {
               var options = {
                     body: notifmsg,
                     icon: "https://iis.emb.gov.ph/embis/assets/images/logo-denr.png",
                     dir : "ltr"
                 };
               var notification = new Notification(data.fullname,options);
               notification.onclick = function () {
                 window.open(base_url+"/Messages/View/index/"+data.msgtokenen);
               };
             }
           }
           kilid();
         }
       });

       function viewfiles(token){
         $.ajax({
           url: base_url+"/Messages/Ajax/filescontent",
           type: 'POST',
           async : true,
           data: { token : token},
           success:function(response){
             $('#chat-id-1-files').html(response);

           }
         });
       }

       function prevuploadbtn() {
         var buttonupload = '<button type="button" class="btn btn-primary btn-sm" onclick="uploadphoto();">'+
                               '<span class="fa fa-upload"></span>&nbsp;Upload Group Photo'+
                             '</button>';
         document.getElementById("upload-button-head").innerHTML = buttonupload;
      }

      function prevuploadbtngroup() {
        var buttonupload = '<button type="button" class="btn btn-danger btn-sm" onclick=document.getElementById("group-photo").click();>'+
                              '<span class="fa fa-edit"></span>&nbsp;Change Group Photo'+
                            '</button>';
        document.getElementById("upload-button-head-group").innerHTML = buttonupload;
     }

      function uploadphoto(){
        var form_data = new FormData();

        // Read selected files
        var totalfiles = document.getElementById('user-photo').files.length;
        for (var index = 0; index < totalfiles; index++) {
          form_data.append("files[]", document.getElementById('user-photo').files[index]);
        }

        $('#upload-button-head').html('');
        document.getElementById("progressuseruploadphoto").style.display = 'block';
        // AJAX request
        $.ajax({
         url: base_url+'/Messages/Ajax/uploaduserphoto',
         type: 'post',
         data: form_data,
         dataType: 'json',
         xhr: function() {
                var sendfilesXHR = $.ajaxSettings.xhr();
                if(sendfilesXHR.upload){
                    sendfilesXHR.upload.addEventListener('progress',userphotoprogress, false);
                }
                return sendfilesXHR;
        },
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
           if(response.status == 'success'){
             var buttonupload = '<button type="button" class="btn btn-info btn-sm" onclick=document.getElementById("user-photo").click();>'+
                                   '<span class="fa fa-edit"></span>&nbsp;Change Photo'+
                                 '</button>';
             document.getElementById("upload-button-head").innerHTML = buttonupload;
             document.getElementById("progressuseruploadphoto").style.display = 'none';
           }else{
             alert('Upload failed.');
             document.getElementById("progressuseruploadphoto").style.display = 'none';
           }
         }
        });
      }

      function userphotoprogress(e){
          if(e.lengthComputable){
              var max = e.total;
              var current = e.loaded;

              var Percentage = (current * 100)/max;
              document.getElementById("userphotouploadprogressbar_").style.width = Math.round(Percentage)+"%";
              var percent = document.getElementById("userphotouploadprogresspercentage_");
              percent.innerHTML = Math.round(Percentage)+"%";

              if(Percentage >= 100){ }
          }
     }

     function addusrtocht(token){
       $.ajax({
         url: base_url+'/Messages/Ajax/addusrtocht',
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response){ $("#add_user_to_chat_body").html(response); }
       });
     }

     function addusertochat(usertoken,msgtoken){
       $.ajax({
         url: base_url+'/Messages/Ajax/addusertochat',
         type: 'POST',
         async : true,
         data: { usertoken : usertoken, msgtoken : msgtoken },
         success:function(response){
           var obj = JSON.parse(response);
           if(obj.status == 'success'){
             alert('User/s successfully added.');
             $('#add_user_to_chat').modal('hide');
           }
         }
       });
     }

     function rmvusrtocht(token){
       $.ajax({
         url: base_url+'/Messages/Ajax/rmvusrtocht',
         type: 'POST',
         async : true,
         data: { token : token },
         success:function(response){ $("#remove_user_to_chat_body").html(response); }
       });
     }

     function rmvusertochat(usertoken,msgtoken){
       $.ajax({
         url: base_url+'/Messages/Ajax/rmvusertochat',
         type: 'POST',
         async : true,
         data: { usertoken : usertoken, msgtoken : msgtoken },
         success:function(response){
           var obj = JSON.parse(response);
           if(obj.status == 'success'){
             alert('User/s successfully removed.');
             $('#remove_user_to_chat').modal('hide');
           }
         }
       });
     }

</script>

</body>

</html>
