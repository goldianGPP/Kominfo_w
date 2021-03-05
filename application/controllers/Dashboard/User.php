<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}
use chriskacerguis\RestServer\RestController;
    class User extends RestController 
    {
        public function __construct() 
        {
        	header('Access-Control-Allow-Origin: *');
    		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

            parent::__construct();
            $this->load->model('QueueModel', 'queue');
            $this->load->dbforge();
            $this->load->helper('string');
        }

        public function index_get(){
            $res = $this->queue->queueCall();

            $this->response( $res , RestController::HTTP_OK);
        }
    }


?>