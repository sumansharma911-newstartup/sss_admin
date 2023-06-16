<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_model extends CI_Model {

    function get_all_service_data($session_user_id) {
        $this->db->select('s.*, d.department_name');
        if (is_dept_user()) {
            $this->db->where('((s.department_id="' . get_from_session('temp_dept_for_sss_admin') . '" '
                    . 'AND s.district="' . get_from_session('temp_district_for_sss_admin') . '")) '
                    . 'OR (s.user_id="' . $session_user_id . '")');
        }
        $this->db->where('s.is_delete !=', IS_DELETE);
        $this->db->from('service AS s');
        $this->db->join('department AS d', 'd.department_id=s.department_id', 'LEFT');
        $this->db->order_by('s.district, s.department_id');
        $resc = $this->db->get();
        return $resc->result_array();
    }

    function get_service_data_by_id($service_id) {
        $this->db->select('s.*, d.department_name');
        $this->db->where('service_id', $service_id);
        $this->db->where('s.is_delete !=', IS_DELETE);
        $this->db->from('service AS s');
        $this->db->join('department AS d', 'd.department_id=s.department_id', 'LEFT');
        $resc = $this->db->get();
        return $resc->row_array();
    }

}

/*
 * EOF: ./application/models/Service_model.php
 */