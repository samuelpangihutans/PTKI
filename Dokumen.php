<?php
class Dokumen{
 
    public function __construct(){ 
     
    }

    public function getJudul($noDoc){
             $currentFile="Doc";
             $ext=".txt";
             if(strlen($noDoc)!=3){
               while(strlen($noDoc)!=3){
                    $temp="0".$noDoc;
                    $noDoc=$temp;
               }
             }
            $currentFile=$currentFile.$noDoc.$ext;
            $fn = fopen("DataSet/".$currentFile,"r") or die("Unable to open file!"); 
            $teks = fgets($fn);
            fclose($fn);   
            return substr($teks,0,strlen($teks)-3);
    }

    public function getDokumen($noDoc){
        $teks="";
        $currentFile="Doc";
        $ext=".txt";
        if(strlen($noDoc)!=3){
          while(strlen($noDoc)!=3){
               $temp="0".$noDoc;
               $noDoc=$temp;
          }
        }
       $currentFile=$currentFile.$noDoc.$ext;
       $fn = fopen("DataSet/".$currentFile,"r") or die("Unable to open file!"); 
       while(!feof($fn)) {
            $teks.=fgets($fn);
        }
      
       fclose($fn);   
       return $teks;
}

public function getDeskripsi($noDoc){
    $teks="";
    $currentFile="Doc";
    $ext=".txt";
    if(strlen($noDoc)!=3){
      while(strlen($noDoc)!=3){
           $temp="0".$noDoc;
           $noDoc=$temp;
      }
    }
   $currentFile=$currentFile.$noDoc.$ext;
   $fn = fopen("DataSet/".$currentFile,"r") or die("Unable to open file!"); 
   while(!feof($fn)) {
        $teks.=fgets($fn);
    }
    fclose($fn);

    if(strlen($teks)<300){
        return $teks."...";
    }
    else{
       return substr($teks,0,300)."...";
    }
      

}

}

?>