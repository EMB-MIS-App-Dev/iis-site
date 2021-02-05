<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Form extends CI_Controller
{

	function __construct()
	{
	 	parent::__construct();
		$this->load->model('Embismodel');
		$this->load->library('session');
	}

  function new_trans(){

    date_default_timezone_set("Asia/Manila");
    $region          = $this->session->userdata('region');
    $sender_id       = $this->session->userdata('token');
    // echo $this->session->userdata('token'); exit;

    $region_where = array('ar.rgnnum' => $region );
    $region_data = $this->Embismodel->selectdata('acc_region AS ar', '', $region_where );

    $wheretransaction= $this->db->where('et.region', $region);
    $new_transaction = $this->Embismodel->selectdata('er_transactions AS et', 'MAX(et.trans_no) AS max_trans_no', '', $wheretransaction);

    // echo $this->db->last_query(); exit;

    $current_yr = date("Y");
    $trans_rgn = $region_data[0]['rgnid'] * 1000000;
    // add statements for same region selection for transaction number identifiers

    if(sizeof($new_transaction) != 0) {
      $max_id = $new_transaction[0]['max_trans_no'];

      $transaction_yr = intval($max_id / 100000000);

      if($transaction_yr == $current_yr) {
        $trans_no = $max_id + 1;
      }
      else {
        $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
      }
    }
    else {
      $trans_no = ($current_yr * 100000000) + $trans_rgn + 1;
    }

    $trans_token = $region.'-'.$current_yr.'-'.sprintf('%06d', ($trans_no - ((int)($trans_no / 1000000)*1000000)));


    $date_in = date('Y-m-d H:i:s');

    $acwhere = array('ac.token' => $sender_id );
    $credq = $this->Embismodel->selectdata('acc_credentials AS ac', '', $acwhere );

    $mname = ' ';
    if(!empty($credq[0]['mname']) )
      $mname = ' '.$credq[0]['mname'][0].'. ';

    $suffix = '';
    if(!empty($credq[0]['suffix']) )
      $suffix = ' '.$credq[0]['suffix'];

    $sender_name = ucwords($credq[0]['fname'].$mname.$credq[0]['sname']).$suffix;
    $trans_log_insert = array(
      'trans_no'        => $trans_no,
      'route_order'     => 0,
      'sender_id'       => $sender_id,
      'sender_name'     => $sender_name,
      'sender_ipadress' => '',
      'sender_region'   => $region,
      'date_in'         => $date_in,
    );
    $this->Embismodel->insertdata('er_transactions_log', $trans_log_insert);

    $start_date = date('Y-m-d');

    $trans_insert = array(
      'trans_no'    => $trans_no,
      'token'       => $trans_token,
      'route_order' => 0,
      'region'      => $region,
      'sender_id'   => $sender_id,
      'sender_name'     => $sender_name,
      'start_date'  => $start_date,
    );
    $this->Embismodel->insertdata('er_transactions', $trans_insert);

    $this->session->unset_userdata('log_trans_no');
    $this->session->unset_userdata('log_trans_no_token');
    $this->session->unset_userdata('cl_company_session');
		$this->session->unset_userdata('cl_rdobtnf_session');
		$this->session->unset_userdata('cl_rdobtns_session');
		$this->session->unset_userdata('cl_second_page');

    $this->session->set_userdata('log_trans_no', $trans_no);
    $this->session->set_userdata('log_trans_no_token', $trans_token);

    redirect(base_url()."Logs/Form");
  }

  function index(){
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $this->load->view('includes/common/footer');

    if(!empty($_SESSION['cl_company_session'])){
			if($this->encrypt->decode($this->session->userdata('cl_company_session')) == 'notinthelist'){
				$query['selectedcomp'] = 'Not in the list?';
				$query['selectedcomp_emb_id'] = $this->session->userdata('cl_company_session');
				$orderbycompanies   = $this->db->order_by('dc.company_name','ASC');
	      $query['companies'] = $this->Embismodel->selectdata('dms_company AS dc','dc.emb_id, dc.company_name','',$orderbycompanies);
			}else{
				$selected_emb_id = $this->encrypt->decode($this->session->userdata('cl_company_session'));
	      $wherecomp       = $this->db->where('dc.emb_id = "'.$selected_emb_id.'"');
	      $query = $this->Embismodel->selectdata('dms_company AS dc','dc.emb_id, dc.company_name','',$wherecomp);
	      $query['selectedcomp'] = $query[0]['company_name'];
	      $query['selectedcomp_emb_id'] = $this->encrypt->encode($query[0]['emb_id']);
	      $orderbycompanies   = $this->db->order_by('dc.company_name','ASC');
	      $wherecompanies     = $this->db->where('dc.emb_id != "'.$selected_emb_id.'"');
	      $query['companies'] = $this->Embismodel->selectdata('dms_company AS dc','dc.emb_id, dc.company_name','',$wherecompanies,$orderbycompanies);
			}
    }else{
      $query['selectedcomp'] = '';
      $query['selectedcomp_emb_id'] = '';
      $orderbycompanies   = $this->db->order_by('dc.company_name','ASC');
      $query['companies'] = $this->Embismodel->selectdata('dms_company AS dc','dc.emb_id, dc.company_name','',$orderbycompanies);
    }

    $this->load->view('logs/form',$query);
  }

  function logattachment(){
		if(!empty($_GET['token'])){
			$log_trans_token = $this->encrypt->decode($_GET['token']);
		}else{
			$log_trans_token = $this->session->userdata('log_trans_no_token');
		}
    $this->load->view('includes/common/header');
    $this->load->view('includes/common/sidebar');
    $this->load->view('includes/common/nav');
    $where = $this->db->where('cl.trans_token = "'.$log_trans_token.'"');
		$join = $this->db->join('client_logs_company AS clc','clc.trans_no = cl.trans_no','left');
    $query['selectlogs'] = $this->Embismodel->selectdata('client_logs AS cl','cl.*,clc.company_name,clc.company_address,clc.company_contact,clc.company_email','',$join,$where);
    $this->load->view('logs/attachmentform',$query);
    $this->load->view('includes/common/footer');
  }

  function validate(){
    if(isset($_POST['cl_save_button'])){
      $this->form_validation->set_error_delimiters(' <span class="set_error">', '</span>');
      $this->form_validation->set_rules('cl_trans_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_trans_token', '', 'required', array('required' => 'This field is required.'));

			$this->form_validation->set_rules('cl_timein', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_firstname', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_middlename');
      $this->form_validation->set_rules('cl_lastname', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_suffix');
      $this->form_validation->set_rules('cl_address', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_contact_no', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_email_address', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_company', '', 'required', array('required' => 'This field is required.'));
			$this->form_validation->set_rules('cl_position', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_purpose', '', 'required', array('required' => 'This field is required.'));
      $this->form_validation->set_rules('cl_other_info', '', 'required', array('required' => 'This field is required.'));

			isset($_POST['cl_cmpnm'])  ? $this->form_validation->set_rules('cl_cmpnm', '', 'required', array('required' => 'This field is required.')) : '';
			isset($_POST['cl_emladd'])  ? $this->form_validation->set_rules('cl_emladd', '', 'required', array('required' => 'This field is required.')) : '';
			isset($_POST['cl_cntctno'])  ? $this->form_validation->set_rules('cl_cntctno', '', 'required', array('required' => 'This field is required.')) : '';
			isset($_POST['cl_emladd'])  ? $this->form_validation->set_rules('cl_emladd', '', 'required', array('required' => 'This field is required.')) : '';

			!empty($_POST['cl_company'])  ? $this->session->set_userdata('cl_company_session', ($_POST['cl_company'])) : '';

			!empty($_POST['cl_rdobtnf'])  ? $this->session->set_userdata('cl_rdobtnf_session', ($_POST['cl_rdobtnf'])) : '';
			isset($_POST['cl_forgin'])  ? $this->form_validation->set_rules('cl_forgin', '', 'required', array('required' => 'This field is required.')) : '';
			isset($_POST['cl_fdttrvl'])  ? $this->form_validation->set_rules('cl_fdttrvl', '', 'required', array('required' => 'This field is required.')) : '';
			isset($_POST['cl_fdtarrvl'])  ? $this->form_validation->set_rules('cl_fdtarrvl', '', 'required', array('required' => 'This field is required.')) : '';

      !empty($_POST['cl_rdobtns'])  ? $this->session->set_userdata('cl_rdobtns_session', ($_POST['cl_rdobtns'])) : '';
			isset($_POST['cl_sorgin'])  ? $this->form_validation->set_rules('cl_sorgin', '', 'required', array('required' => 'This field is required.')) : '';


      if ($this->form_validation->run() == FALSE)
      {
          $this->index();
      }
      else
      {
         $data = $this->input->post();
         $this->save_data($data);
      }
    }
  }

  function save_data($data){

    date_default_timezone_set("Asia/Manila");
    $userid   = $this->session->userdata('userid');
    $region   = $this->session->userdata('region');

    $trans_no = $this->encrypt->decode($data['cl_trans_no']);

    $fname = strtolower(str_replace('ñ', '&ntilde;', $data['cl_firstname']));
    $mname = strtolower(str_replace('ñ', '&ntilde;', $data['cl_middlename']));
    $sname = strtolower(str_replace('ñ', '&ntilde;', $data['cl_lastname']));
    $mn  = !empty($data['cl_middlename']) ? $mname[0].". " : '';
    $sfx = !empty($data['cl_suffix']) ? " ".$data['cl_suffix'] : '';
    $full_name = ucwords($fname." ".$mn.$sname).$sfx;

		if($this->encrypt->decode($data['cl_company']) == 'notinthelist'){
			$emb_id = 'Not in the list of company';
			$company_name = $data['cl_cmpnm'];
		}else{
			$whereselectedcompany = $this->db->where('dc.emb_id = "'.$this->encrypt->decode($data['cl_company']).'"');
	    $selectedcompany      = $this->Embismodel->selectdata('dms_company AS dc','dc.emb_id, dc.company_name, dc.token','',$whereselectedcompany);
			$emb_id = $selectedcompany[0]['emb_id'];
			$company_name = trim($selectedcompany[0]['company_name']);
		}

		if($this->encrypt->decode($data['cl_company']) == 'notinthelist'){
			$datainsert = array(
	                    'trans_no'        => $trans_no,
	                    'company_name'    => $data['cl_cmpnm'],
	                    'company_address' => $data['cl_cmpaddress'],
	                    'company_contact' => $data['cl_cntctno'],
	                    'company_email'   => $data['cl_emladd'],
	                 );
	    $this->Embismodel->insertdata('client_logs_company', $datainsert);
		}

		$datainsert = array(
                    'trans_no'      => $trans_no,
                    'trans_token'   => $this->encrypt->decode($data['cl_trans_token']),
                    'cl_fname'         => ucwords($fname),
                    'cl_mname'         => ucwords($mname),
                    'cl_sname'         => ucwords($sname),
                    'cl_suffix'        => !empty($data['cl_suffix']) ? $data['cl_suffix'] : '',
                    'cl_full_name'     => $full_name,
                    'cl_address'       => $data['cl_address'],
                    'cl_contact_no'    => $data['cl_contact_no'],
                    'cl_email_address' => $data['cl_email_address'],
                    'cl_emb_id'        => $emb_id,
                    'cl_company_name'  => $company_name,
										'cl_comp_pos'      => $data['cl_position'],
                    'cl_purpose'       => $data['cl_purpose'],
										'cl_frdobtn'       => !empty($data['cl_rdobtnf']) ? $this->encrypt->decode($data['cl_rdobtnf']) : '',
										'cl_forigin'       => !empty($data['cl_forgin']) ? $data['cl_forgin'] : '',
										'cl_fdtoftravel'   => !empty($data['cl_fdttrvl']) ? $data['cl_fdttrvl'] : '',
										'cl_fdtofarrival'  => !empty($data['cl_fdtarrvl']) ? $data['cl_fdtarrvl'] : '',
										'cl_srdobtn'       => !empty($data['cl_rdobtns']) ? $this->encrypt->decode($data['cl_rdobtns']) : '',
										'cl_saddress'      => !empty($data['cl_sorgin']) ? $data['cl_sorgin'] : '',
                    'cl_other_info'    => $data['cl_other_info'],
                    'region'        => $this->session->userdata('region'),
                    'cl_datetimein'    => date("Y-m-d")." ".date("h:i:sa", strtotime($data['cl_timein'])),
                    'cl_datetimeout'   => '',
                 );
    $insert_data = $this->Embismodel->insertdata('client_logs', $datainsert);

    if($insert_data){

        $senderwhere = $this->db->where('ac.token = "'.$this->session->userdata('token').'" AND af.stat = "1"');
        $joinsender = $this->db->join('acc_function AS af','af.userid = ac.userid','left');
        $sender = $this->Embismodel->selectdata('acc_credentials AS ac', 'ac.fname,ac.mname,ac.sname,ac.suffix,af.divno,af.secno','',$joinsender,$senderwhere );

        $suffix = '';
        if(!empty($sender[0]['suffix']) )
          $suffix = ' '.$sender[0]['suffix'];

        $sender_name = ucwords($sender[0]['fname']." ".$sender[0]['sname']).$suffix;

        $date_out = date('Y-m-d H:i:s');
        $ip_address = $this->input->ip_address();

				$likeemb    = $this->db->like('company_name','Environmental Management Bureau');
				if($region == 'CO'){
					$whereemb   = $this->db->where('dc.emb_id','EMBNCR-1053620-0001');
				}else{
					$whereemb   = $this->db->where('dc.region_name',$region);
				}
				$queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb,$likeemb);

        $er_trans_data = array(
                                'route_order'      => '1',
                                'company_token'    => $selectedcompany[0]['token'],
                                'company_name'     => $queryemb[0]['company_name'],
                                'emb_id'           => $queryemb[0]['emb_id'],
                                'subject'          => "Visitor Log: ".$full_name,
                                'system'           => '9',
                                'type'             => '116',
                                'type_description' => 'VISITOR RECORD',
                                'status'           => '1',
                                'status_description' => 'open',
                                'sender_id'        => $this->session->userdata('token'),
                                'sender_name'      => $sender_name,
                                'action_taken'     => 'For information/guidance/reference.',
                                'remarks'          => '-',
                                'end_date'         => $date_out,
                              );
        $er_trans_where = array('trans_no' => $trans_no);
        $update_er_trans = $this->Embismodel->updatedata($er_trans_data,'er_transactions',$er_trans_where);

        $er_trans_log_data = array(
                                'route_order'      => '1',
                                'subject'          => "Visitor Log: ".$full_name,
                                'sender_divno'     => $sender[0]['divno'],
                                'sender_secno'     => $sender[0]['secno'],
                                'sender_id'        => $this->session->userdata('token'),
                                'sender_name'      => $sender_name,
                                'sender_region'    => $this->session->userdata('region'),
                                'sender_ipadress'  => $ip_address,
                                'type'             => '116',
                                'status'           => '1',
                                'status_description' => 'open',
                                'action_taken'     => 'For information/guidance/reference.',
                                'remarks'          => '-',
                                'date_out'         => $date_out,
                              );
        $er_trans_log_where = array('trans_no' => $trans_no);
        $update_er_trans_log = $this->Embismodel->updatedata($er_trans_log_data,'er_transactions_log',$er_trans_log_where);
        if($update_er_trans_log){
					$this->session->set_userdata('cl_second_page', 'cl_second_page');
          redirect(base_url().'Logs/Form/logattachment');
        }else{
          echo "<script>alert('Error.')</script>";
        }
    }else{
      echo "<script>alert('Error.')</script>";
    }
  }

  function save_attachment(){
    if(isset($_POST['cl_save_attachment_button'])){
      // print_r($_FILES); exit;
      $where = $this->db->where('cl.trans_token = "'.$this->encrypt->decode($_POST['cl_trans_token']).'"');
      $logs = $this->Embismodel->selectdata('client_logs AS cl','','',$where);
      // echo $this->db->last_query(); exit;
      $path = 'dms/'.date('Y').'/'.$logs[0]['region'].'/';
      $folder = $logs[0]['trans_no'];

      if(!is_dir('uploads/'.$path.'/'.$folder)) {
        mkdir('uploads/'.$path.'/'.$folder, 0777, TRUE);
      }

      if(!empty($_FILES['cl_picture']['name'])) {
        $att_token1 = fmod($logs[0]['trans_no'], 1000000);

        $ea_w = array(
          'ea.trans_no'     => $logs[0]['trans_no'],
          'ea.route_order'  => '1',
        );
        $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

        $att_token = $region.date('Y').'-FT'.'1'.'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);
        // Set preference
        $config = array(
          'upload_path'   => 'uploads/'.$path.'/'.$folder, // .'/'.$m_addpath
          'allowed_types' => '*',
          'max_size'      => '20480', // max_size in kb
          'file_name'     => $att_token,
          'overwrite'     => FALSE,
        );
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if(!$this->upload->do_upload('cl_picture')) {
          // Show error on uploading
          $uploadError = array('error' => $this->upload->display_errors());
        }
        else {
          // Get data about the file
          $uploadData = $this->upload->data();

          $erattach_insert = array(
            'trans_no'      => $logs[0]['trans_no'],
            'route_order'   => '1',
            'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
            'token'         => $att_token,
            'file_name'     => $_FILES['cl_picture']['name'],
          );
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);
        }
      }

      if(!empty($_FILES['cl_valid_id']['name'])) {
        $att_token1 = fmod($logs[0]['trans_no'], 1000000);

        $ea_w = array(
          'ea.trans_no'     => $logs[0]['trans_no'],
          'ea.route_order'  => '1',
        );
        $ea_q = $this->Embismodel->selectdata('er_attachments AS ea', 'MAX(ea.file_id) AS max_fileid', $ea_w);

        $att_token = $region.date('Y').'-FT'.'1'.'N'.$att_token1.'-File_'.($ea_q[0]['max_fileid']+1);
        // Set preference
        $config = array(
          'upload_path'   => 'uploads/'.$path.'/'.$folder, // .'/'.$m_addpath
          'allowed_types' => '*',
          'max_size'      => '20480', // max_size in kb
          'file_name'     => $att_token,
          'overwrite'     => TRUE,
        );
        //Load upload library
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if(!$this->upload->do_upload('cl_valid_id')) {
          // Show error on uploading
          $uploadError = array('error' => $this->upload->display_errors());
        }
        else {
          // Get data about the file
          $uploadData = $this->upload->data();

          $erattach_insert = array(
            'trans_no'      => $logs[0]['trans_no'],
            'route_order'   => '1',
            'file_id'       => $ea_q[0]['max_fileid']+1, // order_by
            'token'         => $att_token,
            'file_name'     => $_FILES['cl_valid_id']['name'],
          );
          $this->Embismodel->insertdata('er_attachments', $erattach_insert);
          $swal_arr = array(
             'title'     => 'SUCCESS!',
             'text'      => 'New log successfully inserted.',
             'type'      => 'success',
           );
           $this->session->set_flashdata('swal_arr', $swal_arr);
          redirect(base_url()."Logs");
        }
      }
    }
  }

  function vwattchmnt(){
    $token = ($this->input->post('token',TRUE));
		$wheretoken = array('et.trans_no' => $token, );
		$selecttoken = $this->Embismodel->selectdata('er_transactions AS et','et.token',$wheretoken);
		$trans_token = $this->encrypt->encode($selecttoken[0]['token']);

    $orderdata  = $this->db->order_by('ea.file_id','asc');
    $wheredata  = $this->db->where('ea.trans_no = "'.$token.'" AND et.route_order = ea.route_order');
    $joindata   = $this->db->join('er_transactions_log AS et','et.trans_no = ea.trans_no','left');
    $selectdata = $this->Embismodel->selectdata('er_attachments AS ea','ea.*,et.date_in,et.date_out,et.sender_region,et.sender_name','',$wheredata,$orderdata);
		if(!empty($selectdata[0]['trans_no'])){
			for ($i=0; $i < sizeof($selectdata); $i++) {
	      if($i==0){
	        $attch_title = "Client Picture";
	      }else{
	        $attch_title = "Gov. ID Presented";
	      }
				$path_file = base_url()."uploads/dms/".date("Y", strtotime($selectdata[$i]['date_in']))."/".$selectdata[$i]['sender_region']."/".$token."/".$selectdata[$i]['token'].'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION);
					echo '<li style="padding: 5px 15px 5px 15px;width: 250px;"><a title="Date attached: '.date("M d, Y", strtotime($selectdata[$i]['date_out'])).'" target="_blank" href="'.$path_file.'">'.substr($selectdata[$i]['token'],0,6).'.'.pathinfo($selectdata[$i]['file_name'], PATHINFO_EXTENSION).'</a> <span style="font-style: italic;color:#000;"> - ('.$attch_title.')</span></li>';
			 }
		}else{
			echo '<li style="padding: 5px 15px 5px 15px;width: 250px;"><a class="btn btn-info btn-sm" style="width:100%;" href="'.base_url('Logs/Form/logattachment?token=').$trans_token.'">Add Picture</a></li>';
		}
		 ?>
  <?php
  }

  function timeoutlog(){
    $token = $this->encrypt->decode($this->input->post('token',TRUE));
		$where = array('cl.trans_no' => $token);
		$selectdata = $this->Embismodel->selectdata('client_logs AS cl','cl.cl_fname,cl.cl_mname,cl.cl_sname,cl.cl_suffix',$where);
		$mname = !empty($selectdata[0]['cl_mname']) ? $selectdata[0]['cl_mname'][0].". ": '';
		$suffix = !empty($selectdata[0]['cl_suffix']) ? " ".$selectdata[0]['cl_suffix']: '';
		$name = ucwords($selectdata[0]['cl_fname']." ".$mname.$selectdata[0]['cl_sname']).$suffix;
		?>
			<div class="row">
				<div class="col-md-12">
					<label>Please input <b><?php echo $name."'s"; ?></b> time out:</label>
					<input type="time" class="form-control" name="cl_timeout" required>
					<input type="hidden" class="form-control" name="cl_token" value="<?php echo $this->input->post('token',TRUE); ?>" required>
				</div>
			</div>
    <?php
  }

	function timeoutinfo(){
		$cl_token = $this->encrypt->decode($this->input->post('cl_token',TRUE));
		$cl_timeout = ($this->input->post('cl_timeout',TRUE));
		$datetimeout = date("Y-m-d")." ".date("h:i:sa", strtotime($cl_timeout));
		if(!empty($cl_token)){
      $data = array('cl_datetimeout' => $datetimeout);
      $where = array('trans_no' => $cl_token);
      $updatedata = $this->Embismodel->updatedata($data,'client_logs',$where);
			if($updatedata){
				$swal_arr = array(
					 'title'     => 'SUCCESS!',
					 'text'      => 'Time out successfully updated.',
					 'type'      => 'success',
				 );
				 $this->session->set_flashdata('swal_arr', $swal_arr);
				redirect(base_url()."Logs");
			}
    }
	}

	function chkcmpcll(){
		$token = $this->encrypt->decode($this->input->post('token',TRUE));
		if($token == 'notinthelist'){?>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<label>Please enter company name:</label><?php echo form_error('cl_cmpnm'); ?>
					<input type="text" name="cl_cmpnm" class="form-control">
				</div>
				<div class="col-md-12" style="margin-top:5px;">
					<label>Company address:</label><?php echo form_error('cl_cmpaddress'); ?>
					<input type="text" name="cl_cmpaddress" class="form-control">
				</div>
				<div class="col-md-6" style="margin-top:5px;">
					<label>Company contact no.:</label><?php echo form_error('cl_cntctno'); ?>
					<input type="text" name="cl_cntctno" class="form-control">
				</div>
				<div class="col-md-6" style="margin-top:5px;">
					<label>Company email address:</label><?php echo form_error('cl_emladd'); ?>
					<input type="text" name="cl_emladd" class="form-control">
				</div>
			</div><hr>
	<?php }
	}

	function cl_frdobtn(){
		$token = $this->encrypt->decode($this->input->post('token',TRUE));
		if($token == 'Yes'){ ?>
			<div class="row">
				<div class="col-md-4">
					<label>Origin:</label><?php echo form_error('cl_forgin'); ?>
					<input type="text" class="form-control" name="cl_forgin">
				</div>
				<div class="col-md-4">
					<label>Date of travel:</label><?php echo form_error('cl_fdttrvl'); ?>
					<input type="date" class="form-control" name="cl_fdttrvl">
				</div>
				<div class="col-md-4">
					<label>Date of arrival:</label><?php echo form_error('cl_fdtarrvl'); ?>
					<input type="date" class="form-control" name="cl_fdtarrvl">
				</div>
			</div>
		<?php }
	}

	function cl_srdobtn(){
		$token = $this->encrypt->decode($this->input->post('token',TRUE));
		if($token == 'Yes'){ ?>
			<div class="row">
				<div class="col-md-12">
					<label>Exact address of origin:</label><?php echo form_error('cl_sorgin'); ?>
					<input type="text" class="form-control" name="cl_sorgin">
				</div>
			</div>
		<?php }
	}
}
