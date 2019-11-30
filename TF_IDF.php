<?php

    class TF_IDF{
        private $keys;// untuk term tf_idf
        private $result;
        

        public function __construct(){
            $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
            $invertedIdx = json_decode($strJsonFileContents,true);
            $this->keys = array_keys($invertedIdx);
            // foreach ($this->keys as $key){
            //    print_r($key);
            //    echo "<br>";         
            // }
            $this->result = [];
            // print_r($this->keys);
        }

        private function createTF(){
            $dir = opendir('DataCleaning');
            $idx=1;// untuk no dokumen
            $temp = [];
            while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
                
                if ($file == '.' || $file == '..') {
                    continue;
                }
                    $currentFile=$file;
                    //untuk membaca file 
                    
                    
                    foreach ($this->keys as $key){
                        // print($key);
                        // echo "<br>";
                        $fn = fopen("DataCleaning/".$currentFile,"r");
                        $count = 0;
                        while(! feof($fn))  {
                            $teks = fgets($fn);
                            $split=explode(" ",$teks);
                            for($i = 0; $i<sizeof($split); $i++){
                                // jika buka string kosong
                                if($split[$i] != ""){
                                    // print($split[$i]);
                                    // echo "<br>";
                                    if(strcmp($split[$i], $key) == 0){
                                        $count++;
                                        // print("masuk");
                                    }
                                }
                            }
                        }
                        $temp[$idx]=$count;
                        $this->result[$key]=$temp;
                        // if($count !=0){
                        //     print($count." ".$key);
                        //     echo "<br>";
                        // }
                    }
                $idx++;
                fclose($fn);
            }
            closedir($dir);
        }
        
        public function getResult(){
            $this->createTF();
            print_r($this->result);
        }


        
    }



    $tf_idf = new TF_IDF();
    $tf_idf->getResult();

?>