<html>
     <head>
         <meta http-equiv="Content-Type"        
            content="text/html; charset=utf-8"/>  
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
      <a href="#" class="brand-logo center">
       College Seeker
      </a>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a href="home.html">Home</a></li>
        <li><a>About Us</a></li>
         <li><a>Search Engine</a></li>
      </ul>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="login.html">Login/Register</a></li>
        </ul>
    </div>
</nav>
        <?php
            include 'open.php';
            $sat_min = $_POST["sat_min"];
            $sat_max = $_POST["sat_max"];
            $school_name = $_POST["school_name"];
            $state = $_POST["state"];
            $city = $_POST["city"];
            $act_min = $_POST["act_min"];
            $act_max = $_POST["act_max"];
            // Get the user input.

            if ($school_name) {
                $school_name = "'$school_name'";
            } else {
                $school_name = "NULL";
            }
            if ($state) {
                $state = "'$state'";
            } else {
                $state = "NULL";
            }
            if ($city) {
                $city = "'$city'";
            } else {
                $city = "NULL";
            }
            if ($sat_min) {
                if (!is_numeric($sat_min)) {
                    die("Error: Invalid input for SAT minimum score.");
                }
            } else {
                $sat_min = "NULL";
            }
            if ($sat_max) {
                if (!is_numeric($sat_max)) {
                    die("Error: Invalid input for SAT maximum score.");
                }
            } else {
                $sat_max = "NULL";
            }


            if ($act_min) {
                if (!is_numeric($act_min)) {
                    die("Error: Invalid input for ACT minimum score.");
                }
            } else {
                $act_min = "NULL";
            }
            if ($act_max) {
                if (!is_numeric($act_max)) {
                    die("Error: Invalid input for ACT maximum score.");
                }
            } else {
                $act_max = "NULL";
            }

            $mysqli->multi_query("CALL Search($school_name, $sat_min, $sat_max,
            $act_min, $act_max, $state, $city);");
            $res = $mysqli->store_result();
            if ($res) {
                $row = $res->fetch_assoc();
                
                if (array_key_exists('Result', $row)) {
                    die($row['Result']);
                } else {
                echo "<table border=\"1px solid black\">";

                echo "<tr>";
                echo "<th> School Name </th>";
                echo "<th> URL </th>";
                echo "<th> School Type </th>";
                echo "<th> SAT Median</th>";
                echo "<th> ACT Median </th>";
                echo "<th> City </th>";
                echo "<th> State </th>";
                echo "<th> In-State Tuition($) </th>";
                echo "<th> Out-of-State Tuition($) </th>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td>".$row['SchName']."</td>";
                    echo "<td>".$row['URL']."</td>";
                    echo "<td>".$row['SchType']."</td>";
                    echo "<td>".$row['SAT_Median']."</td>";
                    echo "<td>".$row['ACT_Median']."</td>";
                    echo "<td>".$row['City']."</td>";
                    echo "<td>".$row['State']."</td>";
                    echo "<td>".$row['in_state']."</td>";
                    echo "<td>".$row['out_of_state']."</td>";
                    echo "</tr>";           // Print every row of the result.

                while ($row = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['SchName']."</td>";
                    echo "<td>".$row['URL']."</td>";
                    echo "<td>".$row['SchType']."</td>";
                    echo "<td>".$row['SAT_Median']."</td>";
                    echo "<td>".$row['ACT_Median']."</td>";
                    echo "<td>".$row['City']."</td>";
                    echo "<td>".$row['State']."</td>";
                    echo "<td>".$row['in_state']."</td>";
                    echo "<td>".$row['out_of_state']."</td>";
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

