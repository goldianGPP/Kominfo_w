<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

    class LibRecommender {

        var $Vdistance = [];

        public function getRecommendations($items, $datas, $person){
            $sim = [];
            $result = [];
            $prediction = [];
            $sumSim = 0;
            $sumPre = 0;
            $check = 0;
            foreach ($datas as $otherPerson => $values) {
                if($otherPerson != $person){
                    $check = $this->distance($datas,$person,$otherPerson);
                    if($check != 0){
                        $sim[$otherPerson] = $check;
                        $sumSim += $sim[$otherPerson];
                    }
                }
            }

            $check = 0;
            array_multisort($sim, SORT_DESC);
            foreach ($items as $item) {
                foreach ($datas as $otherPerson => $value) {
                    if($otherPerson != $person){
                        if(array_key_exists("id_item-".$item->id_item,$datas[$otherPerson])){
                            if($check <= 5){
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
                            'rank' => $sumPre
                        ]);
                }
                $sumPre = 0;
                $check = 0;
            }

            return $result;
                
        }

        public function distance($datas,$person,$otherPerson){
            $p_prsnAvg = 0;
            $o_prsnAvg = 0;
            $count = 0;
            $personItem = 0;
            $otherPersonItem = 0;
            $simDenominator = 0;
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
            // echo $simDenominator."\n";
            // echo ((sqrt(pow($personItem,2))) * (sqrt(pow($otherPersonItem,2))))."\n";
            $this->Vdistance[$otherPerson] = $o_prsnAvg;
            $sim = $simDenominator / ((sqrt($personItem)) * (sqrt($otherPersonItem)));
            return $sim;
        }

    }


// select item.id_item as id_itmes, coalesce(jorans.id_joran, 0) as id_joran, coalesce(kails.id_kail, 0) as id_kail, coalesce(benangs.id_benang, 0) as id_benang
// from item
// left join(
// 	select joran.id_item as id_itmes, id_joran, (null) as id_kail, (null) as id_benang
// 	from joran
// )jorans on  
// item.id_item = jorans.id_itmes
// left join(
// 	select kail.id_item as id_itmes, (null) id_joran, id_kail, (null) as id_benang
// 	from kail
// )kails on  
// item.id_item = kails.id_itmes
// left join(
// 	select benang.id_item as id_itmes, (null) id_joran, (null) as id_kail,  id_benang
// 	from benang
// )benangs on  
// item.id_item = benangs.id_itmes

?>

