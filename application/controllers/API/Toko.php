<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;
    class Toko extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelToko', 'toko');
            $this->load->model('ModelUploadFile', 'file');
        }

        public function index_get(){
            $this->toko->getToko();
        }

        public function index_post(){
            $data = [
                'id_pengguna' => $this->input->post('id_pengguna', TRUE),
                'nama_toko' => $this->input->post('nama_toko', TRUE),
                'latitude' => $this->input->post('latitude', TRUE),
                'longitude' => $this->input->post('longitude', TRUE),
                'alamat_toko' => $this->input->post('alamat_toko', TRUE)
            ];
            if($this->file->uploads($data['nama_toko'],"toko",$_FILES))
                $this->toko->createToko($data);

            $res = $this->toko->getId($data);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_put(){
            $id_toko = $this->put('id_toko');
            $data = [
                'latitude' => $this->put('latitude'),
                'longitude' => $this->put('longitude'),
                'alamat_toko' => $this->put('alamat_toko')
            ];

            $res = $this->toko->updateAlamat($id_toko, $data); 
            $this->response( $res , RestController::HTTP_OK);
        }
    }
?>