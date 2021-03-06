<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>






<?php
    include('Preprocessing.php');
    $preprocessing =  new Preprocessing();

    include("Statistik.php");
    $statistik = new Statistik();

    include('InvertedIdx.php');
    $invertedIdx=new InvertedIdx();

    include("Search.php");
    $search=new Search();

    $dir = opendir('DataSet');
    
    $idx=0;
    $times = 0;
    while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
        $temp=0;
        if ($file == '.' || $file == '..') {
            continue;
        }
            $statistik->jumlahDoc();
            $currentFile=$file;
            //untuk membaca file 
            $fn = fopen("DataSet/".$currentFile,"r");
            //membuat File baru
            $newFile = fopen("DataCleaning/".$currentFile,"w"); 
            while(! feof($fn))  {
                $teks = fgets($fn);
                $result = $preprocessing->doPreprocessing($teks);
                $times += $preprocessing->getTime();
                $temp += $statistik->jumlahTerm($result);
                fwrite($newFile,$result);// menulis text ke new file
            }
        //echo "sukses cleaning ".$currentFile."<br>";
        $statistik->setValueArrayTerm($temp,$idx);
        $idx++;
        fclose($fn);
    }
    
    fclose($newFile);
    closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY

    $jumlahKata=$statistik->jumlahWord ();

    // echo "<br>";
    // echo "<br>";
    
    // echo "Jumlah Dokumen :".$statistik->getJumlahDoc();
    
    // echo "<br>";
    // echo "<br>";
    // echo "Jumlah word Seluruh Document : ".$jumlahKata;
    // echo "<br>";
    // echo "Rata-rata word tiap dokumen : ".$statistik->jumlahRataRataWordDoc($jumlahKata);
    
    // echo "<br>";
    // echo "<br>";
    echo "Jumlah Term : ".$statistik->getValueArrayTerm(0);
    echo "<br>";
    // echo "Rata-rata term setiap dokumen : ".$statistik->jumlahRataRataTermDoc();
    print_r("Exceution time Preprocessing = ".$times);
    echo "<br>";

    $start = microtime(true);
    $invertedIdx->createInvertedIdx();
    $time_elapsed_secs = microtime(true) - $start;

    print_r("Exceution time Inverted Index = ".$time_elapsed_secs);

    echo "<br>";


    $idx = $invertedIdx->getInvertedIdx();
    $invertedIdx->saveInvertedIdx();
    $search->search("fairest people die first",$invertedIdx->getInvertedIdx());
    
    
    #$invertedIdx->getInvertedIndex();
    // $inverted = $invertedIdx->getInvertedIndex();

    // // print_r(array_keys($inverted));

    // $search = new Search("fairest people die first", $inverted, $preprocessing);
    // // $search->preprocQuery();
    // $temp = $search->searchDoc();
    // $keys = array_keys($temp);
    // // print_r($temp);
    // // print_r("Key ".$keys[0]." values ".$temp[$keys[0]]);
    // echo "<br>";
    // // print_r(sizeof($temp));

    // $t = $inverted[$keys[0]];
    // print_r(sizeof($t));
    // echo "<br>";
    // print_r(sizeof($t));
    // // cara barbar
    // if(sizeof($temp)==1){
    //     print_r($temp);
    // }else if(sizeof($temp)>1){
    //     $keys = array_keys($temp);
    //     if(sizeof($temp)==2){
    //         print_r(array_intersect_assoc($temp[$keys[0]],$temp[$keys[1]]));
    //     }else{
    //         for($i = 0;$i<sizeof($temp)-1;$i++){
    //             if($i==0){
    //                 $arr1 = $temp[$keys[$i]];
    //                 $arr2 = $temp[$keys[$i+1]];
    //                 $te = array_intersect_assoc($arr1,$arr2);
    //             }else{
    //                 $arr1 = $te;
    //                 $arr2 = $temp[$keys[$i+1]];
    //                 $te = array_intersect_assoc($arr1,$arr2);
    //             }   
    //         }
    //         return $te;
    //     }
    // }
    // print_r($inverted[""]);
?>
    
</body>
</html>