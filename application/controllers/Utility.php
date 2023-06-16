<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('utility_model');
    }

    function generate_new_token() {
        if (!is_post()) {
            echo json_encode(get_error_array(INVALID_ACCESS_MESSAGE));
            return false;
        }
        echo json_encode(get_success_array());
    }

    function get_common_data() {
        $success_array = get_success_array();
        $this->db->trans_start();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode($success_array);
            return;
        }
        echo json_encode($success_array);
    }

}

/*
     * EOF: ./application/controller/Utility.php
     */    