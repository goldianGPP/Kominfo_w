<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

use chriskacerguis\RestServer\RestController;
    class Pengguna extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelPengguna', 'mp');
            $this->load->model('ModelUploadFile', 'file');
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
        }

        public function index_get($nip = null){
            if ($nip == null)
                $res = $this->mp->getAllPengguna();
            else
                $res = $this->mp->getPengguna($nip);
            if($res != null)
                $this->response( $res , 200);
            else
                $this->response( [] , 400);
        }
        

        public function register_post(){
            $data = [
                'nama' => $this->post('nama'),
                'jabatan' => $this->post('jabatan'),
                'tugas' => $this->post('tugas'),
                'nip' => $this->post('nip'),
                // 'nip' => password_hash($this->input->post('nip'),PASSWORD_DEFAULT),
                'tipe_presensi' => 0,
                'tgl_masuk' => date('Y-m-d', strtotime('+2 hours')),
            ];

            if ($this->mp->postPengguna($data) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }

        public function index_put(){
            $id_pengguna = $this->put('id_pengguna');
            $data = [
                'nama' => $this->put('nama'),
                'tipe_presensi' => $this->put('tipe_presensi'),
                'tandatangan' => $this->put('tandatangan'),
            ];
            if ($this->mp->updatePengguna($id_pengguna, $data) > 0) 
                $this->response( $data , 200);
            else
                $this->response( [] , 400);
        }

        public function index_delete(){
            $id_pengguna = $this->post('id_pengguna');

            if ($this->mp->deletePengguna($id_pengguna) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }

        public function image_post(){
            $id_pengguna = $this->input->post('id_pengguna', TRUE);
            $dir = "signature/";
            $image = $this->file->upload($dir,$id_pengguna.'.png');

            if ($image != ""){
                $data = [
                    'tandatangan' => 'images/'.$dir.$image
                ];

                $this->mp->updatePengguna($id_pengguna,$data);
                unlink('./'.$this->input->post('image', TRUE));
                $this->response( true , 200);
            }
            else
                $this->response( false , 400);
        }
    }
?>