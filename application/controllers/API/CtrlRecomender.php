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
            $res = $this->ub->getRecommendations("id_pengguna-".$id_pengguna, $jenis);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function userbasedsearch_get($id_pengguna=null, $search=null){
            $array = explode("%20", $search);
            $res = $this->ub->getRecommendations("id_pengguna-".$id_pengguna, $array);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function itembased_get($id_pengguna=null, $id_item=null, $jenis=null){
            $res = $this->ib->getRecommendations("id_pengguna-".$id_pengguna, $jenis, $id_item);
            $this->response( $res , RestController::HTTP_OK);
        }

        //-----------------------------------------------------------------------------------------------
    }

?>