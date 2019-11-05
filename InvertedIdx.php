<?php

class InvertedIdx{

    private $inverted_idx;

    public function __construct(){ 
        $this->inverted_idx=array();
    }

    public function create(){
        $dir = opendir('DataSet');
        $noDok=1;
        while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
            if ($file == '.' || $file == '..') {
                continue;
            }
                $currentFile=$file;
                //untuk membaca file 
                $fn = fopen("DataCleaning/".$currentFile,"r");
                //membuat File baru
                $newFile = fopen("DataCleaning/".$currentFile,"w"); 
                while(! feof($fn))  {
                    $teks = fgets($fn);
                    $key[]=$teks.split(' ');
                    for($i=0;$i<sizeof($key);$i++){
                        if(in_array($key[i], $key, FALSE)){
                            array_push($this->inverted_idx,array($key=>""));
                            if(in_array($noDok,$this->inverted_idx[$key],FALSE)){
                                array_push($this->inverted_idx[$key],$noDok);
                            }
                            
                        }
                    }
                }
            $noDok++;
            fclose($fn);
        }
        
        fclose($newFile);
        closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY
    
    }

    public function getInvertedIndex(){
        return $this->inverted_idx;
    }


}


?>