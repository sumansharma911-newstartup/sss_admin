<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $this->load->view('login');
    }

    function check_login() {
        if (!is_post()) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $user_data = $this->_get_post_data();
        $validation_message = $this->_check_validation($user_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $this->db->trans_start();
        $new_user_data = $this->user_model->check_username_and_password($user_data);
        if (empty($new_user_data)) {
            echo json_encode(get_error_array(INVALID_USERNAME_OR_PASSWORD_MESSAGE));
            return;
        }
        if (decrypt($new_user_data['password']) != $user_data['password']) {
            echo json_encode(get_error_array(INVALID_USERNAME_OR_PASSWORD_MESSAGE));
            return;
        }
        if ($new_user_data['status'] == IS_DEACTIVE) {
            echo json_encode(get_error_array(ACCOUNT_NOT_ACTIVE_MESSAGE));
            return;
        }
        if ($new_user_data['is_delete'] == IS_DELETE) {
            echo json_encode(get_error_array(ACCOUNT_DELETE_MESSAGE));
            return;
        }
        $log_id = $this->utility_lib->login_log($new_user_data['sa_user_id']);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $session_data = array();
        $session_data['temp_id_for_sss_admin'] = $new_user_data['sa_user_id'];
        $session_data['name'] = ucwords($new_user_data['name']);
        $session_data['temp_type_for_sss_admin'] = $new_user_data['user_type'];
        $session_data['temp_dept_for_sss_admin'] = $new_user_data['department_id'];
        $session_data['temp_district_for_sss_admin'] = $new_user_data['district'];
        $session_data['temp_logged'] = encrypt($log_id);
        $this->session->set_userdata($session_data);
        echo json_encode(get_success_array());
    }

    function _get_post_data() {
        $user_data = array();
        $user_data['username'] = get_from_post('temp_name');
        $user_data['password'] = get_from_post('temp_password');
        return $user_data;
    }

    function _check_validation($user_data) {
        if (!$user_data['username']) {
            return 'Enter Username.';
        }
        if (!$user_data['password']) {
            return 'Enter Password.';
        }
        return '';
    }

    function logout() {
        $this->_destroy_session();
        header("Location:" . base_url() . "main");
    }

    /**
     * This function is used to destroy the session.
     */
    function _destroy_session() {
        $temp_user_id = get_from_session('temp_id_for_sss_admin');
        if ($temp_user_id != NULL) {
            $temp_logged_id = decrypt(get_from_session('temp_logged'));
            if ($temp_logged_id) {
                $this->utility_lib->logout_log($temp_logged_id);
            }
        }
        $this->session->sess_destroy();
    }

}

/*
 * EOF: ./application/controller/Login.php
 */