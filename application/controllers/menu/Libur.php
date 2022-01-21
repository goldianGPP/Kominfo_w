<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Libur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelDetailTgl', 'mdt');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data = [
            "data" => $this->getLibur(),
            'dayname' => $this->dayName(),
        ];

        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/libur/ly_libur', $data);
        $this->load->view('layout/libur/ly_ubah', $data);
        $this->load->view('contents/footer_content');
    }

    public function getLibur() {
        return $this->mdt->getLibur();
    }

    public function postLibur() {
        $data = [
            'tgl_libur' => $this->input->post('tgl_libur'),
            'deskripsi' => $this->input->post('deskripsi'),
        ];

        $this->mdt->postLibur($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updateLibur() {
        $data = [
            'id_detail' => $this->input->post('id_detail'),
            'tgl_libur' => $this->input->post('tgl_libur'),
            'deskripsi' => $this->input->post('deskripsi'),
        ];
        
        $this->mdt->updateLibur($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function deleteLibur() {
        $data = [
            'id_detail' => $this->input->post('id_detail'),
            'tgl_libur' => $this->input->post('tgl_libur'),
        ];
        $this->mdt->deleteLibur($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function dayName()
    {
        return [
            'senin',
            'selasa',
            'rabu',
            'kamis',
            'jumat',
        ];
    }
}
