<?php
    include("TF_IDF.php");
    include("Cosine.php");
class Search{
    private $clean;
    private $tf_idf;
    private $cosine;

    public function __construct(){
        $this->clean=new Preprocessing();
        $this->tf_idf = new TF_IDF();

    }

    public function search($input,$invertedIndex){
        // melakukan preprocessing untuk query
        $query=$this->clean->doPreprocessing($input);
        // print($query);

        $words=explode(" ",rtrim($query));

        // print_r($words);
        $this->tf_idf->doTF_IDF($words);

        $TF = $this->tf_idf->getTF();
        $IDF = $this->tf_idf->getIDF();
        $TF_IDF = $this->tf_idf->getTF_IDF();

        $this->cosine = new Cosine($TF, $IDF, $TF_IDF);
        $this->cosine->calculateDQ();
        $dq = $this->cosine->getDQ();
        $this->cosine->calculatePower();
        $power = $this->cosine->getPower();
        $res = $this->cosine->calculateCosine();

        // print_r($res);
        // $res=$this->cosine->getRes();
        return $res;
        // $this->tf_idf->getTF_IDF();

        // //untuk menampung hasil
        // $res=[];
        // // split query, dengan menghilangkan white space
        // $words=explode(" ",rtrim($query));
        // // sorting word alfabet
        // sort($words);
        // // looping sebanyak jumlah term hasil prepocessing
        // for($i=0;$i<sizeof($words);$i++){
        //     // cek apakah word ke i ada di dalam inverted index
        //     if(array_key_exists($words[$i],$invertedIndex)==TRUE){
        //         for($j=0;$j<sizeof((array)$invertedIndex[$words[$i]]);$j++){
        //             $idDoc = $invertedIndex[$words[$i]][$j];
        //             // untuk inisialisasi res
        //             if(array_key_exists($idDoc,$res)==FALSE){
        //                 $res[$idDoc]=1;
        //             }else {
        //                 $res[$idDoc]+=1;                        
        //             }
        //         }
        //     }
        // }
        // arsort($res);
        // return $res;
    }
}
?>