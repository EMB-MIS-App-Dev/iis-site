<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Filesuploads_postdata extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

	function document_header(){
		if(!empty($_FILES['document_header']['name'])) {
			// Set preference
			$config = array(
				'upload_path'   => '../iis-images/document-header/',
				'allowed_types' => 'gif|jpeg|jpg|png',
				'max_size'      => '20480', // max_size in kb
				'file_name'     => $this->session->userdata('region').'-'.rand(5000, 6000).".".pathinfo($_FILES['document_header']['name'], PATHINFO_EXTENSION),
				'overwrite'     => TRUE,
			);

			//Load upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			// File upload
			if(!$this->upload->do_upload('document_header')) {
				// Show error on uploading
				$uploadError = array('error' => $this->upload->display_errors());
			}
			else {
				// Get data about the file
				$uploadData = $this->upload->data();

				$datainsert = array(
					'region'             =>   $this->session->userdata('region'),
					'office'             =>   $this->session->userdata('office'),
					'file_name'          => 	$config['file_name'],
				);

				$insertdata = $this->Embismodel->insertdata('office_uploads_document_header', $datainsert);
				if($insertdata){
					echo "<script>alert('File successfully uploaded.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
				}
			}
		}
  }

	function document_footer(){
		if(!empty($_FILES['document_footer']['name'])) {
			// Set preference
			$config = array(
				'upload_path'   => '../iis-images/document-footer/',
				'allowed_types' => 'gif|jpeg|jpg|png',
				'max_size'      => '20480', // max_size in kb
				'file_name'     => $this->session->userdata('region').'-'.rand(5000, 6000).".".pathinfo($_FILES['document_footer']['name'], PATHINFO_EXTENSION),
				'overwrite'     => TRUE,
			);

			//Load upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			// File upload
			if(!$this->upload->do_upload('document_footer')) {
				// Show error on uploading
				$uploadError = array('error' => $this->upload->display_errors());
			}
			else {
				// Get data about the file
				$uploadData = $this->upload->data();

				$datainsert = array(
					'region'             =>   $this->session->userdata('region'),
					'office'             =>   $this->session->userdata('office'),
					'file_name'          => 	$config['file_name'],
				);
				$insertdata = $this->Embismodel->insertdata('office_uploads_document_footer', $datainsert);
				if($insertdata){
					echo "<script>alert('File successfully uploaded.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
				}
				else {
					echo "<script>alert('Error on Uploading.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
				}
			}
		}
  }

	function esignatures(){
		if(!empty($_FILES['esignature']['name'])) {

			if(!is_dir('../iis-images/e-signatures')) {
				mkdir('../iis-images/e-signatures', 0777, TRUE);
			}

			$querymaxcnt = $this->db->query('SELECT MAX(cnt) AS mcnt FROM office_uploads_esignature')->result_array();
			$mcnt = $querymaxcnt[0]['mcnt']+1;
			// Set preference
			$config = array(
				'upload_path'   => '../iis-images/e-signatures/',
				'allowed_types' => 'gif|jpeg|jpg|png',
				'max_size'      => '20480', // max_size in kb
				'file_name'     => $mcnt.'-'.$this->session->userdata('region').'-'.$this->encrypt->decode($this->input->post('name_of_employee')).'-'.rand(5000, 6000).".".pathinfo($_FILES['esignature']['name'], PATHINFO_EXTENSION),
				'overwrite'     => TRUE,
			);
			//Load upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			// File upload
			if(!$this->upload->do_upload('esignature')) {
				// Show error on uploading
				$uploadError = array('error' => $this->upload->display_errors());
			}
			else {

				// Get data about the file
				$uploadData = $this->upload->data();

				$data    = array(
										'status' 	  => 'Inactive',
								 );
				$where    = array('office_uploads_esignature.userid' => $this->encrypt->decode($this->input->post('name_of_employee')));
				$update  = $this->Embismodel->updatedata($data,'office_uploads_esignature',$where);

				$wheredata = array('af.userid' => $this->encrypt->decode($this->input->post('name_of_employee')), 'af.stat' => '1', );
				$selectdata = $this->Embismodel->selectdata('acc_function AS af','af.func',$wheredata);

				if($selectdata[0]['func'] == 'Director'){
					$nxaxis = '60';
		      $nyaxis = '238';
		      $nwidth = '0';
		      $nheight = '11';

					$rxaxis = '58';
		      $ryaxis = '233';
		      $rwidth = '0';
		      $rheight = '11';
				}else if($selectdata[0]['func'] == 'Regional Director'){
					$nxaxis = '50';
		      $nyaxis = '222';
		      $nwidth = '0';
		      $nheight = '11';

		      $rxaxis = '50';
		      $ryaxis = '232';
		      $rwidth = '0';
		      $rheight = '11';
				}else{
					$nxaxis = '';
		      $nyaxis = '';
		      $nwidth = '';
		      $nheight = '';

		      $rxaxis = '';
		      $ryaxis = '';
		      $rwidth = '';
		      $rheight = '';
				}

				$insertdata = array(
					'userid'						 => $this->encrypt->decode($this->input->post('name_of_employee')),
					'date_added'         => date('Y-m-d'),
					'file_name'          => $config['file_name'],
					'status'             => 'Active',
					'to_height_a'        => '15',
					'to_width_a'         => '0',
					'to_yaxis_a'         => '290',
					'to_xaxis_a'         => '95',
					'to_height_r'        => $rheight,
					'to_width_r'         => $rwidth,
					'to_yaxis_r'         => $ryaxis,
					'to_xaxis_r'         => $rxaxis,
					'to_height_n'        => $nheight,
					'to_width_n'         => $nwidth,
					'to_yaxis_n'         => $nyaxis,
					'to_xaxis_n'         => $nxaxis,
					'swm_height'         => '11',
					'swm_width'          => '0',
					'swm_yaxis'          => '95',
					'swm_xaxis'          => '95',
					'swm_nov_height'     => '11',
					'swm_nov_width'      => '0',
					'swm_nov_yaxis'      => '95',
					'swm_nov_xaxis'      => '95',
				);
				$insert_esignature = $this->Embismodel->insertdata('office_uploads_esignature', $insertdata);



				if($insert_esignature){
					echo "<script>alert('File successfully uploaded.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
				}else{
					echo "<script>alert('Error! Please contact webmaster.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
				}
			}
		}
  }

	function remove_esignature(){
		$userid = $this->encrypt->decode($this->input->post('token'));

		$data    = array(
								'status' 	  => 'Inactive',
						 );
		$where    = array('office_uploads_esignature.userid' => $userid);
		$update  = $this->Embismodel->updatedata($data,'office_uploads_esignature',$where);

		if($update){
			echo "<script>alert('File successfully removed.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
		}else{
			echo "<script>alert('Error! Please contact webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/Uploads'</script>";
		}

	}

}

?>
