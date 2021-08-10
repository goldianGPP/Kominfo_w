<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class UserBased extends CI_Model {

        public function __construct() {
            parent::__construct();
            $this->load->model('ModelItem','mi');
        }

        //get the recommendation
        //mengambil rekomendasi
        public function getRecommendations($person,$type){
            $sim = [];
            $prediction = [];


            if(is_array($type)){
                $datas = $this->mi->getUBItemsSearch($type);
                if (empty($datas[$person])) {
                    return null;
                }
            }
            else{
                $datas = $this->mi->getUBItems($type);
                if ($type!==null && empty($datas[$person])) {
                    return null;
                }
            }

            foreach ($datas as $otherPerson => $values) {
                if($otherPerson != $person){
                    $temp = $this->similarities($datas,$person,$otherPerson);
                    if (is_array($temp)) {
                        $sim[$otherPerson] = $temp;
                    }
                }
            }

            array_multisort($sim, SORT_DESC);

            return $this->setPrediction($datas,$sim,$type,$person);
        }

        public function setPrediction($datas,$sim,$type,$person){
            $result = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;
            $avgU= 0;

            foreach ($datas[$person] as $item => $value) {
                $avgU = $value[2];
                break;
            }

            if(is_array($type))
                $items = $this->mi->getUBItemSearch(array_keys($datas[$person]),$type);
            else
                $items = $this->mi->getUBItem(array_keys($datas[$person]),$type);

            foreach ($items as $item) {
                foreach ($sim as $otherPerson => $value) {
                    if(array_key_exists("id_item-".$item->id_item, $datas[$otherPerson])){
                        $sumPre += ($value[0] * $value[1]);
                        $sumSim += abs($value[0]);
                        $check += 1;

                        if($check >= 5)
                            break;
                    }
                }
                if($check != 0){
                    $rank = $avgU + ($sumPre/$sumSim);
                    array_push($result,
                        [
                            'id_pengguna' => $item->id_pengguna,
                            'id_item' => $item->id_item,
                            'nama' => $item->nama,
                            'jenis' => $item->jenis,
                            'web' => $item->web,
                            'rating' => ($item->subrating/$item->sumrater),
                            'deskripsi' => $item->deskripsi,
                            'img' => $item->img,
                            'harga' => $item->harga,
                            'rank' => $rank
                        ]);
                }
                $sumPre = 0;
                $sumSim = 0;
                $check = 0;
            }
            
            array_multisort(array_column($result, 'rank'), SORT_DESC, $result);
            return $result;
        }

        //array_multisort(array_column($inventory, 'price'), SORT_DESC, $inventory);

        //calculate similarity distance of rated data each users to user
        //menghitung jarak kesamaan dari rating yang dilakukan para pengguna terhadap pengguna tertentu
        public function similarities($datas,$person,$otherPerson){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simNumerator = 0;

            if(!$this->isEmpty($datas,$person,$otherPerson)){
                return 0;
            }

            //calculate similarities formula
            //menghitung rumun mencari kesamaan antar user
            foreach ($datas[$person] as $item => $value) {
                if(array_key_exists($item, $datas[$otherPerson])){
                    $personItem += (pow((float)$value[1]-(float)$value[2],2)); 
                    $otherPersonItem += (pow((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2],2));
                    $o_prsnAvg += ((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2]);
                    $simNumerator += ((float)$value[1]-(float)$value[2])*((float)$datas[$otherPerson][$item][1]-(float)$datas[$otherPerson][$item][2]);
                }
            }

            $Vdistance = $o_prsnAvg;

            $simDenominator = (sqrt($personItem) * sqrt($otherPersonItem));
            if ($simDenominator<0) {
                return 0;
            }
            else
                return $sim = [($simNumerator / $simDenominator), $Vdistance];
        }

        //check similarity true or false
        //mengecek adanya kesamaan data
        public function isEmpty($datas,$person,$otherPerson){
            foreach ($datas[$person] as $item => $value) {
                if(array_key_exists($item, $datas[$otherPerson])){
                    return true;
                }
            }

            return false;
        }
    }

?>