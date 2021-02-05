<?php
/**
 *
 */
  defined('BASEPATH') OR exit('No direct script access allowed');
class Get_address extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
  }


  function get_address(){
    $address = "India+Panchkula";
  $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($ch);
  curl_close($ch);
  print_r($response);exit;
  $response_a = json_decode($response);
  echo $lat = $response_a->results[0]->geometry->location->lat;
  echo "<br />";
  echo $long = $response_a->results[0]->geometry->location->lng;
  echo "1";
  }
}
