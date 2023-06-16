<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    function __construct() {
        parent::__construct();
        check_authenticated();
        $this->load->model('service_model');
        $this->load->model('utility_model');
    }

    function get_service_data() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['service_data'] = array();
        if ($session_user_id == NULL || !$session_user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['service_data'] = $this->service_model->get_all_service_data($session_user_id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['service_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_common_data_for_service() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['department_data'] = array();
        if ($user_id == NULL || !$user_id || (!is_admin())) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['department_data'] = $this->utility_lib->get_department_data_by_district();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function _get_db_field_name_for_service($module_type) {
        $db_field_name = '';
        if ($module_type == VALUE_ONE) {
            $db_field_name = 'cc_doc';
        }
        if ($module_type == VALUE_TWO) {
            $db_field_name = 'process_flow_doc';
        }
        return $db_field_name;
    }

    function upload_service_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(array('success' => FALSE, 'message' => INVALID_ACCESS_MESSAGE));
            return false;
        }
        $service_id = get_from_post('service_id');
        $module_type = get_from_post('module_type');
        if ($module_type != VALUE_ONE && $module_type != VALUE_TWO) {
            echo json_encode(array('success' => FALSE, 'message' => INVALID_ACCESS_MESSAGE));
            return;
        }
        $db_field_name = $this->_get_db_field_name_for_service($module_type);
        if (!$db_field_name) {
            echo json_encode(array('success' => FALSE, 'message' => INVALID_ACCESS_MESSAGE));
            return;
        }
        $service_data = $this->utility_lib->upload_document('document_file', 'service', 'service_' . $module_type . '_', $db_field_name);
        if (!$service_data) {
            return false;
        }
        $this->db->trans_start();
        if (!$service_id || $service_id == null) {
            if (is_dept_user()) {
                $service_data['district'] = get_from_session('temp_district_for_sss_admin');
                $service_data['department_id'] = get_from_session('temp_dept_for_sss_admin');
            }
            $service_data['user_id'] = $session_user_id;
            $service_data['created_by'] = $session_user_id;
            $service_data['created_time'] = date('Y-m-d H:i:s');
            $service_id = $this->utility_model->insert_data('service', $service_data);
        } else {
            $service_data['updated_by'] = $session_user_id;
            $service_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('service_id', $service_id, 'service', $service_data);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('success' => FALSE, 'message' => DATABASE_ERROR_MESSAGE));
            return;
        }
        $service_data['service_id'] = $service_id;
        $service_data['module_type'] = $module_type;
        $success_array = array();
        $success_array['success'] = TRUE;
        $success_array['service_data'] = $service_data;
        echo json_encode($success_array);
    }

    function remove_service_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_id = get_from_post('service_id');
        if ($session_user_id == NULL || !$session_user_id || !$service_id || $service_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $module_type = get_from_post('module_type');
        if ($module_type != VALUE_ONE && $module_type != VALUE_TWO) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        $db_field_name = $this->_get_db_field_name_for_service($module_type);
        if (!$db_field_name) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        $this->db->trans_start();
        $ex_data = $this->utility_model->get_by_id('service_id', $service_id, 'service');
        if (empty($ex_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if (!isset($ex_data[$db_field_name])) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if ($ex_data[$db_field_name] != '') {
            $file_path = 'documents' . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR . $ex_data[$db_field_name];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $update_data = array();
        $update_data['status'] = VALUE_ZERO;
        $update_data[$db_field_name] = '';
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->utility_model->update_data('service_id', $service_id, 'service', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DOCUMENT_REMOVED_MESSAGE;
        $success_array['doc_filename'] = $db_field_name;
        echo json_encode($success_array);
    }

    function upload_sas_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_id = get_from_post('service_id_for_service');
        $service_sas_doc_id = get_from_post('service_sas_doc_id_for_service_sas');
        if ($session_user_id == NULL || !$session_user_id) {
            echo json_encode(array('success' => FALSE, 'message' => INVALID_ACCESS_MESSAGE));
            return false;
        }
        if ($_FILES['document_for_service_sas']['name'] == '') {
            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_DOC_MESSAGE));
            return;
        }
        $doc_size = $_FILES['document_for_service_sas']['size'];
        if ($doc_size == 0) {
            echo json_encode(array('success' => FALSE, 'message' => DOC_INVALID_SIZE_MESSAGE));
            return;
        }
        $maxsize = '104857600';
        if ($doc_size >= $maxsize) {
            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_MAX_TEN_MB_MESSAGE));
            return;
        }
        $path = 'documents';
        if (!is_dir($path)) {
            mkdir($path);
            chmod("$path", 0755);
        }
        $main_path = $path . DIRECTORY_SEPARATOR . 'service';
        if (!is_dir($main_path)) {
            mkdir($main_path);
            chmod("$main_path", 0755);
        }
        $doc_path = $main_path . DIRECTORY_SEPARATOR . 'sas_doc';
        if (!is_dir($doc_path)) {
            mkdir($doc_path);
            chmod("$doc_path", 0755);
        }
        $this->load->library('upload');
        $temp_qd_filename = str_replace('_', '', $_FILES['document_for_service_sas']['name']);
        $drd_filename = 'sas_doc_' . (rand(100000, 999999)) . time() . '.' . pathinfo($temp_qd_filename, PATHINFO_EXTENSION);
        //Change file name
        $qd_final_path = $doc_path . DIRECTORY_SEPARATOR . $drd_filename;
        if (!move_uploaded_file($_FILES['document_for_service_sas']['tmp_name'], $qd_final_path)) {
            echo json_encode(array('success' => FALSE, 'message' => DOCUMENT_NOT_UPLOAD_MESSAGE));
            return;
        }
        $this->db->trans_start();
        $service_data = array();
        if (!$service_id || $service_id == NULL) {
            if (is_dept_user()) {
                $service_data['district'] = get_from_session('temp_district_for_sss_admin');
                $service_data['department_id'] = get_from_session('temp_dept_for_sss_admin');
            }
            $service_data['user_id'] = $session_user_id;
            $service_data['created_by'] = $session_user_id;
            $service_data['created_time'] = date('Y-m-d H:i:s');
            $service_id = $this->utility_model->insert_data('service', $service_data);
        }

        $sas_doc_data = array();
        $sas_doc_data['document'] = $drd_filename;
        if (!$service_sas_doc_id || $service_sas_doc_id == NULL) {
            $sas_doc_data['service_id'] = $service_id;
            $sas_doc_data['created_by'] = $session_user_id;
            $sas_doc_data['created_time'] = date('Y-m-d H:i:s');
            $service_sas_doc_id = $this->utility_model->insert_data('service_sas_doc', $sas_doc_data);
        } else {
            $sas_doc_data['updated_by'] = $session_user_id;
            $sas_doc_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('service_sas_doc_id', $service_sas_doc_id, 'service_sas_doc', $sas_doc_data);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('success' => FALSE, 'message' => DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = array();
        $success_array['service_id'] = $service_id;
        $success_array['service_sas_doc_id'] = $service_sas_doc_id;
        $success_array['document_name'] = $drd_filename;
        echo json_encode($success_array);
    }

    function remove_sas_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_sas_doc_id = get_from_post('service_sas_doc_id');
        if ($session_user_id == NULL || !$session_user_id || !$service_sas_doc_id || $service_sas_doc_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $ex_data = $this->utility_model->get_by_id('service_sas_doc_id', $service_sas_doc_id, 'service_sas_doc');
        if (empty($ex_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if ($ex_data['document'] != '') {
            $file_path = 'documents' . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR .
                    'sas_doc' . DIRECTORY_SEPARATOR . $ex_data['document'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $update_data = array();
        $update_data['document'] = '';
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->utility_model->update_data('service_sas_doc_id', $service_sas_doc_id, 'service_sas_doc', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DOCUMENT_REMOVED_MESSAGE;
        echo json_encode($success_array);
    }

    function remove_sas_document_item() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_sas_doc_id = get_from_post('service_sas_doc_id');
        if ($session_user_id == NULL || !$session_user_id || !$service_sas_doc_id || $service_sas_doc_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $ex_data = $this->utility_model->get_by_id('service_sas_doc_id', $service_sas_doc_id, 'service_sas_doc');
        if (empty($ex_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if ($ex_data['document'] != '') {
            $file_path = 'documents' . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR .
                    'sas_doc' . DIRECTORY_SEPARATOR . $ex_data['document'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $update_data = array();
        $update_data['is_delete'] = IS_DELETE;
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->utility_model->update_data('service_sas_doc_id', $service_sas_doc_id, 'service_sas_doc', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DOCUMENT_ITEM_REMOVED_MESSAGE;
        echo json_encode($success_array);
    }

    function upload_req_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_id = get_from_post('service_id_for_service');
        $service_req_doc_id = get_from_post('service_req_doc_id_for_service_req');
        if ($session_user_id == NULL || !$session_user_id) {
            echo json_encode(array('success' => FALSE, 'message' => INVALID_ACCESS_MESSAGE));
            return false;
        }
        if ($_FILES['document_for_service_req']['name'] == '') {
            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_DOC_MESSAGE));
            return;
        }
        $doc_size = $_FILES['document_for_service_req']['size'];
        if ($doc_size == 0) {
            echo json_encode(array('success' => FALSE, 'message' => DOC_INVALID_SIZE_MESSAGE));
            return;
        }
        $maxsize = '104857600';
        if ($doc_size >= $maxsize) {
            echo json_encode(array('success' => FALSE, 'message' => UPLOAD_MAX_TEN_MB_MESSAGE));
            return;
        }
        $path = 'documents';
        if (!is_dir($path)) {
            mkdir($path);
            chmod("$path", 0755);
        }
        $main_path = $path . DIRECTORY_SEPARATOR . 'service';
        if (!is_dir($main_path)) {
            mkdir($main_path);
            chmod("$main_path", 0755);
        }
        $doc_path = $main_path . DIRECTORY_SEPARATOR . 'req_doc';
        if (!is_dir($doc_path)) {
            mkdir($doc_path);
            chmod("$doc_path", 0755);
        }
        $this->load->library('upload');
        $temp_qd_filename = str_replace('_', '', $_FILES['document_for_service_req']['name']);
        $drd_filename = 'req_doc_' . (rand(100000, 999999)) . time() . '.' . pathinfo($temp_qd_filename, PATHINFO_EXTENSION);
        //Change file name
        $qd_final_path = $doc_path . DIRECTORY_SEPARATOR . $drd_filename;
        if (!move_uploaded_file($_FILES['document_for_service_req']['tmp_name'], $qd_final_path)) {
            echo json_encode(array('success' => FALSE, 'message' => DOCUMENT_NOT_UPLOAD_MESSAGE));
            return;
        }
        $this->db->trans_start();
        $service_data = array();
        if (!$service_id || $service_id == NULL) {
            if (is_dept_user()) {
                $service_data['district'] = get_from_session('temp_district_for_sss_admin');
                $service_data['department_id'] = get_from_session('temp_dept_for_sss_admin');
            }
            $service_data['user_id'] = $session_user_id;
            $service_data['created_by'] = $session_user_id;
            $service_data['created_time'] = date('Y-m-d H:i:s');
            $service_id = $this->utility_model->insert_data('service', $service_data);
        }

        $req_doc_data = array();
        $req_doc_data['document'] = $drd_filename;
        if (!$service_req_doc_id || $service_req_doc_id == NULL) {
            $req_doc_data['service_id'] = $service_id;
            $req_doc_data['created_by'] = $session_user_id;
            $req_doc_data['created_time'] = date('Y-m-d H:i:s');
            $service_req_doc_id = $this->utility_model->insert_data('service_req_doc', $req_doc_data);
        } else {
            $req_doc_data['updated_by'] = $session_user_id;
            $req_doc_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('service_req_doc_id', $service_req_doc_id, 'service_req_doc', $req_doc_data);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('success' => FALSE, 'message' => DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = array();
        $success_array['service_id'] = $service_id;
        $success_array['service_req_doc_id'] = $service_req_doc_id;
        $success_array['document_name'] = $drd_filename;
        echo json_encode($success_array);
    }

    function remove_req_document() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_req_doc_id = get_from_post('service_req_doc_id');
        if ($session_user_id == NULL || !$session_user_id || !$service_req_doc_id || $service_req_doc_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $ex_data = $this->utility_model->get_by_id('service_req_doc_id', $service_req_doc_id, 'service_req_doc');
        if (empty($ex_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if ($ex_data['document'] != '') {
            $file_path = 'documents' . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR .
                    'req_doc' . DIRECTORY_SEPARATOR . $ex_data['document'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $update_data = array();
        $update_data['document'] = '';
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->utility_model->update_data('service_req_doc_id', $service_req_doc_id, 'service_req_doc', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DOCUMENT_REMOVED_MESSAGE;
        echo json_encode($success_array);
    }

    function remove_req_document_item() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $service_req_doc_id = get_from_post('service_req_doc_id');
        if ($session_user_id == NULL || !$session_user_id || !$service_req_doc_id || $service_req_doc_id == NULL) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $ex_data = $this->utility_model->get_by_id('service_req_doc_id', $service_req_doc_id, 'service_req_doc');
        if (empty($ex_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return;
        }
        if ($ex_data['document'] != '') {
            $file_path = 'documents' . DIRECTORY_SEPARATOR . 'service' . DIRECTORY_SEPARATOR .
                    'req_doc' . DIRECTORY_SEPARATOR . $ex_data['document'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $update_data = array();
        $update_data['is_delete'] = IS_DELETE;
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $this->utility_model->update_data('service_req_doc_id', $service_req_doc_id, 'service_req_doc', $update_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = DOCUMENT_ITEM_REMOVED_MESSAGE;
        echo json_encode($success_array);
    }

    function get_service_data_by_id() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $module_type = get_from_post('module_type');
        if ($module_type != VALUE_ONE && $module_type != VALUE_TWO) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $service_id = get_from_post('service_id');
        if (!$service_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        if ($module_type == VALUE_ONE) {
            $service_data = $this->utility_model->get_by_id('service_id', $service_id, 'service');
        }
        if ($module_type == VALUE_TWO) {
            $service_data = $this->service_model->get_service_data_by_id($service_id);
        }
        if (empty($service_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();
        $service_data['sas_doc_data'] = $this->utility_model->get_result_data_by_id('service_id', $service_id, 'service_sas_doc');
        $service_data['req_doc_data'] = $this->utility_model->get_result_data_by_id('service_id', $service_id, 'service_req_doc');
        if ($module_type == VALUE_ONE) {
            $department_data = $this->utility_lib->get_department_data_by_district();
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['service_data'] = $service_data;
        if ($module_type == VALUE_ONE) {
            $success_array['department_data'] = $department_data;
        }
        echo json_encode($success_array);
    }

    function _get_post_data_for_service() {
        $service_data = array();
        if (is_admin()) {
            $service_data['district'] = get_from_post('district_for_service');
            $service_data['department_id'] = get_from_post('department_id_for_service');
        }
        $service_data['service_name'] = get_from_post('service_name_for_service');
        $service_data['designation'] = get_from_post('designation_for_service');
        $service_data['first_app_for_gr'] = get_from_post('first_app_for_gr_for_service');
        $service_data['second_app_for_gr'] = get_from_post('second_app_for_gr_for_service');
        $service_data['second_app_for_gr'] = get_from_post('second_app_for_gr_for_service');
        $service_data['declared_in'] = $this->input->post('declared_in_for_service');
        if (is_array($service_data['declared_in'])) {
            if (in_array(VALUE_FOUR, $service_data['declared_in']) || in_array(VALUE_FIVE, $service_data['declared_in'])) {
                $service_data['declared_in_remarks'] = get_from_post('declared_in_remarks_for_service');
            }
        } else if ($service_data['declared_in'] == VALUE_FOUR || $service_data['declared_in'] == VALUE_FIVE) {
            $service_data['declared_in_remarks'] = get_from_post('declared_in_remarks_for_service');
        }
        $service_data['delivery_type'] = get_from_post('delivery_type_for_service');
        $service_data['delivery_remarks'] = get_from_post('delivery_remarks_for_service');
        if ($service_data['delivery_type'] == VALUE_THREE || $service_data['delivery_type'] == VALUE_FOUR) {
            $service_data['service_url'] = get_from_post('service_url_for_service');
        }
        $service_data['days_as_per_cc'] = get_from_post('days_as_per_cc_for_service');
        $service_data['days_as_per_sss'] = get_from_post('days_as_per_sss_for_service');
        $service_data['ds_category'] = $this->input->post('ds_category_for_service');
        if (is_array($service_data['ds_category'])) {
            if (in_array(VALUE_THREE, $service_data['ds_category'])) {
                $service_data['ds_other_category'] = get_from_post('ds_other_category_for_service');
            }
        } else if ($service_data['ds_category'] == VALUE_THREE) {
            $service_data['ds_other_category'] = get_from_post('ds_other_category_for_service');
        }
        $service_data['is_delivery_fees'] = get_from_post('is_delivery_fees_for_service');
        $service_data['is_payment_to_applicant'] = get_from_post('is_payment_to_applicant_for_service');
        $service_data['remarks'] = get_from_post('remarks_for_service');
        return $service_data;
    }

    function _check_validation_for_service($module_type, $service_data) {
        if (is_admin()) {
            if (!$service_data['district']) {
                return DISTRICT_MESSAGE;
            }
            if (!$service_data['department_id']) {
                return ONE_OPTION_MESSAGE;
            }
        }
        if (!$service_data['service_name']) {
            return SERVICE_NAME_MESSAGE;
        }
        if ($module_type == VALUE_ONE) {
            return '';
        }
        if (!$service_data['designation']) {
            return DESIGNATION_MESSAGE;
        }
        if (is_array($service_data['declared_in'])) {
            if (in_array(VALUE_FOUR, $service_data['declared_in']) || in_array(VALUE_FIVE, $service_data['declared_in'])) {
                if (!$service_data['declared_in_remarks']) {
                    return REMARKS_MESSAGE;
                }
            }
        } else if ($service_data['declared_in'] == VALUE_FOUR || $service_data['declared_in'] == VALUE_FIVE) {
            if (!$service_data['declared_in_remarks']) {
                return REMARKS_MESSAGE;
            }
        }
        if (!$service_data['delivery_type']) {
            return ONE_OPTION_MESSAGE;
        }
        if ($service_data['delivery_type'] == VALUE_THREE || $service_data['delivery_type'] == VALUE_FOUR) {
            if (!$service_data['service_url']) {
                return SERVICE_DELIVERY_URL_MESSAGE;
            }
        }
        if (!$service_data['ds_category']) {
            return ONE_OPTION_MESSAGE;
        }
        if (is_array($service_data['ds_category'])) {
            if (in_array(VALUE_THREE, $service_data['ds_category'])) {
                if (!$service_data['ds_other_category']) {
                    return OTHER_DS_CATEGORY_MESSAGE;
                }
            }
        } else if ($service_data['ds_category'] == VALUE_THREE) {
            if (!$service_data['ds_other_category']) {
                return OTHER_DS_CATEGORY_MESSAGE;
            }
        }
        if (!$service_data['is_delivery_fees']) {
            return ONE_OPTION_MESSAGE;
        }
        return '';
    }

    function submit_service_details() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $module_type = get_from_post('module_type');
        if ($module_type != VALUE_ONE && $module_type != VALUE_TWO) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $service_id = get_from_post('service_id_for_service');
        $service_data = $this->_get_post_data_for_service();
        $validation_message = $this->_check_validation_for_service($module_type, $service_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
        if ($service_data['is_delivery_fees'] == VALUE_ONE) {
            $dfd = $this->input->post('delivery_fees_details');
            $tdf = get_from_post('total_delivery_fees');
            if ($module_type != VALUE_ONE && empty($dfd)) {
                echo json_encode(get_error_array(ONE_FEES_MESSAGE));
                return false;
            }
            $service_data['delivery_fees_details'] = empty($dfd) ? '' : json_encode($dfd);
            $service_data['total_delivery_fees'] = $tdf;
        }
        if ($service_data['is_payment_to_applicant'] == VALUE_ONE) {
            $service_data['applicant_payment_type'] = get_from_post('applicant_payment_type_for_service');
            if (!$service_data['applicant_payment_type']) {
                echo json_encode(get_error_array(ONE_OPTION_MESSAGE));
                return false;
            }
            $apd = $this->input->post('applicant_payment_details');
            $tap = get_from_post('total_applicant_payment');
            if ($module_type != VALUE_ONE && empty($apd)) {
                echo json_encode(get_error_array(ONE_PAYMENT_MESSAGE));
                return false;
            }
            $service_data['applicant_payment_details'] = empty($apd) ? '' : json_encode($apd);
            $service_data['total_applicant_payment'] = $tap;
        }
        $new_sasd_items = $this->input->post('new_sasd_items');
        $exi_sasd_items = $this->input->post('exi_sasd_items');
        $new_reqd_items = $this->input->post('new_reqd_items');
        $exi_reqd_items = $this->input->post('exi_reqd_items');
        if ($module_type == VALUE_TWO) {
            if (empty($exi_reqd_items) && empty($new_reqd_items)) {
                echo json_encode(get_error_array(ONE_DOC_REQ_MESSAGE));
                return false;
            }
        }
        if (is_array($service_data['declared_in'])) {
            $service_data['declared_in'] = implode(',', $service_data['declared_in']);
        }
        if (is_array($service_data['ds_category'])) {
            $service_data['ds_category'] = implode(',', $service_data['ds_category']);
        }
        $this->db->trans_start();
        $service_data['status'] = $module_type == VALUE_ONE ? VALUE_ZERO : VALUE_ONE;
        if ($module_type == VALUE_TWO) {
            $service_data['submitted_datetime'] = date('Y-m-d H:i:s');
        }
        if (!$service_id || $service_id == NULL) {
            if (is_dept_user()) {
                $service_data['district'] = get_from_session('temp_district_for_sss_admin');
                $service_data['department_id'] = get_from_session('temp_dept_for_sss_admin');
            }
            $service_data['user_id'] = $session_user_id;
            $service_data['created_by'] = $session_user_id;
            $service_data['created_time'] = date('Y-m-d H:i:s');
            $service_id = $this->utility_model->insert_data('service', $service_data);
        } else {
            $service_data['updated_by'] = $session_user_id;
            $service_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('service_id', $service_id, 'service', $service_data);
        }
        $this->_update_doc_items('sas', $session_user_id, $service_id, $exi_sasd_items, $new_sasd_items);
        $this->_update_doc_items('req', $session_user_id, $service_id, $exi_reqd_items, $new_reqd_items);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = $module_type == VALUE_ONE ? SERVICE_DRAFT_MESSAGE : SERVICE_SUBMITTED_MESSAGE;
        echo json_encode($success_array);
    }

    function _update_doc_items($module_type, $session_user_id, $service_id, $exi_items, $new_items) {
        if ($exi_items != '') {
            if (!empty($exi_items)) {
                foreach ($exi_items as &$value) {
                    $value['service_id'] = $service_id;
                    $value['updated_by'] = $session_user_id;
                    $value['updated_time'] = date('Y-m-d H:i:s');
                }
                $this->utility_model->update_data_batch('service_' . $module_type . '_doc_id', 'service_' . $module_type . '_doc', $exi_items);
            }
        }
        if ($new_items != '') {
            if (!empty($new_items)) {
                foreach ($new_items as &$value) {
                    $value['service_id'] = $service_id;
                    $value['created_by'] = $session_user_id;
                    $value['created_time'] = date('Y-m-d H:i:s');
                    $this->utility_model->insert_data('service_' . $module_type . '_doc', $value);
                }
            }
        }
    }

}

/*
 * EOF: ./application/controller/Service.php
 */