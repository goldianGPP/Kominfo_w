<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class CtrlRecomender extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('UserBased', 'ub');
            $this->load->model('ItemBased', 'ib');
        }

        public function index_get($username = null,$password = null){
            $res = $this->ub->getUser(); 
            $this->response( $res , RestController::HTTP_OK);
        }

        //-----------------------------------------------------------------------------------------------
        // get recomendation for items
        // mangambil rekomendasi dari items

        public function userbased_get($id_pengguna=null, $jenis=null){
            $type=array("joran","kail","benang", null);
            $res = $this->ub->getRecommendations("id_pengguna-".$id_pengguna, $jenis);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function itembased_get($id_pengguna=null, $jenis=null, $id_item=null){
            $res = $this->ib->getRecommendations("id_pengguna-".$id_pengguna, $jenis, $id_item);
            $this->response( $res , RestController::HTTP_OK);
        }

        //-----------------------------------------------------------------------------------------------

        public function index_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => $this->post('password'),
            ];

            $data = $this->ub->createUser($data); 
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

            $data = $this->ub->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_delete(){
            $data = $this->post('id_user');
            $data = $this->ub->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }
    }

?>