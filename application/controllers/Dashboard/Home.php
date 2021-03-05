<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


    public function index(){
        $this->load->helper('url');
        $this->load->view('Dashboard/Parts/Contents/Content');
        $this->load->view('Dashboard/Parts/Header');
        $this->load->view('Dashboard/HomeView');
        $this->load->view('Dashboard/Parts/Footer');
    }
}


