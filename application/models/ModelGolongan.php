<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelGolongan extends CI_Model {
        
        public function getGolongan(){
            $this->db->select('id_golongan, golongan, definisi');
            $this->db->from('golongan');
            $res = $this->db->get()->result();

            return $res;
        }
    }

?>