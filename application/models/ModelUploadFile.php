<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelUploadFile extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function upload($dir,$name){
            if (!is_dir('images/'.$dir)) {
                mkdir('./images/'.$dir, 0777, TRUE);
            }

            $config['file_name']            = $name;
            $config['upload_path']          = './images/'.$dir;
            $config['allowed_types']        = 'jpg|jpeg|png|pdf';
            $config['overwrite']            = true;
            //$config['max_size']             = 3000; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                return $name;
            }
            else
                return "";
        }
    }

?>