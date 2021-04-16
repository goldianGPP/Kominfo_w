<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class Pengguna {
        public $id_pengguna; 
        public $username;
        public $password;
        public $email;
        public $phone;
        public $sumitemrating;
        public $sumitemrated;
        public $modelToko;

        public function __constuct($id_pengguna, $username, $password, $email, $phone, $sumitemrating, $sumitemrated) {
            $this->id_pengguna = $id_pengguna;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->phone = $phone;
            $this->sumitemrating = $sumitemrating;
            $this->sumitemrated = $sumitemrated;
            $this->modelToko = $this->load->model('ModelToko', 'toko');
        }
    }

?>