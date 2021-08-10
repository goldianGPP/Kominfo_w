<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelEvent extends CI_Model {


        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getEvents(){
            $this->db->select('id_event, id_pengguna, title, day, month, year, link, deskripsi, img, created_at, edited_at');
            $this->db->from('event');
            return $this->db->get()->result();
        }
        
        public function getMyEvents($id_pengguna){
            $this->db->select('id_event, id_pengguna, title, day, month, year, link, deskripsi, img, created_at, edited_at');
            $this->db->from('event');
            $this->db->where('id_pengguna',$id_pengguna);
            return $this->db->get()->result();
        }
        
        public function postEvent($data){
            $this->db->insert('event', $data);
            return $this->db->affected_rows();
        }
        
        public function updateEvent($id_event,$data){
            $this->db->where('id_event', $id_event);
            $this->db->update('event', $data);  
            return $this->db->affected_rows();
        }
        
        public function deleteEvent($id_event){
            $this->db->where('id_event', $id_event);
            $this->db->delete('event');
            return $this->db->affected_rows();
        }
    }

?>