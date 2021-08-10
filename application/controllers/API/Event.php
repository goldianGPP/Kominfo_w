<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class Event extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelEvent', 'event');
            $this->load->model('ModelUploadFile', 'file');
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
        }

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function index_get($id_pengguna = null){
            if ($id_pengguna == null) 
                $res = $this->event->getEvents();
            else
                $res = $this->event->getMyEvents($id_pengguna);

            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $format = "%Y-%m-%d";
            $datestring = '%Y-%m-%d-%h-%i-%s-%a';
            $data = [
                'id_pengguna' => $this->input->post('id_pengguna', TRUE),
                'title' => $this->input->post('title', TRUE),
                'day' => $this->input->post('day', TRUE),
                'month' => $this->input->post('month', TRUE),
                'year' => $this->input->post('year', TRUE),
                'link' => $this->input->post('link', TRUE),
                'deskripsi' => $this->input->post('deskripsi', TRUE),
                'img' => $this->input->post('id_pengguna', TRUE)."_".mdate($datestring).".jpg",
                'created_at' => mdate($format)
            ];

            if ($this->file->upload($this->input->post('id_pengguna', TRUE)."_".mdate($datestring, $time),"event")) {
                if ($this->event->postEvent($data) > 0)
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
            else 
                $this->response( $_FILES , 404);
        }

        public function index_put(){
            $id_event = $this->put('id_event');
            $format = "%Y-%m-%d";
            $data = [
                'title' => $this->put('title'),
                'day' => $this->put('day'),
                'month' => $this->put('month'),
                'year' => $this->put('year'),
                'link' => $this->put('link'),
                'deskripsi' => $this->put('deskripsi'),
                'edited_at' => mdate($format)
            ];

            if ($this->event->updateEvent($id_event,$data) > 0)
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }

        public function image_post(){
            $format = "%Y-%m-%d-%h-%i-%s-%a";

            $id_event = $this->input->post('id_event', TRUE);
            $img = "Event_".$id_event."_Image.jpg";
            $data = [
                'img' => $img
            ];

            if ($this->file->upload($img,"event")) {
                if ($this->event->updateEvent($id_event,$data) > 0)
                    $this->response( true , 200);
                else
                    $this->response( false , 400);
            }
            else
                $this->response( $this->file->upload($img,"event") , 400);
        }

        public function index_delete(){
            $id_event = $this->delete('id_event');
            
            if ($this->event->deleteEvent($id_event) > 0) 
                $this->response( true , 200);
            else
                $this->response( false , 400);
        }
    }
?>