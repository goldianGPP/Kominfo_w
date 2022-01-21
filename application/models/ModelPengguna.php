<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelPengguna extends CI_Model {
        
        public function getPengguna($nip){
            $this->db->select('id_pengguna, nama, jabatan, nip, tugas, tandatangan');
            $this->db->from('pengguna');
            $this->db->where('nip', $nip);
            $res = $this->db->get()->row();

            if(!empty($res->nip))
                return $res;
            else 
                return null;
        }

        public function getAllPengguna(){
            $this->db->select('id_pengguna, nama, nip, tugas, jabatan, tandatangan, golongan, definisi');
            $this->db->from('pengguna');
            $this->db->join('golongan', 'golongan.id_golongan=pengguna.id_golongan');
            $res = $this->db->get()->result();

            return $res;
        }

        public function postPengguna($data){
            $this->db->insert('pengguna', $data);
            $res = $this->db->affected_rows();

            return $res;
        }

        public function updatePengguna($id_pengguna,$data){
            $this->db->where('id_pengguna', $id_pengguna);
            $this->db->update('pengguna', $data);
            $res = $this->db->affected_rows();
            
            return $res;
        }

        
        public function deletePengguna($id_pengguna){
            $this->db->where('id_pengguna', $id_pengguna);
            $this->db->delete('pengguna');
            $res = $this->db->affected_rows();
            
            return $res;
        }
    }

?>