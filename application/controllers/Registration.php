<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $success_array = array();
        $success_array['department_data'] = $this->utility_lib->get_department_data_by_district();
        $this->load->view('registration', $success_array);
    }

    function check_username() {
        if (!is_post()) {
            echo json_encode(array('success' => false, 'message' => INVALID_ACCESS_MESSAGE));
            return false;
        }
        $username = get_from_post('username_for_verification');
        if (!$username) {
            echo json_encode(array('success' => false, 'message' => USERNAME_MESSAGE));
            return false;
        }
        $this->load->model('utility_model');
        $ex_username = $this->utility_model->get_by_id('username', $username, 'sa_users', 'user_type', TEMP_TYPE_DEPT_USER);
        if (!empty($ex_username)) {
            echo json_encode(array('success' => false, 'message' => USER_EXISTS_MESSAGE));
            return false;
        }
        echo json_encode(array('success' => true));
    }

    function _get_post_data_for_registration() {
        $user_data = array();
        $user_data['district'] = get_from_post('district_for_registration');
        $user_data['department_id'] = get_from_post('department_id_for_registration');
        $user_data['other_department_name'] = get_from_post('other_department_name_for_registration');
        $user_data['name'] = get_from_post('cp_name_for_registration');
        $user_data['mobile_number'] = get_from_post('cp_mobile_number_for_registration');
        $user_data['email'] = get_from_post('cp_email_for_registration');
        $user_data['username'] = get_from_post('username_for_registration');
        $user_data['password'] = atob_decode(get_from_post('password_for_registration'));
        $user_data['retype_password'] = atob_decode(get_from_post('retype_password_for_registration'));
        return $user_data;
    }

    function _check_validation_for_registration($registration_data) {
        if (!$registration_data['district']) {
            return DISTRICT_MESSAGE;
        }
        if (!$registration_data['department_id']) {
            return SELECT_DEPARTMENT_MESSAGE;
        }
        if ($registration_data['department_id'] == OTHER_DEPT_DAMAN || $registration_data['department_id'] == OTHER_DEPT_DIU ||
                $registration_data['department_id'] == OTHER_DEPT_DNH) {
            if (!$registration_data['other_department_name']) {
                return DEPARTMENT_MESSAGE;
            }
        }
        if (!$registration_data['name']) {
            return NAME_MESSAGE;
        }
        if (!$registration_data['mobile_number']) {
            return MOBILE_NUMBER_MESSAGE;
        }
        if (!$registration_data['email']) {
            return EMAIL_MESSAGE;
        }
        if (!$registration_data['username']) {
            return USERNAME_MESSAGE;
        }
        if (!$registration_data['password']) {
            return PASSWORD_MESSAGE;
        }
        if (!$registration_data['retype_password']) {
            return RETYPE_PASSWORD_MESSAGE;
        }
        return '';
    }

    function check_registration() {
        if (!is_post()) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $registration_data = $this->_get_post_data_for_registration();
        $validation_message = $this->_check_validation_for_registration($registration_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        $ex_username = $this->utility_model->get_by_id('username', $registration_data['username'], 'sa_users', 'user_type', TEMP_TYPE_DEPT_USER);
        if (!empty($ex_username)) {
            echo json_encode(get_error_array(USER_EXISTS_MESSAGE));
            return false;
        }
        if ($registration_data['department_id'] == OTHER_DEPT_DAMAN || $registration_data['department_id'] == OTHER_DEPT_DIU ||
                $registration_data['department_id'] == OTHER_DEPT_DNH) {
            $ex_deptname = $this->utility_model->get_by_id('department_name', $registration_data['other_department_name'], 'department', 'district', $registration_data['district']);
            if (!empty($ex_deptname)) {
                echo json_encode(get_error_array(DEPARTMENT_EXISTS_MESSAGE));
                return false;
            }
            $dept_array = array();
            $dept_array['district'] = $registration_data['district'];
            $dept_array['department_name'] = $registration_data['other_department_name'];
            $dept_array['created_time'] = date('Y-m-d H:i:s');
            $registration_data['department_id'] = $this->utility_model->insert_data('department', $dept_array);
        }
        unset($registration_data['other_department_name']);
        unset($registration_data['retype_password']);
        $registration_data['password'] = encrypt($registration_data['password']);
        $registration_data['user_type'] = TEMP_TYPE_DEPT_USER;
        $registration_data['created_time'] = date('Y-m-d H:i:s');
        $this->db->trans_start();
        $registration_data['user_id'] = $this->utility_model->insert_data('sa_users', $registration_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $registration_message = 'Dear ' . $registration_data['name'] . ',<br><br>'
                . 'Following Credentials are Login<br>'
                . '<b>URL : </b>' . base_url() . 'login<br>'
                . '<b>Username : </b>' . $registration_data['username'] . '<br>'
                . '<b>Password : </b>' . decrypt($registration_data['password']);
        $this->load->library('email_lib');
        $this->email_lib->send_email($registration_data, 'S.S.S.(Samay Sudhini Seva) Login Credentials', $registration_message, VALUE_ONE);

        $message = 'You have successfully submitted your registration details.<br>'
                . 'Please Login with your Username and Password.<br> '
                . '<span style="color: red;">Note :</span> If Mail is Not Received Your Inbox. Please Check the Spam.';
        $success_array = get_success_array();
        $success_array['message'] = $message;
        echo json_encode($success_array);
    }

}

/*
 * EOF: ./application/controller/Login.php
 */