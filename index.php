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

    $dir = opendir('DataSet');
    while ($file = readdir($dir)) { //MEMBUKA DIRECTORY

        if ($file == '.' || $file == '..') {
            continue;
        }

         $currentFile=$file;
         //untuk membaca file 
         $fn = fopen("DataSet/".$currentFile,"r");
         $document="";
         while(! feof($fn))  {
            $result = fgets($fn);
         }
         echo $result;

         fclose($fn);
        
    }
    closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY
?>
    
</body>
</html>