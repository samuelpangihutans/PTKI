<?php

class Statistik{
    //Atribut
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