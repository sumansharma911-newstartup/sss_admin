<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utility_model extends CI_Model {

    function get_by_id($id, $compare_id, $table_name, $second_id = NULL, $second_value = NULL) {
        $this->db->where($id, $compare_id);
        if ($second_id != NULL && $second_value != NULL) {
            $this->db->where($second_id, $second_value);
        }
        $this->db->where('is_delete !=' . IS_DELETE);
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function insert_data($table_name, $table_data) {
        $this->db->insert($table_name, $table_data);
        return $this->db->insert_id();
    }

    function insert_data_batch($table_name, $table_data) {
        $this->db->insert_batch($table_name, $table_data);
    }

    function update_data($id, $id_value, $table_name, $table_data, $second_id = NULL, $second_value = NULL) {
        $this->db->where($id, $id_value);
        if ($second_id != NULL && $second_value != NULL) {
            $this->db->where($second_id, $second_value);
        }
        $this->db->update($table_name, $table_data);
    }

    function update_data_batch($id, $table_name, $table_data) {
        $this->db->where('is_delete !=' . IS_DELETE);
        $this->db->update_batch($table_name, $table_data, $id);
    }

    function get_result_data($table_name) {
        $this->db->where('is_delete !=' . IS_DELETE);
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->result_array();
    }

    function get_result_data_by_id($id_text, $id, $table_name, $field_name2 = NULL, $field_value2 = NULL, $field_name3 = NULL, $field_value3 = NULL, $field_name4 = NULL, $field_value4 = NULL, $field_name5 = NULL, $field_value5 = NULL) {
        $this->db->where($id_text, $id);
        $this->db->where('is_delete !=' . IS_DELETE);
        if ($field_name2 != NULL && $field_value2 != NULL) {
            $this->db->where($field_name2, $field_value2);
        }
        if ($field_name3 != NULL && $field_value3 != NULL) {
            $this->db->where($field_name3, $field_value3);
        }
        if ($field_name4 != NULL && $field_value4 != NULL) {
            $this->db->where($field_name4, $field_value4);
        }
        if ($field_name5 != NULL && $field_value5 != NULL) {
            $this->db->where($field_name5, $field_value5);
        }
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->result_array();
    }

    function check_field_value_exists_or_not($field_name, $field_value, $table_name, $id = NULL, $id_value = NULL, $field_name2 = NULL, $field_value2 = NULL) {
        $this->db->where('is_delete !=', IS_DELETE);
        $this->db->where($field_name, $field_value);
        if ($field_name2 != NULL && $field_value2 != NULL) {
            $this->db->where($field_name2, $field_value2);
        }
        if ($id != NULL && $id_value != NULL) {
            $this->db->where("$id != $id_value");
        }
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function get_by_id_for_all($id, $compare_id, $table_name, $second_id = NULL, $second_value = NULL) {
        $this->db->where($id, $compare_id);
        if ($second_id != NULL && $second_value != NULL) {
            $this->db->where($second_id, $second_value);
        }
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function get_result_data_by_id_for_all($table_name) {
        $this->db->from($table_name);
        $resc = $this->db->get();
        return $resc->result_array();
    }

}

/*
 * EOF: ./application/models/Utility_model.php
 */