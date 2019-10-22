<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
    include('Preprocessing.php');
    $preprocessing =  new Preprocessing();

    include("Statistik.php");
    $statistik = new Statistik();

    $dir = opendir('DataSet');
   
    $idx=0;
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
                $temp += $statistik->jumlahTerm($result);
                fwrite($newFile,$result);// menulis text ke new file
            }
        // echo "sukses cleaning ".$currentFile."<br>";
        $statistik->setValueArrayTerm($temp,$idx);
        $idx++;
        fclose($fn);
    }
    
    fclose($newFile);
    echo $statistik->getValueArrayTerm(0);
    closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY

    $jumlahKata=$statistik->jumlahWord ();

    echo "<br>";
    echo "<br>";
    
    echo "Jumlah Dokumen :".$statistik->getJumlahDoc();
    echo "<br>";
    echo "Jumlah word Seluruh Document : ".$jumlahKata;
?>
    
</body>
</html>