<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Ssocontroller extends CI_Controller
{

    function __construct()
    {
      parent::__construct();
      $this->load->model('Ssomodel');
      $this->load->database();
    }

    function test(){
        $data['test'] =  $this->Ssomodel->fetch_subsys();
        echo json_encode($data['test']);
    }

    function enrollment()
    {

        $this->load->library('session');
        $this->load->view('includes/common/header');
        $this->load->view('includes/common/sidebar');
        $this->load->view('includes/common/nav');
        $this->load->view('includes/common/footer');
        $this->load->view('sso/enrollment', $data);
    }

    function enroll()
    {

        $result = $this->input->post('selSubsystem');
        $result_explode = explode('|', $result);
        
        $subsys = $result_explode[0];
        $subsyslink = $result_explode[1];
        $subsysimg = $result_explode[2];

        $nickname = $this->input->post('txtnickname');
        $uname = $this->input->post('txtusernames');
        $password = $this->input->post('txtpasswords');

        if($subsys == 'PCB'){
            // get api
            $data =  file_get_contents("http://pcb.emb.gov.ph/api/table/userTB/$uname/$password");
            $var = json_decode($data);

            $iisid = $this->session->userdata('userid');

            if($var->status == 1 && $var->message == 'Valid'){
                $data = array(
                    'iis_id' =>  $iisid,
                    'subsys_id' => $subsys,
                    'subsys_link' => $subsyslink,
                    'subsys_img' => $subsysimg,
                    'nickname' => $nickname,
                    'username' => $uname,
                    'password' => $password
                );
               $res = $this->Ssomodel->enroll($data);

               $this->session->set_flashdata('flashmsg', 'Account successfully added!');
            }else{

                $this->session->set_flashdata('flashmsg', $var->message);
            }
        }else if($subsys == 'HWMS'){
            // get api
            $data =  file_get_contents("https://hwms.emb.gov.ph/api/user/$uname/$password");
            $var = json_decode($data);

            $iisid = $this->session->userdata('userid');

            if($var->status == 1 && $var->message == 'Valid'){
                $data = array(
                    'iis_id' =>  $iisid,
                    'subsys_id' => $subsys,
                    'subsys_link' => $subsyslink,
                    'nickname' => $nickname,
                    'username' => $uname,
                    'password' => $password
                );
                $res = $this->Ssomodel->enroll($data);

                $this->session->set_flashdata('flashmsg', 'Account successfully added!');
            }else{

                $this->session->set_flashdata('flashmsg', $var->message);
            }
        }else{
            $this->session->set_flashdata('flashmsg', 'System Unavailable!');
        }

        // $this->session->set_flashdata('flashmsg', $subsys);

        $url = $_SERVER['HTTP_REFERER'];
        redirect($url);
   
    }

    function getsubsys(){
        $data['data'] =  $this->Ssomodel->fetch_subsys();
        echo json_encode($data['data']);
    }

    function remsubsys($id){
        $this->Ssomodel->rem_subsys($id);
        
        $url = $_SERVER['HTTP_REFERER'];
		redirect($url);
    }

    function selectsys(){
        $data['getsub'] =  $this->Ssomodel->fetch_subsys();
        $this->load->library('session');
        $this->load->view('includes/login/header');
        $this->load->view('sso/selectsys', $data);
        $this->load->view('includes/login/footer');
        
        // echo "<script>window.location.href='".base_url()."dashboard'</script>";
    }
}

?>