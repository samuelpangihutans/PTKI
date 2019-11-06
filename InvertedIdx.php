<?php
    class InvertedIdx{
        private $invertedIdx;

        public function __construct(){
            $this->invertedIdx = array();
        }

        public function createInvertedIdx(){
            $dir = opendir('DataCleaning');
            $idx=1;// untuk no dokumen
            while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
                $temp=0;
                if ($file == '.' || $file == '..') {
                    continue;
                }
                    $currentFile=$file;
                    //untuk membaca file 
                    $fn = fopen("DataCleaning/".$currentFile,"r");
 
                    while(! feof($fn))  {
                        $teks = fgets($fn);
                        $split=explode(" ",$teks);
                        for($i = 0; $i<sizeof($split); $i++){
                            // key yang ada di array saat ini
                            $keys = array_keys($this->invertedIdx);
                            // kalau key belum ada di array
                            if(array_key_exists($split[$i],$this->invertedIdx)==FALSE){//return false
                                $this->invertedIdx[$split[$i]] = array($idx);
                                #var_dump(array_key_exists($split[$i], $this->invertedIdx));
                            }
                            // kalau key sudah ada di array dibeda dokumen
                            else if(array_key_exists($split[$i],$this->invertedIdx)==TRUE){
                                $temp = $this->invertedIdx[$split[$i]];
                                if($temp[sizeof($temp)-1]!=$idx){
                                    $temp[sizeof($temp)] = $idx;
                                    $this->invertedIdx[$split[$i]] = $temp;
                                }
                            }
                        }
                        
                    }
                $idx++;
                fclose($fn);
            }
            closedir($dir);
            $keys = array_keys($this->invertedIdx);
            // print_r(array_keys($this->invertedIdx));
<<<<<<< HEAD
            for ($i = 0;$i<sizeof($keys);$i++){
                print_r("Keys = ".$keys[$i]." Values =");
                for($j = 0;$j<sizeof($this->invertedIdx[$keys[$i]]);$j++){
                    print_r($this->invertedIdx[$keys[$i]][$j]." ");
                }
                echo "<br>";
            }
            echo "<br>";
=======
            // for ($i = 0;$i<sizeof($keys);$i++){
            //     print_r("Keys = ".$keys[$i]." Values =");
            //     for($j = 0;$j<sizeof($this->invertedIdx[$keys[$i]]);$j++){
            //         print_r($this->invertedIdx[$keys[$i]][$j]." ");
            //     }
            //     echo "<br>";
            // }
            // echo "<br>";
>>>>>>> a91815a26d4d855708cb6731038a813d5562631b
            return $this->invertedIdx;
            // print_r("Keys ".$keys[0]." value ".$this->invertedIdx[$keys[0]]);
        }
    }
?>