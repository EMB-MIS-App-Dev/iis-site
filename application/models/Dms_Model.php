<?php
  /**
   *
   */
  class Dms_Model extends CI_Model
  {

    function __construct(argument)
    {
      parent::__construct();
      // code...
    }

    function _is_empty($data="", $empt="", $added="") { return !empty($data) ? $data.$added : $empt; }

    function _alert($alert_data="", $redirect_page="", $code="", $type="")
    {
      $asd = '';
      if(empty($alert_data)) {
        $alert_data = array(
          'title'     => 'NOTE',
          'text'      => 'You have Accessed an Unidentified Page and have been Redirected to this Page. '.$code,
          'type'      => 'warning',
        );
      }
      else {
        if(!empty($code)) {
          $alert_data['text'] = $alert_data['text'].' '.$code;
        }
      }
      if(empty($type)) {
        $this->session->set_flashdata('bthead_alert_data', $alert_data);
      }
      else {
        $this->session->set_flashdata('swal_alert_data', $alert_data);
      }

      if(empty($redirect_page)) {
        $redirect_page = base_url('dms/documents/all');
      }
      redirect($redirect_page);
    }

    function validate_session()
    {
      $where_ucred = array(
        'userid'   => $this->ajaxdata['user']['id'],
        'verified' => 1,
      );
      $session_ucred = $this->Embismodel->selectdata('acc_credentials', '*', $where_ucred)[0];

      if($session_ucred['region'] != $this->ajaxdata['user']['region'] || $session_ucred['secno'] != $this->ajaxdata['user']['secno'] || $session_ucred['divno'] != $this->ajaxdata['user']['divno']) {
        $this->ajaxdata['user'] = array(
          'id'      => $session_ucred['userid'],
          'token'   => $session_ucred['token'],
          'region'  => $session_ucred['region'],
          'secno'   => $session_ucred['secno'],
          'divno'   => $session_ucred['divno'],
        );
      }
    }

    function get_division()
    {
      $data = array(
        'division'  => $this->input->post('selected'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );

      $this->validate_session();

      $type = ($data['region'] == 'CO') ? 'co' : 'region';
      $type2 = strtolower($data['region']);

      $func = $this->Embismodel->selectdata('acc_function', 'func', array('stat' => 1, 'userid' => $this->ajaxdata['user']['id']));
      $restriction = 'divno IN (2, 6)';

      if($data['region'] == $this->ajaxdata['user']['region']) {
        $restriction = '1';
      }
      else {
        foreach ($func as $key => $value) {
          if(in_array($value['func'], array('Director', 'Assistant Director'))) {
            $restriction = '1';
            break;
          }
          else if($value['func'] == 'Regional Director')
          {
          $restriction = 'divno IN (1, 2, 6, 14, 17)';
          }
        }
      }
      $where_div = $this->db->where('type IN("'.$type.'", "'.$type2.'") AND office = "EMB" AND '.$restriction);
      $get_division = $this->Embismodel->selectdata('acc_xdvsion', '*', '', $where_div);

      echo '<option value="" selected>-select division-</option>';
      foreach ($get_division as $key => $value) {
        echo '<option value="'.$value['divno'].'">'.$value['divname'].'</option>';
      }
    }

    function get_section()
    {
      $data = array(
        'section'   => $this->input->post('selected'),
        'division'  => $this->input->post('division'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );
      $this->validate_session();
      $exclude_sect = $this->Embismodel->selectdata('acc_xsect_not_applicable', '*', array('region' => $data['region']) );
      $xsct = '0';
      if(!empty($exclude_sect))
      {
        foreach($exclude_sect as $key => $value) {
          if(count($exclude_sect)-1 == $key) {
            $xsct .= $value['secno'];
          }
          else {
            $xsct .= $value['secno'].',';
          }
        }
      }
      // if($this->session->userdata('region') == $region || $this->session->userdata('func') == 'Director') {
        $restriction = '1';
      // }
      // else {
      //   $restriction = 'axs.secno IN (77, 166, 176, 195, 223, 231, 232, 235, 255, 279, 316)';
      // }
      if($region != 'CO') {
        $where['xsect'] = $this->db->where('divno = "'.$data['division'].'" AND ( region = "'.$data['region'].'" OR region = "R" ) AND secno NOT IN ('.$xsct.') AND '.$restriction);
      }
      else {
        $where['xsect'] = $this->db->where('divno = "'.$data['division'].'" AND region = "'.$data['region'].'" AND '.$restriction);
      }
      $get_section = $this->Embismodel->selectdata('acc_xsect', '*', '', $where['xsect']);

      echo '<option value="" selected>-select section-</option>';
      echo '<option value="0">N/A</option>';
      foreach ($get_section as $key => $value) {
        echo '<option value="'.$value['secno'].'">'.$value['sect'].'</option>';
      }
    }

    function get_personnel()
    {
      $data = array(
        'personnel' => $this->input->post('selected'),
        'section'   => !empty($this->input->post('section')) ? $this->input->post('section') : 0,
        'division'  => $this->input->post('division'),
        'region'    => !empty($this->input->post('region')) ? $this->input->post('region') : $this->ajaxdata['user']['region'],
      );
      $this->validate_session();

      $af_where = array('stat' => 1, 'secno' => $data['section'], 'divno' => $data['division'], 'region' => $data['region']);
      $func_grp = $this->db->group_by("userid");
      $func = $this->Embismodel->selectdata('acc_function', 'userid', $af_where, $func_grp);

      echo '<option value="" selected>-select personnel-</option>';
      foreach ($func as $key => $value) {
        $sec_where = array(
          'userid'   => $value['userid'],
          'verified' => 1
        );
        $personnel1_grp = $this->db->group_by("userid");
        $personnel = $this->Embismodel->selectdata('acc_credentials', 'token, fname, mname, sname', $sec_where, $personnel1_grp);
        if(!empty($personnel)) {
          echo '<option value="'.$personnel[0]['token'].'">'.ucwords($personnel[0]['fname'].' '.strtoupper($personnel[0]['mname'][0]).'. '.$personnel[0]['sname']).'</option>';
        }
      }
    }

  }

 ?>
