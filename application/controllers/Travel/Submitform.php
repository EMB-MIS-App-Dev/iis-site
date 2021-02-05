<?php

class Submitform extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Embismodel');
    $this->load->model('Travelordermodel');
    $this->load->library('session');
    $this->load->helper('url');
    date_default_timezone_set("Asia/Manila");
  }

  function travel_acknowledgement(){

     $process_trans_no_travel = $this->session->userdata('process_trans_no_travel');
     $region                  = $this->session->userdata('region');
     $ip_address = $this->input->ip_address();
     //ACKNOWLEDGMENT

        $where         = $this->db->where('tt.er_no',$process_trans_no_travel);
        $qryaccounts   = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);
        $qryaccountsmx = $this->db->query("SELECT MAX(trans_order) AS mto FROM to_trans_log WHERE er_no = '$process_trans_no_travel'")->result_array();

        //FUNCTION
          $wherehead   = $this->db->where('af.userid',$qryaccounts[0]['userid']);
          $wherehead   = $this->db->where('af.stat','1');
          $join        = $this->db->join('acc_credentials AS acs','acs.userid = af.userid','left');
          $qryhead     = $this->Embismodel->selectdata('acc_function AS af','af.func,acs.fname,acs.sname','',$wherehead,$join);
        //FUNCTION

            //TRANSACTIONS
            //Receiver
            $wherereceiver = $this->db->where('acs.userid',$qryaccounts[0]['userid']);
            $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
            $join          = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
            $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.title,acs.fname,acs.sname,acs.suffix,acs.region,xn.divname,xt.sect,xt.secno,xn.divno','',$wherereceiver,$join);
            $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
            $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
            $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
            $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
            $receiverdivno = (!empty($receiver[0]['divno'])) ? $receiver[0]['divno'] : '';
            $receiversecno= (!empty($receiver[0]['secno'])) ? $receiver[0]['secno'] : '';
            //Receiver

            //Sender
            $wheresender   = $this->db->where('acs.userid',$this->session->userdata('userid'));
            $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.fname,acs.sname','',$wheresender);
            //Sender

            //Trans logs
            $transx    = $this->db->query("SELECT MAX(route_order) AS mro FROM er_transactions_log WHERE trans_no = '$process_trans_no_travel'")->result_array();
            $wherelog  = $this->db->where('et.trans_no',$process_trans_no_travel);
            $wherelog  = $this->db->where('et.route_order','1');
            $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

            $status             = "24";
            $status_description = "for filing / closed";
            $action_taken       = "Acknowledged";
            //Trans logs

          $date_out  = date('Y-m-d H:i:s');

          $trans_set = array(
            'subject'               => $translog[0]['subject'],
            'sender_region'         => $translog[0]['sender_region'],
            'sender_ipadress'       => $ip_address,
            'receiver_divno'        => $receiverdivno,
            'receiver_secno'        => $receiversecno,
            'receiver_id'           => $receiver[0]['token'],
            'receiver_name'         => $receiver_name,
            'receiver_region'       => $receiver[0]['region'],
            'type'                  => $translog[0]['type'],
            'status'                => $status,
            'status_description'    => $status_description,
            'action_taken'          => $action_taken,
            'date_in'               => $date_out,
            'date_out'              => $date_out,
          );

          $trans_update_where = array(
            'etl.trans_no'          => $process_trans_no_travel,
            'etl.route_order'       => $transx[0]['mro'],
          );

          $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
           // echo $this->db->last_query(); exit;

          $set = array(
            'et.route_order'        => $transx[0]['mro'],
            'status'                => $status,
            'status_description'    => $status_description,
            'et.receive'            => 0,
            'et.sender_id'          => $qrysender[0]['token'],
            'et.sender_name'        => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
            'et.receiver_division'  => $receiver[0]['divname'],
            'et.receiver_section'   => $receiver[0]['sect'],
            'receiver_region'       => $receiver[0]['region'],
            'et.receiver_id'        => $receiver[0]['token'],
            'et.receiver_name'      => $receiver_name,
            'et.action_taken'       => $action_taken,
          );

          $where = array( 'et.trans_no' => $process_trans_no_travel);
          $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
        //TRANSACTIONS

        if($result){
          $swal_arr = array(
           'title'     => 'SUCCESS!',
           'text'      => 'Travel disapproval successfully acknowledged.',
           'type'      => 'success',
         );
         $this->session->set_flashdata('swal_arr', $swal_arr);
        echo "<script>window.location.href='".base_url()."Travel/Dashboard'</script>";
        }
  }

  function submit_travel(){
      error_reporting(0);

      date_default_timezone_set("Asia/Manila");
      $ip_address = $this->input->ip_address();
      $sender   = $this->session->userdata('token');
      $userid   = $this->session->userdata('userid');
      $region   = $this->session->userdata('region');
      $trans_no = $this->session->userdata('travel_trans_no');
      $trans_token = $this->session->userdata('travel_trans_no_token');
      $data     = $this->input->post();

        if(!empty($data['travel_cat']) AND !empty($data['travel_type']) AND !empty($data['departure_date']) AND
        !empty($data['arrival_date']) AND !empty($data['off_station']) AND !empty($data['purpose']) AND !empty($data['remarks']) AND !empty($data['report_submit'])){

            $user_name         = $this->Travelordermodel->name_of_user();         //Name of User

            $user_credentials  = $this->Travelordermodel->user_credentials();     //User Credentials

            $tonumber          = $this->Travelordermodel->travelnumber();         //Travel Number

            $maxtocnt          = $this->Travelordermodel->maxtocnt();             //Max to Count

            $route_to          = $this->Travelordermodel->route_order_function(); //Route to

            $to_trans          = $this->Travelordermodel->to_trans_assigned_to(); //Assigned to

            $max_assignedto    = $this->Travelordermodel->route_order_max(); //Assigned to

            $whereheader  = $this->db->where('oudh.region = "'.$this->session->userdata('region').'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$this->session->userdata('region').'" AND oudhh.office = "'.$this->session->userdata('office').'")');
            $selectheader = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','oudh.file_name','',$whereheader);

            if($data['travel_cat'] == "Yes"){ //Regional
              // if($user_credentials[0]['func'] == 'Regional Director' || $user_credentials[0]['func'] == 'Director'){
              if($user_credentials[0]['func'] == 'Director'){
                $assignedto = $userid;
                $status     = "Signed Document";
                $er_status  = "5";
                $er_statusd = "Signed Document";
                $er_action  = "Signed Document";
              }else{
                $assignedto = $route_to;
                $status     = "On-Process";
                $er_status  = "15";
                $er_statusd = "For Approval";
                $er_action  = "Pls. for approval";
              }
            }else{                            //National
              if($user_credentials[0]['func'] == 'Director'){
                $assignedto = $userid;
                $status     = "Signed Document";
                $er_status  = "5";
                $er_statusd = "Signed Document";
                $er_action  = "Signed Document";
              }else{
                $assignedto = $route_to;
                $status     = "On-Process";
                $er_status  = "15";
                $er_statusd = "For Approval";
                $er_action  = "Pls. for approval";
              }
            }

            if(!empty($user_credentials[0]['secno'])){
              $secno = $user_credentials[0]['secno'];
              $sect  = $user_credentials[0]['sect'];
            }else{
              $secno = "";
              $sect  = "";
            }

            $to_trans_token = $userid.mt_rand(10000000, 99999999);

            $assistant = '';
            $assistantcounter = 0;
            for ($i=0; $i < count($_POST['assistant']); $i++) {
              if(!empty($_POST['assistant'][$i])){
                $assistantcounter++;
                $conassistant = ($assistantcounter == 1) ? '' : (($assistantcounter == count($_POST['assistant'])) ? ', and ' : ', ');
                $assistant .= $conassistant.$_POST['assistant'][$i];
              }
            }

            $travel_format = (!empty($_POST['travel_format'])) ? $this->encrypt->decode($_POST['travel_format']) : '';

            $trans_insert        = array(
              'er_no'             => $trans_no,
              'toheader'          => $selectheader[0]['file_name'],
              'tocnt'             => $maxtocnt,
              'toid'              => "EMB".$trans_token,
              'userid'            => $userid,
              'name'              => $user_name,
              'region'            => $region,
              'division'          => $user_credentials[0]['divname'],
              'divno'             => $user_credentials[0]['divno'],
              'section'           => $sect,
              'secno'             => $secno,
              'designation'       => $user_credentials[0]['designation'],
              'plantilla_pos'     => $user_credentials[0]['plantilla_pos'],
              'plantilla_itemno'  => $user_credentials[0]['plantilla_itemno'],
              'travel_cat'        => $data['travel_cat'],
              'travel_type'       => $data['travel_type'],
              'departure_date'    => $data['departure_date'],
              'arrival_date'      => $data['arrival_date'],
              'official_station'  => $data['off_station'],
              'destination'       => "",
              'travel_purpose'    => $data['purpose'],
              'per_diem'          => $data['per_diem'],
              'assistant'         => $assistant,
              'remarks'           => $data['remarks'],
              'report_submission' => $data['report_submit'],
              'status'            => $status,
              'assignedto'        => $max_assignedto[0]['assigned_to'],
              'route_order'       => $max_assignedto[0]['route_order'],
              'token'             => $to_trans_token,
              'travel_format'     => $travel_format,
            ); $this->Embismodel->insertdata('to_trans', $trans_insert);
            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => "EMB".$trans_token,
              'userid'            => $userid,
              'region'            => $region,
              'status'            => $status,
              'assignedto'        => $assignedto,
              'trans_order'       => 1,
            ); $this->Embismodel->insertdata('to_trans_log', $trans_insert_log);

        //TRAVEL ORDER

          $where    = $this->db->where('acs.userid',$assignedto);
          $join     = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
          $join     = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
          $receiver = $this->Embismodel->selectdata('acc_credentials AS acs','xn.divname,xn.divno,xt.sect,xt.secno,acs.region,acs.userid,acs.title,acs.fname,acs.sname,acs.suffix,acs.token','',$where);

          $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
          $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
          $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
          $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;

          if($user_credentials[0]['func'] == 'Director' AND ($data['travel_cat'] == "Yes" OR $data['travel_cat'] == "No")){

            //TRANSACTION DIRECTOR
                $date_out = date('Y-m-d H:i:s');
                $et_where = array('et.trans_no' => $trans_no);
                $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );

                $trans_set = array(
                  'route_order'         => "1",
                  'subject'             => "TRAVEL ORDER - ".$user_name,
                  'sender_divno'        => $user_credentials[0]['divno'],
                  'sender_secno'        => $secno,
                  'sender_id'           => $sender,
                  'sender_ipadress'     => $ip_address,
                  'receiver_divno'      => $receiver[0]['divno'],
                  'receiver_secno'      => $receiver[0]['secno'],
                  'receiver_id'         => $receiver[0]['token'],
                  'receiver_name'       => $receiver_name,
                  'receiver_region'     => $receiver[0]['region'],
                  'type'                => "83",
                  'status'              => "24",
                  'status_description'  => "for filing / closed",
                  'action_taken'        => $er_action,
                  'date_in'             => $date_out,
                  'date_out'            => $date_out,
                );

                $trans_update_where = array(
                  'etl.trans_no'    => $trans_no,
                );

                $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

                $whereemb   = $this->db->where('tcd.region',$this->session->userdata('region'));
                $queryemb   = $this->Embismodel->selectdata('to_company_designation AS tcd','tcd.*','',$whereemb);

                $set = array(
                  'et.route_order'        => "1",
                  'et.company_token'      => $queryemb[0]['token'],
                  'et.company_name'       => $queryemb[0]['company_name'],
                  'et.emb_id'             => $queryemb[0]['emb_id'],
                  'et.subject'            => "TRAVEL ORDER - ".$user_name,
                  'et.system'             => "9",
                  'et.type'               => "83",
                  'et.type_description'   => "TRAVEL ORDER",
                  'et.status'             => "24",
                  'et.status_description' => "for filing / closed",
                  'et.receive'            => 0,
                  'et.sender_id'          => $sender,
                  'et.sender_name'        => $user_name,
                  'et.receiver_division'  => $receiver[0]['divname'],
                  'et.receiver_section'   => $receiver[0]['sect'],
                  'receiver_region'       => $receiver[0]['region'],
                  'et.receiver_id'        => $receiver[0]['token'],
                  'et.receiver_name'      => $receiver_name,
                  'et.action_taken'       => $er_action,
                  'et.remarks'            => "None",
                );

                $where = array( 'et.trans_no' => $trans_no);
                $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

                $destination = "";
                $countdestination = count($_POST['destination']);
                $count = 0;
                for ($ds=0; $ds < count($_POST['destination']); $ds++) {
                  $count++;
                  if(!empty($_POST['destination'][$ds])){
                    $location = array(
                      'er_no'        => $trans_no,
                      'location'     => $_POST['destination'][$ds],
                      'latitude'     => $_POST['latitude'][$ds],
                      'longitude'    => $_POST['longitude'][$ds],
                      'loc_order'    => $count,
                    );
                    $this->Embismodel->insertdata('to_destination', $location);

                    if($countdestination == $count){ $con  = ""; }else{ $con = ", "; }
                    $destination .= $_POST['destination'][$ds].$con;
                  }
                }

                $set_to_trans       = array(
                  'tt.destination'  => $destination,
                );
                $where_to_trans     = array( 'tt.er_no' => $trans_no);
                $resul_to_transt    = $this->Embismodel->updatedata( $set_to_trans, 'to_trans AS tt', $where_to_trans );


                if($result){
                  $swal_arr = array(
                   'title'     => 'SUCCESS!',
                   'text'      => 'Travel request successfully submitted.',
                   'type'      => 'success',
                 );
                 $this->session->set_flashdata('swal_arr', $swal_arr);
                  echo "<script>window.location.href='".base_url()."Travel/Dashboard'</script>";
                }

          }
          // else if($user_credentials[0]['func'] == 'Regional Director' AND ($data['travel_cat'] == "Yes")){
          //
          //   //TRANSACTION REGIONAL DIRECTOR
          //       $date_out = date('Y-m-d H:i:s');
          //       $et_where = array('et.trans_no' => $trans_no);
          //       $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );
          //
          //       $trans_set = array(
          //         'subject'             => "TRAVEL ORDER - ".$user_name,
          //         'sender_divno'        => $user_credentials[0]['divno'],
          //         'sender_secno'        => $secno,
          //         'sender_id'           => $sender,
          //         'sender_ipadress'     => $ip_address,
          //         'receiver_divno'      => $receiver[0]['divno'],
          //         'receiver_secno'      => $receiver[0]['secno'],
          //         'receiver_id'         => $receiver[0]['token'],
          //         'receiver_name'       => $receiver_name,
          //         'receiver_region'     => $receiver[0]['region'],
          //         'type'                => "83",
          //         'status'              => "24",
          //         'status_description'  => "for filing / closed",
          //         'action_taken'        => $er_action,
          //         'date_in'             => $date_out,
          //         'date_out'            => $date_out,
          //       );
          //
          //       $trans_update_where = array(
          //         'etl.trans_no'    => $trans_no,
          //         'etl.route_order' => $er_trans_query[0]['route_order'],
          //       );
          //
          //       $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
          //
          //       $likeemb    = $this->db->like('company_name','Environmental Management Bureau');
          //       if($region == 'CO'){
          //         $whereemb   = $this->db->where('dc.emb_id','EMBNCR-1053620-0001');
          //       }else{
          //         $whereemb   = $this->db->where('dc.region_name',$region);
          //       }
          //       $queryemb   = $this->Embismodel->selectdata('dms_company AS dc','dc.token,dc.company_name,dc.emb_id','',$whereemb,$likeemb);
          //
          //       $set = array(
          //         'et.route_order'        => $er_trans_query[0]['route_order'],
          //         'et.company_token'      => $queryemb[0]['token'],
          //         'et.company_name'       => $queryemb[0]['company_name'],
          //         'et.emb_id'             => $queryemb[0]['emb_id'],
          //         'et.subject'            => "TRAVEL ORDER - ".$user_name,
          //         'et.system'             => "9",
          //         'et.type'               => "83",
          //         'et.type_description'   => "TRAVEL ORDER",
          //         'et.status'             => "24",
          //         'et.status_description' => "for filing / closed",
          //         'et.receive'            => 0,
          //         'et.sender_id'          => $sender,
          //         'et.sender_name'        => $user_name,
          //         'et.receiver_division'  => $receiver[0]['divname'],
          //         'et.receiver_section'   => $receiver[0]['sect'],
          //         'receiver_region'       => $receiver[0]['region'],
          //         'et.receiver_id'        => $receiver[0]['token'],
          //         'et.receiver_name'      => $receiver_name,
          //         'et.action_taken'       => $er_action,
          //         'et.remarks'            => "None",
          //       );
          //
          //       $where = array( 'et.trans_no' => $trans_no);
          //       $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
          //
          //       $destination = "";
          //       $countdestination = count($_POST['destination']);
          //       $count = 0;
          //       for ($ds=0; $ds < count($_POST['destination']); $ds++) {
          //         $count++;
          //         if(!empty($_POST['destination'][$ds])){
          //           $location = array(
          //             'er_no'        => $trans_no,
          //             'location'     => $_POST['destination'][$ds],
          //             'latitude'     => $_POST['latitude'][$ds],
          //             'longitude'    => $_POST['longitude'][$ds],
          //             'loc_order'    => $count,
          //           );
          //           $this->Embismodel->insertdata('to_destination', $location);
          //
          //           if($countdestination == $count){ $con  = ""; }else{ $con = ", "; }
          //           $destination .= $_POST['destination'][$ds].$con;
          //         }
          //       }
          //
          //       $set_to_trans       = array(
          //         'tt.destination'  => $destination,
          //       );
          //       $where_to_trans     = array( 'tt.er_no' => $trans_no);
          //       $resul_to_transt    = $this->Embismodel->updatedata( $set_to_trans, 'to_trans AS tt', $where_to_trans );
          //
          //
          //       if($result){
          //         $swal_arr = array(
          //          'title'     => 'SUCCESS!',
          //          'text'      => 'Travel request successfully submitted.',
          //          'type'      => 'success',
          //        );
          //        $this->session->set_flashdata('swal_arr', $swal_arr);
          //        echo "<script>window.location.href='".base_url()."Travel/Dashboard'</script>";
          //       }
          //
          // }
          else{

            //TRANSACTION NORMAL USERS
              $date_out = date('Y-m-d H:i:s');
              $et_where = array('et.trans_no' => $trans_no);
              $er_trans_query = $this->Embismodel->selectdata('er_transactions AS et', '', $et_where );

              $trans_set = array(
                'route_order'         => "1",
                'subject'             => "TRAVEL ORDER - ".$user_name,
                'sender_divno'        => $user_credentials[0]['divno'],
                'sender_secno'        => $secno,
                'sender_id'           => $sender,
                'sender_ipadress'     => $ip_address,
                'receiver_divno'      => $receiver[0]['divno'],
                'receiver_secno'      => $receiver[0]['secno'],
                'receiver_id'         => $receiver[0]['token'],
                'receiver_name'       => $receiver_name,
                'receiver_region'     => $receiver[0]['region'],
                'type'                => "83",
                'status'              => $er_status,
                'status_description'  => $er_statusd,
                'action_taken'        => $er_action,
                'date_in'             => $date_out,
                'date_out'            => $date_out,
              );

              $trans_update_where = array(
                'etl.trans_no'    => $trans_no,
              );

              $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

              $whereemb   = $this->db->where('tcd.region',$this->session->userdata('region'));
              $queryemb   = $this->Embismodel->selectdata('to_company_designation AS tcd','tcd.*','',$whereemb);
              // if($this->session->userdata('userid') == '2588'){
              //   echo $this->db->last_query(); exit;
              // }
              $set = array(
                'et.route_order'        => "1",
                'et.company_token'      => $queryemb[0]['token'],
                'et.company_name'       => $queryemb[0]['company_name'],
                'et.emb_id'             => $queryemb[0]['emb_id'],
                'et.subject'            => "TRAVEL ORDER - ".$user_name,
                'et.system'             => "9",
                'et.type'               => "83",
                'et.type_description'   => "TRAVEL ORDER",
                'et.status'             => "15",
                'et.status_description' => "For Approval",
                'et.receive'            => 0,
                'et.sender_id'          => $sender,
                'et.sender_name'        => $user_name,
                'et.receiver_division'  => $receiver[0]['divname'],
                'et.receiver_section'   => $receiver[0]['sect'],
                'receiver_region'       => $receiver[0]['region'],
                'et.receiver_id'        => $receiver[0]['token'],
                'et.receiver_name'      => $receiver_name,
                'et.action_taken'       => $er_action,
                'et.remarks'            => "None",
              );

              $where = array( 'et.trans_no' => $trans_no);
              $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

              $destination = "";
              $countdestination = count($_POST['destination']);
              $count = 0;
              for ($ds=0; $ds < count($_POST['destination']); $ds++) {
                $count++;
                if(!empty($_POST['destination'][$ds])){
                  $location = array(
                    'er_no'        => $trans_no,
                    'location'     => $_POST['destination'][$ds],
                    'latitude'     => $_POST['latitude'][$ds],
                    'longitude'    => $_POST['longitude'][$ds],
                    'loc_order'    => $count,
                  );
                  $this->Embismodel->insertdata('to_destination', $location);

                  if($countdestination == $count){ $con  = ""; }else{ $con = ", "; }
                  $destination .= $_POST['destination'][$ds].$con;
                }
              }

              $set_to_trans       = array(
                'tt.destination'  => $destination,
              );
              $where_to_trans     = array( 'tt.er_no' => $trans_no);
              $resul_to_transt    = $this->Embismodel->updatedata( $set_to_trans, 'to_trans AS tt', $where_to_trans );


              if($result){
                $swal_arr = array(
                 'title'     => 'SUCCESS!',
                 'text'      => 'Travel request successfully submitted.',
                 'type'      => 'success',
               );
               $this->session->set_flashdata('swal_arr', $swal_arr);
               echo "<script>window.location.href='".base_url()."Travel/Dashboard'</script>";
              }

          }

        }else{
          echo "<script>alert('Please input required fields.')</script>";
          echo "<script>window.location.href='".base_url()."Travel/Order/form'</script>";
        }
        clearstatcache();
  }

  function process_travel(){
     date_default_timezone_set("Asia/Manila");
     $ip_address = $this->input->ip_address();
     $disapproval_reason      = $this->input->post('disapproval_reason');
     $trans_no                = $this->session->userdata('process_trans_no_travel');
     $region                  = $this->session->userdata('region');

     $where                = $this->db->where('tt.er_no',$trans_no);
     $qryaccounts          = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);

     if($qryaccounts[0]['assignedto'] == $this->session->userdata('userid')){

        if(!empty($trans_no) AND empty($disapproval_reason)){ //APPROVAL

        $user_credentials     = $this->Travelordermodel->user_credentials();                  //User Credentials

        $assignedto           = $this->Travelordermodel->route_order_function_approval($trans_no);     //Route to
        // echo $this->db->last_query(); exit;

        $whereheader  = $this->db->where('oudh.region = "'.$this->session->userdata('region').'" AND oudh.office = "'.$this->session->userdata('office').'" AND oudh.cnt = (SELECT MAX(oudhh.cnt) FROM office_uploads_document_header AS oudhh WHERE oudhh.region = "'.$this->session->userdata('region').'" AND oudhh.office = "'.$this->session->userdata('office').'")');
        $selectheader = $this->Embismodel->selectdata('office_uploads_document_header AS oudh','oudh.file_name','',$whereheader);

        $trans_order          = $this->Travelordermodel->to_trans_log_trans_order($trans_no);          //Trans Log Trans Order
        $to_trans_route_order = $this->Travelordermodel->to_trans_route_order($trans_no);                   //Assigned to

        $whereregionalapproval = $this->db->where('tf.userid = "'.$qryaccounts[0]['userid'].'" AND af.stat = "1" AND af.func = "Regional Executive Director"');
        $joinregionalapproval = $this->db->join('acc_function AS af','af.userid = tf.assigned_to','left');
        $selectregionalapprover = $this->Embismodel->selectdata('to_func AS tf','af.func','',$joinregionalapproval,$whereregionalapproval);


        if($selectregionalapprover[0]['func'] == 'Regional Executive Director'){
          $regionalapprover = $selectregionalapprover[0]['func'];
        }else{
          $regionalapprover = 'Regional Director';
        }


        if($qryaccounts[0]['travel_cat'] == "Yes"){ //Regional
          if($user_credentials[0]['func'] == "Director" OR $user_credentials[0]['func'] == $regionalapprover){
            $data = array(
                      'toheader'   => $selectheader[0]['file_name'],
                      'status'     => 'Signed Document',
                      'assignedto' => $assignedto,
                      'route_order'=> $to_trans_route_order,
            );
            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => $qryaccounts[0]['toid'],
              'userid'            => $qryaccounts[0]['userid'],
              'region'            => $qryaccounts[0]['region'],
              'status'            => 'Signed Document',
              'assignedto'        => $assignedto,
              'trans_order'       => $trans_order,
            );
          }else{
            $data = array(
              'toheader'   => $selectheader[0]['file_name'],
              'assignedto' => $assignedto,
              'route_order'=> $to_trans_route_order,
            );

            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => $qryaccounts[0]['toid'],
              'userid'            => $qryaccounts[0]['userid'],
              'region'            => $qryaccounts[0]['region'],
              'status'            => 'On-Process',
              'assignedto'        => $assignedto,
              'trans_order'       => $trans_order,
            );
          }
        }else{                                   //National
          if($user_credentials[0]['func'] == "Director" OR ($user_credentials[0]['func'] == $regionalapprover AND $to_trans_route_order == "1")){
            $data = array(
                      'status'     => 'Signed Document',
                      'assignedto' => $assignedto,
            );
            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => $qryaccounts[0]['toid'],
              'userid'            => $qryaccounts[0]['userid'],
              'region'            => $qryaccounts[0]['region'],
              'status'            => 'Signed Document',
              'assignedto'        => $assignedto,
              'trans_order'       => $trans_order,
            );
          }else{

            $data = array(
              'toheader'   => $selectheader[0]['file_name'],
              'assignedto' => $assignedto,
              'route_order'=> $to_trans_route_order,
            );

            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => $qryaccounts[0]['toid'],
              'userid'            => $qryaccounts[0]['userid'],
              'region'            => $qryaccounts[0]['region'],
              'status'            => 'On-Process',
              'assignedto'        => $assignedto,
              'trans_order'       => $trans_order,
            );
          }
        }
            $where = array('er_no' => $trans_no);
            $this->Embismodel->updatedata( $data,'to_trans',$where);
            $this->Embismodel->insertdata('to_trans_log', $trans_insert_log);


        //TRANSACTIONS
            //Receiver
            $wherereceiver = $this->db->where('acs.userid',$assignedto);
            $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
            $join          = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
            $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.title,acs.fname,acs.sname,acs.suffix,acs.region,xn.divname,xt.sect,xn.divno,xt.secno','',$wherereceiver,$join);
            $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
            $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
            $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
            $receiver_name = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
            //Receiver

            //Sender
            $wheresender   = $this->db->where('acs.userid',$this->session->userdata('userid'));
            $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.fname,acs.sname','',$wheresender);
            //Sender

            //Trans logs
            $transx    = $this->db->query("SELECT MAX(route_order) AS mro FROM er_transactions_log WHERE trans_no = '$trans_no'")->result_array();
            $wherelog  = $this->db->where('et.trans_no',$trans_no);
            $wherelog  = $this->db->where('et.route_order','1');
            $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

            if($qryaccounts[0]['travel_cat'] == "Yes"){ //Regional
              if($user_credentials[0]['func'] == "Director" OR $user_credentials[0]['func'] == $regionalapprover){
                $status             = "24";
                $status_description = "for filing / closed";
                $action_taken       = "Signed Document";
                $receiver_id        = "";
                $receiver_name      = "";
                $receiver_divno     = "";
                $receiver_secno     = "";
                $receiver_divname   = "";
                $receiver_sect      = "";
              }else{
                $status             = $translog[0]['status'];
                $status_description = $translog[0]['status_description'];
                $action_taken       = $translog[0]['action_taken'];
                $receiver_id        = $receiver[0]['token'];
                $receiver_name      = $receiver_name;
                $receiver_divno     = $receiver[0]['divno'];
                $receiver_secno     = $receiver[0]['secno'];
                $receiver_divname   = $receiver[0]['divname'];
                $receiver_sect      = $receiver[0]['sect'];
              }
            }else{                                   //National
              if($user_credentials[0]['func'] == "Director" OR ($user_credentials[0]['func'] == $regionalapprover AND $to_trans_route_order == "1")){
                $status             = "24";
                $status_description = "for filing / closed";
                $action_taken       = "Signed Document";
                $receiver_id        = "";
                $receiver_name      = "";
                $receiver_divno     = "";
                $receiver_secno     = "";
                $receiver_divname   = "";
                $receiver_sect      = "";
              }else if($user_credentials[0]['func'] == $regionalapprover OR $user_credentials[0]['func'] == "Assistant Director"){
                $status             = "5";
                $status_description = "signed document";
                $action_taken       = "For approval";
                $receiver_id        = $receiver[0]['token'];
                $receiver_name      = $receiver_name;
                $receiver_divno     = $receiver[0]['divno'];
                $receiver_secno     = $receiver[0]['secno'];
                $receiver_divname   = $receiver[0]['divname'];
                $receiver_sect      = $receiver[0]['sect'];
              }else{
                $status             = $translog[0]['status'];
                $status_description = $translog[0]['status_description'];
                $action_taken       = $translog[0]['action_taken'];
                $receiver_id        = $receiver[0]['token'];
                $receiver_name      = $receiver_name;
                $receiver_divno     = $receiver[0]['divno'];
                $receiver_secno     = $receiver[0]['secno'];
                $receiver_divname   = $receiver[0]['divname'];
                $receiver_sect      = $receiver[0]['sect'];
              }
            }

            //Trans logs

          $date_out  = date('Y-m-d H:i:s');

          $trans_set = array(
            'subject'               => $translog[0]['subject'],
            'sender_region'         => $translog[0]['sender_region'],
            'sender_ipadress'       => $ip_address,
            'receiver_divno'        => $receiver_divno,
            'receiver_secno'        => $receiver_secno,
            'receiver_id'           => $receiver_id,
            'receiver_name'         => $receiver_name,
            'receiver_region'       => $receiver[0]['region'],
            'type'                  => $translog[0]['type'],
            'status'                => $status,
            'status_description'    => $status_description,
            'action_taken'          => $action_taken,
            'date_in'               => $date_out,
            'date_out'              => $date_out,
          );

          $trans_update_where = array(
            'etl.trans_no'          => $trans_no,
            'etl.route_order'       => $transx[0]['mro'],
          );

          $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
           // echo $this->db->last_query(); exit;

          $set = array(
            'et.route_order'        => $transx[0]['mro'],
            'status'                => $status,
            'status_description'    => $status_description,
            'et.receive'            => 0,
            'et.sender_id'          => $qrysender[0]['token'],
            'et.sender_name'        => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
            'et.receiver_division'  => $receiver_divname,
            'et.receiver_section'   => $receiver_sect,
            'receiver_region'       => $receiver[0]['region'],
            'et.receiver_id'        => $receiver_id,
            'et.receiver_name'      => $receiver_name,
            'et.action_taken'       => $action_taken,
          );

          $where = array( 'et.trans_no' => $trans_no);
          $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

          if($result){
            $swal_arr = array(
             'title'     => 'SUCCESS!',
             'text'      => 'Travel request successfully approved.',
             'type'      => 'success',
           );
           $this->session->set_flashdata('swal_arr', $swal_arr);
            echo "<script>window.location.href='".base_url()."Travel/Dashboard/Forapproval'</script>";
          }
        //TRANSACTIONS

      }else{ //DISAPPROVAL

        $where                = $this->db->where('tt.er_no',$trans_no);
        $qryaccounts          = $this->Embismodel->selectdata('to_trans AS tt','*','',$where);
        $user_credentials     = $this->Travelordermodel->user_credentials();         //User Credentials
        // echo $this->db->last_query(); exit;
        $trans_order          = $this->Travelordermodel->to_trans_log_trans_order(); //Trans Log Trans Order

            $assignedto      = $qryaccounts[0]['userid'];

            $data = array(
              'status'     => 'Disapproved',
              'assignedto' => $assignedto,
            ); $where = array('er_no' => $trans_no);
               $this->Embismodel->updatedata( $data,'to_trans',$where);

            $trans_insert_log     = array(
              'er_no'             => $trans_no,
              'toid'              => $qryaccounts[0]['toid'],
              'userid'            => $qryaccounts[0]['userid'],
              'region'            => $qryaccounts[0]['region'],
              'status'            => 'Disapproved',
              'assignedto'        => $assignedto,
              'trans_order'       => $trans_order,
            ); $this->Embismodel->insertdata('to_trans_log', $trans_insert_log);

          //TRANSACTIONS
              //Receiver
              $wherereceiver = $this->db->where('acs.userid',$assignedto);
              $join          = $this->db->join('acc_xdvsion AS xn','xn.divno = acs.divno','left');
              $join          = $this->db->join('acc_xsect AS xt','xt.secno = acs.secno','left');
              $receiver      = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.fname,acs.sname,acs.region,xn.divname,xt.sect','',$wherereceiver,$join);
              $rmname = !empty($receiver[0]['mname']) ? $receiver[0]['mname'][0].'. ' : '';
              $rsuffix = !empty($receiver[0]['suffix']) ? ' '.$receiver[0]['suffix'] : '';
              $rtitle = !empty($receiver[0]['title']) ? $receiver[0]['title'].' ' : '';
              $receiver_named = $rtitle.$receiver[0]['fname'].' '.$rmname.$receiver[0]['sname'].$rsuffix;
              //Receiver

              //Sender
              $wheresender   = $this->db->where('acs.userid',$this->session->userdata('userid'));
              $qrysender     = $this->Embismodel->selectdata('acc_credentials AS acs','acs.token,acs.userid,acs.fname,acs.sname','',$wheresender);
              //Sender

              //Trans logs
              $transx    = $this->db->query("SELECT MAX(route_order) AS mro FROM er_transactions_log WHERE trans_no = '$trans_no'")->result_array();
              $wherelog  = $this->db->where('et.trans_no',$trans_no);
              $wherelog  = $this->db->where('et.route_order','1');
              $translog  = $this->Embismodel->selectdata('er_transactions_log AS et','*','',$wherelog);

              $status             = "6";
              $status_description = "disapproved / denied";
              $action_taken       = $disapproval_reason;

            //Trans logs

              $date_out  = date('Y-m-d H:i:s');

              $trans_set = array(
                'subject'               => $translog[0]['subject'],
                'sender_region'         => $translog[0]['sender_region'],
                'sender_ipadress'       => $ip_address,
                'receiver_id'           => $receiver[0]['token'],
                'receiver_name'         => $receiver_named,
                'receiver_region'       => $receiver[0]['region'],
                'type'                  => $translog[0]['type'],
                'status'                => $status,
                'status_description'    => $status_description,
                'action_taken'          => $action_taken,
                'date_in'               => $date_out,
                'date_out'              => $date_out,
              );

              $trans_update_where = array(
                'etl.trans_no'          => $trans_no,
                'etl.route_order'       => $transx[0]['mro'],
              );

              $etl_update = $this->Embismodel->updatedata( $trans_set, 'er_transactions_log AS etl', $trans_update_where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING
               // echo $this->db->last_query(); exit;

              $set = array(
                'et.route_order'        => $transx[0]['mro'],
                'status'                => $status,
                'status_description'    => $status_description,
                'et.receive'            => 0,
                'et.sender_id'          => $qrysender[0]['token'],
                'et.sender_name'        => ucwords($qrysender[0]['fname']." ".$qrysender[0]['sname']),
                'et.receiver_division'  => $receiver[0]['divname'],
                'et.receiver_section'   => $receiver[0]['sect'],
                'receiver_region'       => $receiver[0]['region'],
                'et.receiver_id'        => $receiver[0]['token'],
                'et.receiver_name'      => $receiver_name,
                'et.action_taken'       => $action_taken,
              );

              $where = array( 'et.trans_no' => $trans_no);
              $result = $this->Embismodel->updatedata( $set, 'er_transactions AS et', $where ); //PLEASE DONT FORGET TO CHECK WHERE CONDITION BEFORE RUNNING

              if($result){
                $swal_arr = array(
                 'title'     => 'SUCCESS!',
                 'text'      => 'Travel request successfully disapproved.',
                 'type'      => 'success',
               );
               $this->session->set_flashdata('swal_arr', $swal_arr);
               echo "<script>window.location.href='".base_url()."Travel/Dashboard/Forapproval'</script>";
              }


      } // DISAPPROVAL
    }else{
      $swal_arr = array(
       'title'     => 'INFO!',
       'text'      => 'Someone already gave an action to this travel using same account.',
       'type'      => 'info',
     );
     $this->session->set_flashdata('swal_arr', $swal_arr);
      echo "<script>window.location.href='".base_url()."Travel/Dashboard/Forapproval'</script>";
    }

    clearstatcache();
  }


}
