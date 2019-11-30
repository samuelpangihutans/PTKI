<?php

    class TF_IDF{
        private $keys;// untuk term tf_idf
        private $invertedIdx;
        private $TF;
        private $IDF;
        private $TF_IDF;
        

        public function __construct(){
            $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
            $this->invertedIdx = json_decode($strJsonFileContents,true);
            $this->keys = array_keys($this->invertedIdx);
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

            foreach ($this->keys as $key){
                $this->TF[$key][155]=0;
            }
        }

        public function createTFQuery($query){
            //idx 155 untuk array baru
            for($j = 0 ;$j<sizeof($query); $j++){
                if(array_key_exists($query[$j],$this->invertedIdx)==TRUE){
                    // print("masuk");
                    $this->TF[$query[$j]][155]=1;
                    }
            }        
        }
        
        public function saveTF(){
            $dir = "TF_IDF";
            // cek nama direktori
            if( is_dir($dir) === false ){
                mkdir($dir);
            }
            
            // buat file untuk invertedIdx.txt
            $newFile = fopen("TF_IDF/TF.json","w") or die("can't open file");

            // menulis inverted index kedalam file txt
            
            $json = $json = json_encode($this->TF);
            fwrite($newFile, $json);
            
            fclose($newFile);
        }

        public function createIDF(){
            foreach ($this->keys as $key){
                $count = 0;
                for($i = 1 ; $i<=155; $i++){
                    if($this->TF[$key][$i]!=0){
                        $count++;
                    }
                }
                $this->IDF[$key] = log((155/$count),10);
            }
        }
        
        public function doTF_IDF($query){
            // $this->createTF();
            // $this->saveTF();
            $strJsonFileContents = file_get_contents("TF_IDF/TF.json");
            $this->TF = json_decode($strJsonFileContents,true);
            
            $this->createTFQuery($query);
            // print_r($this->TF);
            $this->createIDF();
            $this->calcaulateTF_IDF();
        }

        public function calcaulateTF_IDF(){
            foreach ($this->keys as $key){
                for($i = 1 ;$i<=155; $i++){
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
            return $this->TF_IDF;
        }
    }

?>