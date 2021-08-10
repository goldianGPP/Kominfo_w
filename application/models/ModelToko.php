<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelToko extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getToko(){
            // $this->db->set('password', '$2y$10$iDYYSjqBIkFEsqku2j73.eRfP9fIgMHvgDLDxap6kMAu2s1Gi682K');
            // $this->db->update('pengguna');
        }

        public function getId($data){
            $this->db->select('id_toko');
            $this->db->from('toko');
            $this->db->where('nama_toko', $data['nama_toko']);
            $res = $this->db->get()->row();

            return $res->id_toko;
        }

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