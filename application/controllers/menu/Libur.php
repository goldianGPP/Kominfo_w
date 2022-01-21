<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Libur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelAbsen', 'ma');
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
        return $this->ma->getLibur();
    }

    public function postLibur() {
        $data = [
            'tgl_presensi' => $this->input->post('tgl_presensi'),
            'status' => 'libur',
        ];

        $this->ma->postAbsen($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updateLibur() {
        $data = [
            'id_absen' => $this->input->post('id_absen'),
            'tgl_presensi' => $this->input->post('tgl_presensi'),
            'status' => 'libur',
        ];
        
        $this->ma->updateAbsen($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function deleteLibur() {
        $data = [
            'id_absen' => $this->input->post('id_absen'),
            'tgl_presensi' => $this->input->post('tgl_presensi'),
        ];
        $this->ma->deleteAbsen($data);
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
