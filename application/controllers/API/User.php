<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;
    class User extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('UserModel', 'user');
            $this->load->library()
            $this->load->dbforge();
            $this->load->helper('string');
        }

        public function index_get($username = null,$password = null){
            $res = $this->user->getUser(); 
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => $this->post('password'),
            ];

            $data = $this->user->createUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_put(){
            $data = [
                'id_user' => $this->post('id_user'),
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => $this->post('password'),
            ];

            $data = $this->user->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_delete(){
            $data = $this->post('id_user');
            $data = $this->user->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }


    }


?>