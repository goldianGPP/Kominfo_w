<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class Lokasi extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelLokasi', 'lokasi');
        }

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function index_get(){
            $res = $this->lokasi->getLokasi();
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => $this->post('password'),
            ];

            $data = $this->lokasi->createUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_put(){
            $data = [
                'id_user' => $this->put('id_user'),
                'username' => $this->put('username'),
                'email' => $this->put('email'),
                'phone' => $this->put('phone'),
                'password' => $this->put('password'),
            ];

            $data = $this->lokasi->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function delete_put(){
            $data = $this->put('id_user');
            $data = $this->lokasi->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }
    }
?>