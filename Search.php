<?php
class Search{
    private $clean;

    public function __construct(){
        $this->clean=new Preprocessing();
    }

    public function search($input,$invertedIndex){
        // melakukan preprocessing untuk query
        $query=$this->clean->doPreprocessing($input);
        //untuk menampung hasil
        $res=[];
        // split query, dengan menghilangkan white space
        $words=explode(" ",rtrim($query));
        // looping sebanyak jumlah term hasil prepocessing
        for($i=0;$i<sizeof($words);$i++){
            // cek apakah word ke i ada di dalam inverted index
            if(array_key_exists($words[$i],$invertedIndex)==TRUE){
                for($j=0;$j<sizeof((array)$invertedIndex[$words[$i]]);$j++){
                    $idDoc = $invertedIndex[$words[$i]][$j];
                    // untuk inisialisasi res
                    if(array_key_exists($idDoc,$res)==FALSE){
                        $res[$idDoc]=1;
                    }else {
                        $res[$idDoc]+=1;                        }
                }
            }
        }
        print_r($res);
    }
}


?>