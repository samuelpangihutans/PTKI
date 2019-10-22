<?php

class Statistik{
    //Atribut isi disini PO !!
    private $jmlhKataDoc;
    private $jumlahDoc;

    public function __construct(){ 
    $this->jmlahKataDoc=array();
    $this->jumlahDOc=0;
    }

    public function jumlahDoc (){
        $this->jumlahDoc++;
    }

    public function getJumlahDoc(){
        return $this->jumlahDoc;
    }

    public function jumlahWord (){
        //Ganda dihitung , berarti diambil dari data mentah keseluruhan doc
        $counter=0;
        $sum=0;
        $result=0;
        $dir = opendir('DataSet');
        while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
            if ($file == '.' || $file == '..') {
                continue;
            }
                $currentFile=$file;
                //untuk membaca file 
                $fn = fopen("DataSet/".$currentFile,"r");
                while(! feof($fn))  {
                    $teks = fgets($fn);
                    $kata = explode(" ",$teks);
                    $sum=$sum+count($kata);
                }
            fclose($fn);
            $this->jmlhKataDoc[$counter]=$sum;
            $counter=$counter+1;
            $sum=0;
        }
        closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY
    for($i=0;$i<count($this->jmlhKataDoc);$i++){
        $result+=$this->jmlhKataDoc[$i];
    }
    return $result;
    }

    public function jumlahTerm(){
        //ganda g dihitung, berarti ambil dari data setelah celaning keseluruhan doc
    }

    public function jumlahRataRataWordDoc(){
        
    }

    public function jumlahRataRataTermDoc(){
      
    }

}






?>