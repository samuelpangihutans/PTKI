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

</head>
<body>

<?php
if(isset($_POST['search'])){
    include("Search.php");
    include("preprocessing.php");
    $strJsonFileContents = file_get_contents("InvertedIdx/invertedIdx.json");
    $invertedIdx=json_decode($strJsonFileContents,true);
    $query=$_POST["query"];
    $search=new Search();
    $start = microtime(true);
    $res = $search->search($query,$invertedIdx);
    $time = microtime(true) - $start;

 
    $notRelevant=array();
    $golden_answer=array();
    $relevant=array();

    $keys = array_keys($res);
    sort($keys);
    print("Nomor Dokumen relevant untuk query ".$query." adalah : ");
    for ($i = 0;$i<count($keys);$i++){
        if($res[$keys[$i]]>1){
            array_push($relevant,$keys[$i]);
            array_push($golden_answer,$keys[$i]);
            print ($keys[$i]." ");
        }
        else if($res[$keys[$i]]<=1){
            array_push($notRelevant,$keys[$i]);
        }
    }
    echo "<br>";

    print("Nomor Dokumen Yang tidak relevant untuk query ".$query." adalah : ");
    for ($i = 0;$i<count($notRelevant);$i++){
        print ($keys[$i]." ");
    }

    echo "<br>";
    $precision=count($relevant)/(count($relevant)+count($notRelevant));
    print("Precision : ".$precision);
    echo '<br>';

    $false_negative=count($golden_answer)-count($relevant);

    $recall=count($relevant)/count($relevant)+$false_negative;

    print("Recall : ".$recall);
    echo '<br>';

    $f1=2*$precision*$recall/($precision+$recall);
    print("F1 : ".$f1);
    echo '<br>';

    print("Execeution Time Search ".$time);
}

?>

</body>
</html>