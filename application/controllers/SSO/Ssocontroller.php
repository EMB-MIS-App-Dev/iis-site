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

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://hwms.emb.gov.ph/api/user/$uname/$password/");
            //curl_setopt($ch, CURLOPT_URL, 'https://hwms.emb.gov.ph/api/user/support@emb.gov.ph/@l03e1t3/');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 45);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                sprintf('Authorization: Bearer %s', 'sh4PgSyLRvBUax1wznv6tpICeC101Dj24btQuWRGj5ck6RDpaP3WypLpiSlL')
             ));
           
           
                $response = curl_exec($ch);  
               
            curl_close($ch);
  
            $res = json_decode($response, true);
            $status = ($res[0]['status']);
            $message = ($res[0]['message']);

            // echo $response;
            // echo $status;
            // echo $message;

            $iisid = $this->session->userdata('userid');

            if($status == 1 && $message == 'Valid'){
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

                $this->session->set_flashdata('flashmsg', $message);
            }
        }else{
            $this->session->set_flashdata('flashmsg', 'System Unavailable!');
        }

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