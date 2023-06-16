<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
        check_authenticated();
    }

    public function index() {
        $this->load->view('common/header');
        $this->load->view('main/main');
        $this->load->view('common/footer');
        $this->load->view('common/backbone_footer');
    }

}

/*
     * EOF: ./application/controller/Main.php
     */    