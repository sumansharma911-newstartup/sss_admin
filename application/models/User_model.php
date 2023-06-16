<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function check_username_and_password($user_data, $sa_user_id = NULL) {
        $this->db->where('username', $user_data['username']);
        if ($sa_user_id != NULL) {
            $this->db->where('sa_user_id !=' . $sa_user_id);
        }
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->from('sa_users');
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function get_all_users_list() {
        $this->db->select('u.*, ut.type, d.department_name');
        $this->db->where('u.is_delete !=', IS_DELETE);
        $this->db->from('sa_users AS u');
        $this->db->join('sa_user_type AS ut', 'ut.sa_user_type_id = u.user_type');
        $this->db->join('department AS d', 'd.department_id = u.department_id', 'LEFT');
        $resc = $this->db->get();
        return $resc->result_array();
    }

    function get_user_by_id($sa_user_id) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where('sa_user_id', $sa_user_id);
        $this->db->from('sa_users');
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function insert_user($user_data) {
        $this->db->insert('sa_users', $user_data);
        return $this->db->insert_id();
    }

    function update_user($sa_user_id, $user_data) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where('sa_user_id', $sa_user_id);
        $this->db->update('sa_users', $user_data);
    }

    function get_all_user_type_list() {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->from('sa_user_type');
        $resc = $this->db->get();
        return $resc->result_array();
    }


    function get_user_type_by_id($user_type_id) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where('sa_user_type_id', $user_type_id);
        $this->db->from('sa_user_type');
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function check_user_type_exists_or_not($user_type, $user_type_id = NULL) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where('type', $user_type);
        if ($user_type_id != NULL) {
            $this->db->where('sa_user_type_id !=' . $user_type_id);
        }
        $this->db->from('sa_user_type');
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function insert_user_type($user_type_data) {
        $this->db->insert('sa_user_type', $user_type_data);
        return $this->db->insert_id();
    }

    function update_user_type($user_type_id, $user_type_data) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where('sa_user_type_id', $user_type_id);
        $this->db->update('sa_user_type', $user_type_data);
    }

}

/*
 * EOF: ./application/models/User_model.php
 */