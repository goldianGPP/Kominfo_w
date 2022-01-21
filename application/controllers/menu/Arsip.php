<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {


    public function __construct() 
    {
        parent::__construct();
        $this->load->model('ModelArsip', 'ma');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(){
        $data = [
            "data" => $this->getFile(),
        ];
        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/arsip/ly_ubah', $data);
        $this->load->view('layout/arsip/ly_arsip', $data);
        $this->load->view('contents/footer_content');
    }

    public function getFile(){
        $res = $this->ma->getFile();
        return $res;
    }

    public function updateFile(){
        $data = [
            'id_file' => $this->input->post('id_file'),
            'nama' => $this->input->post('nama'),
            'tipe' => $this->input->post('tipe'),
            'tgl_ubah' => date('Y-m-d', strtotime('+2 hours'))
        ];
        if($this->ma->updateFile($data) > 0)
            $this->session->set_userdata('isSuccess', true);

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function deleteFile(){
        $id_file = $this->input->post('id_file');
        $path = $this->input->post('path');

        if($this->ma->deleteFile($id_file) > 0){
            unlink('./'.$path);
            $this->session->set_userdata('isSuccess', true);
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}


