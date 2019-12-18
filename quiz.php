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
            <a href="#" class="brand-logo center">Company Finder</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="home.html">Home</a></li>
            </ul>
        </div>
    </nav>


    <?php
    include 'open.php'; # connect to the database
    $query = "SELECT * FROM Company\n"; # Base query with some true condition
    $query .= "INNER JOIN StateInfo on Company.hq_state_code = StateInfo.state_code " .
    "INNER JOIN CityInfo on StateInfo.state_name = CityInfo.state_name AND Company.hq_city = CityInfo.city_name ";
    "INNER JOIN CompactCrimeData on StateInfo.state_name = CompactCrimeData.state_name AND Company.hq_city = CompactCrimeData.city_name ";
    $query .= "WHERE 1 = 1\n";
    $state = $_POST["state"];
    $city = $_POST["city"];
    $sector = $_POST["sector"];
    $companysize = $_POST["companysize"];
    $violent_crime_rate = $_POST["violent_crime_rate"];
    $property_crime_rate = $_POST["property_crime_rate"];

    # state code
    if ($state) {
      $state_condition = "AND Company.hq_state_code = '" . $state . "'";
      $query .= $state_condition;
    }

    # city
    if ($city) {
      $state_condition = "AND Company.hq_city = '" . $city . "'";
      $query .= $state_condition;
    }

    # violent_crime_rate
    if ($violent_crime_rate) {
      if (strcmp($violent_crime_rate,"4") == 0) {
        $state_condition = "AND violent_crimes_per_100000 < 50\n";
      }
      if (strcmp($violent_crime_rate,"3") == 0) {
        $state_condition = "AND violent_crimes_per_100000 < 100\n";
      }
      if (strcmp($violent_crime_rate,"2") == 0) {
        $state_condition = "AND violent_crimes_per_100000 < 500\n";
      }
      $query .= $state_condition;
    }

    # property_crime_rate
    if ($property_crime_rate) {
      if (strcmp($property_crime_rate,"4") == 0) {
        $state_condition = "AND property_crime_per_100000 < 50\n";
      }
      if (strcmp($property_crime_rate,"3") == 0) {
        $state_condition = "AND property_crime_per_100000 < 100\n";
      }
      if (strcmp($property_crime_rate,"2") == 0) {
        $state_condition = "AND property_crime_per_100000 < 500\n";
      }
      $query .= $state_condition;
    }


    # sector
    if ($sector) {
      if (strcmp($sector,"any") != 0) {
        $state_condition = "AND Company.sector = '" . $sector . "' ";
      }
      $query .= $state_condition;
    }

    # company size
    if ($companysize) {
      if (strcmp($companysize,"small") == 0) {
        $state_condition = "AND Company.num_employees < 10000 ";
      }
      if (strcmp($companysize,"med") == 0) {
        $state_condition = "AND Company.num_employees > 10000 AND Company.num_employees < 100000 ";
      }
      if (strcmp($companysize,"big") == 0) {
        $state_condition = "AND Company.num_employees > 100000 ";
      }
      $query .= $state_condition;
    }

    # Attach ending semicolon
    $query .= ";\n";

    $mysqli->multi_query($query);
    echo 'Here are your results: <br/>';
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
