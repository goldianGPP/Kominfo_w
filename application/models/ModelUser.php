<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelUser extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------
        public function getItem($username){
            // $this->db->select('id_item, nama');
            // $this->db->from('item');
            // $this->db->where('username', $username);
            // return $this->db->get()->result();
            
            $this->db->set("status", "finished");
            $this->db->update("transaksi");
        }

        public function loginUser($data){
            $this->db->select('id_pengguna, nama, email, password, username, auth');
            $this->db->from('pengguna');
            $this->db->where('username', $data['username']);
            $this->db->get()->row();

            if(password_verify($data['password'], $res->password)) {
                if($res->auth !== '1')
                    return null;
                return $res;
            } 
            else 
                return null;
        }

        public function registerUser($data){
            $this->db->set('username', $data['username']);
            $this->db->set('email', $data['email']);
            $this->db->set('nama', $data['nama']);
            $this->db->set('password', $data['password']);
            $this->db->insert('pengguna');
            return $this->db->affected_rows();
        }

        public function updateUser($id_pengguna, $data){
            $this->db->where('id_pengguna', $id_pengguna);
            $this->db->update('pengguna', $data);
            return $this->db->affected_rows();
        }

        public function updateUserPassword($id_pengguna, $data){
            $this->db->where('id_pengguna', $id_pengguna);
            $this->db->update('pengguna', $data);
            return $this->db->affected_rows();
        }

        public function email($email){
            $this->load->library('email');
            $config = array();
            $config['protocol']="smtp";
            $config['charset'] ='utf-8';
            $config['useragent'] = 'Codeigniter';
            $config['mailtype']= "html";
            $config['smtp_host']= "smtp.gmail.com";
            $config['smtp_port']= "465";
            $config['smtp_timeout']= "400";
            $config['smtp_user']= "rubencahyadi6@gmail.com"; 
            $config['smtp_pass']= "PONCEDELEON10";
            $config['smtp_crypto']  = "ssl" ;
            $config['crlf']="\r\n"; 
            $config['newline']="\r\n"; 
            $config['wordwrap'] = TRUE;

            //memanggil library email dan set konfigurasi untuk pengiriman email

            $this->email->initialize($config);
            $this->email->from('no-Replay@email.com','BajoLapak.com'); 
            $this->email->to($email);
            $this->email->subject('Aktifkan Account');
            $this->email->message(
            'Click Here : <a href="'.base_url().'frontend/register/verify?email='.$email.'&token='.$token.'">Active</a>');
            if($this->email->send())
            {
                return true ; 
            }       
            else{
                echo "tidak terkirim"; 
                echo $this->email->print_debugger();
                die ;
            }
        }
    }

?>