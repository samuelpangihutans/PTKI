<?php

class Statistik{
    //Atribut isi disini PO !!
    private $array1;// jumlah word per dokumen


    public function __construct(){ 
        $this->arrayTerm = array();
    }

    public function jumlahDoc (){

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
        
    }

    public function jumlahRataRataTermDoc(){
      
    }

}






?>