<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(E_ALL);
  // error_reporting(0);
  /*
  * segment 1 - dms
  * segment 2 - documents
  * segment 3 - actions (add, route, revise)
  */
  class Api_Retrieval extends CI_Controller
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

    function index()
    {
      echo '<button type="button" class="btn btn-danger">-UPDATE ALL-</button>';
    }

    function update_all()
    {
        $this->ecc();
        $this->cnc();
        $this->hw_generators();
        $this->registered_tsd();
        $this->transporter();
    }

    function ecc()
    {
      $ecc1= file_get_contents("http://192.168.90.202/ecc/api/projectswithstatus");
      $ecc = json_decode($ecc1, TRUE);
      // echo "<pre>".print_r($ecc, TRUE)."</pre>";
      // echo count($ecc);
      for($i = 0; $i < count($ecc); $i++)
      {
          $appExist = $this->Embismodel->selectdata( 'online_ecc', '*', array("GUID" => $ecc[$i]["GUID"]) );
          if($appExist) {
              $data = array (
                "GUID" => $ecc[$i]["GUID"],
                "ProjectName" => $ecc[$i]["ProjectName"],
                "Address" => $ecc[$i]["Address"],
                "Municipality" => $ecc[$i]["Municipality"],
                "Province" => $ecc[$i]["Province"],
                "Region" => $ecc[$i]["Region"],
                "Representative" => $ecc[$i]["Representative"],
                "Designation" => $ecc[$i]["Designation"],
                "Status" => $ecc[$i]["Status"],
                "ReferenceNo" => $ecc[$i]["ReferenceNo"],
                "DecisionDate" => $ecc[$i]["DecisionDate"],
                "RoutedToOffice" => $ecc[$i]["RoutedToOffice"],
                "RoutedTo" => $ecc[$i]["RoutedTo"],
                "CreatedDate" => $ecc[$i]["CreatedDate"],
                "ProponentName" => $ecc[$i]["ProponentName"],
                "MailingAddress" => $ecc[$i]["MailingAddress"],
                "ContactPerson" => $ecc[$i]["ContactPerson"],
                "Expr1" => $ecc[$i]["Expr1"],
              );
              $dbquery = $this->Embismodel->updatedata( $data, 'online_ecc', array("GUID" => $ecc[$i]["GUID"]) );
          }
          else {
              $data = array (
                "GUID" => $ecc[$i]["GUID"],
                "ProjectName" => $ecc[$i]["ProjectName"],
                "Address" => $ecc[$i]["Address"],
                "Municipality" => $ecc[$i]["Municipality"],
                "Province" => $ecc[$i]["Province"],
                "Region" => $ecc[$i]["Region"],
                "Representative" => $ecc[$i]["Representative"],
                "Designation" => $ecc[$i]["Designation"],
                "Status" => $ecc[$i]["Status"],
                "ReferenceNo" => $ecc[$i]["ReferenceNo"],
                "DecisionDate" => $ecc[$i]["DecisionDate"],
                "RoutedToOffice" => $ecc[$i]["RoutedToOffice"],
                "RoutedTo" => $ecc[$i]["RoutedTo"],
                "CreatedDate" => $ecc[$i]["CreatedDate"],
                "ProponentName" => $ecc[$i]["ProponentName"],
                "MailingAddress" => $ecc[$i]["MailingAddress"],
                "ContactPerson" => $ecc[$i]["ContactPerson"],
                "Expr1" => $ecc[$i]["Expr1"],
              );
              $dbquery = $this->Embismodel->insertdata( 'online_ecc', $data );
          }
      }

      if($dbquery) {
        echo 'success';
        $data = array(
          "updated_db" => 'ecc',
          "datetime_updated" => date("Y-m-d H:i:s")
        );
        $retrievalDbQuery = $this->Embismodel->insertdata( 'online_data_retrieval', $data );
      }
      else {
        echo 'failed';
      }
    }

    function cnc()
    {
      // $ch = curl_init();
      //
      // curl_setopt($ch, CURLOPT_URL, 'http://192.168.90.202/ecc/api/cncprojectswithstatus');
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
      //
      // $response = curl_exec($ch);
      // curl_close($ch);
      // // echo $response;
      //
      // $cnc = json_decode($response, true);

        $get= file_get_contents("http://192.168.90.202/ecc/api/cncprojectswithstatus");
        $cnc = json_decode($get, TRUE);
        // echo "<pre>".print_r($ecc, TRUE)."</pre>";
        echo count($cnc);

      // for($i = 0; $i < 50; $i++)
      // {
      //     $appExist = $this->Embismodel->selectdata( 'online_cnc', '*', array("GUID" => $cnc[$i]["GUID"]) );
      //     if($appExist) {
      //         $data = array (
      //           "GUID" => $cnc[$i]["GUID"],
      //           "ProjectName" => $cnc[$i]["ProjectName"],
      //           "Address" => $cnc[$i]["Address"],
      //           "Municipality" => $cnc[$i]["Municipality"],
      //           "Province" => $cnc[$i]["Province"],
      //           "Region" => $cnc[$i]["Region"],
      //           "Representative" => $cnc[$i]["Representative"],
      //           "Designation" => $cnc[$i]["Designation"],
      //           "Status" => $cnc[$i]["Status"],
      //           "ReferenceNo" => $cnc[$i]["ReferenceNo"],
      //           "DecisionDate" => $cnc[$i]["DecisionDate"],
      //           "RoutedToOffice" => $cnc[$i]["RoutedToOffice"],
      //           "RoutedTo" => $cnc[$i]["RoutedTo"],
      //           "CreatedDate" => $cnc[$i]["CreatedDate"],
      //           "ProponentName" => $cnc[$i]["ProponentName"],
      //           "MailingAddress" => $cnc[$i]["MailingAddress"],
      //           "ContactPerson" => $cnc[$i]["ContactPerson"],
      //           "Expr1" => $cnc[$i]["Expr1"]
      //         );
      //         $dbquery = $this->Embismodel->updatedata( $data, 'online_cnc', array("GUID" => $cnc[$i]["GUID"]) );
      //     }
      //     else {
      //         $data = array (
      //           "GUID" => $cnc[$i]["GUID"],
      //           "ProjectName" => $cnc[$i]["ProjectName"],
      //           "Address" => $cnc[$i]["Address"],
      //           "Municipality" => $cnc[$i]["Municipality"],
      //           "Province" => $cnc[$i]["Province"],
      //           "Region" => $cnc[$i]["Region"],
      //           "Representative" => $cnc[$i]["Representative"],
      //           "Designation" => $cnc[$i]["Designation"],
      //           "Status" => $cnc[$i]["Status"],
      //           "ReferenceNo" => $cnc[$i]["ReferenceNo"],
      //           "DecisionDate" => $cnc[$i]["DecisionDate"],
      //           "RoutedToOffice" => $cnc[$i]["RoutedToOffice"],
      //           "RoutedTo" => $cnc[$i]["RoutedTo"],
      //           "CreatedDate" => $cnc[$i]["CreatedDate"],
      //           "ProponentName" => $cnc[$i]["ProponentName"],
      //           "MailingAddress" => $cnc[$i]["MailingAddress"],
      //           "ContactPerson" => $cnc[$i]["ContactPerson"],
      //           "Expr1" => $cnc[$i]["Expr1"]
      //         );
      //         $dbquery = $this->Embismodel->insertdata( 'online_cnc', $data );
      //     }
      // }

      if($dbquery) {
        echo 'success';
        $data = array(
          "updated_db" => 'cnc',
          "datetime_updated" => date("Y-m-d H:i:s")
        );
        $retrievalDbQuery = $this->Embismodel->insertdata( 'online_data_retrieval', $data );
      }
      else {
        echo 'failed';
      }
    }

    function hw_generators()
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
      $generators = $decoded['hw_generators'];

      for($i = 0; $i < count($generators); $i++)
      {
          $appExist = $this->Embismodel->selectdata( 'online_hw_generators', '*', array("id" => $generators[$i]["id"]) );
          if($appExist) {
              $data = array (
                  "id" => $generators[$i]["id"],
                  "case_handler" => $generators[$i]["case_handler"],
                  "region" => $generators[$i]["region"],
                  "province" => $generators[$i]["province"],
                  "reference_code" => $generators[$i]["reference_code"],
                  "sub_type" => $generators[$i]["sub_type"],
                  "accepted_at" => $generators[$i]["accepted_at"],
                  "date_issued" => $generators[$i]["date_issued"],
                  "company" => $generators[$i]["company"],
                  "address" => $generators[$i]["address"],
                  "latitude" => $generators[$i]["latitude"],
                  "longitude" => $generators[$i]["longitude"],
                  "pco_name" => $generators[$i]["pco_name"],
                  "pco_accreditation_no" => $generators[$i]["pco_accreditation_no"],
                  "pco_date_of_accreditation" => $generators[$i]["pco_date_of_accreditation"],
                  "pco_email" => $generators[$i]["pco_email"],
                  "telephone_number" => $generators[$i]["telephone_number"],
                  "no_employee" => $generators[$i]["no_employee"],
                  "code" => $generators[$i]["code"],
                  "psic_no" => $generators[$i]["psic_no"],
                  "description" => $generators[$i]["description"],
                  "details" => $generators[$i]["details"],
                  "catalogue" => $generators[$i]["catalogue"],
                  "nature" => $generators[$i]["nature"],
                  "waste_mgmt_practice" => $generators[$i]["waste_mgmt_practice"],
                  "products" => $generators[$i]["products"],
                  "services" => $generators[$i]["services"],
                  "nature_business" => $generators[$i]["nature_business"],
                  "permit_name" => $generators[$i]["permit_name"],
                  "permit_no" => $generators[$i]["permit_no"],
                  "permit_date_issued" => $generators[$i]["permit_date_issued"],
                  "permit_date_expiry" => $generators[$i]["permit_date_expiry"],
                  "place_of_issuance" => $generators[$i]["place_of_issuance"],
              );
              $dbquery = $this->Embismodel->updatedata( $data, 'online_hw_generators', array("id" => $generators[$i]["id"]) );
          }
          else {
              $data = array (
                  "id" => $generators[$i]["id"],
                  "case_handler" => $generators[$i]["case_handler"],
                  "region" => $generators[$i]["region"],
                  "province" => $generators[$i]["province"],
                  "reference_code" => $generators[$i]["reference_code"],
                  "sub_type" => $generators[$i]["sub_type"],
                  "accepted_at" => $generators[$i]["accepted_at"],
                  "date_issued" => $generators[$i]["date_issued"],
                  "company" => $generators[$i]["company"],
                  "address" => $generators[$i]["address"],
                  "latitude" => $generators[$i]["latitude"],
                  "longitude" => $generators[$i]["longitude"],
                  "pco_name" => $generators[$i]["pco_name"],
                  "pco_accreditation_no" => $generators[$i]["pco_accreditation_no"],
                  "pco_date_of_accreditation" => $generators[$i]["pco_date_of_accreditation"],
                  "pco_email" => $generators[$i]["pco_email"],
                  "telephone_number" => $generators[$i]["telephone_number"],
                  "no_employee" => $generators[$i]["no_employee"],
                  "code" => $generators[$i]["code"],
                  "psic_no" => $generators[$i]["psic_no"],
                  "description" => $generators[$i]["description"],
                  "details" => $generators[$i]["details"],
                  "catalogue" => $generators[$i]["catalogue"],
                  "nature" => $generators[$i]["nature"],
                  "waste_mgmt_practice" => $generators[$i]["waste_mgmt_practice"],
                  "products" => $generators[$i]["products"],
                  "services" => $generators[$i]["services"],
                  "nature_business" => $generators[$i]["nature_business"],
                  "permit_name" => $generators[$i]["permit_name"],
                  "permit_no" => $generators[$i]["permit_no"],
                  "permit_date_issued" => $generators[$i]["permit_date_issued"],
                  "permit_date_expiry" => $generators[$i]["permit_date_expiry"],
                  "place_of_issuance" => $generators[$i]["place_of_issuance"],
              );
              $dbquery = $this->Embismodel->insertdata( 'online_hw_generators', $data );
          }
      }

      if($dbquery) {
        echo 'success';
        $data = array(
          "updated_db" => 'hw_generators',
          "datetime_updated" => date("Y-m-d H:i:s")
        );
        $retrievalDbQuery = $this->Embismodel->insertdata( 'online_data_retrieval', $data );
      }
      else {
        echo 'failed';
      }

    }

    function registered_tsd()
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
      $treater = $decoded['registered_tsd'];

      for($i = 0; $i < count($treater); $i++)
      {
          $appExist = $this->Embismodel->selectdata( 'online_registered_tsd', '*', array("application_id" => $treater[$i]["application_id"]) );
          if($appExist) {
              $data = array (
                "application_id" => $treater[$i]["application_id"],
                "case_handler" => $treater[$i]["case_handler"],
                "region" => $treater[$i]["region"],
                "province" => $treater[$i]["province"],
                "sub_type" => $treater[$i]["sub_type"],
                "application_type" => $treater[$i]["application_type"],
                "date_application_recieved" => $treater[$i]["date_application_recieved"],
                "expiry_date" => $treater[$i]["expiry_date"],
                "reference_code" => $treater[$i]["reference_code"],
                "date_approved" => $treater[$i]["date_approved"],
                "company" => $treater[$i]["company"],
                "establish_name" => $treater[$i]["establish_name"],
                "address" => $treater[$i]["address"],
                "latitude" => $treater[$i]["latitude"],
                "longitude" => $treater[$i]["longitude"],
                "pco_name" => $treater[$i]["pco_name"],
                "pco_accreditation_no" => $treater[$i]["pco_accreditation_no"],
                "pco_date_of_accreditation" => $treater[$i]["pco_date_of_accreditation"],
                "pco_email" => $treater[$i]["pco_email"],
                "pco_tel_number" => $treater[$i]["pco_tel_number"],
                "no_employee" => $treater[$i]["no_employee"],
                "permit_name" => $treater[$i]["permit_name"],
                "permit_no" => $treater[$i]["permit_no"],
                "permit_date_issued" => $treater[$i]["permit_date_issued"],
                "permit_date_expiry" => $treater[$i]["permit_date_expiry"],
                "place_of_issuance" => $treater[$i]["place_of_issuance"],
                "waste_code" => $treater[$i]["waste_code"],
                "waste_description" => $treater[$i]["waste_description"],
                "category" => $treater[$i]["category"],
                "treatment_method" => $treater[$i]["treatment_method"],
                "description_method" => $treater[$i]["description_method"],
                "capacity" => $treater[$i]["capacity"],
                "residual_management" => $treater[$i]["residual_management"],
                "total_storage" => $treater[$i]["total_storage"],
                "operating_condition" => $treater[$i]["operating_condition"],
                "polution_control" => $treater[$i]["polution_control"],
                "name_of_disposal" => $treater[$i]["name_of_disposal"],
                "disposal_address" => $treater[$i]["disposal_address"],
                "disposal_capacity" => $treater[$i]["disposal_capacity"]
              );
              $dbquery = $this->Embismodel->updatedata( $data, 'online_registered_tsd', array("application_id" => $treater[$i]["application_id"]) );
          }
          else {
              $data = array (
                  "application_id" => $treater[$i]["application_id"],
                  "case_handler" => $treater[$i]["case_handler"],
                  "region" => $treater[$i]["region"],
                  "province" => $treater[$i]["province"],
                  "sub_type" => $treater[$i]["sub_type"],
                  "application_type" => $treater[$i]["application_type"],
                  "date_application_recieved" => $treater[$i]["date_application_recieved"],
                  "expiry_date" => $treater[$i]["expiry_date"],
                  "reference_code" => $treater[$i]["reference_code"],
                  "date_approved" => $treater[$i]["date_approved"],
                  "company" => $treater[$i]["company"],
                  "establish_name" => $treater[$i]["establish_name"],
                  "address" => $treater[$i]["address"],
                  "latitude" => $treater[$i]["latitude"],
                  "longitude" => $treater[$i]["longitude"],
                  "pco_name" => $treater[$i]["pco_name"],
                  "pco_accreditation_no" => $treater[$i]["pco_accreditation_no"],
                  "pco_date_of_accreditation" => $treater[$i]["pco_date_of_accreditation"],
                  "pco_email" => $treater[$i]["pco_email"],
                  "pco_tel_number" => $treater[$i]["pco_tel_number"],
                  "no_employee" => $treater[$i]["no_employee"],
                  "permit_name" => $treater[$i]["permit_name"],
                  "permit_no" => $treater[$i]["permit_no"],
                  "permit_date_issued" => $treater[$i]["permit_date_issued"],
                  "permit_date_expiry" => $treater[$i]["permit_date_expiry"],
                  "place_of_issuance" => $treater[$i]["place_of_issuance"],
                  "waste_code" => $treater[$i]["waste_code"],
                  "waste_description" => $treater[$i]["waste_description"],
                  "category" => $treater[$i]["category"],
                  "treatment_method" => $treater[$i]["treatment_method"],
                  "description_method" => $treater[$i]["description_method"],
                  "capacity" => $treater[$i]["capacity"],
                  "residual_management" => $treater[$i]["residual_management"],
                  "total_storage" => $treater[$i]["total_storage"],
                  "operating_condition" => $treater[$i]["operating_condition"],
                  "polution_control" => $treater[$i]["polution_control"],
                  "name_of_disposal" => $treater[$i]["name_of_disposal"],
                  "disposal_address" => $treater[$i]["disposal_address"],
                  "disposal_capacity" => $treater[$i]["disposal_capacity"]
              );
              $dbquery = $this->Embismodel->insertdata( 'online_registered_tsd', $data );
          }
      }

      if($dbquery) {
        echo 'success';
        $data = array(
          "updated_db" => 'registered_tsd',
          "datetime_updated" => date("Y-m-d H:i:s")
        );
        $retrievalDbQuery = $this->Embismodel->insertdata( 'online_data_retrieval', $data );
      }
      else {
        echo 'failed';
      }

    }

    function transporter()
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
      $transporter = $decoded['transporter'];

      for($i = 0; $i < count($transporter); $i++)
      {
          $appExist = $this->Embismodel->selectdata( 'online_transporter', '*', array("application_id" => $transporter[$i]["application_id"]) );
          if($appExist) {
              $data = array (
                  "application_id" => $transporter[$i]["application_id"],
                  "case_handler" => $transporter[$i]["case_handler"],
                  "region" => $transporter[$i]["region"],
                  "province" => $transporter[$i]["province"],
                  "application_type" => $transporter[$i]["application_type"],
                  "reference" => $transporter[$i]["reference"],
                  "sub_type" => $transporter[$i]["sub_type"],
                  "date_application_recieved" => $transporter[$i]["date_application_recieved"],
                  "date_approved" => $transporter[$i]["date_approved"],
                  "expiry_date" => $transporter[$i]["expiry_date"],
                  "company_name" => $transporter[$i]["company_name"],
                  "address" => $transporter[$i]["address"],
                  "latitude" => $transporter[$i]["latitude"],
                  "longitude" => $transporter[$i]["longitude"],
                  "pco_name" => $transporter[$i]["pco_name"],
                  "pco_accreditation_no" => $transporter[$i]["pco_accreditation_no"],
                  "pco_date_of_accreditation" => $transporter[$i]["pco_date_of_accreditation"],
                  "pco_email" => $transporter[$i]["pco_email"],
                  "pco_tel_number" => $transporter[$i]["pco_tel_number"],
                  "no_employee" => $transporter[$i]["no_employee"],
                  "waste_code" => $transporter[$i]["waste_code"],
                  "waste_description" => $transporter[$i]["waste_description"]
              );
              $dbquery = $this->Embismodel->updatedata( $data, 'online_transporter', array("application_id" => $transporter[$i]["application_id"]) );
          }
          else {
              $data = array (
                  "application_id" => $transporter[$i]["application_id"],
                  "case_handler" => $transporter[$i]["case_handler"],
                  "region" => $transporter[$i]["region"],
                  "province" => $transporter[$i]["province"],
                  "application_type" => $transporter[$i]["application_type"],
                  "reference" => $transporter[$i]["reference"],
                  "sub_type" => $transporter[$i]["sub_type"],
                  "date_application_recieved" => $transporter[$i]["date_application_recieved"],
                  "date_approved" => $transporter[$i]["date_approved"],
                  "expiry_date" => $transporter[$i]["expiry_date"],
                  "company_name" => $transporter[$i]["company_name"],
                  "address" => $transporter[$i]["address"],
                  "latitude" => $transporter[$i]["latitude"],
                  "longitude" => $transporter[$i]["longitude"],
                  "pco_name" => $transporter[$i]["pco_name"],
                  "pco_accreditation_no" => $transporter[$i]["pco_accreditation_no"],
                  "pco_date_of_accreditation" => $transporter[$i]["pco_date_of_accreditation"],
                  "pco_email" => $transporter[$i]["pco_email"],
                  "pco_tel_number" => $transporter[$i]["pco_tel_number"],
                  "no_employee" => $transporter[$i]["no_employee"],
                  "waste_code" => $transporter[$i]["waste_code"],
                  "waste_description" => $transporter[$i]["waste_description"],
              );
              $dbquery = $this->Embismodel->insertdata( 'online_transporter', $data );
          }
      }

      if($dbquery) {
        echo 'success';
        $data = array(
          "updated_db" => 'transporter',
          "datetime_updated" => date("Y-m-d H:i:s")
        );
        $retrievalDbQuery = $this->Embismodel->insertdata( 'online_data_retrieval', $data );
      }
      else {
        echo 'failed';
      }

    }

  }
?>
