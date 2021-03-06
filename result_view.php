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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>

    <style>
        /* Styles for wrapping the search box */


    </style>

</head>
<body>
<H1 class="mt-4 left pl-5"><a style="color:teal"href="index.php">SEMA SEARCH </a></H1>
<form action="result_view.php" method="post">
  <!-- Another variation with a button -->
  <div id="g1" class="input-group pl-5 pt-2 pb-3 p5-3 w-50">
    <input type="text" name="query" class="form-control" placeholder="Search Document">
    <select name="mode">
        <option value="1" selected="selected">AND</option>
        <option value="0">OR</option>
    </select>
    <select name="top">
        <option selected="selected" value="all">ALL</option>
        <option value="5">TOP 5</option>
        <option value="10">TOP 10</option>
    </select>
    <select name="metode">
        <option selected="selected" value="1">TF-IDF</option>
        <option value="2">Inverted Index</option>
        <option value="3">Language Model</option>
    </select>
    <div class="input-group-append">
      <button class="btn btn-secondary" type="submit" name="search">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>

<?php
if(isset($_POST['search'])){
    include("Search.php");
    include("preprocessing.php");
    
    $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
    $invertedIdx=json_decode($strJsonFileContents,true);

    $query=$_POST["query"];
    $search=new Search();
    
    // $tf_idf = new TF_IDF();
    // $tf_idf->doTF_IDF($query);

    $mode=$_POST["mode"];
    $metode=$_POST["metode"];
    $start = microtime(true);
    $res = $search->search($mode, $metode,$query,$invertedIdx);
    $time = microtime(true) - $start;
    echo '<p class="pl-5">Execeution Time Search : '.$time.' </p>';
    echo '<hr class="ml-5 mr-5" >';

    $notRelevant=array();
    $golden_answer=array();
    $relevant=array();

    if(!is_null($res)){
      $keys = array_keys($res);
      // sort($keys);
      for ($i = 0;$i<count($keys);$i++){
          if($res[$keys[$i]]>0){
            array_push($relevant,$keys[$i]);
            array_push($golden_answer,$keys[$i]);
          }
          else if($res[$keys[$i]]<=1){
              array_push($notRelevant,$keys[$i]);
          }
      }
      echo "<br>";
      $precision=0;
      if(count($relevant)+count($notRelevant)!=0){
        $precision=count($relevant)/(count($relevant)+count($notRelevant));
      }
      $false_negative=count($golden_answer)-count($relevant);
      
      $recall=0;
      if(count($relevant)+$false_negative!=0){
        $recall=count($relevant)/count($relevant)+$false_negative;
      }
      
      //Template buat ngeprint si result.
      include('Dokumen.php');
      $dokumen =  new Dokumen();
      $temp="";
      print($temp);
      $top=$_POST["top"];

    if($top=="5"){
      $counter=0;
      foreach($relevant as $rel){
        if($counter>4){
        break;
        }
        $counter++;
        $dok=$dokumen->getDokumen($rel);
        $judul=$dokumen->getJudul($rel);
       echo' <div class="hr-line-dashed "></div>';
       echo' <div class="search-result w-50 pb-3 pl-5">';
       echo'   <h4><a href="Dokumen_view.php?rel='.$rel.'">'.$dokumen->getJudul($rel).'</a></h4>';
       echo '<p>'. $dokumen->getDeskripsi($rel).'</p>';
       echo '<p style="color:red">SCORE :'.$res[$rel]. '</p>';
       echo '</div>';
       //echo '<hr>';
       echo '<div class="hr-line-dashed"></div>';

   
      }
      echo"<hr>";
    }
    else if($top=="10"){
      $counter=0;
      foreach($relevant as $rel){
        if($counter>9){
        break;
        }
        $counter++;
        $dok=$dokumen->getDokumen($rel);
        $judul=$dokumen->getJudul($rel);
       echo' <div class="hr-line-dashed "></div>';
       echo' <div class="search-result w-50 pb-3 pl-5">';
       echo'   <h4><a href="Dokumen_view.php?rel='.$rel.'">'.$dokumen->getJudul($rel).'</a></h4>';
       echo '<p>'. $dokumen->getDeskripsi($rel).'</p>';
       echo '<p style="color:red">SCORE :'.$res[$rel]. '</p>';
       echo '</div>';
       //echo '<hr>';
       echo '<div class="hr-line-dashed"></div>';
      }
      echo"<hr>";

    }
    else{
      foreach($relevant as $rel){
        $dok=$dokumen->getDokumen($rel);
        $judul=$dokumen->getJudul($rel);
       echo' <div class="hr-line-dashed "></div>';
       echo' <div class="search-result w-50 pb-3 pl-5">';
       echo'   <h4><a href="Dokumen_view.php?rel='.$rel.'">'.$dokumen->getJudul($rel).'</a></h4>';
       echo '<p>'. $dokumen->getDeskripsi($rel).'</p>';
       echo '<p style="color:red">SCORE :'.$res[$rel]. '</p>';
       echo '</div>';
       //echo '<hr>';
       echo '<div class="hr-line-dashed"></div>';
      }
      echo"<hr>";
    }
 
      print("Precision : ".$precision);
      echo '<br>';

      print("Recall : ".$recall);
      echo '<br>';

      $f1 = 0;
      if($precision+$recall!=0){
        $f1=2*$precision*$recall/($precision+$recall);
      }
      print("F1 : ".$f1);
      echo '<br>';
    }
    
}

?>

</body>
</html>