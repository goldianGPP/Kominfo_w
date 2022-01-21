<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelDetailTgl extends CI_Model {
        
        public function getLibur(){
            $this->db->select('id_detail, tgl_libur, deskripsi');
            $this->db->from('detail_tgl');
            $res = $this->db->get()->result();

            return $res;
        }

        public function postLibur($data){
            if($this->cekTanggal($data['tgl_libur']) > 0){
                return null;
            }
            else{
                $this->db->insert('detail_tgl', $data);
                $res = $this->db->affected_rows();
            }

            return $res;
        }

        public function cekTanggal($tgl_libur){
            $this->db->select('count(id_detail) as sum');
            $this->db->from('detail_tgl');
            $this->db->where('tgl_libur', $tgl_libur);
            $res = $this->db->get()->row();

            return $res->sum;
            
        }

        public function updateLibur($data){
            $this->db->where('id_detail', $data['id_detail']);
            $this->db->update('detail_tgl', $data);
            $res = $this->db->affected_rows();

            return $res;
        }

        public function deleteLibur($data){
            $this->db->where('tgl_libur', $data['tgl_libur']);
            $this->db->delete('detail_tgl', $data);
            $res = $this->db->affected_rows();

            return $res;
        }
    }
