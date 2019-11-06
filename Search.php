<?php
class Search{
    private $clean;

    public function __construct(){
        $this->clean=new Preprocessing();
    }

    public function search($input,$invertedIndex){
        $query=$this->clean->doPreprocessing($input);
        $res=[];
        $words=explode(" ",rtrim($query));
        for($i=0;$i<sizeof($words);$i++){
            if(array_key_exists($words[$i],$invertedIndex)==TRUE){
                for($j=0;$j<sizeof((array)$invertedIndex[$words[$i]]);$j++){
                        $idDoc = $invertedIndex[$words[$i]][$j];
                        if(array_key_exists($idDoc,$res)==FALSE){
                            $res[$idDoc]=1;
                        }else {
                            $res[$idDoc]+=1;
                        }
                        //checking words
                        //echo $words[$i]." ".$invertedIndex[$words[$i]][$j]." ";
                }
                echo "<br>";
            }
        }
        print_r($res);
    }
}


?>