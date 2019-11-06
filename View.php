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


<!--view  GAIS -->
<form action="view.php" method="post">
<div class="card mt-2 mr-3" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Data Preprocessing</h5>
    <p class="card-text">Fungsi ini berguna untuk membersihkan data, yakni normalisasi, case folding, stop words, lemmatization, Stemming</p>
    <button type="submit" class="btn btn-primary" name="preprocess">Do Preprocessing</button>
  </div>
</div>
</form>

<?php


if(isset($_POST['preprocess'])){
    include("Statistik.php");
    $statistik = new Statistik();

    include('Preprocessing.php');
    $preprocessing =  new Preprocessing();

    $dir = opendir('DataSet');
    $idx=0;
    while ($file = readdir($dir)) { //MEMBUKA DIRECTORY
        $jTerm=0;
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
                $jTerm += $statistik->jumlahTerm($result);
                fwrite($newFile,$result);// menulis text ke new file
            }
        $statistik->setValueArrayTerm($jTerm,$idx);
        $idx++;
        fclose($fn);
    }
    
    fclose($newFile);
    closedir($dir);  //SELESAI MEMBACA SEMUA DIRECTORY

    $jumlahKata=$statistik->jumlahWord ();
    $jumlahDoc=$statistik->getJumlahDoc();
    $jumlahTerm=$jTerm;
    $jumlahRataRataWordDoc=$statistik->jumlahRataRataWordDoc($jumlahKata);
    $jumlahRataRataTermDoc=$statistik->jumlahRataRataTermDoc();

 echo'<table class="table mt-3 mr-3">
  <thead>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Jumlah Word</td>
      <td>'. $jumlahKata.'</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jumlah Dokumen</td>
      <td> '.$jumlahDoc.'</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Jumlah Term</td>
      <td>'. $jumlahTerm.'</td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>Jumlah rata-rata word dokumen</td>
      <td>'. $jumlahRataRataWordDoc.'</td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>Jumlah rata-rata term dokumen</td>
      <td>'. $jumlahRataRataTermDoc.'</td>
    </tr>
  </tbody>
</table>';
    

}
?>

<!-- <table class="table">
  <thead>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Jumlah Word</td>
      <td><?php $jumlahKata?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jumlah Dokumen</td>
      <td><?php $jumlahDoc?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Jumlah Term</td>
      <td><?php $jumlahTerm?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>Jumlah rata-rata word dokumen</td>
      <td><?php $jumlahRataRataWordDoc?></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>Jumlah rata-rata term dokumen</td>
      <td><?php $jumlahRataRataTermDoc?></td>
    </tr>
  </tbody>
</table> -->
    
</body>
</html>