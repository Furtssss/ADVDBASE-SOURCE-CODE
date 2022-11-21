<!--listpage-->

<?php
//connector
include "finalscrud.php";

$selectAllDocuments = array();
$cursor = $restaurants->find($selectAllDocuments, [
  'limit' => 10
]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <title>Resto Cluster</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg container mt-1 navbar-success bg-success">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">Resto Cluster</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent" method="POST" action="">
        <form class="form-inline" action="" method="POST">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <button class="btn btn-success" name="brooklyn" type="submit">Brooklyn</button>


            <button class="btn btn-success" name="queens" type="submit">Queens</button>


            <button class="btn btn-success" name="manhattan" type="submit">Manhattan</button>


            <button class="btn btn-success" name="bronx" type="submit">Bronx</button>


            <button class="btn btn-success" name="staten-island" type="submit">Staten Island</button>
        
          </ul>
        </form>

      

        <form class="d-flex" role="search" method="POST" action="">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchbox">
          <button class="btn btn-light" type="submit" name="search">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <table class="table container mt-5 table-success table-hover">
    <tr>
      <th>Name</th>
      <th>Borough</th>
      <th>Cuisine</th>
      <th>Address</th>
      <th>Grades</th>
    </tr>


    <?php
    //buttons
    if (isset($_POST['brooklyn'])) {
      $cursor = $restaurants->find(['borough' => 'Brooklyn']);
    } elseif (isset($_POST['queens'])) {
      $cursor = $restaurants->find(['borough' => 'Queens']);
    } elseif (isset($_POST['manhattan'])) {
      $cursor = $restaurants->find(['borough' => 'Manhattan']);
    } elseif (isset($_POST['bronx'])) {
      $cursor = $restaurants->find(['borough' => 'Bronx']);
    } elseif (isset($_POST['staten-island'])) {
      $cursor = $restaurants->find(['borough' => 'Staten Island']);
    }

  
    if(isset($_POST['search'])){
      $searchbox = $_POST['searchbox'];
      $cursor = $restaurants->aggregate(
        [['$match' => ['$or' => [['name' => ['$regex' => $searchbox, '$options' => 'i']], ['borough' => ['$regex' => $searchbox, '$options' => 'i'],['cuisine' => ['$regex' => $searchbox, '$options' => 'i']]]]]]]);
    }


    foreach ($cursor as $doc) {
    ?>

      <tr class="table table-borderless">

        <?php

        echo "<td>", $doc['name'], "</td>";
        echo "<td>", $doc['borough'], "</td>";
        echo "<td>", $doc['cuisine'], "</td>";

        echo
        "<td>";
        ?>
        <ul class="list-group list-group-vertical">
          <?php
          echo "<li class=\"list-group-item\">", $doc['address']['building'], "</li>";
          echo "<li class=\"list-group-item\">", $doc['address']['street'], "</li>";
          echo "<li class=\"list-group-item\">", $doc['address']['zipcode'], "</li>";
          ?>
        </ul>
        <?php
        echo "</td>";
        ?>
        <?php

        echo
        "<td>";
        ?>
        <ul class="list-group list-group-vertical">
          <?php
          echo "<li class=\"list-group-item\">", $doc['grades']['0']['date'], "</li>";
          echo "<li class=\"list-group-item\">", $doc['grades']['0']['grade'], "</li>";
          echo "<li class=\"list-group-item\">", $doc['grades']['0']['score'], "</li>";
          ?>
        </ul>
      </tr>


    <?php
    }
    ?>

  </table>
</body>

</html>