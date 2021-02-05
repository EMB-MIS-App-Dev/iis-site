<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exportdata extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Attachment');
    $this->load->model('Embismodel');
    $this->load->library('session');
    $this->load->helper('url');

  }

  function index(){
    // print_r($_POST);
    // echo APPPATH;
      $reader = IOFactory::createReader('Xlsx');
      $spreadsheet = $reader->load(APPPATH."sweetreport_template.xlsx");

      $sheet = $spreadsheet->getActiveSheet();

      $wheredata = $this->db->where('sf.status = "Signed Document" AND et.status != 0 AND sf.region = "'.$this->session->userdata('region').'" AND sf.date_patrolled BETWEEN "'.$_POST['from_dt'].'" AND "'.$_POST['to_dt'].'"');
      $joindata  = $this->db->join('er_transactions AS et', 'et.token = sf.trans_no', 'left');
      $querydata = $this->Embismodel->selectdata('sweet_form_log AS sf','sf.*','',$joindata,$wheredata);

      $contentStartRow = 3;
      $currentContentRow = 3;

      for ($i=0; $i < sizeof($querydata); $i++) {

        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1,1);

        if(!empty($querydata[$i]['trans_no'])){
          $sheet->setCellValue('A'.$currentContentRow, $querydata[$i]['trans_no']);
          $sheet->setCellValue('B'.$currentContentRow, $querydata[$i]['travel_no']);
          $sheet->setCellValue('C'.$currentContentRow, $querydata[$i]['date_created']);
          $sheet->setCellValue('D'.$currentContentRow, $querydata[$i]['creator_name']);
          $sheet->setCellValue('E'.$currentContentRow, $querydata[$i]['month_monitoring']);
          $sheet->setCellValue('F'.$currentContentRow, $querydata[$i]['report_type']);
          $sheet->setCellValue('G'.$currentContentRow, $querydata[$i]['date_patrolled']);
          $sheet->setCellValue('H'.$currentContentRow, date('h:i a', strtotime($querydata[$i]['time_patrolled'])));
          $sheet->setCellValue('I'.$currentContentRow, $querydata[$i]['lgu_patrolled_id']);
          $sheet->setCellValue('J'.$currentContentRow, $querydata[$i]['lgu_patrolled_name']);
          $sheet->setCellValue('K'.$currentContentRow, $querydata[$i]['barangay_name']);
          $sheet->setCellValue('L'.$currentContentRow, $querydata[$i]['street']);
          $sheet->setCellValue('M'.$currentContentRow, $querydata[$i]['latitude']);
          $sheet->setCellValue('N'.$currentContentRow, $querydata[$i]['longitude']);
          $sheet->setCellValue('O'.$currentContentRow, str_replace(';', ' ', $querydata[$i]['violations_observed_desc']));
          $sheet->setCellValue('P'.$currentContentRow, str_replace(';', '. ', $querydata[$i]['type_of_area_desc']));
          $sheet->setCellValue('Q'.$currentContentRow, $querydata[$i]['type_of_monitoring_desc']);
          $sheet->setCellValue('R'.$currentContentRow, $querydata[$i]['date_of_issuance_of_notice']);
          $sheet->setCellValue('S'.$currentContentRow, $querydata[$i]['number_dumping']);
          $sheet->setCellValue('T'.$currentContentRow, $querydata[$i]['number_activity']);
          $sheet->setCellValue('U'.$currentContentRow, $querydata[$i]['total_land_area']);
          $sheet->setCellValue('V'.$currentContentRow, str_replace(';|', '. ', $querydata[$i]['actions_undertaken_desc']));
          $sheet->setCellValue('W'.$currentContentRow, $querydata[$i]['final_disposal']);
          $sheet->setCellValue('X'.$currentContentRow, $querydata[$i]['fd_location']);
          $sheet->setCellValue('Y'.$currentContentRow, $querydata[$i]['fd_latitude']);
          $sheet->setCellValue('Z'.$currentContentRow, $querydata[$i]['fd_longitude']);

          $currentContentRow++;
        }
      }

      $writer = new Xlsx($spreadsheet); // instantiate Xlsx

      $filename = 'Data'; // set filename for excel file to be exported

      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');	// download file


  }

  // function index(){
  //   $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
  //
  //   $sheet = $spreadsheet->getActiveSheet();
  //
  //   // manually set table data value
  //   $sheet->setCellValue('A1', 'Gipsy Danger');
  //   $sheet->setCellValue('A2', 'Gipsy Avenger');
  //   $sheet->setCellValue('A3', 'Striker Eureka');
  //
  //   $writer = new Xlsx($spreadsheet); // instantiate Xlsx
  //
  //   $filename = 'list-of-jaegers'; // set filename for excel file to be exported
  //
  //   header('Content-Type: application/vnd.ms-excel'); // generate excel file
  //   header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
  //   header('Cache-Control: max-age=0');
  //
  //   $writer->save('php://output');	// download file
  // }

}

?>
