<?php
    class Cosine{
        private $TF, $IDF, $TF_IDF;
        private $keys;
        private $res;
        private $res2;
        private $cosine;
        private $dq;

        private $counter;

        private $power;

        public function __construct($TF, $IDF, $TF_IDF, $counter){
            $this->TF = $TF;
            $this->IDF = $IDF;
            $this->TF_IDF = $TF_IDF;

            $this->keys = array_keys($TF_IDF);

            $this->dq = [];

            $this->power = [];
            $this->res=[];
            $this->res2=[];
            $this->cosine=[];
            for($i=1;$i<=154;$i++){
                $this->res[$i]=0;
                $this->res2[$i]=0;
                $this->cosine[$i]=0;
            }
            $this->res2[155]=0;

            $this->counter=$counter;
        }

        public function calculateDQ(){
            foreach ($this->keys as $key){
                for($i = 1; $i<=154; $i++){
                    $this->dq[$key][$i]=$this->TF_IDF[$key][$i]*$this->TF_IDF[$key][155];
                }
            }
        }

        public function calculatePower(){
            foreach($this->keys as $key){
                for($i = 1; $i<=155; $i++){
                    $this->power[$key][$i]=pow($this->TF_IDF[$key][$i],2);
                }
            }
        }

        public function calculateCosine($mode, $query){
            foreach($this->keys as $key){
                for($i=1;$i<=154;$i++){
                    $this->res[$i]+=$this->dq[$key][$i];
                }
                for($i=1;$i<=155;$i++){
                    $this->res2[$i]+=$this->power[$key][$i];
                }
                for($i=1;$i<=155;$i++){
                    $this->res2[$i]=sqrt($this->res2[$i]);
                }
            }
            for($i=1;$i<=154;$i++){
                if (($this->res2[$i]*$this->res2[155])!=0){
                    $this->cosine[$i]=$this->res[$i]/($this->res2[$i]*$this->res2[155]);
                }
                
            }
            
            return $this->cek($mode, $query);

            // arsort($this->cosine);
            // return $this->cosine;
        }

        public function AND($query){
            $res = 0;
            for($i = 0; $i<sizeof($query); $i++){
                if($query[$i]!=""){
                    $res++;
                }
            }
            if($res==$this->counter){
                return 1;
            }else{
                return 0;
            }
        }

        public function cek($mode, $query){
            if($mode == 1){//and
                if($this->AND($query)==1){
                    arsort($this->cosine);
                    return $this->cosine;
                }else{
                    return [];
                }
            }else{//or
                arsort($this->cosine);
                return $this->cosine;
            }
        }

        public function getDQ(){
            return $this->dq;
        }

        public function getPower(){
            return $this->power;
        }

        public function getRes(){
            return $this->res;
        }
    }
?>