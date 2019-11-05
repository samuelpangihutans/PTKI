<?php
class Search{
    private $clean;

    public function __construct(){
        $this->clean=new Preprocessing();
    }

    public function search($input,$invertedIndex){
        $query=$this->clean->doPreprocessing($input);
        $res=array();
        $words=explode(" ",$query);
        for($i=0;$i<sizeof($words);$i++){
            if(array_key_exists($words[$i],$invertedIndex)==TRUE){
                for($j=0;$j<sizeof((array)$invertedIndex[$words[$i]]);$j++){
                    if(array_key_exists($words[$i],$invertedIndex)){
                        echo $words[$i]." ".$invertedIndex[$words[$i]][$j]." ";
                    }
                }
            }
        }
    }
}


?>