<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

use chriskacerguis\RestServer\RestController;
    class Transaksi extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelTransaksi', 'transaksi');
        }

        public function finished_get($id_pengguna=null,$switch=null){
            $res = $this->transaksi->getFinished($id_pengguna,$switch); 
            $this->response( $res , RestController::HTTP_OK);
        }

        public function requested_get($id_pengguna=null,$switch=null){
            $res = $this->transaksi->getRequested($id_pengguna,$switch); 
            $this->response( $res , RestController::HTTP_OK);
        }

        public function carts_get($id_pengguna=null,$switch=null){
            $res = $this->transaksi->getCarts($id_pengguna,$switch);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_get($id_transaksi=null){
            $res = $this->transaksi->getTransaksi($id_transaksi);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function carts_post(){
            $data = [
                'id_item' => $this->post('id_item'),
                'id_pengguna' => $this->post('id_pengguna')
            ];

            $res = $this->transaksi->addOnCart($data);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function carts_put(){
            $id_transaksi = $this->put('id_transaksi');
            $data = [
                'jumlah' => $this->put('jumlah'),
                'subtotal' => $this->put('subtotal'),
                'status' => "requested"
            ];

            $res = $this->transaksi->addOnRequest($id_transaksi,$data);
            $this->response( $res , RestController::HTTP_OK);
        }
    }
?>