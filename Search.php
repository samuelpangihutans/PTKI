<?php
    // include("Preprocessing.php");
    class Search{
        private $query;
        private $invertedIdx;
        private $preprocessing;

        public function __construct($query, $invertedIdx, $preprocessing){
            $this->query = $query;
            $this->invertedIdx = $invertedIdx;
            $this->preprocessing = $preprocessing;
            
        }

        public function preprocQuery(){
            // print($this->preprocessing->doPreprocessing($this->query));
            return $this->preprocessing->doPreprocessing($this->query);
        }

        public function searchDoc(){
            // print($this->preprocQuery());
            // echo "<br>";
            $split = explode(" ",rtrim($this->preprocQuery()));
            print_r($split);
            echo "<br>";
            $arr = array();
            for($i = 0; $i<sizeof($split);$i++){
                // print($split[$i]." i = ".$i);
                
                if(array_key_exists($split[$i],$this->invertedIdx)==TRUE){
                    print_r($split[$i]." ada didalam inverted index ". $i);
                    echo "<br>";
                    $arr[$split[$i]] = $this->invertedIdx[$split[$i]];
                    // print("Key pada Array = ");
                    // print_r($arr[$split[$i]]);
                    // print($i);
                    echo "<br>";
                }
            }
            return $arr;

            // print_r($this->invertedIdx["fair"]);
        }
    }
?>