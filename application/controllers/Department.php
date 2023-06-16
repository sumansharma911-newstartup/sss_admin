<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    function __construct() {
        parent::__construct();
        check_authenticated();
        $this->load->model('utility_model');
    }

    function get_department_data() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['department_data'] = array();
        if ($user_id == NULL || !$user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['department_data'] = $this->utility_model->get_result_data('department', 'department_name', 'ASC');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['department_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_department_data_by_id() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $department_id = get_from_post('department_id');
        if (!$department_id) {
            echo json_encode(get_error_array(INVALID_DEPARTMENT_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $department_data = $this->utility_model->get_by_id('department_id', $department_id, 'department');
        if (empty($department_data)) {
            echo json_encode(get_error_array(INVALID_DEPARTMENT_MESSAGE));
            return false;
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['department_data'] = $department_data;
        echo json_encode($success_array);
    }

    function _get_post_data_for_department() {
        $dept_data = array();
        $dept_data['district'] = get_from_post('district_for_department');
        $dept_data['department_name'] = get_from_post('department_name_for_department');
        $dept_data['department_address'] = get_from_post('department_address_for_department');
        $dept_data['pincode'] = get_from_post('pincode_for_department');
        $dept_data['mobile_number'] = get_from_post('mobile_number_for_department');
        $dept_data['landline_number'] = get_from_post('landline_number_for_department');
        $dept_data['email'] = get_from_post('email_for_department');
        return $dept_data;
    }

    function _check_validation_for_department($dept_data) {
        if (!$dept_data['district']) {
            return DISTRICT_MESSAGE;
        }
        if (!$dept_data['department_name']) {
            return DEPARTMENT_MESSAGE;
        }
//        if (!$dept_data['department_address']) {
//            return ADDRESS_MESSAGE;
//        }
//        if (!$dept_data['pincode']) {
//            return PINCODE_MESSAGE;
//        }
//        if (!$dept_data['email']) {
//            return EMAIL_MESSAGE;
//        }
        return '';
    }

    function save_department() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $dept_data = $this->_get_post_data_for_department();
        $validation_message = $this->_check_validation_for_department($dept_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $existing_department_data = $this->utility_model->check_field_value_exists_or_not('department_name', $dept_data['department_name'], 'department', NULL, NULL, 'district', $dept_data['district']);
        if (!empty($existing_department_data)) {
            echo json_encode(get_error_array(DEPARTMENT_EXISTS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        unset($dept_data['department_id']);
        $dept_data['created_by'] = $user_id;
        $dept_data['created_time'] = date('Y-m-d H:i:S');
        $this->utility_model->insert_data('department', $dept_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DEPARTMENT_SAVED_MESSAGE;
        echo json_encode($success_array);
    }

    function update_department() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $department_id = get_from_post('department_id_for_department');
        if (!is_post() || $user_id == NULL || !$user_id || !$department_id || $department_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $dept_data = $this->_get_post_data_for_department();
        $validation_message = $this->_check_validation_for_department($dept_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $existing_department_data = $this->utility_model->check_field_value_exists_or_not('department_name', $dept_data['department_name'], 'department', 'department_id', $department_id, 'district', $dept_data['district']);
        if (!empty($existing_department_data)) {
            echo json_encode(get_error_array(DEPARTMENT_EXISTS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $dept_data['updated_by'] = $user_id;
        $dept_data['updated_time'] = date('Y-m-d H:i:S');
        $this->utility_model->update_data('department_id', $department_id, 'department', $dept_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DEPARTMENT_UPDATED_MESSAGE;
        echo json_encode($success_array);
    }

}

/*
 * EOF: ./application/controller/Department.php
 */