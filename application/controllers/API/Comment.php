<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    header('Access-Control-Allow-Origin: *');

    use chriskacerguis\RestServer\RestController;
    class Comment extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('ModelComment', 'comment');
            $this->load->helper('date');
        }

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function index_get($ids=null){
            $res = $this->comment->getComment($ids);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function index_post(){
            $format = "%Y-%m-%d";
            $data = [
                'id_pengguna' => $this->post('id_pengguna'),
                'ids' => $this->post('ids'),
                'comment' => $this->post('comment'),
                'replies' => 0,
                'created_at' => mdate($format)
            ];

            if ($this->comment->postComment($data)) {
               $this->response( $data , RestController::HTTP_OK);
            } 
        }

        public function reply_get($id_comment=null){
            $res = $this->comment->getReply($id_comment);
            $this->response( $res , RestController::HTTP_OK);
        }

        public function reply_post(){
            $format = "%Y-%m-%d";
            $data = [
                'id_comment' => $this->post('id_comment'),
                'id_pengguna' => $this->post('id_pengguna'),
                'reply' => $this->post('reply'),
                'reply_to' => $this->post('reply_to'),
                'created_at' => mdate($format)
            ];

            if ($this->comment->postReply($data)) {
               $this->response( $data , RestController::HTTP_OK);
            } 
        }
    }
?>