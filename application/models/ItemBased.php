<?php
// || \\ array_push($data,['id_cuci' => $key->id_cuci,'nama_cuci' => $key->nama_cuci]);
    class ItemBased extends CI_Model {

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
                    $temp = $this->similarities($datas,'id_item-'.$item,$otherItem,$person);
                    if (is_array($temp)){
                        $sim[$otherItem] = $temp;
                    }
                }
            }

            array_multisort($sim, SORT_DESC);

            $result = $this->setPrediction($datas,$sim,$type,$item,$person);
            return $result;
                
        }

        //setting prediction value each items
        //memberikan inlai prediksi terhadap item
        public function setPrediction($datas,$sim,$type,$cur_item,$person){
            $result = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;

            $items = $this->mi->getIBItem(array_keys($sim),$cur_item,$type);

            foreach ($items as $item) {
                foreach ($datas["id_item-".$item->id_item] as $otherPerson => $value) {
                    $sumPre += ($sim["id_item-".$item->id_item][0] * $value[1]);
                    $sumSim += abs($sim["id_item-".$item->id_item][0]);
                    $check +=1;
                    //get rating prediction each data to only 5 higest score of user's similarity
                    //mengambil 5 data dari similaritas para user untuk menghitung prediksi score (nilai)
                    if($check > 5)
                        break;
                }

                if($check != 0){
                    if ($sumSim<=0) 
                        $data = 0;
                    else
                        $data = $sumPre/$sumSim;

                    array_push($result, [   
                            'id_pengguna' => $item->id_pengguna,
                            'id_item' => $item->id_item,
                            'nama' => $item->nama,
                            'jenis' => $item->jenis,
                            'rating' => ($item->subrating/$item->sumrater),
                            'deskripsi' => $item->deskripsi,
                            'img' => $item->img,
                            'harga' => $item->harga,
                            'web' => $item->web,
                            'rank' => $data,
                        ]);
                }
                $sumPre = 0;
                $sumSim = 0;
                $check = 0;
            }

            array_multisort(array_column($result, 'rank'), SORT_DESC, $result);
            // print_r(array_column($result, 'id_item'));
            // die();
            return $result;
            // return $result;
        }

        //calculate similarity distance of rated data each users to user
        //menghitung jarak kesamaan dari rating yang dilakukan para pengguna terhadap pengguna tertentu
        public function similarities($datas,$item,$otherItem,$person){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simNumerator = 0;

            //check similarity true or false
            //mengecek adanya kesamaan data
            if(!$this->isEmpty($datas,$item,$otherItem,$person)){
               return 0;
            }

            //calculate similarities formula
            //menghitung rumun mencari kesamaan antar item
            foreach ($datas[$item] as $otherPerson => $value) {
                if(array_key_exists($otherPerson, $datas[$otherItem])){
                    if($otherPerson != $person){
                        $personItem += (pow((float)$value[1]-(float)$value[2],2)); 
                        $otherPersonItem += (pow((float)$datas[$otherItem][$otherPerson][1]-(float)$datas[$otherItem][$otherPerson][2],2));
                        $simNumerator += ((float)$value[1]-(float)$value[2])*((float)$datas[$otherItem][$otherPerson][1]-(float)$datas[$otherItem][$otherPerson][2]);
                    }
                }
            }

            $simDenominator = ((sqrt($personItem)) * (sqrt($otherPersonItem)));

            if ($simDenominator<=0){
               return 0;
            }
            else{
               return $sim = [($simNumerator / $simDenominator)];
            }
        }

        //check similarity true or false
        //mengecek adanya kesamaan data
        public function isEmpty($datas,$item,$otherItem,$person){
            $count = 0;

            foreach ($datas[$item] as $otherPerson => $value) {
                if(array_key_exists($otherPerson, $datas[$otherItem])){
                    $count += 1;
                    return true;
                }
            }
            
            return false;
        }
    }

?>