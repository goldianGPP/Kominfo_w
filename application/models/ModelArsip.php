<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelArsip extends CI_Model {
        
        public function getFile(){
            $this->db->select('id_file, pengguna.nama as pengguna, file.nama, tipe, path, tgl_masuk, tgl_ubah');
            $this->db->from('file');
            $this->db->join('pengguna', 'file.id_pengguna=pengguna.id_pengguna');
            $res = $this->db->get()->result();

            return $res;
        }

        public function postFile($data){
            $this->db->insert('file', $data);
            $res = $this->db->affected_rows();

            return $res;
        }

        public function updateFile($data){
            $this->db->where('id_file', $data['id_file']);
            $this->db->update('file', $data);
            $res = $this->db->affected_rows();

            return $res;
        }

        public function deleteFile($id_file){
            $this->db->where('id_file', $id_file);
            $this->db->delete('file');
            $res = $this->db->affected_rows();

            return $res;
        }
    }

?>