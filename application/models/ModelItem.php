<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelItem extends CI_Model {


        //ITEM BASED
        //----------------------------------------------------------------------------------------------------------------------------------------
        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getIBItems($type){
            $arr = [];
            $this->db->select('item_rating.id_pengguna as "id_pengguna", item_rating.id_item as "id_item", rating, (SUMITEMRATING / SUMITEMRATED) as "item_ratings"');
            $this->db->from('item_rating');
            $this->db->join('pengguna','item_rating.id_pengguna = pengguna.id_pengguna', 'left');
            $this->db->join('histori_pengguna','pengguna.id_pengguna = histori_pengguna.id_pengguna', 'left');
            $this->db->join('item','item_rating.id_item = item.id_item', 'left');
            if($type != null){
                $this->db->where('jenis', $type);
            }
            $this->db->order_by('item_rating.id_item', 'asc');

            // sending a response with a custom array from class CI_DB_result
            // mengirim hasil dengan bentuk custom array dari class CI_DB_result
            return $this->db->get()->custom_array2($arr);
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getIBItem($type){
            $this->db->select('item.id_item, id_toko, jenis, nama, harga, subrating, sumrater, img');
            $this->db->from('item');
            if($type != null){
                $this->db->where('jenis', $type);
            }
            return $this->db->get()->result();
        }


        //USER BASED
        //----------------------------------------------------------------------------------------------------------------------------------------
        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItems($type){
            $arr = [];
            $this->db->select('item_rating.id_pengguna as "id_pengguna", item_rating.id_item as "id_item", rating, (SUMITEMRATING / SUMITEMRATED) as "item_ratings"');
            $this->db->from('item_rating');
            $this->db->join('pengguna','item_rating.id_pengguna = pengguna.id_pengguna', 'left');
            $this->db->join('histori_pengguna','pengguna.id_pengguna = histori_pengguna.id_pengguna', 'left');
            $this->db->join('item','item_rating.id_item = item.id_item', 'left');
            if($type != null){
                $this->db->where('jenis', $type);
            }
            $this->db->order_by('item_rating.id_pengguna', 'asc');

            // sending a response with a custom array from class CI_DB_result
            // mengirim hasil dengan bentuk custom array dari class CI_DB_result
            return $this->db->get()->custom_array($arr);
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItem($type){
            $this->db->select('item.id_item, jenis, nama, harga, subrating, sumrater, img');
            $this->db->from('item');
            if($type != null){
                $this->db->where('jenis', $type);
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

        public function getDetailItems($id_item)
        {
            $this->db->select('item.id_item, id_toko, nama as "nama", jenis, description, harga, jumlah, (subrating/sumrater) as rating, sumrater, img');
            $this->db->from('item');
            $this->db->where('item.id_item',$id_item);
            return $this->db->get()->result();
        }

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

        public function postItem($data){
            $this->db->insert('item', $data);
        }

        public function updateItem($data){
            $this->db->set('nama', $data['nama']);
            $this->db->set('jenis', $data['jenis']);
            $this->db->set('description', $data['description']);
            $this->db->set('harga', $data['harga']);
            $this->db->set('jumlah', $data['jumlah']);
            $this->db->where('id_item', $data['id_item']);
            $this->db->update('item'); 
        }

        public function deleteItem($data){
            $this->db->where('id_item', $data['id_item']);
            $this->db->delete('item', $data);
        }
    }

?>