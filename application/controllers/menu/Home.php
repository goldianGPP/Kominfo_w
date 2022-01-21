<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelAbsen', 'ma');
        $this->load->model('ModelPengguna', 'mp');
        $this->load->helper('date');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/ly_home', $this->getAbsen());
        $this->load->view('contents/footer_content');
    }

    public function print()
    {
        $this->load->view('contents/header_content');
        $this->load->view('layout/absen/ly_print', $this->getAbsen());
    }

    public function update($id_pengguna = null)
    {

        $this->load->view('contents/header_content');
        $this->load->view('layout/ly_navbar');
        $this->load->view('layout/ly_sidebar');
        $this->load->view('layout/absen/ly_ubah', $this->getAbsen2($id_pengguna));
        $this->load->view('contents/footer_content');
    }

    //////////////////////////////////////////////////
    public function getAbsen2($id_pengguna = null)
    {
        $year = date('Y', strtotime('+2 hours'));
        $month = date('m', strtotime('+2 hours'));

        $penggunas = $this->mp->getAllPengguna();

        if ($id_pengguna == null)
            $absens = null;
        else
            $absens = $this->ma->getAbsen2($id_pengguna, $year, $month);

        // print_r($absens); die;

        return [
            'year' => $year,
            'month' => $month,
            'monthname' => $this->getMonthName($month - 1),
            'dayname' => $this->dayName(),
            'days' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
            'absens' => $absens,
            'penggunas' => $penggunas,
            'index' => 0,
            'id_pengguna' => $id_pengguna,
        ];
    }

    public function getAbsen()
    {
        $year = date('Y');
        $month = date('m');
        $date = date('Y-m-d', strtotime('+2 hours'));

        $absen = $this->ma->getTable();
        $pengguna = $this->mp->getAllPengguna();


        return [
            'date' => $date,
            'year' => $year,
            'month' => $month,
            'monthname' => $this->getMonthName($month - 1),
            'days' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
            'absens' => $absen,
            'penggunas' => $pengguna,
        ];
    }

    public function change($id_pengguna)
    {
        $isUpdate = $this->input->post('isUpdate');
        $status = $this->input->post('status');
        $data = [
            'id_pengguna' => $id_pengguna,
            'id_absen' => $this->input->post('id_absen'),
            'status' => $status,
            'tgl_presensi' => $this->input->post('tgl_presensi'),
        ];

        if ($isUpdate) {
            if ($status == 'alpa')
                $this->ma->deleteAbsen($data);
            else
                $this->ma->updateAbsen($data);
        } 
        else{
            if ($status != 'alpa')
                $this->ma->postAbsen($data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getMonthName($month)
    {
        $monthnames = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        return strtoupper($monthnames[$month]);
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
