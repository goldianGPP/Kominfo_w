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
            $this->load->model('ModelUploadFile', 'file');
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

        public function index_get($id_pengguna = null){
            $res = $this->item->getItems($id_pengguna);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function rated_get($id_pengguna = null){
            $res = $this->item->getRatedItem($id_pengguna);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $data = [
                'id_pengguna' => $this->input->post('id_pengguna', TRUE),
                'nama' => $this->input->post('nama', TRUE),
                'jenis' => $this->input->post('jenis', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'harga' => $this->input->post('harga', TRUE),
                'img' => $this->input->post('img', TRUE),
                'web' => $this->input->post('web', TRUE),
                'subrating' => 0,
                'sumrater' => 0
            ];

            if($this->file->upload($this->input->post('img', TRUE),$this->input->post('id_pengguna', TRUE)."/item"))   {
                if ($this->item->postItem($data) > 0) 
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }

        }

        public function index_put(){
            $id_item =  $this->put('id_item');
            $data = [
                'id_pengguna' => $this->put('id_pengguna'),
                'nama' => $this->put('nama'),
                'jenis' => $this->put('jenis'),
                'deskripsi' => $this->put('deskripsi'),
                'harga' => $this->put('harga'),
                'web' => $this->put('web'),
            ];

            $res = $this->item->updateItem($id_item,$data); 

            if ($this->item->updateItem($id_item,$data) > 0) 
                $this->response( true , 200);
            else
                $this->response( false , 400);

        }

        public function image_post(){
            $format = "%Y-%m-%d-%h-%i-%s-%a";

            $id_item = $this->input->post('id_item', TRUE);
            $img = "Item_".$id_item."_Image.jpg";
            $data = [
                'img' => $img
            ];

            if ($this->file->upload($img,"item")) {

                if ($this->item->updateitem($id_item,$data) > 0) 
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
            else
                $this->response( $this->file->upload($img,"item") , 400);
        }

        public function index_delete(){
            $id_item = $this->delete('id_item');
            $data = [
                'status' => 0
            ];

            if ($this->item->deleteItem($id_item,$data) > 0) 
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }
    }

?>