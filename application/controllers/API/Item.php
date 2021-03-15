<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class Item extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelItem', 'item');
        }

        public function index_get($username = null,$password = null){
            $res = $this->item->getUser(); 
            $this->response( $res , RestController::HTTP_OK);
        }

        //-----------------------------------------------------------------------------------------------
        // get recomendation for items
        // mangambil rekomendasi dari items

        public function itemrec_get(){
            $type=array("joran","kail","benang");
            $res = $this->item->getRecommendations("id_pengguna-2", $type[array_rand($type)]);
            $this->response( $res , RestController::HTTP_OK);
        }

        //-----------------------------------------------------------------------------------------------

        public function detail_post(){
            $id_item = $this->post('id_item');
            $jenis = $this->post('jenis');

            if($jenis == "joran")
                $res = $this->item->getDetailJoran($id_item);
            else if($jenis == "kail")
                $res = $this->item->getDetailKail($id_item);
            else
                $res = $this->item->getDetailBenang($id_item);

            $this->response( $res[0] , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'password' => $this->post('password'),
            ];

            $data = $this->item->createUser($data); 
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

            $data = $this->item->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_delete(){
            $data = $this->post('id_user');
            $data = $this->item->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }
    }

?>