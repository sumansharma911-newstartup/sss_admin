<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Ticket_raise_model extends CI_Model {

        function get_all_ticketraise_data($session_user_id='',$search_district = '') {
            if (is_dept_user()) {  

            $this->db->select('u.*,a.*,t.*');
            $this->db->where('t.is_delete !=' . IS_DELETE);
            $this->db->where('a.sa_user_id =' . $session_user_id);
            $this->db->from('ticket_raise AS t'); 
            $this->db->join('assigned_employee AS a', 't.ticketraise_id=a.ticketraise_id','LEFT');
            $this->db->where('a.work_status =' . 1);
            $this->db->join('sa_users AS u', 'a.sa_user_id=u.sa_user_id','LEFT');
            $this->db->order_by('t.ticketraise_id', 'DESC');
            $resc = $this->db->get();
            return $resc->result_array();
            }
            else {
                    $this->db->select('u.*,t.*');
                    $this->db->where('t.is_delete !=' . IS_DELETE);
                    $this->db->where('t.status !=', 0);
                    $this->db->from('ticket_raise AS t');  
                   // $this->db->join('assigned_employee AS a', 't.ticketraise_id=a.ticketraise_id','LEFT');
                    $this->db->join('sa_users AS u', 't.sa_user_id=u.sa_user_id','LEFT');
                    $this->db->order_by('t.ticketraise_id', 'DESC');
                    $resc = $this->db->get();
                    return $resc->result_array();                    
            }
        }
     
    function get_ticketraise_data_by_id($ticketraise_id){
        $this->db->select('t.*');
        $this->db->where('t.ticketraise_id', $ticketraise_id);
        $this->db->where('t.is_delete !=' . IS_DELETE);
        $this->db->from('ticket_raise AS t');  
        //$this->db->join('assigned_employee AS a', 't.ticketraise_id=a.ticketraise_id');
        //$this->db->join('sa_users AS u', 'a.sa_user_id=u.sa_user_id','LEFT');
        $this->db->order_by('t.ticketraise_id', 'DESC');
        $resc = $this->db->get();
        return $resc->row_array();
    }

    function get_all_user_type_list($ticketraise_id,$sa_user_id=array()) {
         $this->db->select('s.*');
         $this->db->from('sa_users AS s');
         $this->db->where('s.is_delete !='. IS_DELETE);
         if(!empty($sa_user_id)){
            $this->db->where_not_in('s.sa_user_id', $sa_user_id);
         }                  
         $resc = $this->db->get();
        // print_r($this->db->last_query());
         return $resc->result_array();
    }

    function update_user_status($ticketraise_id){
        $this->db->set('status',3);
        $this->db->where('ticketraise_id', $ticketraise_id);
        $this->db->update('ticket_raise');
        return $this->db->affected_rows();    
    }

    function update_user_reject_status($ticketraise_id){
        $this->db->set('status',4);
        $this->db->where('ticketraise_id', $ticketraise_id);
        $this->db->update('ticket_raise');
        return $this->db->affected_rows();    
    }

    function employee_forward_status($ticketraise_id){
        $this->db->set('status',2);
        $this->db->where('ticketraise_id', $ticketraise_id);
        $this->db->update('ticket_raise');
        return $this->db->affected_rows();    
    }

    function update_work_status($sa_user_id,$ticketraise_id){
        $this->db->set('work_status',0);
        $this->db->set('sa_user_id_update',0);
        $this->db->where('ticketraise_id', $ticketraise_id);
        $this->db->where('sa_user_id', $sa_user_id);
        $this->db->update('assigned_employee');
        return $this->db->affected_rows();    
    }

    function user_pending_status($ticketraise_id){
        //$this->db->set('status',1);
        $this->db->set('sa_user_id',0);
        $this->db->where('ticketraise_id', $ticketraise_id);
        $this->db->update('ticket_raise');
        return $this->db->affected_rows();    
    }

    function get_assigned_employeedata($ticketraise_id) {
        $this->db->select('t.status AS status,a.*,u.name AS sa_user_name,a.sa_user_id_update AS emp_user_id');
        $this->db->where('a.ticketraise_id', $ticketraise_id);
        $this->db->where('a.is_delete !=' . IS_DELETE);
        //  $this->db->where('a.sa_user_id_update !=',0);
        $this->db->from('assigned_employee AS a');
        $this->db->join('sa_users AS u', 'a.sa_user_id = u.sa_user_id','LEFT');
        $this->db->join('ticket_raise AS t', 'a.ticketraise_id = t.ticketraise_id','LEFT');
        $this->db->order_by('a.assignedemployee_id', 'DESC');
        $resc = $this->db->get();
        // print_r($this->db->last_query());

        return $resc->result_array();
    }
}


//get_assigned_employeedata this function change sa_user_id to sa_user_id_update