<?php

class Attachment extends CI_Model
{

  function __construct()
  {
  parent::__construct();
    $this->load->helper(array('form', 'url'));
  }

  public function uploadattch($randomtickets='',$subfolder=''){
    if (!is_dir('uploads/'.$subfolder.'/'.$randomtickets)) {
      mkdir('uploads/'.$subfolder.'/'.$randomtickets, 0777, TRUE);
    }else {
      echo "exist";
    }
    foreach ($_FILES as $key => $v) {
           $_FILES['files']['name']      = $v['name'];
           $_FILES['files']['type']      = $v['type'];
           $_FILES['files']['tmp_name']  = $v['tmp_name'];
           $_FILES['files']['error']     = $v['error'];
           $_FILES['files']['size']      = $v['size'];
           $config['upload_path']   = 'uploads/'.$subfolder.'/'.$randomtickets;
           $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx';
           $config['max_size']      = '50000'; // max_size in kb
           $config['file_name']     =  $v['name'];
           $config['overwrite']     =  FALSE;
           $this->load->library('upload',$config);
           $this->upload->initialize($config);
           if(! $this->upload->do_upload('files')){
               $error = array('error' => $this->upload->display_errors());
           }else{
             $data = $this->upload->data();
           }
     }
  }


}
