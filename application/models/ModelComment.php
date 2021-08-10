<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelComment extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getComment($ids){
            $this->db->select('id_comment, comment.id_pengguna, username, comment, replies, vote, replies');
            $this->db->from('comment');
            $this->db->join('pengguna', 'comment.id_pengguna=pengguna.id_pengguna');
            $this->db->where('ids',$ids);
            $this->db->order_by('vote','desc');
            return  $this->db->get()->result();
        }

        public function postComment($data){
            $res = $this->db->insert('comment', $data);

            if($res == 0)
                return $this->db->error();
            else 
                return $res;
        }

        public function getReply($id_comment){
            $this->db->select('reply.id_comment, A.username as username, B.username as replier, A.id_pengguna as id_pengguna, B.id_pengguna as reply_to, reply, reply.created_at');
            $this->db->from('reply');
            $this->db->join('pengguna A', 'A.id_pengguna=reply.id_pengguna','left');
            $this->db->join('pengguna B', 'B.id_pengguna=reply.reply_to','left');
            $this->db->join('comment', 'comment.id_comment=reply.id_comment');
            $this->db->where('reply.id_comment',$id_comment);
            $this->db->order_by('id_reply','asc');
            return  $this->db->get()->result();
        }

        public function postReply($data){
            $res = $this->db->insert('reply', $data);

            if($res == 0)
                return $this->db->error();
            else 
                return $res;
        }
    }

?>