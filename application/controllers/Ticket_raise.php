<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_raise extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ticket_raise_model');
        $this->load->model('utility_model');
        $this->load->model('user_model');        
    }    

    function get_ticketraise_data() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['ticketraise_data'] = array();
        if ($session_user_id == NULL || !$session_user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['ticketraise_data'] = $this->ticket_raise_model->get_all_ticketraise_data($session_user_id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['ticketraise_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

    function get_ticketraise_data_by_id() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $ticketraise_id = get_from_post('ticketraise_id');
        
        if (!$ticketraise_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        // $ex_ticketraise_data = $this->utility_model->get_by_id('ticketraise_id', $ticketraise_id, 'assigned_employee','work_status',VALUE_ONE); 
        $ex_ticketraise_data = array();
        $ex_ticketraise_data = $this->ticket_raise_model->get_assigned_employeedata($ticketraise_id);
       // print_r($ex_ticketraise_data);
        $ex_user_id = array();
        foreach($ex_ticketraise_data as $value){
        $ids = $value['emp_user_id'];
        array_push($ex_user_id, $ids);
         }



        $ticketraise_data = $this->ticket_raise_model->get_ticketraise_data_by_id($ticketraise_id);   
    
        if (empty($ticketraise_data)) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $this->db->trans_start();

        $ticketraise_data['tr_doc_data'] = $this->utility_model->get_result_data_by_id('ticketraise_id', $ticketraise_id, 'ticket_raise_doc');
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }

        $success_array = get_success_array();
        $name = '';
        // $sauserid = '';
        // $assign_date = '';
        // $work_status = '';
        if(!empty($ex_ticketraise_data) ){
            $success_array['name'] = $this->ticket_raise_model->get_all_user_type_list($ticketraise_id,$ex_user_id);
           // print_r($success_array['name']);
            // $assigneduser_data = $this->utility_model->get_by_id('sa_user_id', $ex_ticketraise_data['sa_user_id'], 'sa_users');
            // $name = $assigneduser_data['name'];
            // $sauserid = $assigneduser_data['sa_user_id'];
            // $assign_date = $ex_ticketraise_data['date'];
            //  $work_status = $ex_ticketraise_data['work_status'];

        }
        else {
            $success_array['name'] = $this->ticket_raise_model->get_all_user_type_list($ticketraise_id);
           // print_r($success_array['name']);
        }

        // print_r($success_array['name']);
        
        $success_array['ticketraise_data'] = $ticketraise_data;
        // $success_array['assigneduserid'] = $sauserid;
        //  $success_array['work_status'] = $work_status;        
         $success_array['assignedusername'] = $name;        
        // $success_array['assigneddate'] = $assign_date;
        $success_array['assigned_users'] = $ex_ticketraise_data;
        echo json_encode($success_array);
    }

    function _get_post_data_for_assignuserdata() {
        $assignuser_data = array();
        $assignuser_data['sa_user_id'] = get_from_post('username_for_ticketraise');
        $assignuser_data['ticketraise_id'] = get_from_post('ticketraise_id_for_ticketraise');
        
        return $assignuser_data;
    }

    function _check_validation_for_assignuserdata($assigneduser_data) {
    
        if (!$assigneduser_data['sa_user_id']) {
            return SELECT_Employee_TYPE_MESSAGE;
        }       
        
        return '';
    }

    function assignuserstatus() {
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $sa_user_id = get_from_post('sa_user_id');
        $ticketraise_id = get_from_post('ticketraise_id');
        
        if (!$sa_user_id || !$ticketraise_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }     
        
        $update_data = array();
        $update_data['is_delete'] = IS_DELETE;
        $update_data['updated_by'] = $session_user_id;
        $update_data['updated_time'] = date('Y-m-d H:i:s');
        $ticketraise_data = $this->ticket_raise_model->update_work_status($sa_user_id,$ticketraise_id);
        $ticketraise_data = $this->ticket_raise_model->user_pending_status($ticketraise_id);


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = EMPLOYEE_REMOVE;
        echo json_encode($success_array);
    }

    function submit_assignuser_details() {
       
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $ticketraise_id = get_from_post('ticketraise_id_for_ticketraise');

        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        $assigned_user_id = get_from_post('username_for_ticketraise');
        
        $assigneduser_data = $this->_get_post_data_for_assignuserdata();

        $validation_message = $this->_check_validation_for_assignuserdata($assigneduser_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }   
                
        $this->db->trans_start();
        if (!$assigned_user_id || $assigned_user_id != NULL) {
            
            //$assigneduser_data['ticketraise_id'] = get_from_session('temp_dept_for_sss_admin'); 
            $assigneduser_data['work_status'] = 1;           
            $assigneduser_data['date'] = date('Y-m-d H:i:s');
            $assigneduser_data['created_by'] = $session_user_id;
            $assigneduser_data['created_time'] = date('Y-m-d H:i:s');
            $assigneduser_data['sa_user_id_update']=$assigned_user_id;
            
            $this->utility_model->insert_data('assigned_employee', $assigneduser_data);

            $updateassigneduser_data['sa_user_id']=$assigned_user_id;
            $this->utility_model->update_data('ticketraise_id',$ticketraise_id,'ticket_raise', $updateassigneduser_data);            
            $ticketraise_data = $this->ticket_raise_model->employee_forward_status($ticketraise_id);
        }
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = ASSIGNEDUSER_SUBMITTED_MESSAGE;
        echo json_encode($success_array);      

    }

    function _get_post_data_for_ticketraise() {
        $ticketraise_data = array();
        $ticketraise_data['remark'] = get_from_post('remark_for_ticketraise');
                
        return $ticketraise_data;
    }

    function _check_validation_for_ticketraise($ticketraise_data) {

        if (!$ticketraise_data['remark']) {
            return REMARK_SUBMITTED_MESSAGE;
        }        
        return '';
    }

    function submit_ticketraiseremark_details() {
       
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $ticketraise_id = get_from_post('ticketraise_id_for_ticketraise');

        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }

        $ticketraise_data = $this->_get_post_data_for_ticketraise();

        $validation_message = $this->_check_validation_for_ticketraise($ticketraise_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
                
         $this->db->trans_start();        
        
         if (!$ticketraise_id || $ticketraise_id == NULL) {        
            $ticketraise_data['user_id'] = $session_user_id;
            $ticketraise_data['created_by'] = $session_user_id;
            $ticketraise_data['created_time'] = date('Y-m-d H:i:s');
            $ticketraise_id = $this->utility_model->insert_data('ticket_raise', $ticketraise_data);
         }
        else {
            $ticketraise_data['updated_by'] = $session_user_id;
            $ticketraise_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('ticketraise_id', $ticketraise_id, 'ticket_raise', $ticketraise_data);
            $ticketraise_data = $this->ticket_raise_model->update_user_status($ticketraise_id);
        }
       
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = QUERYDONE_SUBMITTED_MESSAGE;
        echo json_encode($success_array);       

    }

    

    function submit_ticketraisereject_details() {
       
        $session_user_id = get_from_session('temp_id_for_sss_admin');
        $ticketraise_id = get_from_post('ticketraise_id_for_ticketraise');

        if (!is_post() || $session_user_id == NULL || !$session_user_id) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }

        $ticketraise_data = $this->_get_post_data_for_ticketraise();

        $validation_message = $this->_check_validation_for_ticketraise($ticketraise_data);
        if ($validation_message != '') {
            echo json_encode(get_error_array($validation_message));
            return false;
        }
                
         $this->db->trans_start();        
        
         if (!$ticketraise_id || $ticketraise_id == NULL) {
        
            $ticketraise_data['user_id'] = $session_user_id;
            $ticketraise_data['created_by'] = $session_user_id;
            $ticketraise_data['created_time'] = date('Y-m-d H:i:s');
            $ticketraise_id = $this->utility_model->insert_data('ticket_raise', $ticketraise_data);
         }
        else {
            $ticketraise_data['updated_by'] = $session_user_id;
            $ticketraise_data['updated_time'] = date('Y-m-d H:i:s');
            $this->utility_model->update_data('ticketraise_id', $ticketraise_id, 'ticket_raise', $ticketraise_data);
            $ticketraise_data = $this->ticket_raise_model->update_user_reject_status($ticketraise_id);
        }
       
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(get_error_array(DATABASE_ERROR_MESSAGE));
            return;
        }
        $success_array = get_success_array();
        $success_array['message'] = QUERYREJECT_SUBMITTED_MESSAGE;
        echo json_encode($success_array);      
    }

}