<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelLokasi extends CI_Model {


        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getLokasi(){
            $this->db->select('id_lokasi, id_pengguna, nama, deskripsi, latitude, longitude, status, img');
            $this->db->from('lokasi');
            return $this->db->get()->result();
        }

        public function getMyLokasi($id_pengguna){
            $this->db->select('id_lokasi, id_pengguna, nama, deskripsi, latitude, longitude, status, img');
            $this->db->from('lokasi');
            $this->db->where('id_pengguna',$id_pengguna);
            return $this->db->get()->result();
        }

        public function postLokasi($data){
            $this->db->insert('lokasi', $data);
            return $this->db->affected_rows();
        }

        public function updateLokasi($id_lokasi,$data){
            $this->db->where('id_lokasi', $id_lokasi);
            $this->db->update('lokasi', $data);  
            return $this->db->affected_rows();
        }

        public function deleteLokasi($id_lokasi){
            $this->db->where('id_lokasi', $id_lokasi);
            $this->db->delete('lokasi');
            return $this->db->affected_rows();
        }
    }

?>