<?php
    include("TF_IDF.php");
    include("Cosine.php");
    include("MixtureModel.php");
class Search{
    private $clean;
    private $tf_idf;
    private $cosine;
    private $mixture;

    public function __construct(){
        $this->clean=new Preprocessing();
        $this->tf_idf = new TF_IDF();

    }

    public function search($mode, $metode,$input,$invertedIndex){
        // melakukan preprocessing untuk query
        $query=$this->clean->doPreprocessing($input);
        // print($query);

        $words=explode(" ",rtrim($query));

        if($metode == 1){
            // print_r($words);
            $this->tf_idf->doTF_IDF($words);

            $TF = $this->tf_idf->getTF();
            $IDF = $this->tf_idf->getIDF();
            $TF_IDF = $this->tf_idf->getTF_IDF();

            $this->cosine = new Cosine($TF, $IDF, $TF_IDF, $this->tf_idf->getCounter());
            $this->cosine->calculateDQ();
            $dq = $this->cosine->getDQ();
            $this->cosine->calculatePower();
            $power = $this->cosine->getPower();
            // $mode = 1;//ambil dari ui, 1 and, 0 or
            $res = $this->cosine->calculateCosine($mode, $words);

            // ASALNYA INI (TF-IDF)
            return $res;
        }else if ($metode == 2){
            $res=[];
            sort($words);
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
                            $res[$idDoc]+=1;                        
                        }
                    }
                }
            }
            $counter = 0;
            for($i = 0; $i<sizeof($words); $i++){
                if($words[$i]!=""){
                    $counter++;
                }
            }

            arsort($res);
            if($mode == 1){
                $keys = array_keys($res);
                $r=[];
                foreach($keys as $key){
                    if($res[$key]==$counter){
                        $r[$key]=$res[$key];
                    }
                }
                return $r;
            }else{
                return $res;
            }
        }else {
            $this->tf_idf->doTF_IDF($words);

            $TF = $this->tf_idf->getTF();

            $this->mixture = new MixtureModel($TF);
            $this->mixture->calculateMixtureModel($words);
            return $this->mixture->getRes();

        }
        // // print_r($words);
        // $this->tf_idf->doTF_IDF($words);

        // $TF = $this->tf_idf->getTF();
        // $IDF = $this->tf_idf->getIDF();
        // $TF_IDF = $this->tf_idf->getTF_IDF();

        // $this->cosine = new Cosine($TF, $IDF, $TF_IDF, $this->tf_idf->getCounter());
        // $this->cosine->calculateDQ();
        // $dq = $this->cosine->getDQ();
        // $this->cosine->calculatePower();
        // $power = $this->cosine->getPower();
        // // $mode = 1;//ambil dari ui, 1 and, 0 or
        // $res = $this->cosine->calculateCosine($mode, $words);

        // // $this->mixture = new MixtureModel($TF);
        // // $this->mixture->calculateMixtureModel($words);
        // // print_r($this->mixture->getRes());

        
        // // ASALNYA INI (TF-IDF)
        // return $res;
        
        // // MIXTURE MODEL
        // return $this->mixture->getRes();

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