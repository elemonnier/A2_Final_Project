<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wonder'airlines</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style2.css"  />
    <link rel="icon" type="image/png" href="../img/avion.png" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="../CSS/style.css" />
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
<div class="container" id="fondmf" style="width : 70%; margin-left: 15%;">
<?php
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])){
//        echo $_POST['nom'];
//        echo $_POST['prenom'];
//        echo"<br>";
    echo '<br>';
    echo "<h1 class='display-4'>Welcome : ".$_POST['nom']." ".$_POST['prenom'] ."</h1>";
    echo "<h2>Below you can see your flight ticket :</h2>";
    echo '<br>';
    echo '<br>';
    $dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
    $user = 'postgres';
    try {
        $dbh = new PDO($dsn, $user);
    } catch (PDOException $e){
        echo 'Connexion échouée : '.$e->getMessage();
    }

    $result0 = $dbh->prepare('SELECT count(*) FROM passagers WHERE nom = ? and prenom = ? and addressemail = ? ');
    $result0->execute(array($_POST['nom'], $_POST['prenom'], $_POST['email']));
    $result0 = $result0->fetch();
//        var_dump($result0);
//        var_dump($result0[0]);


    if($result0[0] != 0){
        $alliddatevol = array();
        $result1 = $dbh->prepare('SELECT * FROM passagers WHERE nom = ? and prenom = ? and addressemail = ? ');
        $result1->execute(array($_POST['nom'], $_POST['prenom'], $_POST['email']));
//        var_dump($result1->fetch());
        while ($data = $result1->fetch()) {
            array_push($alliddatevol, $data);
//            echo $data['iddatevol'];
//
        }
        //            pour tous les vols du passager on affiche son ticket avec les info
        foreach($alliddatevol as $iddatevol) {
//            var_dump($iddatevol);
            $result2 = $dbh->prepare('SELECT * FROM datevol WHERE iddatevol = ?');
            $result2->execute(array($iddatevol['iddatevol']));
            $result2 = $result2->fetch();
//                var_dump($result2);
            $result3 = $dbh->prepare('SELECT * FROM vol WHERE idvol = ?');
            $result3->execute(array($result2['idvol']));
            $result3 = $result3->fetch();
            $date=$_POST['date'];
            $dates = explode('-', $date);
            $year = $dates[0];
            $month = $dates[1];
            $day = $dates[2];
            if ($result2['datedepart']==0||$result2['datedepart']==6){
                $weflight=1;
            }
            else{
                $weflight=0;
            }

            $numerodate = date('w', mktime(0, 0, 0, $month, $day, $year));
            $englishDate = $dates[1]."/".$dates[2]."/".$dates[0];
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


           //     var_dump($result3);
//                echo $_POST['nom'],"<br>", $_POST['prenom'],"<br>",$result2['idvol'],"<br>",$result3['nomaeroport'],"<br>",$result3['nomaeroport__atterit'],"<br>",$result3['heurearrive'],"<br>",$result3['heuredepart'];

            $result4  = $dbh->prepare('SELECT * FROM tarif WHERE iddatevol = ? and farecode = ?');
            $result4->execute(array($iddatevol['iddatevol'],$farecode));
            $result4 = $result4->fetch();

            if($iddatevol['isyoung'] == 1){//c'est un enfant
                $prix = getPrice($result2['idvol'], $farecode, $weflight,$dbh) / 2;
            }


            if($iddatevol['isyoung'] == 0 ){//c'est un adulte
                $prix = getPrice($result2['idvol'], $farecode, $weflight,$dbh);
            }

            //NOM AERO DEP
            $result5 = $dbh->prepare('SELECT * FROM aeroport WHERE nomaeroport = ?');
            $result5->execute(array($result3['nomaeroport']));
            $result5 = $result5->fetch();

            //NOM AERO ARR
            $result6 = $dbh->prepare('SELECT * FROM aeroport WHERE nomaeroport = ?');
            $result6->execute(array($result3['nomaeroport__atterit']));
            $result6 = $result6->fetch();


            echo"<div class=\"container-fluid\">";


        }
        create_card($result2['idvol'], $_POST['nom'], $_POST['prenom'], $date, $prix, $result3['distance'],$result5['nomville'] ,$result6['nomville'],$result3['heurearrive'],$result3['heuredepart']  );
        echo"</div>";
    }else{
        echo"<div class=\"alert alert-danger\" style=\"text-align: center\">You are not in our passenger database :(</div>";

    }
}
function create_card($id_vol,$nom,$prenom,$date, $prix, $distance, $villeDep, $villeArr, $heureDep, $heureArr){
    echo '<div id="my_ticket" style="width: 940px; height: 373px; border: solid white 1px; border-radius: 25px;">';
    echo '<h2 style="  margin-left: 37px; margin-top: 74px;  width: 10%; ">
       Flight '.$id_vol.'
    </h2>';
    echo '<div style=" margin-left: 37px;  background-color: white; width: 10%; ">
       <b style="text-decoration: underline;font-size: 130%">From</b> '.$villeDep.'
    </div>';
    echo '<br>';
    echo '<div style="margin-left: 37px;  background-color: white; width: 10%; ">
       <b style="text-decoration: underline;font-size: 130%">To</b><br> '.$villeArr.'
    </div>';
    echo '<br>';

    echo '<div style="margin-left: 257px; margin-top: -250px;">
        <b style="text-decoration: underline; font-size: 130%">Passenger </b><br>'.$nom.' '.$prenom.'
    </div>';
    echo '<div style="margin-left: 257px; margin-top: 20px;">
        <b style="text-decoration: underline; font-size: 130%">Time </b><br>'.$heureDep.'
    </div>';
    echo '<div style="margin-left: 257px; margin-top: 20px;">
        <b style="text-decoration: underline; font-size: 130%">Arrival time </b><br>'.$heureArr.'
    </div>';
    echo '<div style="margin-left: 477px; margin-top: -190px; background-color: white; width: 10%; ">
       <b style=" text-decoration: underline;font-size: 130%">Traveled</b><br> '.$distance.'km
    </div>';
    echo '<div style="margin-left: 477px; margin-top: 20px;">
        <b style="text-decoration: underline; font-size: 130%">Date </b><br>'.$date.'
    </div>';
    echo '<div style=" margin-left: 477px; margin-right: 250px; margin-top: 20px; border: solid black 1px; border-radius: 25px;">
        <b style="text-decoration: underline; margin-left:30px; font-size: 130%">Price </b><br><b style="margin-left:30px; font-size: 200%;">'.$prix.'$</b>
    </div>';

    echo '</div>';
    echo '<br>';
    echo '<button class="btn btn-warning" id="foo" style="width : 75%; margin-left: 15%">>> download my ticket <<</button>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
}
function getPrice($idVol, $fareCode, $weFlights, $idcon){

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
?>
</div>
<script src="../JS/telechargement_billet.js"></script>
</html>
