<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelItem extends CI_Model {


        //ITEM BASED
        //----------------------------------------------------------------------------------------------------------------------------------------
        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getIBItems($type){
            $arr = [];
            $this->db->select('item_rating.id_pengguna as "id_pengguna", item_rating.id_item as "id_item", rating, item_ratings');
            $this->db->from('item_rating');
            $this->db->join('pengguna','item_rating.id_pengguna = pengguna.id_pengguna', 'left');
            $this->db->join('histori_pengguna','pengguna.id_pengguna = histori_pengguna.id_pengguna', 'left');
            $this->db->join('item','item_rating.id_item = item.id_item', 'left');
            if($type != null){
                $this->db->join($type,'item.id_item = '.$type.'.id_item');
            }
            $this->db->order_by('item_rating.id_item', 'asc');

            // sending a response with a custom array from class CI_DB_result
            // mengirim hasil dengan bentuk custom array dari class CI_DB_result
            return $this->db->get()->custom_array2($arr);
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getIBItem($type){
            $this->db->select('item.id_item, id_pengguna, jenis, nama, harga, sumrating, sumrater, img');
            $this->db->from('item');
            if($type != null){
                $this->db->join($type,'item.id_item = '.$type.'.id_item');
            }
            return $this->db->get()->result();
        }


        //USER BASED
        //----------------------------------------------------------------------------------------------------------------------------------------
        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItems($type){
            $arr = [];
            $this->db->select('item_rating.id_pengguna as "id_pengguna", item_rating.id_item as "id_item", nama, rating, 
                               avg(rating) OVER( ORDER BY item_rating.id_pengguna asc) as "average"');
            $this->db->from('item_rating');
            $this->db->join('item','item_rating.id_item = item.id_item', 'left');
            if($type != null){
                $this->db->join($type,'item.id_item = '.$type.'.id_item');
            }
            $this->db->order_by('item_rating.id_pengguna', 'asc');

            // sending a response with a custom array from class CI_DB_result
            // mengirim hasil dengan bentuk custom array dari class CI_DB_result
            return $this->db->get()->custom_array($arr);
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItem($type){
            $this->db->select('item.id_item, jenis, nama, harga, sumrating, sumrater, img');
            $this->db->from('item');
            if($type != null){
                $this->db->join($type,'item.id_item = '.$type.'.id_item');
            }
            return $this->db->get()->result();
        }

        //DETAIL ITEMS
        //----------------------------------------------------------------------------------------------------------------------------------------

        public function getRandomItems($person){
            $query = '(select id_item from item_rating where id_pengguna = '.$person.')';
            $this->db->select('id_item');
            $this->db->from('item');
            $this->db->where_not_in('id_item', $query);
            $this->db->group_by('id_item');
            // $this->db->order_by('id_pengguna', 'RANDOM');
            return $this->db->get()->row();
        }

        public function getDetailJoran($id_item)
        {
            $this->db->select('username, item.nama as "nama", description, harga, jumlah, jenis_joran.nama as "jenis_item", panjang, berat, (sumrating/sumrater) as rating, sumrater, img');
            $this->db->from('pengguna');
            $this->db->join('item','pengguna.id_pengguna = item.id_pengguna');
            $this->db->join('joran','item.id_item = joran.id_item');
            $this->db->join('jenis_joran','joran.id_jenis_joran = jenis_joran.id_jenis_joran');
            $this->db->where('item.id_item',$id_item);
            return $this->db->get()->result();
        }

        public function getDetailBenang($id_item)
        {
            $this->db->select('username, item.nama as "nama", description, harga, jumlah, jenis_benang.nama as "jenis_item", ketahanan, (sumrating/sumrater) as rating, sumrater, img');
            $this->db->from('pengguna');
            $this->db->join('item','pengguna.id_pengguna = item.id_pengguna');
            $this->db->join('benang','item.id_item = benang.id_item');
            $this->db->join('jenis_benang','benang.id_jenis_benang = jenis_benang.id_jenis_benang');
            $this->db->where('item.id_item',$id_item);
            return $this->db->get()->result();
        }

        public function getDetailKail($id_item)
        {
            $this->db->select('username, item.nama as "nama", description, harga, jumlah, jenis_kail.nama as "jenis_item", ukuran, (sumrating/sumrater) as rating, sumrater, img');
            $this->db->from('pengguna');
            $this->db->join('item','pengguna.id_pengguna = item.id_pengguna');
            $this->db->join('kail','item.id_item = kail.id_item');
            $this->db->join('jenis_kail','kail.id_jenis_kail = jenis_kail.id_jenis_kail');
            $this->db->where('item.id_item',$id_item);
            return $this->db->get()->result();
        }
    }

?>