<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ItemBased extends CI_Model {

        var $Vdistance = [];
        var $urating = [];

        public function __construct() {
            parent::__construct();
            $this->load->model('ModelItem','mi');
        }

        //get the recommendation
        //mengambil rekomendasi
        public function getRecommendations($person,$type,$item){
            $sim = [];
            $prediction = [];

            //get list of items from database
            //mengambil data item dari basis data
            $datas = $this->mi->getIBItems($type);

            foreach ($datas as $otherItem => $values) {
                if($otherItem != 'id_item-'.$item){
                    $sim[$otherItem] = $this->similarities($datas,'id_item-'.$item,$otherItem,$person);
                }
            }

            array_multisort($sim, SORT_DESC);
            return $this->setPrediction($datas,$sim,$type,$item,$person);
                
        }

        //setting prediction value each items
        //memberikan inlai prediksi terhadap item
        public function setPrediction($datas,$sim,$type,$rand,$person){
            $result = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;

            $items = $this->mi->getIBItem($type);
            foreach ($items as $item) {
                foreach ($sim as $otherItem => $value) {
                    if($rand != $item->id_item){
                        //get rating prediction each data to only 5 higest score of user's similarity
                        //mengambil 5 data dari similaritas para user untuk menghitung prediksi score (nilai)
                        if(array_key_exists($person, $datas[$otherItem]) && array_key_exists('id_item-'.$item->id_item, $this->urating)){
                                if($check <= 5){
                                $sumPre += ($value * $this->urating[$otherItem]);
                                $sumSim += $value;
                                $check += 1;
                            }
                        }
                    }
                            
                }
                if($check != 0){
                    // array_push($result,
                    //     [
                    //         'id_item' => $item->id_item,
                    //         'nama' => $item->nama,
                    //         'jenis' => $item->jenis,
                    //         'rating' => ($item->sumrating/$item->sumrater),
                    //         'img' => $item->img,
                    //         'harga' => $item->harga,
                    //         'rank' => ($sumPre/abs($sumSim))
                    //     ]);
                    $result[$item->id_item] = ($sumPre/abs($sumSim));
                }
                $sumPre = 0;
                $check = 0;
            }

            return$result;
        }

        //calculate similarity distance of rated data each users to user
        //menghitung jarak kesamaan dari rating yang dilakukan para pengguna terhadap pengguna tertentu
        public function similarities($datas,$item,$otherItem,$person){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simDenominator = 0;

            //check similarity true or false
            //mengecek adanya kesamaan data
            if(!$this->isEmpty($datas,$item,$otherItem,$person))
                return 0;

            //calculate similarities formula
            //menghitung rumun mencari kesamaan antar item
            foreach ($datas[$item] as $otherPerson => $value) {
                if(array_key_exists($otherPerson, $datas[$otherItem])){
                    if($otherPerson != $person){
                        $personItem += (pow((float)$value[1]-(float)$value[2],2)); 
                        $otherPersonItem += (pow((float)$datas[$otherItem][$otherPerson][1]-(float)$datas[$otherItem][$otherPerson][2],2));
                        $simDenominator += ((float)$value[1]-(float)$value[2])*((float)$datas[$otherItem][$otherPerson][1]-(float)$datas[$otherItem][$otherPerson][2]);
                    }
                    $this->urating[$otherItem] = $datas[$otherItem][$person][1];
                }
            }

            $sim = $simDenominator / ((sqrt($personItem)) * (sqrt($otherPersonItem)));
            return $sim;
        }

        //check similarity true or false
        //mengecek adanya kesamaan data
        public function isEmpty($datas,$item,$otherItem,$person){
            $count = 0;

            foreach ($datas[$item] as $otherPerson => $value) {
                if(array_key_exists($person, $datas[$otherItem]) && array_key_exists($otherPerson, $datas[$otherItem])){
                    $count += 1;
                    return true;
                }
            }

            return false;
        }
    }

?>