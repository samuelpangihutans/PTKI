<?php

class Statistik{
    // atribut untuk jumlah kata dalam doc
    private $jmlhKataDoc;
    // atribut untuk jumlah doc
    private $jumlahDoc;
    // atribut untuk menampung term
    private $arrayTerm;

    public function __construct(){ 
        $this->jmlahKataDoc=array();
        $this->jumlahDOc=0;
        $this->arrayTerm = array();
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
         $idx=0;
         $dir = opendir('DataSet');
         while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
             if ($file == '.' || $file == '..') {
                 continue;
             }
                 $currentFile=$file;
                 //untuk membaca file 
                 $fn = fopen("DataSet/".$currentFile,"r");
                 $temp = 0;
                 while(! feof($fn))  {
                     $teks = fgets($fn);
                     $kata = explode(" ",$teks);
                     $sum=$sum+count($kata);
                     $temp += $this->jumlahTerm($teks);
                 }
            $this->setValueArrayTerm($temp,$idx);
            $idx++;
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

    // idx untuk nomor dokumen
    // res jumlah term pada dokumen idx 
    public function setValueArrayTerm($res, $idx){
        $this->arrayTerm[$idx]=$res;
    }

    // mengembalikan jumlah term pada semua dokumen
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