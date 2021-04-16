<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelToko extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function createToko($data){
            $res = $this->db->insert('toko', $data);

            if($res == 0)
                return $this->db->error();
            else 
                return $res;
        }

        public function updateAlamat($id_toko, $data){
            $this->db->where('id_toko', $id_toko);
            $res = $this->db->update('toko', $data);

            if($res == 0)
                return $this->db->error();
            else 
                return $res;
        }
    }

?>