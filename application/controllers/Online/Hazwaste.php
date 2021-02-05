<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Hazwaste extends CI_Controller
  {
    private $onlinedata;
    function __construct()
    {
      parent::__construct();
      // USER SESSION CHECK
      if ( empty($this->session->userdata('token')) ) {
        echo "<script>alert('Session Timeout. Please Re-Login.'); window.location.href='".base_url()."';</script>";
      }

      $this->load->model('Embismodel');
      $this->load->helper(array('form', 'url'));

      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->library('upload');
      $this->load->library('encryption');

      date_default_timezone_set("Asia/Manila");

      $this->onlinedata['user'] = array(
        'id'      => $this->session->userdata('userid'),
        'token'   => $this->session->userdata('token'),
        'region'  => $this->session->userdata('region'),
        'secno'   => $this->session->userdata('secno'),
        'divno'   => $this->session->userdata('divno'),
      );

    }

    function transporter()
    {
        $this->load->view('includes/common/header');
        $this->load->view('includes/common/sidebar');
        $this->load->view('includes/common/nav');
        $this->load->view('includes/common/footer');
        // $this->load->view('includes/common/univ_styles');
        $this->load->view('Online/includes/custom_header');

        $this->load->view('Online/transporter', $this->onlinedata);
    }

    function transporter_data()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_URL => 'https://hwms.emb.gov.ph/api/transporter',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer sh4PgSyLRvBUax1wznv6tpICeC101Dj24btQuWRGj5ck6RDpaP3WypLpiSlL'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $decoded = json_decode($response, true);
        echo json_encode($decoded['transporter']);
    }

    function treater()
    {
        $this->load->view('includes/common/header');
        $this->load->view('includes/common/sidebar');
        $this->load->view('includes/common/nav');
        $this->load->view('includes/common/footer');
        $this->load->view('Online/includes/custom_header');

        $this->load->view('Online/treater', $this->onlinedata);
    }

    function treater_data()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_URL => 'https://hwms.emb.gov.ph/api/treater',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer sh4PgSyLRvBUax1wznv6tpICeC101Dj24btQuWRGj5ck6RDpaP3WypLpiSlL'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $decoded = json_decode($response, true);
        echo json_encode($decoded['registered_tsd']);
    }

    function generators()
    {
        $this->load->view('includes/common/header');
        $this->load->view('includes/common/sidebar');
        $this->load->view('includes/common/nav');
        $this->load->view('includes/common/footer');
        $this->load->view('Online/includes/custom_header');

        $this->load->view('Online/generators', $this->onlinedata);
    }

    function generators_data()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_SSL_VERIFYPEER => FALSE,
          CURLOPT_URL => 'https://hwms.emb.gov.ph/api/generators',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer sh4PgSyLRvBUax1wznv6tpICeC101Dj24btQuWRGj5ck6RDpaP3WypLpiSlL'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $decoded = json_decode($response, true);
        echo json_encode($decoded['hw_generators']);
    }

  }
?>
