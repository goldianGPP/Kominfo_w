<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

use chriskacerguis\RestServer\RestController;
    class Absen extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelAbsen', 'ma');
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
        }

        public function index_get($id = null,$date = null){
            $res = $this->ma->getAbsen($id,$date);
            if($res != null)
                $this->response( $res , 200);
            else
                $this->response( [] , 400);
        }

        public function data_get($year=null,$month=null){
            $res = $this->ma->getAbsensi($year,$month);
            if($res != null)
                $this->response( $res , 200);
            else
                $this->response( [] , 400);
        }
        

        public function index_post(){
            $data = [
                'id_pengguna' => $this->post('id_pengguna'),
                'tgl_presensi' => date('Y-m-d', strtotime('+2 hours')),
            ];
            if ($this->ma->checkAbsen($data)) {
                if ($this->ma->postAbsen($data) > 0)
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
        }

        public function index_delete(){
            $id_absen = $this->post('id_absen');

            if ($this->ma->deleteAbsen($id_absen) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }
    }
?>