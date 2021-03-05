<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ModelRecommender extends CI_Model {

        var $Vdistance = [];

        function __construct() {
            parent::__construct();
        }

        //get the items or needed datas from database
        //mengambil item - item yang dibutuhkan dari basis data
        public function getItems($person, $type){
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
        public function getItem($type){
            $this->db->select('item.id_item, nama, harga, sumrating, sumrater, img');
            $this->db->from('item');
            if($type != null){
                $this->db->join($type,'item.id_item = '.$type.'.id_item');
            }
            return $this->db->get()->result();
        }

        //get the recommendation
        //mengambil rekomendasi
        public function getRecommendations($person,$type){
            $sim = [];
            $result = [];
            $prediction = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;

            echo $type;
            $datas = $this->getItems($person,$type);
            $items = $this->getItem($type);

            foreach ($datas as $otherPerson => $values) {
                if($otherPerson != $person){
                    $sim[$otherPerson] = $this->distance($datas,$person,$otherPerson);
                    $sumSim += $sim[$otherPerson];
                }
            }

            $check = 0;
            array_multisort($sim, SORT_DESC);
            foreach ($items as $item) {
                foreach ($datas as $otherPerson => $value) {
                    if($otherPerson != $person){
                        //get rating prediction each data to only 5 higest score of user's similarity
                        //mengambil 5 data dari similaritas para user untuk menghitung prediksi score (nilai)
                        if(array_key_exists("id_item-".$item->id_item,$datas[$otherPerson])){
                            if($check <= 5 && $sim[$otherPerson] != 0){
                                $sumPre += ($this->Vdistance[$otherPerson] * $sim[$otherPerson]) / $sumSim;
                                $check += 1;
                            }
                        }
                    }
                }
                if($check != 0){
                    array_push($result,
                        [
                            'id_item' => $item->id_item,
                            'nama' => $item->nama,
                            'rating' => ($item->sumrating/$item->sumrater),
                            'img' => $item->img,
                            'harga' => $item->harga,
                            'rank' => $sumPre
                        ]);
                }
                $sumPre = 0;
                $check = 0;
            }

            return $result;
                
        }

        //calculate similarity distance of rated data each users to user
        //menghitung jarak kesamaan dari rating yang dilakukan para pengguna terhadap pengguna tertentu
        public function distance($datas,$person,$otherPerson){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $count = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simDenominator = 0;
            //check similarity true or false
            //mengecek adanya kesamaan data
            foreach ($datas[$person] as $item => $value) {
                if(array_key_exists($item, $datas[$otherPerson])){
                    $count += 1;
                    break;
                }
            }

            if($count == 0)
                return $count;


            foreach ($datas[$person] as $item => $value) {
                if(array_key_exists($item, $datas[$otherPerson])){
                    $personItem += (pow((float)$value[1]-(float)$value[2],2)); 
                    $otherPersonItem += (pow((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2],2));
                    $o_prsnAvg += ((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2]);
                    $simDenominator += ((float)$value[1]-(float)$value[2])*((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2]);
                }
            }

            $this->Vdistance[$otherPerson] = $o_prsnAvg;
            $sim = $simDenominator / ((sqrt($personItem)) * (sqrt($otherPersonItem)));
            return $sim;
        }
    }

?>