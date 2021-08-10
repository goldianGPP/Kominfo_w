<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelTransaksi extends CI_Model {

        //BASIC CRUD
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getTransaksi($id_transaksi){
            $this->db->select('id_item, id_pengguna, id_item_rating, jumlah, ongkir, subtotal');
            $this->db->from('transaksi');
            $this->db->where('id_transaksi',$id_transaksi);
            $res = $this->db->get()->row();

            // for ($i=1; $i <= 4135; $i++) { 
            //     $tahun = rand(2019,2020);
            //     $bulan = rand(1,12);
            //     $tanggal = rand(1,31);

            //     $date = $tahun."-".$bulan."-".$tanggal;
            //     $this->db->set('created_at', $date);
            //     $add1 = rand(0,3);
            //     $date = $this->seting($tanggal,$bulan,$tahun,$add1);
            //     $this->db->set('accepted_at', $date);
            //     $add2 = rand($add1,($add1+1));
            //     $date = $this->seting($tanggal,$bulan,$tahun,$add2);
            //     $this->db->set('finished_at', $date);
            //     $this->db->where('id_transaksi', $i);
            //     $this->db->update('transaksi');
            // }

            return $res;
        }

        public function seting($tanggal,$bulan,$tahun,$add){
            if($bulan == 1 || $bulan == 3 || $bulan == 5 || $bulan == 7 || $bulan == 8 || $bulan == 10 || $bulan == 12){
                $added = $tanggal + $add;
                if($added > 31){
                    $tanggal = $added - 31;
                    if($bulan == 12){
                        $bulan = 1;
                        $tahun += 1;
                    }
                    else
                        $bulan += 1;
                }
                else{
                     $tanggal = $added;
                }

                if (strlen((string)$bulan) == 1) {
                   $bulan = "0".$bulan;
                }
                if (strlen((string)$tanggal) == 1) {
                   $tanggal = "0".$tanggal;
                }
                return $tahun."-".$bulan."-".$tanggal;

            }
            else if($bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11){
                $added = $tanggal + $add;
                if($added > 30){
                    $tanggal = $added - 30;
                    $bulan += 1;
                }
                else{
                     $tanggal = $added;
                }

                if (strlen((string)$bulan) == 1) {
                   $bulan = "0".$bulan;
                }
                if (strlen((string)$tanggal) == 1) {
                   $tanggal = "0".$tanggal;
                }
                return $tahun."-".$bulan."-".$tanggal;
            }
            else{
                $added = $tanggal + $add;
                if($added > 28){
                    $tanggal = $added - 28;
                    $bulan += 1;
                }
                else{
                     $tanggal = $added;
                }

                if (strlen((string)$bulan) == 1) {
                   $bulan = "0".$bulan;
                }
                if (strlen((string)$tanggal) == 1) {
                   $tanggal = "0".$tanggal;
                }
                return $tahun."-".$bulan."-".$tanggal;
            }
        }

        public function addOnCart($data){
            if(empty($this->cekTransaksi($data))){
                $res = $this->db->insert('transaksi', $data);

                if($res == 0)
                    return false;
                else 
                    return true;
            }
            else
                return false;  
        }

        public function addOnRequest($id_transaksi,$data){
            $this->db->where('id_transaksi', $id_transaksi);
            $res = $this->db->update('transaksi', $data);

            if($res == 0)
                return false;
            else 
                return true;
        }

        public function setStatus($id_transaksi,$data){
            $this->db->where('id_transaksi', $id_transaksi);
            $res = $this->db->update('transaksi', $data);

            if($res == 0)
                return false;
            else 
                return true;
        }

        //BASIC CRUD
        //---------------------------------------------------------------------------------------------------------------------------------------
        public function getTransaksis($id_pengguna, $type, $indicate){
            $ongoing = array('requested', 'carted');
            $this->db->select('id_transaksi, transaksi.id_item, nama_toko, nama, jenis, subtotal, img, transaksi.jumlah, harga, transaksi.status, created_at, accepted_at, finished_at, toko.latitude, toko.longitude');
            $this->db->from('transaksi');
            $this->db->join('item', 'transaksi.id_item=item.id_item');
            $this->db->join('toko', 'toko.id_toko=item.id_toko');
            $this->db->where($indicate.'.id_pengguna', $id_pengguna);
            if($type == "request"){
                $this->db->where_in('transaksi.status', $ongoing);
                $this->db->order_by('date(created_at)','desc');
            }
            else if($type != "none"){
                $this->db->where('transaksi.status', $type);
                $this->db->order_by('date(finished_at)','desc');
            }
            else{
                $this->db->order_by('date(created_at)','desc');
            }

            return $this->db->get()->result();
        }

        public function cekTransaksi($data){
            $status = array('requested', 'carted');
            $this->db->select('*');
            $this->db->from('transaksi');
            $this->db->where('id_pengguna', $data['id_pengguna']);
            $this->db->where('id_item', $data['id_item']);
            $this->db->where_in('status', $status);
            return $this->db->get()->result();
        }
    }

?>