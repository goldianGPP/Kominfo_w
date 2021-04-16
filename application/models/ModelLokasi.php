<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelLokasi extends CI_Model {


        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getLokasi(){
            $this->db->select('nama');
            $this->db->from('lokasi');
            return $this->db->get()->result();
        }

        public function postLokasi($data){
            $this->db->insert('lokasi', $data);
        }

        public function updateLokasi($data){
            $this->db->where('id_lokasi', $data['id_lokasi']);
            $this->db->update('lokasi', $data);  
        }

        public function deleteLokasi($data){
            $this->db->where('id_lokasi', $data['id_lokasi']);
            $this->db->delete('lokasi', $data);
        }
    }

?>