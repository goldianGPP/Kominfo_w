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


        //OTHER
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function detail_post(){
            $id_item = $this->post('id_item');
            
            $res = $this->item->getDetailItems($id_item);

            $this->response( $res[0] , RestController::HTTP_OK);
        }

        public function jenis_get($jenis = null){
            if($jenis == 'joran')
                $res = $this->item->jenisJoran();
            else if($jenis == "kail")
                $res = $this->item->jenisKail();
            else if($jenis == "benang")
                $res = $this->item->jenisBenang();
            else $res = null;

            $this->response( $res , RestController::HTTP_OK);
        }

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function index_get($username = null){
            $res = $this->item->getItem($username);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'id_toko' => $this->put('id_toko'),
                'nama' => $this->put('nama'),
                'jenis' => $this->put('jenis'),
                'description' => $this->put('description'),
                'harga' => $this->put('harga'),
                'jumlah' => $this->put('jumlah'),
                'img' => $this->put('img'),
                'subrating' => 0,
                'sumrater' => 0
            ];

            $data = $this->item->postItem($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function index_put(){
            $data = [
                'id_item' => $this->put('id_item'),
                'nama' => $this->put('nama'),
                'jenis' => $this->put('jenis'),
                'description' => $this->put('description'),
                'harga' => $this->put('harga'),
                'jumlah' => $this->put('jumlah'),
            ];

            $data = $this->item->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }

        public function delete_put(){
            $data = $this->put('id_user');
            $data = $this->item->editUser($data); 
            $this->response( $data , RestController::HTTP_OK);
        }
    }

?>