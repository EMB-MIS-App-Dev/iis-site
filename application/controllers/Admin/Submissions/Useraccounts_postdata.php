<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Useraccounts_postdata extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

	function add_function(){
		// error_reporting(0);
		$function 	   = $this->encrypt->decode($this->input->post('function'));
		$designation   = ucwords($this->input->post('designation'));
		$start_date    = $this->input->post('start_date');
		$plantilla_pos = $this->input->post('plantilla_pos');
		$plantilla_itm = $this->input->post('rank');

		$where         = $this->db->where('au.token', $function);
		$queryselect   = $this->Embismodel->selectdata('embis.acc_usertype AS au','au.dsc,au.ordr','',$where);
		$user_region   = $this->session->userdata('region');
		// echo $this->db->last_query(); exit;

		$arr           = str_split('ABCDEFGHIJKLMNOP'); shuffle($arr);
		$arrr          = array_slice($arr, 0, 6);
		$raw_password  = implode('', $arrr);
		$en_password   = password_hash($raw_password,PASSWORD_DEFAULT);

			$section 	      = $this->encrypt->decode($this->input->post('section'));
			$wheresect      = $this->db->where('xt.secno',$section);
			$queryselectsca = $this->Embismodel->selectdata('embis.acc_xsect AS xt','xt.secno,xt.sect','',$wheresect);

			$division 	    = $this->encrypt->decode($this->input->post('division'));
			$wherediv       = $this->db->where('xn.token',$division);
			$queryselectdva = $this->Embismodel->selectdata('embis.acc_xdvsion AS xn','xn.divcode,xn.divno','',$wherediv);

			if(!empty($queryselectsca[0]['secno'])){ $secno = $queryselectsca[0]['secno']; }else { $secno = "";}
			if(!empty($queryselectdva[0]['divno'])){ $divno = $queryselectdva[0]['divno']; }else { $divno = "";}

			//Assign new user function
			$employee_token= $this->encrypt->decode($this->input->post('employee_userid'));
			$designation   = $this->input->post('designation');
			$start_date    = $this->input->post('start_date');

			$where_token   = $this->db->where('acs.userid',$employee_token);
			$joinacc       = $this->db->join('embis.acc', 'acc.userid = acs.userid', 'left');
			$queryselectacs= $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.userid,acs.email,acc.username','',$where_token,$joinacc);

			if($queryselectacs[0]['userid'] == ''){
				echo "<script>alert('Error encountered. Please contact the webmaster. Thank you.')</script>";
				echo "<script>window.location.href='".base_url()."'</script>";
			}else{

				foreach($_POST['order'] as $key => $value){
					$employee    = array_values(array_filter($this->input->post('employee')));
					$order       = array_values(array_filter($this->input->post('order')));
					$employeekey = $this->encrypt->decode($employee[$key]);
					$orderkey    = $this->encrypt->decode($order[$key]);
					if(!empty($employeekey) AND !empty($orderkey)){
						$whereifexist = $this->db->where('tf.userid = "'.$queryselectacs[0]['userid'].'" AND tf.assigned_to = "'.$employeekey.'"');
						$checkifexist = $this->Embismodel->selectdata('to_func AS tf','tf.cnt','',$whereifexist);
						if(empty($checkifexist[0]['cnt'])){
							$data = array(
								'userid'       => $queryselectacs[0]['userid'],
								'assigned_to'  => $employeekey,
								'route_order'  => $orderkey,
							);
							$this->Embismodel->insertdata('to_func', $data);
						}
					}
				}

				$data     	   = array(
									'division' 	         => $queryselectdva[0]['divcode'],
									'divno' 	         	 => $divno,
									'section' 	         => $queryselectsca[0]['sect'],
									'secno' 	           => $secno,
									'designation'        => $designation,
									'plantilla_pos' 	   => $plantilla_pos,
									'plantilla_itemno'   => $plantilla_itm,
									'verified' 	         => '1',
								);

				$where         = array('acc_credentials.userid' => $queryselectacs[0]['userid']);
				$updateuser    = $this->Embismodel->updatedata($data,'acc_credentials',$where);

				$data_func_old      = array( 'acc_function.stat'  => '0', );
				$where_func_old     = array('acc_function.userid' => $queryselectacs[0]['userid']);
				$update_func_old    = $this->Embismodel->updatedata($data_func_old,'acc_function',$where_func_old);

				$data 		   = array(
												'acc_function.userid'     => $queryselectacs[0]['userid'],
												'acc_function.dt_strt'    => $start_date,
												'acc_function.func'       => $queryselect[0]['dsc'],
												'acc_function.func_order' => $queryselect[0]['ordr'],
												'acc_function.secno'      => $secno,
												'acc_function.divno'      => $divno,
												'acc_function.div_nam'    => $queryselectdva[0]['divcode'],
												'acc_function.region'     => $user_region,
												'acc_function.office'     => $this->session->userdata('office'),
												'acc_function.stat'       => '1',
											);

				$insertfunction = $this->Embismodel->insertdata('embis.acc_function',$data);

				$data     	    = array(
  				'raw_password' => $this->encrypt->encode($raw_password),
					'en_password'  => $en_password,
					'acc_status'   => '1',
					'cpass'        => '0',
				);

				$where         = array('acc.userid' => $queryselectacs[0]['userid']);
				$updateacc     = $this->Embismodel->updatedata($data,'acc',$where);


			}
			//Assign new user function
			$raw_username = str_replace('&ntilde;','ñ',$queryselectacs[0]['username']);
		error_reporting(0);

		    $this->load->config('email');
        $this->load->library('email');
        $from 	 = $this->config->item('smtp_user');
        $to 	 = $queryselectacs[0]['email'];
				$subject = 'Environmental Management Bureau User Credentials';
				$message = '
Please refer below for your user credentials.

Username: '.$raw_username.' Password: '.$raw_password.'

Login to this link: http://iis.emb.gov.ph/';

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

		if($updateuser){
			if($insertfunction){
				if ($this->email->send()) {
					$swal_arr = array(
					 'title'     => 'SUCCESS!',
					 'text'      => 'User successfully assigned.',
					 'type'      => 'success',
				 );
				 $this->session->set_flashdata('swal_arr', $swal_arr);
					echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
				} else {
					// show_error($this->email->print_debugger());
					echo "<script>alert('It seems like the email given is not correct. Please report to r7support@emb.gov.ph. Thank you!')</script>";
					echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
				}
			}else{
				echo "<script>alert('Error! Please contact the webmaster2.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}else{
			echo "<script>alert('Error! Please contact the webmaster3.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function edit_section_details(){

		$divno   = $this->input->post('divno');
		$secno   = $this->encrypt->decode($this->input->post('secno'));
		$secname = $this->input->post('secname');
		$secode = $this->input->post('secode');

		if(!empty($divno) AND !empty($secno) AND !empty($secname) AND !empty($secode)){

			$data    = array(
								'divno'  => $divno,
								'secode' => $secode,
								'sect'   => $secname,
							);

			$where   = array('acc_xsect.secno' => $secno);
			$update  = $this->Embismodel->updatedata($data,'acc_xsect',$where);

			if($update){
				$swal_arr = array(
				 'title'     => 'SUCCESS!',
				 'text'      => 'Successfully edited.',
				 'type'      => 'success',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}else{
				echo "<script>alert('Error! Please contact the webmaster.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function add_section_details(){

		$divno         = $this->input->post('division');
		$section       = $this->input->post('section');
		$secode       = $this->input->post('secode');
		$user_region   = $this->session->userdata('region');

		if(!empty($divno) AND !empty($section) AND !empty($secode)){

			$chkwr = $this->db->where('ax.divno = "'.$divno.'" AND ax.sect = "'.$section.'" AND ax.region = "'.$user_region.'"');
			$chkdup = $this->Embismodel->selectdata('acc_xsect AS ax','ax.secno','',$chkwr);
			// echo $this->db->last_query(); exit;
			if(empty($chkdup[0]['secno'])){
				$this->db->select_max('secno');
		    $result = $this->db->get('acc_xsect');
		    if ($result->num_rows() > 0)
		    {
		        $res = $result->result_array();
		        $reslt = $res[0]['secno'];
		        $maxsecno = $reslt + 1; //column 1
		    }

				$data 	= array(
							'acc_xsect.secno'  => $maxsecno,
							'acc_xsect.divno'  => $divno,
							'acc_xsect.secode' => $secode,
							'acc_xsect.sect'   => $section,
							'acc_xsect.region' => $user_region,
							'acc_xsect.added_by' => $this->session->userdata('userid'),
	            );

				$insertsection = $this->Embismodel->insertdata('embis.acc_xsect',$data);

				if($insertsection){
					$swal_arr = array(
					 'title'     => 'SUCCESS!',
					 'text'      => 'Successfully added.',
					 'type'      => 'success',
				 );
				 $this->session->set_flashdata('swal_arr', $swal_arr);
					echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
				}else{
					echo "<script>alert('Error! Please contact the webmaster.')</script>";
					echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
				}
			}else{
				$swal_arr = array(
				 'title'     => 'ERROR!',
				 'text'      => 'Section/Unit already exist.',
				 'type'      => 'error',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}


		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function add_division_details(){

		$division      = $this->input->post('division');
		$divcode       = $this->input->post('divcode');
		$user_region   = strtolower($this->session->userdata('region'));

		if(!empty($division) AND !empty($user_region)){

			$this->db->select_max('divno');
		    $result = $this->db->get('acc_xdvsion');
			    if ($result->num_rows() > 0)
			    {
			        $res         = $result->result_array();
			        $reslt       = $res[0]['divno'];
					$maxdivno    = $reslt + 1; //column 1
					$div_token   = $maxdivno.uniqid();
			    }

			$data 	= array(
						'acc_xdvsion.divno'   => $maxdivno,
						'acc_xdvsion.divcode' => $divcode,
						'acc_xdvsion.divname' => $division,
						'acc_xdvsion.type'    => $user_region,
						'acc_xdvsion.office'  => $this->session->userdata('office'),
						'acc_xdvsion.cat'     => 'Division',
						'acc_xdvsion.token'   => $div_token,
	                );

			$insertdivision = $this->Embismodel->insertdata('embis.acc_xdvsion',$data);

			if($insertdivision){
				$swal_arr = array(
				 'title'     => 'SUCCESS!',
				 'text'      => 'Successfully added.',
				 'type'      => 'success',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}else{
				echo "<script>alert('Error! Please contact the webmaster.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function edit_plantilla(){

		$planpstn_desc   = $this->input->post('planpstn_desc');
		$planpstn_code   = $this->input->post('planpstn_code');
		$planpstn_id     = $this->input->post('planpstn_id');

		if(!empty($planpstn_desc) AND !empty($planpstn_code) AND !empty($planpstn_id)){

			$data    = array(
								'planpstn_code'   => $planpstn_code,
								'planpstn_desc'   => $planpstn_desc,
							);

			$where   = array('acc_plantillapostn.planpstn_id' => $planpstn_id);
			$update  = $this->Embismodel->updatedata($data,'acc_plantillapostn',$where);

			if($update){
				$swal_arr = array(
				 'title'     => 'SUCCESS!',
				 'text'      => 'Successfully edited.',
				 'type'      => 'success',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}else{
				echo "<script>alert('Error! Please contact the webmaster.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function add_plantilla(){

		$plantilla      = ucwords($this->input->post('plantilla_pos'));
		$plantillacode  = ucwords($this->input->post('plantilla_abbreviation'));
		// $user_region   = strtolower($this->session->userdata('region'));

		if(!empty($plantilla) AND !empty($plantillacode)){

			$this->db->select_max('planpstn_id ');
		    $result = $this->db->get('acc_plantillapostn');
			    if ($result->num_rows() > 0)
			    {
			        $res               = $result->result_array();
			        $reslt             = $res[0]['planpstn_id'];
							$maxplanpstn_id    = $reslt + 1; //column 1
			    }

			$data 	= array(
						'acc_plantillapostn.planpstn_id '   => $maxplanpstn_id,
						'acc_plantillapostn.planpstn_code'  => $plantillacode,
						'acc_plantillapostn.planpstn_desc'  => $plantilla,
	   );

			$insertplantillapostn = $this->Embismodel->insertdata('embis.acc_plantillapostn',$data);

			if($insertplantillapostn){
				$swal_arr = array(
				 'title'     => 'SUCCESS!',
				 'text'      => 'Successfully added.',
				 'type'      => 'success',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}else{
				echo "<script>alert('Error! Please contact the webmaster.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function add_rule(){
		$userid    = $this->session->userdata('userid');
		$region    = $this->session->userdata('region');

		$rule_name = $this->input->post('rule_name');
		$no_rows   = $this->encrypt->decode($this->input->post('no_rows'));

		$cnt = 0;
		foreach($_POST['order'] as $key => $value){

          $employee    = array_values(array_filter($this->input->post('employee')));
          $order       = array_values(array_filter($this->input->post('order')));

          $employeekey = $this->encrypt->decode($employee[$key]);
          $orderkey    = $this->encrypt->decode($order[$key]);

          if(!empty($employeekey) AND !empty($orderkey)){

          	$cnt++;

          	if($cnt <= $no_rows){
          		$data = array(
	              'addedby'       => $userid,
	              'region'        => $region,
	              'rule_name'     => $rule_name,
	              'rule_userid'   => $employeekey,
	              'rule_order'    => $orderkey,
	            );

	            $this->Embismodel->insertdata('acc_rule', $data);
          	}

          }

        }

        echo "<script>alert('Successfully assigned.')</script>";
		echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
	}

	function update_user_account(){
		$userid    = $this->encrypt->decode($this->input->post('token'));
		$region    = $this->session->userdata('region');

		$cnt = 0;
		foreach($_POST['employee'] as $key => $value){ $cnt++;

			if($cnt == 1){
				//DELETE TO_FUNC
				$this->db->where('userid', $userid);
	   		$this->db->delete('to_func');
			}

				$employee    = array_values(array_filter($this->input->post('employee')));
				$order       = array_values(array_filter($this->input->post('order')));

				// $employeekey = $employee[$key];
				// $orderkey    = $order[$key];
				$employeekey = $this->encrypt->decode($employee[$key]);
				$orderkey    = $this->encrypt->decode($order[$key]);

			if(!empty($employeekey) AND !empty($orderkey)){

	            $data = array(
	              'userid'       => $userid,
	              'assigned_to'  => $employeekey,
	              'route_order'  => $orderkey,
	            );

	            $this->Embismodel->insertdata('to_func', $data);

			}

        }

        echo "<script>alert('Account hierarchy successfully edited.')</script>";
		echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
	}

	function employee_actions(){
		$employee_token = $this->input->post('employee_token');
		$action 	      = $this->input->post('action');

	  $emp_replacement = !empty($this->encrypt->decode($_POST['employee_replacement'])) ? $this->encrypt->decode($_POST['employee_replacement']) : '';

		$whereemployee  = $this->db->where('acs.token',$employee_token);
		$queryemployee  = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.userid','',$whereemployee);
		$whereaction    = $this->db->where('ass.token',$action);
		$queryaction    = $this->Embismodel->selectdata('embis.acc_settings AS ass','ass.acc_id','',$whereaction);

		if(!empty($emp_replacement)){
			$datatofunc    = array(
				'assigned_to' 	=> $emp_replacement,
			);

			$wheretofunc   = array('to_func.assigned_to' => $queryemployee[0]['userid']);
			$updatetofunc  = $this->Embismodel->updatedata($datatofunc,'to_func',$wheretofunc);
		}

		if($queryaction[0]['acc_id'] == '1'){ //Remove area of assignment
			$comment 	   = $this->input->post('comment');
			$date_end 	   = date("Y-m-d");
			$data_fnctn    = array(
				'stat' 	   => '0',
				'dt_end'   => $date_end,
				'comment'  => $comment,
			);

			$wherefnctn    = array('acc_function.userid' => $queryemployee[0]['userid']);
			$updatefunctn  = $this->Embismodel->updatedata($data_fnctn,'acc_function',$wherefnctn);

			$data_fnctns   = array(
				'verified' 	   => '0',
			);

			$wherefnctns   = array('acc_credentials.userid' => $queryemployee[0]['userid']);
			$updatefunctns = $this->Embismodel->updatedata($data_fnctns,'acc_credentials',$wherefnctns);

			$data_action   = array(
				'reset' => '1',
			);

			$whereaction     = array('acc.userid' => $queryemployee[0]['userid']);
			$updatefunctnss  = $this->Embismodel->updatedata($data_action,'acc',$whereaction);

			//DELETE TO_FUNC
			$this->db->where('userid', $queryemployee[0]['userid']);
 			$this->db->delete('to_func');
		}

		if($queryaction[0]['acc_id'] == '2'){ //Deactivate User
			$comment 	   = $this->input->post('comment');
			$date_end 	   = date("Y-m-d");
			// $data_fnctn    = array(
			// 	'stat' 	   => '0',
			// 	'dt_end'   => $date_end,
			// 	'comment'  => 'Deactivated',
			// );
			//
			// $wherefnctn    = array('acc_function.userid' => $queryemployee[0]['userid']);
			// $updatefunctn  = $this->Embismodel->updatedata($data_fnctn,'acc_function',$wherefnctn);

			$data_fnctns   = array(
				'verified' 	   => '2',
			);

			$wherefnctns   = array('acc_credentials.userid' => $queryemployee[0]['userid']);
			$updatefunctns = $this->Embismodel->updatedata($data_fnctns,'acc_credentials',$wherefnctns);

			$data_action   = array(
				'acc_status' => '0',
			);

			$whereaction   = array('acc.userid' => $queryemployee[0]['userid']);
			$updatefunctn  = $this->Embismodel->updatedata($data_action,'acc',$whereaction);
		}

		if($queryaction[0]['acc_id'] == '3'){ //Activate User
			$data_action   = array(
				'acc_status' => '1',
			);

			$whereaction   = array('acc.userid' => $queryemployee[0]['userid']);
			$updatefunctn  = $this->Embismodel->updatedata($data_action,'acc',$whereaction);

			$data_action   = array(
				'acc_credentials.verified' => '1',
			);

			$whereaction   = array('acc_credentials.userid' => $queryemployee[0]['userid']);
			$updatefunctn  = $this->Embismodel->updatedata($data_action,'acc_credentials',$whereaction);
		}

		if($updatefunctn){
			echo "<script>alert('Action successfully granted.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}
	}

	function edit_account(){
		$userid   = $this->encrypt->decode($this->input->post('token'));
		$username = $this->input->post('username');
		$email    = $this->input->post('email');


		if(!empty($username) AND !empty($email)){

				$data_action   = array(
					'acc.username' => $username,
				);

			$whereaction   = array('acc.userid' => $userid);
			$updateacc     = $this->Embismodel->updatedata($data_action,'acc',$whereaction);

			$data_action_a   = array(
				'acc_credentials.email' => $email,
			);

			$whereactiona   = array('acc_credentials.userid' => $userid);
			$updateacca     = $this->Embismodel->updatedata($data_action_a,'acc_credentials',$whereactiona);

			echo "<script>alert('User account successfully updated.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";

		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}
	}

	function remove_line_of_authority(){
		$description   = $this->encrypt->decode($this->input->post('token'));

		if($description != ''){
			$this->db->where('rule_name', $description);
			$delete = $this->db->delete('acc_rule');
		}

		if($delete){
			echo "<script>alert('Successfully removed.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function edit_line_of_authority(){
		$description      = $this->encrypt->decode($this->input->post('token'));
		$description_name = $this->input->post('description');


		if($description != '' AND $description_name != ''){
			$data    = array(
									'rule_name' 	  => $description_name,
							 );

			$where    = array('acc_rule.rule_name' => $description);
			$update  = $this->Embismodel->updatedata($data,'acc_rule',$where);
		}

		if($update){
			$swal_arr = array(
			 'title'     => 'SUCCESS!',
			 'text'      => 'Successfully edited.',
			 'type'      => 'success',
		 );
		 $this->session->set_flashdata('swal_arr', $swal_arr);
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function edit_user_accounts_details_modal(){
		$userid        = $this->encrypt->decode($this->input->post('token'));
		$prefix_name    = $this->input->post('prefix_name');
		$first_name    = $this->input->post('first_name');
		$middle_name   = $this->input->post('middle_name');
		$last_name     = $this->input->post('last_name');
		$suffix_name   = $this->input->post('suffix_name');
		$designation   = $this->input->post('designation');
		$plantilla_pos = $this->input->post('plantilla_pos');
		$rank 		   = $this->input->post('rank');
		$email_address = $this->input->post('email_address');

		if($designation != '' AND $first_name != '' AND $last_name != '' AND $email_address != ''){

		$data    = array(
								'title' 	     		    => $prefix_name,
								'fname' 	     		    => $first_name,
								'mname' 	            => $middle_name,
								'sname' 	            => $last_name,
								'suffix' 	            => $suffix_name,
								'designation' 	      => $designation,
								'plantilla_pos' 	    => $plantilla_pos,
								'plantilla_itemno' 	  => $rank,
								'email' 	            => $email_address,

						 );


		$where    = array('acc_credentials.userid' => $userid);
		$update  = $this->Embismodel->updatedata($data,'acc_credentials',$where);

		}

		if($update){
			$swal_arr = array(
			 'title'     => 'SUCCESS!',
			 'text'      => 'Successfully edited.',
			 'type'      => 'success',
		 );
		 $this->session->set_flashdata('swal_arr', $swal_arr);
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}else{
			echo "<script>alert('Error! Please contact the webmaster.')</script>";
			echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
		}

	}

	function add_user_right(){
		$employee = $this->encrypt->decode($this->input->post('employee'));
		$where    = $this->db->where('acs.userid',$employee);
		$query    = $this->Embismodel->selectdata('embis.acc_credentials AS acs','acs.region','',$where);
		if($employee != ''){
			$data 	= array(
							'acc_rights.userid'     	   				  	=> $employee,
							'acc_rights.region'     	   					  => $query[0]['region'],
							'acc_rights.superadmin_rights' 					=> "no",
							'acc_rights.hr_rights'         			  	=> "no",
							'acc_rights.account_credentials_rights' => "no",
							'acc_rights.company_rights' 						=> "no",
							'acc_rights.to_rights' 									=> "no",
							'acc_rights.to_ticket_request' 					=> "no",
							'acc_rights.to_ticket_chief_accountant' => "no",
							'acc_rights.dms_all_view_attachment'    => "no",
							'acc_rights.to_assistant_or_laborers'   => "no",
							'acc_rights.to_view_all_approved'       => "no",
							'acc_rights.to_view_all_approved'       => "no",
							'acc_rights.client_rights'      			  => "no",
							'acc_rights.loginas'      			        => "no",
							'acc_rights.trans_qrcode'      			    => "no",
							'acc_rights.qrcode_docs'      			    => "no",
							'acc_rights.trans_regionalprc'					=> "no",
							'acc_rights.trans_multiprc'							=> "no",
							'acc_rights.client_log'					    		=> "no",
							'acc_rights.access_regions'					    => "no",
							'acc_rights.rec_officer'					    	=> "no",
							'acc_rights.trans_deletion'					   	=> "no",
							'acc_rights.view_pab_trans'					   	=> "no",
							'acc_rights.access_offices'					   	=> "no",
							'acc_rights.access_sweet_settings'			=> "no",
							'acc_rights.view_monitoring_report'			=> "no",
							'acc_rights.view_eia'										=> "no",
							'acc_rights.view_haz'										=> "no",
							'acc_rights.view_chem'									=> "no",
							'acc_rights.view_confidential_tab'			=> "no",
							'acc_rights.set_confidential_tag'				=> "no",
							'acc_rights.add_user_rights_with_role'	=> "no",
							'acc_rights.add_event'                	=> "no",
							'acc_rights.access_pbsbur'              => "no",
							'acc_rights.add_bulletin'               => "no",
							'acc_rights.support_admin'              => "no",
							'acc_rights.inbox_monitoring'          	=> "no",
							'acc_rights.universe_admin'            	=> "no",
		                );

			$insertfunction = $this->Embismodel->insertdata('embis.acc_rights',$data);

			if($insertfunction){
				$swal_arr = array(
				 'title'     => 'SUCCESS!',
				 'text'      => 'Successfully added.',
				 'type'      => 'success',
			 );
			 $this->session->set_flashdata('swal_arr', $swal_arr);
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}else{
				echo "<script>alert('Error! Please contact the webmaster.')</script>";
				echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}
		}
	}

	function transfer_user(){

		$dflt_where = $this->db->where('au.dsc = "'.$this->encrypt->decode($_POST['dflt_user_function']).'"');
		$dflt_usertype = $this->Embismodel->selectdata('acc_usertype AS au','au.ordr','',$dflt_where);

		$rplc_where = $this->db->where('au.dsc = "'.$this->encrypt->decode($_POST['rplc_user_function']).'"');
		$rplc_usertype = $this->Embismodel->selectdata('acc_usertype AS au','au.ordr','',$rplc_where);

		$dflt_section_where = $this->db->where('xt.secno = "'.$this->encrypt->decode($_POST['dflt_user_section']).'"');
		$dflt_section = $this->Embismodel->selectdata('acc_xsect AS xt','xt.sect','',$dflt_section_where);

		$rplc_section_where = $this->db->where('xt.secno = "'.$this->encrypt->decode($_POST['rplc_user_section']).'"');
		$rplc_section = $this->Embismodel->selectdata('acc_xsect AS xt','xt.sect','',$rplc_section_join,$rplc_section_where);

		$dflt_division_where = $this->db->where('ax.token = "'.$this->encrypt->decode($_POST['dflt_user_division']).'"');
		$dflt_division = $this->Embismodel->selectdata('acc_xdvsion AS ax','ax.divcode,ax.divno','',$dflt_division_where);

		$rplc_division_where = $this->db->where('ax.token = "'.$this->encrypt->decode($_POST['rplc_user_division']).'"');
		$rplc_division = $this->Embismodel->selectdata('acc_xdvsion AS ax','ax.divcode,ax.divno','',$rplc_division_join,$rplc_division_where);

		$where_dflt_user = $this->db->where('af.userid = "'.$this->encrypt->decode($_POST['dflt_user']).'" AND af.stat = "1"');
		$dflt_user = $this->Embismodel->selectdata('acc_function AS af','af.region','',$where_dflt_user);

		$where_rplc_user = $this->db->where('af.userid = "'.$this->encrypt->decode($_POST['rplc_user']).'" AND af.stat = "1"');
		$rplc_user = $this->Embismodel->selectdata('acc_function AS af','af.region','',$where_rplc_user);

		if(!empty($this->encrypt->decode($_POST['dflt_user']))){

			$data = array('acc_function.stat' => '0');
			$where         = array('acc_function.userid' => $this->encrypt->decode($_POST['dflt_user']));
			$update_dflt_acc_function    = $this->Embismodel->updatedata($data,'acc_function',$where);

			if($update_dflt_acc_function){

				$data = array(
					'userid'       => $this->encrypt->decode($_POST['dflt_user']),
					'dt_strt'      => date('Y-m-d'),
					'comment'      => '',
					'func'         => $this->encrypt->decode($_POST['dflt_user_function']),
					'func_order'   => $dflt_usertype[0]['ordr'],
					'secno'        => $this->encrypt->decode($_POST['dflt_user_section']),
					'divno'        => $dflt_division[0]['divno'],
					'div_nam'      => $dflt_division[0]['divcode'],
					'region'       => $dflt_user[0]['region'],
					'stat'         => '1',
				);
				$dflt_insert_function = $this->Embismodel->insertdata('acc_function', $data);

				$data = array(
											 'acc_credentials.division'    => $dflt_division[0]['divcode'],
											 'acc_credentials.divno'       => $dflt_division[0]['divno'],
											 'acc_credentials.section'     => $dflt_section[0]['sect'],
											 'acc_credentials.secno'       => $dflt_section[0]['secno'],
											 'acc_credentials.designation' => $_POST['dflt_designation'],
										 );
				$where         = array('acc_credentials.userid' => $this->encrypt->decode($_POST['dflt_user']));
				$update_dflt_acc_credentials = $this->Embismodel->updatedata($data,'acc_credentials',$where);

			}
		}

		if(!empty($this->encrypt->decode($_POST['rplc_user']))){
			$data = array('acc_function.stat' => '0');
			$where = array('acc_function.userid' => $this->encrypt->decode($_POST['rplc_user']));
			$update_rplc_acc_function = $this->Embismodel->updatedata($data,'acc_function',$where);

			if($update_rplc_acc_function){

				$data = array(
					'userid'       => $this->encrypt->decode($_POST['rplc_user']),
					'dt_strt'      => date('Y-m-d'),
					'comment'      => '',
					'func'         => $this->encrypt->decode($_POST['rplc_user_function']),
					'func_order'   => $rplc_usertype[0]['ordr'],
					'secno'        => $this->encrypt->decode($_POST['rplc_user_section']),
					'divno'        => $rplc_division[0]['divno'],
					'div_nam'      => $rplc_division[0]['divcode'],
					'region'       => $rplc_user[0]['region'],
					'stat'         => '1',
				);
				$rplc_insert_function = $this->Embismodel->insertdata('acc_function', $data);

				$data = array(
											 'acc_credentials.division'    => $rplc_division[0]['divcode'],
											 'acc_credentials.divno'       => $rplc_division[0]['divno'],
											 'acc_credentials.section'     => $rplc_section[0]['sect'],
											 'acc_credentials.secno'       => $rplc_section[0]['secno'],
											 'acc_credentials.designation' => $_POST['rplc_designation'],
										 );
				$where         = array('acc_credentials.userid' => $this->encrypt->decode($_POST['rplc_user']));
				$update_rplc_acc_credentials = $this->Embismodel->updatedata($data,'acc_credentials',$where);

			}

		}

		if(!empty($this->encrypt->decode($_POST['dflt_user'])) AND !empty($this->encrypt->decode($_POST['rplc_user']))){

			//SET AS UNIQUE FIRST TO_FUNC OF DEFAULT USER
			$data = array('to_func.cookie' => '1',); //SET
			$where = array('to_func.assigned_to' => $this->encrypt->decode($_POST['dflt_user']));
			$update_dflt_cookie = $this->Embismodel->updatedata($data,'to_func',$where);

			//UPDATE ASSIGNED TO_FUNC OF REPLACE USER TO DEFAULT USER
			$data = array('to_func.assigned_to' => $this->encrypt->decode($_POST['dflt_user'])); //SET
			$where = array('to_func.assigned_to' => $this->encrypt->decode($_POST['rplc_user']));
			$update_dflt_to_func = $this->Embismodel->updatedata($data,'to_func',$where);

			//UPDATE ASSIGNED TO_FUNC OF DEFAULT USER TO REPLACE USER WITH COOKIE = 1
			$data = array('to_func.assigned_to' => $this->encrypt->decode($_POST['rplc_user'])); //SET
			$where = array('to_func.assigned_to' => $this->encrypt->decode($_POST['dflt_user']), 'to_func.cookie' => '1');
			$update_rplc_to_func = $this->Embismodel->updatedata($data,'to_func',$where);

			//UPDATE COOKIE
			$data = array('to_func.cookie' => ''); //SET
			$where = array('to_func.assigned_to' => $this->encrypt->decode($_POST['rplc_user']), 'to_func.cookie' => '1');
			$update_cookie = $this->Embismodel->updatedata($data,'to_func',$where);

			$dflt_cnt = 0;
			foreach($_POST['dflt_order'] as $key => $value){
				$dflt_employee    = array_values(array_filter($this->input->post('dflt_employee')));
				$dflt_order  = array_values(array_filter($this->input->post('dflt_order')));
				$dflt_employeekey = $this->encrypt->decode($dflt_employee[$key]);
				$dflt_orderkey  = $this->encrypt->decode($dflt_order[$key]);
				if(!empty($dflt_employeekey) AND !empty($dflt_orderkey)){
					$dflt_cnt++;
					if($dflt_cnt == 1){
						//DELETE TO_FUNC
						$this->db->where('userid', $this->encrypt->decode($_POST['dflt_user']));
			   		$this->db->delete('to_func');
					}
					$whereifexist = $this->db->where('tf.userid = "'.$this->encrypt->decode($_POST['dflt_user']).'" AND tf.assigned_to = "'.$dflt_employeekey.'"');
					$checkifexist = $this->Embismodel->selectdata('to_func AS tf','tf.cnt','',$whereifexist);
					if(empty($checkifexist[0]['cnt'])){
						$data = array(
							'userid'       => $this->encrypt->decode($_POST['dflt_user']),
							'assigned_to'  => $dflt_employeekey,
							'route_order'  => $dflt_orderkey,
						);
						$this->Embismodel->insertdata('to_func', $data);
					}
				}
			}

			$rplc_cnt = 0;
			foreach($_POST['rplc_order'] as $key => $value){
				$rplc_employee    = array_values(array_filter($this->input->post('rplc_employee')));
				$rplc_order  = array_values(array_filter($this->input->post('rplc_order')));
				$rplc_employeekey = $this->encrypt->decode($rplc_employee[$key]);
				$rplc_orderkey  = $this->encrypt->decode($rplc_order[$key]);
				if(!empty($rplc_employeekey) AND !empty($rplc_orderkey)){
					$rplc_cnt++;
					if($rplc_cnt == 1){
						//DELETE TO_FUNC
						$this->db->where('userid', $this->encrypt->decode($_POST['rplc_user']));
			   		$this->db->delete('to_func');
					}
					$whereifexist = $this->db->where('tf.userid = "'.$this->encrypt->decode($_POST['rplc_user']).'" AND tf.assigned_to = "'.$rplc_employeekey.'"');
					$checkifexist = $this->Embismodel->selectdata('to_func AS tf','tf.cnt','',$whereifexist);
					if(empty($checkifexist[0]['cnt'])){
						$data = array(
							'userid'       => $this->encrypt->decode($_POST['rplc_user']),
							'assigned_to'  => $rplc_employeekey,
							'route_order'  => $rplc_orderkey,
						);
						$this->Embismodel->insertdata('to_func', $data);
					}
				}
			}

			if($update_cookie){
				$swal_arr = array(
					 'title'     => 'SUCCESS!',
					 'text'      => 'Both users successfully transfered.',
					 'type'      => 'success',
				 );
				 $this->session->set_flashdata('swal_arr', $swal_arr);
				 echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}

		}
	}

	function changehierarchybulk(){

		$countemployeeselected = count($_POST['employeeselected']);
		$countorder = count($_POST['order']);
		$cnt = 0;
		for ($i=0; $i < $countemployeeselected; $i++) {
			$empselect = $this->encrypt->decode($_POST['employeeselected'][$i]);
			$this->db->where('userid', $empselect);
			$this->db->delete('to_func');
			for ($o=0; $o < $countorder; $o++) {
				$order = $this->encrypt->decode($_POST['order'][$o]);
				$emph = $this->encrypt->decode($_POST['employee'][$o]);
				$data = array(
					'userid'       => $empselect,
					'assigned_to'  => $emph,
					'route_order'  => $order,
				);
				$this->Embismodel->insertdata('to_func', $data);
			}
			$cnt++;
			if($cnt == $countemployeeselected){
				$swal_arr = array(
					 'title'     => 'SUCCESS!',
					 'text'      => 'Hierarchy successfully updated.',
					 'type'      => 'success',
				 );
				 $this->session->set_flashdata('swal_arr', $swal_arr);
				 echo "<script>window.location.href='".base_url()."Admin/User_accounts/User_list'</script>";
			}
		}
	}
}
