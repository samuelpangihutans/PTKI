<?php

class InvertedIdx{

    private $inverted_idx;

    public function __construct(){ 
        $this->inverted_idx=[];
    }

    public function create(){
        $dir = opendir('DataCleaning');
        $noDok=1;
        while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
            if ($file == '.' || $file == '..') {
                continue;
            }
                $currentFile=$file;
                //untuk membaca file 
                $fn = fopen("DataCleaning/".$currentFile,"r");
                while(! feof($fn))  {
                    $teks = fgets($fn);
                    $key=explode(" ",$teks);
                    for($i=0;$i<sizeof($key);$i++){
                       if(in_array($key[$i],$this->inverted_idx)){
                        }
                        else{
                        
                                 if(in_array($noDok,$this->inverted_idx)){
                               
                                  }
                                  else{
                                  $this->inverted_idx[$key[$i]][]=$noDok;
                                }
                        }
                    }
                }
            $noDok++;
            fclose($fn);
        }
        closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY
    
    }

    public function getInvertedIndex(){
        print_r($this->inverted_idx);
    }


}


?>