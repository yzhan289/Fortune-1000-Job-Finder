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
    <nav class="blue" role="navigation">
        <div class="nav-wrapper">
            <a href="#" class="brand-logo center">Employment</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a href="home.html">Home</a></li>
                <li><a>About Us</a></li>
                <li><a href="csearch.html">Search Engine</a></li>
            </ul>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a>Login/Register</a></li>
            </ul>
        </div>
    </nav>


    <?php
    include 'open.php';
    $sat = $_POST["state"];

    // this does the query, calls some function called MatchSchool, not sure what though?
    $mysqli->multi_query("CALL MatchSchool($sat, $act, NULL, $eth, $ret, $fee);");

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
            echo "<th> City </th>";
            echo "<th> State </th>";
            echo "<th> Admission Rate </th>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>".$row['SchName']."</td>";
            echo "<td>".$row['URL']."</td>";
            echo "<td>".$row['City']."</td>";
            echo "<td>".$row['State']."</td>";
            echo "<td>".$row['Adm_rate']."</td>";
            echo "</tr>";           // Print every row of the result.

            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['SchName']."</td>";
                echo "<td>".$row['URL']."</td>";
                echo "<td>".$row['City']."</td>";
                echo "<td>".$row['State']."</td>";
                echo "<td>".$row['Adm_rate']."</td>";
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
