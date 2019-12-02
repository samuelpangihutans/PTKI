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

.main {
    width: 50%;
    margin: 200px auto;
}

/* Bootstrap 4 text input with search icon */

.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
    </style>
</head>
<body>

<div class="main">
  
  <form action="result_view.php" method="post">
  <!-- Another variation with a button -->
  <H1 class="mt-4 left pl-5 mt-4 text-center pb-5"><a style="color:teal"href="index.php">SEMA SEARCH </a></H1>
  <div class="input-group">
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
        <option value="2">Cosine</option>
        <option value="3">Language Model</option>
    </select>
    <div class="input-group-append">
      <button class="btn btn-secondary" type="submit" name="search">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>  
</form>
</div>
</body>
</html>