<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility_lib {

    var $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('utility_model');
    }

    function login_log($user_id) {
        $logs_data = array();
        $logs_data['sa_user_id'] = $user_id;
        $logs_data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $logs_data['login_timestamp'] = time();
        $logs_data['logs_data'] = json_encode($this->_get_client_info());
        $logs_data['created_time'] = date('Y-m-d H:i:s');
        return $this->CI->logs_model->insert_log(TBL_LOGS_LOGIN_LOGOUT, $logs_data);
    }

    function logout_log($log_id) {
        $logs_data = array();
        $logs_data['logout_timestamp'] = time();
        $logs_data['updated_time'] = date('Y-m-d H:i:s');
        return $this->CI->logs_model->update_log(TBL_LOGS_LOGIN_LOGOUT, TBL_LOGS_LOGIN_LOGOUT_PRIMARY_KEY, $log_id, $logs_data);
    }

    function _get_client_info() {
        return array(
            'HTTP_USER_AGENT' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR']
        );
    }

    function get_department_data_by_district() {
        $temp_department_data = $this->CI->utility_model->get_result_data('department', 'department_name', 'ASC');
        $department_data = array();
        foreach ($temp_department_data as $dd) {
            if (!isset($department_data[$dd['district']])) {
                $department_data[$dd['district']] = array();
            }
            if (!isset($department_data[$dd['district']][$dd['department_id']])) {
                $department_data[$dd['district']][$dd['department_id']] = $dd;
            }
        }
        return $department_data;
    }

    function upload_document($field_name, $folder_name, $replace_name, $db_name) {
        if ($_FILES[$field_name]['name'] == '') {
            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_DOC_MESSAGE));
            return false;
        }
        $evidence_size = $_FILES[$field_name]['size'];
        if ($evidence_size == 0) {
            echo json_encode(array('success' => FALSE, 'message' => DOC_INVALID_SIZE_MESSAGE));
            return;
        }
//        $maxsize = '20971520';
//        if ($evidence_size >= $maxsize) {
//            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_MAX_ONE_MB_MESSAGE));
//            return;
//        }

        if ($_FILES[$field_name]['name'] != '') {
            $documents_path = 'documents';
            if (!is_dir($documents_path)) {
                mkdir($documents_path);
                chmod($documents_path, 0777);
            }
            $module_path = $documents_path . DIRECTORY_SEPARATOR . "$folder_name";
            if (!is_dir($module_path)) {
                mkdir($module_path);
                chmod($module_path, 0777);
            }
            $this->CI->load->library('upload');
            $temp_filename = str_replace(' ', '_', $_FILES[$field_name]['name']);
            $filename = "$replace_name" . (rand(100000000, 999999999)) . time() . '.' . pathinfo($temp_filename, PATHINFO_EXTENSION);
            //Change file name
            $final_path = $module_path . DIRECTORY_SEPARATOR . $filename;
            if (!move_uploaded_file($_FILES[$field_name]['tmp_name'], $final_path)) {
                echo json_encode(array('success' => FALSE, 'message' => DOCUMENT_NOT_UPLOAD_MESSAGE));
                return;
            }
            $document_data[$db_name] = $filename;
            return $document_data;
        }
    }

}

/**
 * EOF: ./application/libraries/Email_lib.php
 */