<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        check_authenticated();
        $this->load->model('user_model');
    }

    function get_users_data() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['users_data'] = array();
        if ($user_id == NULL || !$user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['users_data'] = $this->user_model->get_all_users_list();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['users_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_user_data_by_id() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $sa_user_id = get_from_post('user_id');
        if (!$sa_user_id) {
            echo json_encode(get_error_array(INVALID_USER_MESSAGE));
            return false;
        }
        $success_array = get_success_array();
        $this->db->trans_start();
        $user_data = $this->user_model->get_user_by_id($sa_user_id);
        if (empty($user_data)) {
            echo json_encode(get_error_array(INVALID_USER_MESSAGE));
            return false;
        }
        $user_data['password'] = decrypt($user_data['password']);
        $success_array['user_type_data'] = $this->user_model->get_all_user_type_list();
        $success_array['department_data'] = $this->utility_lib->get_department_data_by_district();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array['user_data'] = $user_data;
        echo json_encode($success_array);
    }

    function save_user() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_data = $this->_get_post_data_for_user();
        $validation_message = $this->_check_validation_for_user($user_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $this->db->trans_start();
        $existing_user_data = $this->user_model->check_username_and_password($user_data);
        if (!empty($existing_user_data)) {
            echo json_encode(get_error_array(USER_EXISTS_MESSAGE));
            return;
        }
        $user_data['password'] = encrypt($user_data['password']);
        $user_data['created_by'] = $user_id;
        $user_data['created_time'] = date('Y-m-d H:i:s');
        $this->user_model->insert_user($user_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = USER_SAVED_MESSSAGE;
        echo json_encode($success_array);
    }

    function update_user() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $sa_user_id = get_from_post('sa_user_id_for_users');
        if (!is_post() || $session_user_id == NULL || !$session_user_id || !$sa_user_id || $sa_user_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_data = $this->_get_post_data_for_user();
        $validation_message = $this->_check_validation_for_user($user_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $this->db->trans_start();
        $check_user = $this->user_model->get_user_by_id($sa_user_id);
        if (empty($check_user)) {
            echo json_encode(get_error_array(INVALID_USER_MESSAGE));
            return;
        }
        $existing_user_data = $this->user_model->check_username_and_password($user_data, $sa_user_id);
        if (!empty($existing_user_data)) {
            echo json_encode(get_error_array(USER_EXISTS_MESSAGE));
            return;
        }
        $user_data['password'] = encrypt($user_data['password']);
        $user_data['updated_by'] = $session_user_id;
        $user_data['updated_time'] = date('Y-m-d H:i:s');
        $this->user_model->update_user($sa_user_id, $user_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = USER_UPDATED_MESSSAGE;
        echo json_encode($success_array);
    }

    function _get_post_data_for_user() {
        $user_data = array();
        $user_data['name'] = get_from_post('name_for_users');
        $user_data['mobile_number'] = get_from_post('mobile_number_for_users');
        $user_data['email'] = get_from_post('email_for_users');
        $user_data['username'] = get_from_post('username_for_users');
        $user_data['password'] = get_from_post('password_for_users');
        $user_data['user_type'] = get_from_post('user_type_for_users');
        $user_data['status'] = get_from_post('status_type_for_users');
        $user_data['district'] = get_from_post('district_for_users');
        $user_data['department_id'] = get_from_post('department_id_for_users');
        return $user_data;
    }

    function _check_validation_for_user($user_data) {
        if (!$user_data['name']) {
            return NAME_MESSAGE;
        }
        if (!$user_data['username']) {
            return USERNAME_MESSAGE;
        }
        if (!$user_data['password']) {
            return PASSWORD_MESSAGE;
        }
        if (!$user_data['user_type']) {
            return SELECT_USER_TYPE_MESSAGE;
        }
        return '';
    }

    function get_user_type_data() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['user_type_data'] = array();
        if ($user_id == NULL || !$user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['user_type_data'] = $this->user_model->get_all_user_type_list();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['user_type_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_common_data_for_user() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['user_type_data'] = array();
        if ($user_id == NULL || !$user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->load->model('utility_model');
        $this->db->trans_start();
        $success_array['user_type_data'] = $this->user_model->get_all_user_type_list();
        $success_array['department_data'] = $this->utility_lib->get_department_data_by_district();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_user_type_data_by_id() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_type_id = get_from_post('user_type_id');
        if (!$user_type_id) {
            echo json_encode(get_error_array(INVALID_USER_TYPE_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $user_type_data = $this->user_model->get_user_type_by_id($user_type_id);
        if (empty($user_type_data)) {
            echo json_encode(get_error_array(INVALID_USER_TYPE_MESSAGE));
            return false;
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['user_type_data'] = $user_type_data;
        echo json_encode($success_array);
    }

    function save_user_type() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_type = get_from_post('user_type_for_user_type');
        if (!$user_type) {
            echo json_encode(get_error_array(USER_TYPE_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $existing_user_type_data = $this->user_model->check_user_type_exists_or_not($user_type);
        if (!empty($existing_user_type_data)) {
            echo json_encode(get_error_array(USER_TYPE_EXISTS_MESSAGE));
            return false;
        }
        $user_type_data = array();
        $user_type_data['type'] = $user_type;
        $user_type_data['created_by'] = $user_id;
        $user_type_data['created_time'] = date('Y-m-d H:i:S');
        $inserted_id = $this->user_model->insert_user_type($user_type_data);
        if (!$inserted_id) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return false;
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = USER_TYPE_SAVED_MESSAGE;
        echo json_encode($success_array);
    }

    function update_user_type() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $user_type_id = get_from_post('user_type_id_for_user_type');
        if (!is_post() || $user_id == NULL || !$user_id || !$user_type_id || $user_type_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_type = get_from_post('user_type_for_user_type');
        if (!$user_type) {
            echo json_encode(get_error_array(USER_TYPE_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $existing_user_type_data = $this->user_model->check_user_type_exists_or_not($user_type, $user_type_id);
        if (!empty($existing_user_type_data)) {
            echo json_encode(get_error_array(USER_TYPE_EXISTS_MESSAGE));
            return false;
        }
        $user_type_data = array();
        $user_type_data['type'] = $user_type;
        $user_type_data['updated_by'] = $user_id;
        $user_type_data['updated_time'] = date('Y-m-d H:i:S');
        $this->user_model->update_user_type($user_type_id, $user_type_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = USER_TYPE_UPDATED_MESSAGE;
        echo json_encode($success_array);
    }

    function _get_post_data_for_change_password() {
        $change_password_data = array();
        $change_password_data['current_password'] = get_from_post('current_password_for_change_password');
        $change_password_data['new_password'] = get_from_post('new_password_for_change_password');
        $change_password_data['retype_password'] = get_from_post('retype_password_for_change_password');
        return $change_password_data;
    }

    function change_password() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $user_id == NULL || !$user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $change_password_data = $this->_get_post_data_for_change_password();
        $this->db->trans_start();
        $user_data = $this->user_model->get_user_by_id($user_id);
        print_r($user_data);
        if (empty($user_data)) {
            echo json_encode(get_error_array(INVALID_USER_MESSAGE));
            return false;
        }
        if (decrypt($user_data['password']) != $change_password_data['current_password']) {
            echo json_encode(get_error_array(INCORRECT_CURRENT_PASSWORD));
            return false;
        }
        if (decrypt($user_data['password']) == $change_password_data['new_password']) {
            echo json_encode(get_error_array(CURRENT_NEW_PASSWORD_SAME_MESSAGE));
            return false;
        }
        $update_data = array();
        $update_data['password'] = encrypt($change_password_data['new_password']);
        $update_data['updated_by'] = $user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->user_model->update_user($user_id, $update_data);
        $this->logs_model->insert_log(TBL_LOGS_CHANGE_PASSWORD, array('sa_user_id' => $user_id, 'old_password' => $user_data['password'], 'new_password' => $update_data['password'], 'created_time' => date('Y-m-d H:i:s')));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = PASSWORD_CHANGED_MESSAGE;
        echo json_encode($success_array);
    }

}

/*
 * EOF: ./application/controller/Users.php
 */