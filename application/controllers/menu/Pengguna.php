<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {


    public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('ModelPengguna', 'mp');
        $this->load->model('ModelGolongan', 'mg');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function add(){
        $data = [
            "golongan" => $this->getGolongan(),
        ];
        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/pengguna/ly_tambah', $data);
        $this->load->view('contents/footer_content');
    }

    public function get(){
        $data = [
            "data" => $this->getAllPengguna(),
            "golongan" => $this->getGolongan(),
        ];
        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/pengguna/ly_tampil', $data);
        $this->load->view('layout/pengguna/ly_ubah', $data);
        $this->load->view('contents/footer_content');
    }

    public function postPengguna(){
        $data = [
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'id_golongan' => $this->input->post('golongan'),
            'nip' => $this->input->post('nip'),
            // 'nip' => password_hash($this->input->post('nip'),PASSWORD_DEFAULT),
        ];
        if($this->mp->postPengguna($data) > 0)
        $this->session->set_userdata('isSuccess', true);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updatePengguna(){
        $id_pengguna = $this->input->post('id_pengguna');
        $data = [
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'id_golongan' => $this->input->post('golongan'),
            'nip' => $this->input->post('nip'),
            // 'nip' => password_hash($this->input->post('nip'),PASSWORD_DEFAULT),
        ];
        if($this->mp->updatePengguna($id_pengguna, $data) > 0)
            $this->session->set_userdata('isSuccess', true);
            
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function deletePengguna(){
        $id_pengguna = $this->input->post('id_pengguna');
        if($this->mp->deletePengguna($id_pengguna) > 0)
            $this->session->set_userdata('isSuccess', true);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getAllPengguna(){
        $res = $this->mp->getAllPengguna();
        return $res;
    }

    public function getGolongan(){
        $res = $this->mg->getGolongan();
        return $res;
    }
}


