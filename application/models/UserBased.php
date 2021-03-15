<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class UserBased extends CI_Model {

        var $Vdistance = [];

        public function __construct() {
            parent::__construct();
            $this->load->model('ModelItem','mi');
        }

        //get the recommendation
        //mengambil rekomendasi
        public function getRecommendations($person,$type){
            $sim = [];
            $prediction = [];

            // echo $type;
            $datas = $this->mi->getUBItems($type);

            foreach ($datas as $otherPerson => $values) {
                if($otherPerson != $person){
                    $sim[$otherPerson] = $this->similarities($datas,$person,$otherPerson);
                }
            }

            array_multisort($sim, SORT_DESC);
            
                // array_multisort($test, SORT_DESC);
            return $this->setPrediction($datas,$sim,$type,$person);;
                
        }

        public function setPrediction($datas,$sim,$type,$person){
            $result = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;

            $items = $this->mi->getUBItem($type);
            foreach ($items as $item) {
                foreach ($datas as $otherPerson => $value) {
                    if(!array_key_exists("id_item-".$item->id_item,$datas[$person])){
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
                    // $test[$item->nama] = $sumPre;
                    array_push($result,
                        [
                            'id_item' => $item->id_item,
                            'nama' => $item->nama,
                            'jenis' => $item->jenis,
                            'rating' => ($item->sumrating/$item->sumrater),
                            'img' => $item->img,
                            'harga' => $item->harga,
                            'rank' => $sumPre
                        ]);
                }
                $sumPre = 0;
                $check = 0;
            }

            return$result;
        }

        //calculate similarity distance of rated data each users to user
        //menghitung jarak kesamaan dari rating yang dilakukan para pengguna terhadap pengguna tertentu
        public function similarities($datas,$person,$otherPerson){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simDenominator = 0;

            if(!$this->isEmpty($datas,$person,$otherPerson))
                return $count;

            //calculate similarities formula
            //menghitung rumun mencari kesamaan antar user
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

        //check similarity true or false
        //mengecek adanya kesamaan data
        public function isEmpty($datas,$person,$otherPerson){
            $count = 0;

            foreach ($datas[$person] as $item => $value) {
                if(array_key_exists($item, $datas[$otherPerson])){
                    $count += 1;
                    return true;
                }
            }

            return false;
        }
    }

?>