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
            echo "<th> Company Name </th>";
            echo "<th> Fortune 1000 Rank </th>";
            echo "<th> Change in Rank </th>";
            echo "<th> Profit (Million) </th>";
            echo "<th> Profit Change </th>";
            echo "<th> Number of Employees </th>";
            echo "<th> CEO </th>";
            echo "<th> Sector </th>";
            echo "<th> Industry </th>";
            echo "<th> HQ State </th>";
            echo "<th> HQ City </th>";
            echo "<th> Latitude </th>";
            echo "<th> Longitude </th>";
            echo "</tr>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['rank']."</td>";
                echo "<td>".$row['change_in_rank']."</td>";
                echo "<td>".$row['profit_mil']."</td>";
                echo "<td>".$row['profit_change']."</td>";
                echo "<td>".$row['num_employees']."</td>";
                echo "<td>".$row['ceo']."</td>";
                echo "<td>".$row['sector']."</td>";
                echo "<td>".$row['industry']."</td>";
                echo "<td>".$row['hq_state']."</td>";
                echo "<td>".$row['hq_city']."</td>";
                echo "<td>".$row['latitude']."</td>";
                echo "<td>".$row['longitude']."</td>";
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
