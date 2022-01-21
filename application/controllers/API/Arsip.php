<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

use chriskacerguis\RestServer\RestController;
    class Arsip extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelArsip', 'ma');
            $this->load->model('ModelUploadFile', 'file');
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
        }

        public function index_get(){
            $res = $this->ma->getFile();
            if($res != null)
                $this->response( $res , 200);
            else
                $this->response( [] , 400);
        }
        

        public function index_post(){
            $nama = $this->input->post('nama', TRUE);
            $dir = "file/";
            $image = $this->file->upload($dir,$nama.'.pdf');

            if ($image != ""){
                $data = [
                    'id_pengguna' => $this->input->post('id_pengguna', TRUE),
                    'nama' => $nama,
                    'tipe' => $this->input->post('tipe', TRUE),
                    'path' => 'images/'.$dir.$image,
                    'tgl_masuk' => date('Y-m-d', strtotime('+2 hours'))
                ];

                $this->ma->postFile($data);
                unlink('./'.$this->input->post('image', TRUE));
                $this->response( true , 200);
            }
            else
                $this->response( false , 400);
        }
    }
?>