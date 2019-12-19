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
  " LEFT JOIN CityInfo on Company.hq_city = CityInfo.city_name\n";
  " LEFT JOIN CompactCrimeData on Company.hq_city = CompactCrimeData.city_name\n";

  $cname = $_POST["company"];
  $query .= " WHERE Company.name = \"$cname\";";


  # Attach ending semicolon
  // $query .= ";\n";
  // echo "<td>".$query."</td>";
  echo 'Looks like you would be a great fit at these companies: <br/>';

  $mysqli->multi_query($query);
  $res = $mysqli->store_result();
  $col;
  $companysize;
  $citypop;
  # get the SQL results
  if ($res) {
    $row = $res->fetch_assoc();
    if (array_key_exists('Result', $row)) {
      die($row['Result']);
    } else {
      // get cost of living, company size, population of city
      $col = $row['dollar_parity'];
      $companysize = $row['num_employees'];
      $citypop = $row['city_population'];
    }
    $res->free();                                              				// Clean-up.
  } else {
    printf("<br>Error: %s\n", $mysqli->error);                 		// The procedure failed to execute.
  }

  // Make a new query with the updated values
  $query = "SELECT * FROM Company, StateInfo, CityInfo, CompactCrimeData\n"; # Base query with some true condition

  # Join conditions
  $query .= " WHERE Company.hq_state_code = StateInfo.state_code\n" .
  " AND StateInfo.state_name = CityInfo.state_name\n" .
  " AND Company.hq_city = CityInfo.city_name\n" .
  " AND StateInfo.state_name = CompactCrimeData.state_name\n" .
  " AND Company.hq_city = CompactCrimeData.city_name\n";

  // if COL was changed
  if ($col) {
    if (strcmp($col,"low") == 0) {
      $state_condition = "AND dollar_parity < $col\n";
    }
    if (strcmp($col,"high") == 0) {
      $state_condition = "AND dollar_parity > $col\n";
    }
    $query .= $state_condition;
  }

  # Attach ending semicolon
  $query .= ";\n";


  echo $query;
  $mysqli->multi_query($query);
  # get the SQL results
  $res = $mysqli->store_result();
  if ($res) {
    $row = $res->fetch_assoc();
    if (array_key_exists('Result', $row)) {
      die($row['Result']);
    } else {
      echo "<table border=\"1px solid black\">";
      echo "<tr>";
      echo "<th> Company Name </th>";
      echo "<th> Fortune 1000 Rank </th>";
      echo "<th> Profit (Million) </th>";
      echo "<th> Number of Employees </th>";
      echo "<th> Sector </th>";
      echo "<th> HQ State </th>";
      echo "<th> HQ City </th>";
      echo "</tr>";
      echo "<td>".$row['name']."</td>";
      echo "<td>".$row['rank']."</td>";
      echo "<td>".$row['profit_mil']."</td>";
      echo "<td>".$row['num_employees']."</td>";
      echo "<td>".$row['sector']."</td>";
      echo "<td>".$row['hq_state_code']."</td>";
      echo "<td>".$row['hq_city']."</td>";
      echo "</tr>";
      while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['rank']."</td>";
        echo "<td>".$row['profit_mil']."</td>";
        echo "<td>".$row['num_employees']."</td>";
        echo "<td>".$row['sector']."</td>";
        echo "<td>".$row['hq_state_code']."</td>";
        echo "<td>".$row['hq_city']."</td>";
        echo "</tr>";     		// Print every row of the result.

      }
      echo "</table>";
    }
    $res->free();                                              				// Clean-up.
  } else {
    printf("<br>Error: %s\n", $mysqli->error);                 		// The procedure failed to execute.
  }
  $mysqli->close();
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
