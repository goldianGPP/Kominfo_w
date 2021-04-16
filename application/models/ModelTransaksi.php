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

            //     $date = $tanggal."-".$bulan."-".$tahun;
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
                return $tanggal."-".$bulan."-".$tahun;

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
                return $tanggal."-".$bulan."-".$tahun;
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
                return $tanggal."-".$bulan."-".$tahun;
            }
        }

        public function addOnCart($data){
            if(empty($this->cekTransaksi($data))){
                $res = $this->db->insert('transaksi', $data);

                if($res == 0)
                    return $this->db->error();
                else 
                    return $res;
            }
            else
                return 'sudah ada';  
        }

        public function addOnRequest($id_transaksi,$data){
            $this->db->where('id_transaksi', $id_transaksi);
            $res = $this->db->update('transaksi', $data);

            if($res == 0)
                return $this->db->error();
            else 
                return $res;
        }

        //BASIC CRUD
        //---------------------------------------------------------------------------------------------------------------------------------------
        public function getFinished($id_pengguna,$switch){
            return $this->getTransaksis($id_pengguna, "finished", $switch);
        }

        public function getRequested($id_pengguna,$switch){
            return $this->getTransaksis($id_pengguna, "requested", $switch);
        }

        public function getCarts($id_pengguna,$switch){
            return $this->getTransaksis($id_pengguna, "carted", $switch);
        }

        public function getTransaksis($id_pengguna, $status, $switch){
            $arr = array('requested', 'carted');
            $this->db->select('id_transaksi, nama_toko, nama, jenis, subtotal, img, transaksi.jumlah, harga, status, created_at');
            $this->db->from('transaksi');
            $this->db->join('item', 'transaksi.id_item=item.id_item');
            $this->db->join('toko', 'toko.id_toko=item.id_toko');
            $this->db->where($switch.'.id_pengguna', $id_pengguna);
            if($status !== "finished"){
                $this->db->where_in('status', $arr);
                $this->db->order_by('created_at','desc');
            }
            else{
                $this->db->where('status', $status);
                $this->db->order_by('finished_at','desc');
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