<?php

class Statistik{
    private $jumlahDokumen;

    public function __construct(){ 
        $jumlahDokumen=0;
    }

    public function jumlahDoc (){
        $this->jumlahDokumen++;
    }

    public function getJumlahDokumen(){
        return $this->jumlahDokumen;
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

    public function jumlahTerm($teks){
        $temp = explode(" ", $teks);
        return sizeof($temp);
    }

    public function setValueArrayTerm($res, $idx){
        $this->arrayTerm[$idx]=$res;
    }

    public function getValueArrayTerm(){
        $res=0;
        for ($i = 0 ; $i<$this->getJumlahDoc();$i++){
            $res+=$this->arrayTerm[$i];
        }
        return $res;
    }

    public function jumlahRataRataWordDoc($jumlahKata){
        return $jumlahKata/$this->getJumlahDoc();
    }

    public function jumlahRataRataTermDoc(){
        return $this->getValueArrayTerm()/$this->getJumlahDoc();
    }

}
?>