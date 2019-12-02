<?php
    include("statistik.php");

    class MixtureModel{
        private $TF;
        private $res, $doc, $termPerDoc;
        private $keys;
        private $statistik;
        private $jumlahTerm;
        private $lamda;

        private $invertedIdx;

        public function __construct($TF){
            $this->TF = $TF;
            $this->res = [];
            $this->doc = [];
            $this->termPerDoc = [];
            for($i = 1; $i <= 154; $i++){
                $this->termPerDoc[$i]=0;
                $this->doc[$i]= 0;
                $this->res[$i]=0;
            }
            $this->keys = array_keys($this->TF);
            $this->statistik = new Statistik();
            $this->statistik->jumlahWord();
            $this->jumlahTerm = $this->statistik->getValueArrayTerm();
            print($this->jumlahTerm);
            $this->lamda = 0.4;

            $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
            $this->invertedIdx = json_decode($strJsonFileContents,true);
            $this->calculateTermPerDoc();
        }

        public function calculateMixtureModel($query){
            for($j = 0 ;$j<sizeof($query); $j++){
                if(array_key_exists($query[$j],$this->invertedIdx)==TRUE){
                    $this->calculateDoc($query[$j]);
                    for ($i = 1; $i <= 154; $i++){
                        if($this->jumlahTerm!=0 && $this->doc[$i]!=0){
                            $a = $this->lamda*($this->TF[$query[$j]][$i]/$this->doc[$i]);
                            $b = (1-$this->lamda)*($this->TF[$query[$j]][$i]/$this->jumlahTerm);
                            $this->res[$i]+=$a*$b;
                        }
                    }
                }
            }        
        }

        public function getRes(){
            print_r($this->res);
        }

        public function calculateDoc($term){
            $temp = $this->TF[$term];
            for($i = 1; $i <=154; $i++){
                $this->doc[$i]=$temp[$i];
            }
        }

        public function calculateTermPerDoc(){
            foreach($this->keys as $key){
                for($i = 1; $i <= 154; $i++){
                    $this->termPerDoc[$i]+=$this->TF[$key][$i];
                }
                
            }
        }
    }
?>