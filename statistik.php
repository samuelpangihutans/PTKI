<?php

class Statistik{
    //Atribut isi disini PO !!
    private $jmlhKataDoc;
    private $jumlahDoc;
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

    public function jumlahWord ($teks){
        
    }

    public function jumlahTerm($teks){
        $temp = explode(" ", $teks);
        return sizeof($temp);
    }

    public function setValueArrayTerm($res, $idx){
        $this->arrayTerm[$idx]=$res;
    }

    public function getValueArrayTerm($idx){
        return $this->arrayTerm[$idx];
    }

    public function jumlahRataRataWordDoc(){
        $temp = 0;
        for($i = 0; $i<$this->getJumlahDokumen();$i++){
            $temp+=0;
        }
        return $temp/$this->getJumlahDokumen();
    }

    public function jumlahRataRataTermDoc(){
        $temp = 0;
        for($i = 0; $i<$this->getJumlahDokumen();$i++){
            $temp+=$this->arrayTerm[$i];
        }
        return $temp/$this->getJumlahDokumen();
    }

}
?>