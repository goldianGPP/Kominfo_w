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
        public function getIBItem($ids,$cur_item,$type){
            $this->db->select('id_item, id_pengguna, jenis, nama, harga, subrating, deskripsi, sumrater, img, web');
            $this->db->from('item');
            $this->db->where_in('concat("id_item-",id_item)',$ids);
            $this->db->where('id_item !=',$cur_item);
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
        public function getUBItem($ids,$type){
            $this->db->select('item.id_item, id_pengguna, jenis, web, deskripsi, nama, harga, subrating, sumrater, img');
            $this->db->from('item');
            $this->db->where_not_in('concat("id_item-",id_item)',$ids);
            if($type != null){
                $this->db->where('jenis', $type);
            }
            return $this->db->get()->result();
        }

        //ON SEARCH-----------------------------------------------------------------
        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItemsSearch($type){
            $arr = [];
            $this->db->select('item_rating.id_pengguna as "id_pengguna", item_rating.id_item as "id_item", rating, (SUMITEMRATING / SUMITEMRATED) as "item_ratings"');
            $this->db->from('item_rating');
            $this->db->join('pengguna','item_rating.id_pengguna = pengguna.id_pengguna', 'left');
            $this->db->join('item','item_rating.id_item = item.id_item', 'left');
            $this->db->where_in('id_pengguna',$ids);
            for ($i=0; $i < count($type) ; $i++) { 
                $this->db->or_like('jenis', $type[$i]);
                $this->db->or_like('jenis', substr($type[$i],0,3));
                $this->db->or_like('jenis', substr($type[$i],-3));
                $this->db->or_like('item.nama', $type[$i]);
                $this->db->or_like('item.nama', substr($type[$i],0,3));
                $this->db->or_like('item.nama', substr($type[$i],-3));
            }
            $this->db->order_by('item_rating.id_pengguna', 'asc');

            // sending a response with a custom array from class CI_DB_result
            // mengirim hasil dengan bentuk custom array dari class CI_DB_result
            return $this->db->get()->custom_array($arr);
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getUBItemSearch($type){
            $this->db->select('item.id_item, id_pengguna, jenis, web, deskripsi, nama, harga, subrating, sumrater, img');
            $this->db->from('item');
            for ($i=0; $i < count($type) ; $i++) { 
                $this->db->or_like('jenis', $type[$i]);
                $this->db->or_like('jenis', substr($type[$i],0,3));
                $this->db->or_like('jenis', substr($type[$i],-3));
                $this->db->or_like('nama', $type[$i]);
                $this->db->or_like('nama', substr($type[$i],0,3));
                $this->db->or_like('nama', substr($type[$i],-3));
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
        
        public function getId(){
            $this->db->select('count(id_item) as id');
            $ids = $this->db->get()->row();
            $id = (int)$ids->id + 1;
            return $id;
        }

        public function getItems($id_pengguna){
            $this->db->select('id_item, id_pengguna, nama, jenis, deskripsi, harga, img, web, (subrating/sumrater) as rating');
            $this->db->from('item');
            $this->db->where('id_pengguna', $id_pengguna);
            return $this->db->get()->result();
            // $this->db->set("status", "finished");
            // $this->db->update("transaksi");
        }

        public function getRatedItem($id_pengguna){
            $this->db->select('item.id_item, item.id_pengguna, nama, harga, img, jenis,  web, rating, deskripsi');
            $this->db->from('item');
            $this->db->join('item_rating','item.id_item=item_rating.id_item');
            $this->db->where('item_rating.id_pengguna', $id_pengguna);
            return $this->db->get()->result();
            // $this->db->set("status", "finished");
            // $this->db->update("transaksi");
        }

        public function postItem($data){
            $this->db->insert('item', $data);
            return $this->db->affected_rows();
        }

        public function updateItem($id_item,$data){
            $this->db->where('id_item', $id_item);
            $this->db->update('item', $data);
            return $this->db->affected_rows();  
        }

        public function deleteItem($id_item,$data){
            $this->db->where('id_item', $id_item);
            $this->db->update('item', $data);
            return $this->db->affected_rows();
        }
    }

?>