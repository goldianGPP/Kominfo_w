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

        public function upload_post(){
            $name =  $this->input->post('name', TRUE);
            $res = $this->file->upload($name,$_FILES);

            $this->response( $_FILES , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'id_pengguna' => $this->post('id_pengguna'),
                'nama_toko' => $this->post('nama_toko'),
                'latitude' => $this->post('latitude'),
                'longitude' => $this->post('longitude'),
                'alamat_toko' => $this->post('alamat_toko')
            ];
            
            $res = $this->toko->createToko($data);
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