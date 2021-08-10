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
            $this->load->model('ModelUploadFile', 'file');
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
            $res->password = $this->post('password');
            $this->response( $res , RestController::HTTP_OK);
        }

        public function register_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'nama' => $this->post('nama'),
                'password' => password_hash($this->put('password'),PASSWORD_DEFAULT)
            ];

            if ($this->user->registerUser($data) > 0)
                $this->response( $data , 200);
            else
                $this->response( [] , 400);
        }

        public function index_put(){
            $id_pengguna = $this->put('id_pengguna');
            $data = [
                'username' => $this->put('username'),
                'nama' => $this->put('nama')
            ];
            if ($this->user->updateUser($id_pengguna, $data) > 0) 
                $this->response( $data , 200);
            else
                $this->response( [] , 400);

        }

        public function password_put(){
            $id_pengguna = $this->put('id_pengguna');
            $password = $this->put('password');
            $data = [
                'password' => password_hash($password,PASSWORD_DEFAULT)
            ];
            
            if ($this->user->updateUserPassword($id_pengguna, $data) > 0) {
                $data->password = $this->post('password');
                $this->response( $data , 200);
            }
            else
                $this->response( [] , 400);
        }

        public function image_post(){
	        $this->response( $this->file->upload($this->input->post('id_pengguna', TRUE),"user") , RestController::HTTP_OK);
        }

        public function index_delete(){
            $data = $this->post('id_user');

            if ($this->user->editUser($data) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
            $this->response( $data , RestController::HTTP_OK);
        }
    }
?>