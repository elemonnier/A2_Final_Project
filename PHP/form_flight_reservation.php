<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wonder'airlines</title>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAywwHrmKyw7KpMVPFlEwVxkwYrkBODIMU&callback=initMap"
            type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/style2.css"  />
    <link rel="icon" type="image/png" href="../img/avion.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div  class="bs-example" id="top_side">

    <nav style="border-bottom: solid;"  class="navbar navbar-expand-md navbar-light bg-light">
        <img style="width: 7%; margin-right: 40%;" id="logo" src="../img/logo2.png">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav" >
                <a class="nav-item nav-link active" id="flight_res" href="../flight_reservation.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Flight reservation</a>
                <a class="nav-item nav-link active" id="my-flight_res" href="my_flyght_auth.php">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    My Flight</a>
                <a class="nav-item nav-link active" id="about_us" href="../contact_us.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Contact us
                </a>
                <a class="nav-item nav-link active" id="accueil" href="../index.html">
                    <img src="../img/avion.png" align="middle" style="margin-right: 10px" width="50" height="50"  alt="">
                    Home
                </a>
            </div>
        </div>
    </nav>
</div>
<h1 style="text-decoration: underline; width: 60%; margin-left: 20%">Your flight card</h1>
<br>
<div id="map">

</div>
<br>
<div id="recup_form">
    <?php
    require_once 'connexpdo.php';

    $dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
    $user = 'postgres';
    $db = connexpdo($dsn, $user);

    class FormulaireRecup{
        private $destAirport;
        private $destAirport2;
        private $date;
        private $adults;
        private $children;
        private $travel_class;
        function __construct()
        {
            $this->destAirport=$_POST['destinationAirport'];
            $this->destAirport2=$_POST['destinationAirport2'];
            $this->date=$_POST['date'];
            $this->adults=$_POST['adults'];
            $this->children=$_POST['children'];
            $this->travel_class=$_POST['travel_class'];

        }

        function display() {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "\nFlight from ".$this->destAirport. " to ".$this->destAirport2." on ".$this->date. '<br>'." Nbr adults : ".$this->adults.'<br>'." Nbr children : ".$this->children."  <br>".$this->travel_class."";
            echo "</div>";
            echo "<br>";
            echo "<hr>";
        }
    }



    $dest1=$_POST['destinationAirport'];

    echo '<br>';
    $a = array();
    $query = "SELECT latitude, longitude FROM aeroport WHERE nomaeroport=?";
    $result = $db->prepare($query);
    $result->execute([$dest1]);
    $res = $result->fetchAll();
    foreach ($res as $data){
        array_push($a, $data[0]);
        array_push($a, $data[1]);
    }



    $dest2=$_POST['destinationAirport2'];

    $b = array();
    $query1 = "SELECT latitude, longitude FROM aeroport WHERE nomaeroport=?";
    $result1 = $db->prepare($query1);
    $result1->execute([$dest2]);
    $res = $result1->fetchAll();
    foreach ($res as $data1){
        array_push($b, $data1[0]);
        array_push($b, $data1[1]);
    }




    ?>

    <input type=hidden id='variableAPasserLatDest1' value=<?php echo $a[0]; ?>>
    <input type=hidden id='variableAPasserLongDest1' value=<?php echo $a[1]; ?>>
    <input type=hidden id='variableAPasserLatDest2' value=<?php echo $b[0]; ?>>
    <input type=hidden id='variableAPasserLongDest2' value=<?php echo $b[1]; ?>>

    <?php

    $date=$_POST['date'];
    $adults=$_POST['adults'];
    $children=$_POST['children'];
    $travel_class=$_POST['travel_class'];

    $test=new FormulaireRecup();
    $test->display();
    $nbr_adults=$_POST['adults'];
    $nbr_children=$_POST['children'];

    echo "<form action='price.php' method='post'>";

    //CODE ETIENNE
    $dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
    $user = 'postgres';
    try {
        $idcon = new PDO($dsn, $user);
    } catch (PDOException $e){
        echo 'Connexion échouée : '.$e->getMessage();
    }


    $dates = explode('-', $date);
    $year = $dates[0];
    $month = $dates[1];
    $day = $dates[2];


    $numerodate = date('w', mktime(0, 0, 0, $month, $day, $year));
    $englishDate = $dates[1]."/".$dates[2]."/".$dates[0];


    function getPrice($idVol, $fareCode, $weFlights, $idcon){
        $dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
        $user = 'postgres';
        try {
            $idcon = new PDO($dsn, $user);
        } catch (PDOException $e){
            echo 'Connexion échouée : '.$e->getMessage();
        }
        $a = $idcon->prepare('SELECT nomaeroport, nomaeroport__atterit FROM vol WHERE idvol = ?');
        $a->execute([$idVol]);
        $a = $a->fetchAll();
        $aeroport_depart = $a[0][0];
        $aeroport_arrivee = $a[0][1];
        $b = $idcon->prepare('SELECT surcharge FROM aeroport WHERE nomaeroport = ?');
        $b->execute([$aeroport_depart]);
        $b = $b->fetchAll();
        $price = $b[0][0];
        $c = $idcon->prepare('SELECT surcharge FROM aeroport WHERE nomaeroport = ?');
        $c->execute([$aeroport_arrivee]);
        $c = $c->fetchAll();
        $price += $c[0][0];
        $route = $aeroport_depart."-".$aeroport_arrivee;
        $d = $idcon->prepare('SELECT tarifs FROM tarif WHERE weflights = ? and farecode = ? and route = ?');
        $d->execute([$weFlights, $fareCode, $route]);
        $d = $d->fetchAll();
        $price += $d[0][0];
        return $price;
    }

    /// VERIFS



    $a = $idcon->prepare('SELECT count(*) FROM vol WHERE nomaeroport = ? AND nomaeroport__atterit = ?');
    $a->execute([$dest1, $dest2]);
    $a = $a->fetchAll();



    /// DEBUT RECHERCHE

    if (strtotime($englishDate) > 86400 * 21 + time()) {
        $farecode = "Q";
    } else {
        if (strtotime($englishDate) > 86400 * 10 + time()) {
            $farecode = "M";
        } else {
            if (strtotime($englishDate) > 86400 * 3 + time()) {
                $farecode = "B";
            } else {
                $farecode = "Y";
            }
        }
    }

    $r = $idcon->prepare('SELECT dayofweek FROM vol WHERE nomaeroport = ? AND nomaeroport__atterit = ? AND dayofweek = ?');
    $r->execute([$dest1, $dest2, $numerodate]);
    $r = $r->fetchAll();
    $dayOfWeek = $r[0][0];
    if ($dayOfWeek > 0 and $dayOfWeek < 6) {
        $weFlights = 0;
    } else {
        $weFlights = 1;
    }
    ///     ok tier

    $route = $dest1 . "-" . $dest2;
    $verify = $idcon->prepare('SELECT count(*) FROM vol WHERE dayofweek = ? AND nomaeroport = ? AND nomaeroport__atterit = ?');
    $verify->execute([$dayOfWeek, $dest1, $dest2]);
    $verify = $verify->fetchAll();
    if ($verify[0][0] == 0){
        echo"<div class=\"alert alert-danger\" style=\"text-align: center\">There is no flight for this day or the flight does not exist. </div>";    }
    else {

        echo "<h2>Please choose your flight in this list :</h2><table class='table'><tr>
        <th scope='col'>Flight ID</th><th scope='col'>Date</th><th scope='col'>Distance</th><th scope='col'>Departure time</th><th scope='col'>Arrival time</th><th scope='col'>Remaining places</th><th scope='col'>Name departure airport</th><th scope='col'>Name arrival airport</th><th scope='col'>Fare code</th><th scope='col'>Price per adult</th><th scope='col'>Your flight ?</th>
        </tr>";
        $s = $idcon->prepare('SELECT idvol, distance, heuredepart, heurearrive, flighsize, nomaeroport, nomaeroport__atterit FROM vol WHERE nomaeroport = ? AND nomaeroport__atterit = ? AND dayofweek = ?');
        $s->execute([$dest1, $dest2, $numerodate]);
        $s = $s->fetchAll();
        $length = count($s);
        $t = $idcon->prepare('SELECT datedepart, fillingrate, farecode, iddatevol FROM tarif WHERE route = ? AND farecode = ?');
        $t->execute([$route, $farecode]);
        $t = $t->fetchAll();
        for ($count = 0; $count < $length; $count++) {
            echo "<tr><td>" . $s[$count][0] . "</td><td>" . $date . "</td><td>" . $s[$count][1] . "</td><td>" . $s[$count][2] . "</td><td>" . $s[$count][3] . "</td><td>" . $s[$count][4] . "</td><td>" . $s[$count][5] . "</td><td>" . $s[$count][6] . "</td><td>" . $t[0][2] . "</td><td>$" . getPrice($s[0][0], $t[0][2], $weFlights, $idcon) . "</td><td>";
            ?>

            <input type="radio" name="vol" id="vol" value="<?php echo $count; ?>" required>
            <?php
        }
    echo '</table>';
        $today = date("Y-m-d", strtotime("-4 years"));
        $todayyy = date("Y-m-d");

        $mon_prix = getPrice($s[0][0], $t[0][2], $weFlights, $idcon);

    echo '<input type="hidden" name="datenum" id="datenum" value="'.$numerodate.'">';
    echo '<input type="hidden" name="price" id="price" value="'.$mon_prix.'">';
    echo '<input type="hidden" name="dest1" id="dest1" value="'. $dest1.'">';
    echo '<input type="hidden" name="dest2" id="dest2" value="'. $dest2.'">';
    echo '<input type="hidden" name="date" id="date" value="'.$date.'">';
    echo '<input type="hidden" name="adults" id="adults" value="'.$adults.'">';
    echo '<input type="hidden" name="children" id="children" value="'. $children.'">';
    echo '<input type="hidden" name="travel_class" id="travel_class" value="'.$travel_class.'">';

    echo '<h1 style="text-decoration: underline">'.$nbr_adults.' adults :</h1>';
    echo "<br>";

    for ($i = 1; $i<=$nbr_adults;$i++){

        echo "
                  <div id=\"global\">  
                   <h3 id='titre_h3'>adult $i :</h3>
                    <div id=\"global1\" class=\"form-row\">
                        <div class=\"form-group col-md-6\">
                            <label>Name : </label>
                            <input type=\"text\" class=\"form-control\" name=\"NomAdult".$i."\" required>
                        </div>
                        <div class=\"form-group col-md-6\">
                            <label>Firstname : </label>
                            <input type=\"text\" class=\"form-control\" name=\"PrenomAdult".$i."\" required>
                        </div>
                    </div>
                    <div id=\"global1\" class=\"form-group\">
                        <label>Birthday : </label>
                        <input id='mydateA' value='$today' max='$today'  type='date' name=\"dateAdult".$i."\"  class=\"form-control\" required>
                    </div>
                    <div id=\"global1\" class=\"form-group\">
                        <label for=\"inputAddress\">Mail : </label>
                        <input type='email' name=\"mailAdult".$i."\" type=\"text\" class=\"form-control\" id=\"inputAddress\" required>
                        <small id=\"emailHelp\" class=\"form-text text-muted\">We'll never share your email with anyone else.</small>
                    </div>
                    <br> 
                  </div>
                  <br>
                  <br>   
    ";
    }

    echo "<hr>";
    if ($nbr_children>0) {
        echo '<h1 style="text-decoration: underline">'.$nbr_children.' children :</h1>';
        echo "<br>";
        for ($i = 1; $i <= $nbr_children; $i++) {

            echo "
                  <div id=\"global\">  
                   <h3 id='titre_h3'>child $i :</h3>
                    <div id=\"global1\" class=\"form-row\">
                        <div class=\"form-group col-md-6\">
                            <label>Name : </label>
                            <input type=\"text\" class=\"form-control\" name=\"NomChild" . $i . "\" required>
                        </div>
                        <div class=\"form-group col-md-6\">
                            <label>Firstname : </label>
                            <input type=\"text\" class=\"form-control\" name=\"PrenomChild" . $i . "\" required>
                        </div>
                    </div>
                    <div id=\"global1\" class=\"form-group\">
                        <label>Birthday : </label>
                        <input id='mydateE' type='date'  value='$today' min='$today' max='$todayyy' name=\"dateChild" . $i . "\" class=\"form-control\" required>
                    </div>
                    <div id=\"global1\" class=\"form-group\">
                        <label for=\"inputAddress\">Mail : </label>
                        <input type='email' name=\"mailChild" . $i . "\" type=\"text\" class=\"form-control\" id=\"inputAddress\" required>
                        <small id=\"emailHelp\" class=\"form-text text-muted\">We'll never share your email with anyone else.</small>
                    </div>
                    <br> 
                  </div>
                  <br>
                  <br>  
    ";
        }
    }
    echo "<button style='margin-left: 45%' type='submit' class=\"btn btn-secondary\">Valid</button>
                </form>";
    echo "<hr>";
    echo "<br>";
    echo "<br>";
    }
    ?>

</div>

</body>

<script src="../JS/map.js" async type="text/javascript"></script>
</html>






