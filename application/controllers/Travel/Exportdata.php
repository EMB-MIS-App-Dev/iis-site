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

      $reader = IOFactory::createReader('Xlsx');
      $spreadsheet = $reader->load(APPPATH."travelorder_template.xlsx");

      $sheet = $spreadsheet->getActiveSheet();
      if($this->session->userdata('func') == 'Regional Executive Director'){
        $wheredata = $this->db->where('(tt.status = "Signed Document" OR tt.status = "Approved") AND tt.region = "'.$this->session->userdata('region').'" AND et.status != 0 AND ttl.assignedto = "'.$this->session->userdata('userid').'" AND tt.departure_date BETWEEN "'.$_POST['from_dt'].'" AND "'.$_POST['to_dt'].'"');
        $joindata  = $this->db->join('er_transactions AS et', 'et.trans_no = tt.er_no', 'left');
        $joindata  = $this->db->join('to_trans_log AS ttl', 'ttl.er_no = tt.er_no', 'left');
        $querydata = $this->Embismodel->selectdata('to_trans AS tt','tt.toid, tt.name, tt.departure_date, tt.travel_cat, tt.travel_type, tt.arrival_date, tt.destination, tt.travel_purpose','',$joindata,$wheredata);
      }else{
        $wheredata = $this->db->where('(tt.status = "Signed Document" OR tt.status = "Approved") AND tt.region = "'.$this->session->userdata('region').'" AND et.status != 0 AND tt.departure_date BETWEEN "'.$_POST['from_dt'].'" AND "'.$_POST['to_dt'].'"');
        $joindata  = $this->db->join('er_transactions AS et', 'et.trans_no = tt.er_no', 'left');
        $querydata = $this->Embismodel->selectdata('to_trans AS tt','tt.toid, tt.name, tt.departure_date, tt.travel_cat, tt.travel_type, tt.arrival_date, tt.destination, tt.travel_purpose','',$joindata,$wheredata);
      }


      $contentStartRow = 3;
      $currentContentRow = 3;
      $counter = 0;
      for ($i=0; $i < sizeof($querydata); $i++) {

        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1,1);

        if(!empty($querydata[$i]['toid'])){
          $travelcat = ($querydata[$i]['travel_cat'] == 'Yes') ? 'Regional' : 'National';
          $counter++;
          $sheet->setCellValue('A'.$currentContentRow, $counter);
          $sheet->setCellValue('B'.$currentContentRow, $querydata[$i]['toid']);
          $sheet->setCellValue('C'.$currentContentRow, $querydata[$i]['name']);
          $sheet->setCellValue('D'.$currentContentRow, date('F d, Y', strtotime($querydata[$i]['departure_date'])).' - '.date('F d, Y', strtotime($querydata[$i]['arrival_date'])));
          $sheet->setCellValue('E'.$currentContentRow, $travelcat);
          $sheet->setCellValue('F'.$currentContentRow, $querydata[$i]['travel_type']);
          $sheet->setCellValue('G'.$currentContentRow, str_replace('Array','',$querydata[$i]['destination']));
          $sheet->setCellValue('H'.$currentContentRow, $querydata[$i]['travel_purpose']);

          $currentContentRow++;
        }
      }

      $writer = new Xlsx($spreadsheet); // instantiate Xlsx

      $filename = 'Travel Order - Export Data'; // set filename for excel file to be exported

      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');	// download file


  }

}

?>
