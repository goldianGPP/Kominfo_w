<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class Lokasi extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelLokasi', 'lokasi');
            $this->load->model('ModelUploadFile', 'file');
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
        }

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function index_get($id_pengguna = null){
            if ($id_pengguna == null) 
                $res = $this->lokasi->getLokasi();
            else
                $res = $this->lokasi->getMyLokasi($id_pengguna);

            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $datestring = '%Y-%m-%d-%h-%i-%s-%a';
            $time = time();
            $data = [
                'id_pengguna' => $this->input->post('id_pengguna', TRUE),
                'nama' => $this->input->post('nama', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'latitude' => $this->input->post('latitude', TRUE),
                'longitude' => $this->input->post('longitude', TRUE),
                'status' => $this->input->post('status', TRUE),
                'img' => $this->input->post('id_pengguna', TRUE)."_".mdate($datestring, $time).".jpg"
            ];

            if ($this->file->upload($this->input->post('id_pengguna', TRUE)."_".mdate($datestring, $time),"lokasi")) {
                
                if ($this->lokasi->postLokasi($data) > 0)
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
            else 
                $this->response( $_FILES , 404);
        }

        public function index_put(){
            $id_lokasi = $this->post('id_lokasi');
            $data = [
                'nama' => $this->post('nama'),
                'deskripsi' => $this->post('deskripsi'),
                'latitude' => $this->post('latitude'),
                'longitude' => $this->post('longitude'),
                'status' => $this->post('status'),
            ];

            if ($this->lokasi->updateLokasi($id_lokasi,$data) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }

        public function image_post(){
            $format = "%Y-%m-%d-%h-%i-%s-%a";

            $id_lokasi = $this->input->post('id_lokasi', TRUE);
            $img = "Lokasi_".$id_lokasi."_Image.jpg";
            $data = [
                'img' => $img
            ];

            if ($this->file->upload($img,"lokasi")) {
                if ($this->lokasi->updateLokasi($id_lokasi,$data))
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
            else
                $this->response( $this->file->upload($img,"lokasi") , 400);
        }

        public function index_delete(){
            $id_lokasi = $this->delete('id_lokasi');
            if ($this->lokasi->deleteLokasi($id_lokasi) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }
    }
?>