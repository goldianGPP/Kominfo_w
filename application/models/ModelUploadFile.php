<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelUploadFile extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function upload($nama,$files){

            if (!is_dir('images/toko/'.$nama)) {
                mkdir('./images/toko/'.$nama, 0777, TRUE);
            }

            $config = array(
                'upload_path'   => 'images/toko/'.$nama,
                'allowed_types' => 'jpg|gif|png',
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

                $fileName = $nama.$count;

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
    }

?>