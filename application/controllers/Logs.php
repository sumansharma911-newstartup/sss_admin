<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

    function __construct() {
        parent::__construct();
        check_authenticated();
        $this->load->model('logs_model');
    }

    function get_admin_login_logs_data() {
        $user_id = get_from_session('temp_id_for_sss_admin');
        $success_array = get_success_array();
        $success_array['admin_login_data'] = array();
        if ($user_id == NULL || !$user_id) {
            echo json_encode($success_array);
            return false;
        }
        $this->db->trans_start();
        $success_array['admin_login_data'] = $this->logs_model->get_admin_login_logs();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $success_array['admin_login_data'] = array();
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

}

/*
 * EOF: ./application/controller/Logs.php
 */