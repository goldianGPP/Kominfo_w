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
            $this->load->model('ModelUser', 'user');
        }

        public function index_get($username = null,$password = null){
            $res = $this->user->getUser(); 
            $this->response( $res , RestController::HTTP_OK);
        }

        public function login_post(){
            $data = [
                'username' => $this->post('username'),
                'password' => $this->post('password'),
            ];

            $res = $this->user->loginUser($data);
            if ($res == null)
                $this->response( $res , RestController::HTTP_BAD_REQUEST);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function register_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => password_hash($this->put('password'),PASSWORD_DEFAULT)
            ];

            $data = $this->user->registerUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_put(){
            $id_pengguna = $this->put('id_pengguna');
            $data = [
                'username' => $this->put('username'),
                'phone' => $this->put('phone'),
                'password' => password_hash($this->put('password'),PASSWORD_DEFAULT)
            ];

            $res = $this->user->updateUser($id_pengguna, $data); 
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_delete(){
            $data = $this->post('id_user');
            $data = $this->user->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }
    }
?>