<?php
    class InvertedIdx{
        // array untuk menampung inverted index
        private $invertedIdx;
        // private $abcd;

        public function __construct(){
            $this->invertedIdx = array();
            // $this->term="";
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
                            // jika buka string kosong
                            if($split[$i] != ""){
                                // penampung
                                // $this->term.=$split[$i]." ";
                                // kalau term belum ada di array
                                if(array_key_exists($split[$i],$this->invertedIdx)==FALSE){
                                    // inisialisasi key pada array 
                                    // memberikan value pada key
                                    $this->invertedIdx[$split[$i]] = array($idx);
                                }
                                // kalau term sudah ada di array dibeda dokumen
                                else if(array_key_exists($split[$i],$this->invertedIdx)==TRUE){
                                    $temp = $this->invertedIdx[$split[$i]];
                                    // menghindari duplikasi no dokumen yang sama
                                    // cek di index sebelumnya
                                    if($temp[sizeof($temp)-1]!=$idx){
                                        // isi di index selanjutnya dengan no dokumen berbeda
                                        $temp[sizeof($temp)] = $idx;
                                        $this->invertedIdx[$split[$i]] = $temp;
                                    }
                                }
                            }
                        }
                    }
                $idx++;
                fclose($fn);
            }
            closedir($dir);
            ksort($this->invertedIdx);
        }

        public function getInvertedIdx(){
            return $this->invertedIdx;
        }

        public function print(){
            // keys berupa term haris preprocessing
            $keys = array_keys($this->invertedIdx);
            for ($i = 0;$i<sizeof($keys);$i++){
                // print keys
                print_r("Keys = ".$keys[$i]." Values =");
                for($j = 0;$j<sizeof($this->invertedIdx[$keys[$i]]);$j++){
                    // print values yang terdapat pada keys
                    print_r($this->invertedIdx[$keys[$i]][$j]." ");
                }
                echo "<br>";
            }
        }

        public function saveInvertedIdx(){
            $dir = "InvertedIdx";
            // cek nama direktori
            if( is_dir($dir) === false ){
                mkdir($dir);
            }
            
            // buat file untuk invertedIdx.txt
            $newFile = fopen("InvertedIdx/invertedIdx.json","w") or die("can't open file");

            // menulis inverted index kedalam file txt
            
            $json = $json = json_encode($this->invertedIdx);
            fwrite($newFile, $json);
            
            fclose($newFile);
        }
    }
?>