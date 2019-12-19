<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <!--Import Google Icon Font-->
  <link rel="stylesheet" href="css/material_icons.woff">
  <!--Import materialize.css-->
  <link rel="stylesheet" href="css/materialize.min.css">
  <!-- libraries -->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo center">Fortune 1000 Company Finder</a>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a href="home.html">Home</a></li>
      </ul>
    </div>
  </nav>

  <?php
  include 'open.php'; # connect to the database
  $query = "SELECT * FROM Company "; # Base query with some true condition

  # Join conditions
  $query .= "INNER JOIN StateInfo on Company.hq_state_code = StateInfo.state_code\n" .
          "LEFT JOIN CityInfo on Company.hq_city = CityInfo.city_name\n" .
          "LEFT JOIN CompactCrimeData on Company.hq_city = CompactCrimeData.city_name\n";

  // $query .= "WHERE Company.hq_state_code = StateInfo.state_code\n" .
  // "AND StateInfo.state_name = CityInfo.state_name\n" .
  // "AND Company.hq_city = CityInfo.city_name\n" .
  // "AND StateInfo.state_name = CompactCrimeData.state_name\n" .
  // "AND Company.hq_city = CompactCrimeData.city_name\n";

  $cname = $_POST["company"];
  $query .= " WHERE Company.name = \"$cname\";";


  # Attach ending semicolon
  // $query .= ";\n";
  echo "<td>".$query."</td>";

  $mysqli->multi_query($query);
  echo 'Here are your results: <br/>';
  # get the SQL results
  $res = $mysqli->store_result();
  if ($res) {
    $row = $res->fetch_assoc();
    if (array_key_exists('Result', $row)) {
      die($row['Result']);
    } else {
      $row['name'];
      $row['rank'];
      $row['profit_mil'];
      $row['num_employees'];
      $row['sector'];
      $row['hq_state_code'];
      $row['hq_city'];
    }
    $res->free();                                              				// Clean-up.
  } else {
    printf("<br>Error: %s\n", $mysqli->error);                 		// The procedure failed to execute.
  }
  $mysqli->close();                                               				// Clean-up.
  ?>

  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <!--Import angularJS-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>
  <!--Import materializec,js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/js/materialize.min.js"></script>
  <!--import main.js-->
  <script type="text/javascript" src="js/main.js"></script>

</body>
</html>
