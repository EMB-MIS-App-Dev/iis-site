<?php

function ersystems_addedtable($data="")
{
    if(!empty($post['appli_type']))
    {
      $where['sub_type'] = array(
        'est.id'      => $post['appli_type'],
        'est.ssysid'  => $post['type']
      );
      $sub_type = $this->Embismodel->selectdata('er_sub_type AS est', '', $where['sub_type'] );
      $subtype_dsc = $sub_type[0]['dsc'];
    }
    else {
      $subtype_dsc = '';
    }

    switch ($post['system']) {
      case 1: // ORD
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_ord AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_ord AS esa',
          'table_ins' => 'er_system_ord',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
          ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      case 2: // ADMINISTRATIVE
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_admin AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_admin AS esa',
          'table_ins' => 'er_system_admin',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
            ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      case 4: // PERMITTING
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_permit AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'    => 'er_system_permit AS esa',
          'table_ins'   => 'er_system_permit',
          'insert'      => array(
            'trans_no'              => $data['trans_no'],
            'sub_system'            => $post['type'],
            'sub_desc'              => $data['type'][0]['name'],
            'subtype_id'            => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'          => $subtype_dsc,
            'permit_no'             => (!empty($post['permit_no'])) ? $post['permit_no'] : '',
            'consultant_id'         => '',
            'consultant_name'       => '',
            'exp_start_date'        => (!empty($post['exp_start_date'])) ? $post['exp_start_date'] : '0000-00-00',
            'exp_end_date'          => (!empty($post['exp_end_date'])) ? $post['exp_end_date'] : '0000-00-00',
          ),
          'set'         => array(
            'esa.sub_system'        => $post['type'],
            'esa.sub_desc'          => $data['type'][0]['name'],
            'esa.subtype_id'        => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'      => $subtype_dsc,
            'esa.permit_no'         => (!empty($post['permit_no'])) ? $post['permit_no'] : '',
            'esa.consultant_id'     => '',
            'esa.consultant_name'   => '',
            'esa.exp_start_date'    => (!empty($post['exp_start_date'])) ? $post['exp_start_date'] : '0000-00-00',
            'esa.exp_end_date'      => (!empty($post['exp_end_date'])) ? $post['exp_end_date'] : '0000-00-00',
            ),
          'where'       => array(
            'esa.trans_no'          => $data['trans_no'],
          )
        );
        break;

      case 10: // LAB
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_lab AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_lab AS esa',
          'table_ins' => 'er_system_lab',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
          ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      case 11: // EEIU
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_eeiu AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_eeiu AS esa',
          'table_ins' => 'er_system_eeiu',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
          ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      case 12: // RECORDS
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_rec AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_rec AS esa',
          'table_ins' => 'er_system_rec',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
            'type_no'             => (!empty($post['type_no'])) ? trim($post['type_no']) : '',
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
            'esa.type_no'         => (!empty($post['type_no'])) ? trim($post['type_no']) : '',
          ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      case 13: // LEGAL
        $esa_where = array( 'esa.trans_no' => $data['trans_no'] );
        $esa = $this->Embismodel->selectdata('er_system_legal AS esa', '', $esa_where );

        $esa_vars = array(
          'table_up'  => 'er_system_legal AS esa',
          'table_ins' => 'er_system_legal',
          'insert'    => array(
            'trans_no'            => $data['trans_no'],
            'sub_system'          => $post['type'],
            'sub_desc'            => $data['type'][0]['name'],
            'subtype_id'          => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'subtype_desc'        => $subtype_dsc,
          ),
          'set'       => array(
            'esa.sub_system'      => $post['type'],
            'esa.sub_desc'        => $data['type'][0]['name'],
            'esa.subtype_id'      => (!empty($post['appli_type'])) ? $post['appli_type'] : 0,
            'esa.subtype_desc'    => $subtype_dsc,
          ),
          'where'     => array(
            'esa.trans_no'        => $data['trans_no'],
          )
        );
        break;

      default:
        $esa = '';
        break;
    }

    if(!empty($esa)) {
      $result = $this->Embismodel->updatedata( $esa_vars['set'] , $esa_vars['table_up'], $esa_vars['where'] );
    }
    else {
      $result = $this->Embismodel->insertdata( $esa_vars['table_ins'], $esa_vars['insert'] );
    }
}



?>
