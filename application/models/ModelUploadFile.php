<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelUploadFile extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function uploads($nama,$folder,$files){

            if (!is_dir('images/'.$folder.'/'.$nama)) {
                mkdir('./images/'.$folder.'/'.$nama, 0777, TRUE);
            }

            $config = array(
                'upload_path'   => 'images/'.$folder.'/'.$nama,
                'allowed_types' => 'jpg|jpeg|png',
                'overwrite'     => true,                       
            );

            $this->load->library('upload', $config);

            $images = array();
            $count = 1;
            foreach ($files['images']['name'] as $key => $image) {
                $_FILES['images[]']['name']= $files['images']['name'][$key];
                $_FILES['images[]']['type']= $files['images']['type'][$key];
                $_FILES['images[]']['tmp_name']= $files['images']['tmp_name'][$key];
                $_FILES['images[]']['error']= $files['images']['error'][$key];
                $_FILES['images[]']['size']= $files['images']['size'][$key];

                $fileName = $nama.$count.".jpg";

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('images[]')) {
                    $this->upload->data();
                } 
                else {
                    return false;
                }
                $count += 1;
            }

            return true;
        }

        public function upload($nama,$dir){
            if (!is_dir('images/'.$dir.'/')) {
                mkdir('./images/'.$dir.'/', 0777, TRUE);
            }

            $config['upload_path']          = './images/'.$dir;
            $config['allowed_types']        = 'jpg|jpeg|png';
            $config['file_name']            = $nama;
            $config['overwrite']            = true;
            //$config['max_size']             = 3000; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                return true;
            }
            else
                return false;
        }
    }

?>