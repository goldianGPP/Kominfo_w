<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class Toko {
        public $id_toko; 
        public $id_pengguna;
        public $alamat_toko;
        public $latitude;
        public $longitude;
        public $nama_toko;
        public $nik;
        public $foto_ktp;

        public function __constuct($id_toko, $id_pengguna, $alamat_toko, $latitude, $longitude, $nama_toko, $nik, $foto_ktp) {
            $this->id_toko = $id_toko;
            $this->id_pengguna = $id_pengguna;
            $this->id_pengguna = $id_pengguna;
            $this->latitude = $latitude;
            $this->longitude = $longitude;
            $this->nama_toko = $nama_toko;
            $this->nik = $nik;
            $this->foto_ktp = $foto_ktp;
        }
    }

?>