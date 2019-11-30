<?php

    class TF_IDF{
        private $keys;// untuk term tf_idf
        private $TF;
        private $IDF;
        private $TF_IDF;
        

        public function __construct(){
            $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
            $invertedIdx = json_decode($strJsonFileContents,true);
            $this->keys = array_keys($invertedIdx);
            $this->TF = [];
            $this->IDF = [];
            $this->TF_IDF = [];
        }

        public function createTF(){
            $dir = opendir('DataCleaning');
            $idx=1;// untuk no dokumen
            while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
                
                if ($file == '.' || $file == '..') {
                    continue;
                }
                    $currentFile=$file;
                    // looping per term di setiap dokumen
                    foreach ($this->keys as $key){
                        //untuk membaca file
                        $fn = fopen("DataCleaning/".$currentFile,"r");
                        $count = 0;
                        while(! feof($fn))  {
                            $teks = fgets($fn);
                            $split=explode(" ",$teks);
                            for($i = 0; $i<sizeof($split); $i++){
                                // jika buka string kosong
                                if($split[$i] != ""){
                                    if($split[$i] == $key){
                                        $count++;
                                    }
                                }
                            }
                        }
                        $this->TF[$key][$idx]=$count;
                    }
                $idx++;
                fclose($fn);
            }
            closedir($dir);
        }

        public function createTFQuery($query){
            $dir = opendir('DataCleaning');
            while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
                
                if ($file == '.' || $file == '..') {
                    continue;
                }
                    $currentFile=$file;
                    // looping per term di setiap dokumen
                    $query = explode(" ",$query);
                    for($j = 0 ;$j<sizeof($query); $j++){
                        //untuk membaca file
                        $fn = fopen("DataCleaning/".$currentFile,"r");
                        $count = 0;
                        while(! feof($fn))  {
                            $teks = fgets($fn);
                            $split=explode(" ",$teks);
                            for($i = 0; $i<sizeof($split); $i++){
                                // jika buka string kosong
                                if($split[$i] != ""){
                                    if($split[$i] == $query[$j]){
                                        $count++;
                                    }
                                }
                            }
                        }
                        //idx 155 untuk array baru
                        if(array_key_exists($query[$j],$this->keys)==TRUE){
                            $this->TF[$key][155]=$count;
                        }
                        
                    }
                $idx++;
                fclose($fn);
            }
            closedir($dir);
        }

        public function createIDF(){
            foreach ($this->keys as $key){
                $count = 0;
                for($i = 1 ; $i<=154; $i++){
                    if($this->TF[$key][$i]!=0){
                        $count++;
                    }
                }
                $this->IDF[$key] = log((154/$count),10);
                // if($key=="fair"){
                //     print($count);
                //     print(log((154/$count),10));
                // }
            }
        }
        
        public function doTF_IDF(){
            $this->createTF();
            $this->createIDF();
            $this->calcaulateTF_IDF();
        }

        public function calcaulateTF_IDF(){
            foreach ($this->keys as $key){
                for($i = 1 ;$i<154; $i++){
                    $this->TF_IDF[$key][$i] = $this->TF[$key][$i]*$this->IDF[$key];
                }
            }
        }

        public function getTF(){
            return $this->TF;
        }

        public function getIDF(){
            return $this->IDF;
        }
        
        public function getTF_IDF(){
            print_r($this->TF_IDF);
        }



    }

    

    $tf_idf = new TF_IDF();
    $tf_idf->doTF_IDF();
    $tf_idf->getTF_IDF();

?>