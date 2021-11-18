<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wonder'airlines</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style2.css"  />
    <link rel="stylesheet" type="text/css" href="../CSS/style3.css"  />
    <link rel="icon" type="image/png" href="../img/avion.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
<div id="recup_form">
    <?php

#-------------------------------------variables---------------------------------
    $dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
    $user = 'postgres';
    try {
        $idcon = new PDO($dsn, $user);
    } catch (PDOException $e){
        echo 'Connexion échouée : '.$e->getMessage();
    }

    $numerodate=$_POST['datenum'];
    $dest1=$_POST['dest1'];
    $dest2=$_POST['dest2'];
    $prix=$_POST['price'];
    $prix_enfant=$prix/2;
    $count=$_POST['vol'];
    $s = $idcon->prepare('SELECT idvol FROM vol WHERE nomaeroport = ? AND nomaeroport__atterit = ? AND dayofweek = ?');
    $s->execute([$dest1, $dest2, $numerodate]);
    $s = $s->fetchAll();

    $idvol = $s[$count][0];

   $date=$_POST['date'];
   $adults=$_POST['adults'];
   $children=$_POST['children'];
   $travel_class=$_POST['travel_class'];
   $tabNameAdult = [];
   $tabPrenomAdult = [];
   $tabDateAdult = [];
   $tabMailAdult = [];
   for ($i = 1;$i<=$adults;$i++){
       #echo 'adult : ';
       $tabNameAdult[$i]=$_POST["NomAdult".$i.""];
       #echo $tabNameAdult[$i].' ';
       $tabPrenomAdult[$i]=$_POST["PrenomAdult".$i.""];
       #echo $tabPrenomAdult[$i].' ';
       $tabDateAdult[$i]=$_POST["dateAdult".$i.""];
       #echo $tabDateAdult[$i].' ';
       $tabMailAdult[$i]=$_POST["mailAdult".$i.""];
       # echo $tabMailAdult[$i].' ';
       # echo '<br>';
   }
    $tabNameChild = [];
    $tabPrenomChild = [];
    $tabDateChild = [];
    $tabMailChild = [];
    for ($i = 1;$i<=$children;$i++){
        #echo 'child : ';
        $tabNameChild[$i]=$_POST["NomChild".$i.""];
        #echo $tabNameChild[$i].' ';
        $tabPrenomChild[$i]=$_POST["PrenomChild".$i.""];
        #echo $tabPrenomChild[$i].' ';
        $tabDateChild[$i]=$_POST["dateChild".$i.""];
        #echo $tabDateChild[$i].' ';
        $tabMailChild[$i]=$_POST["mailChild".$i.""];
        #echo $tabMailChild[$i].' ';
        #echo '<br>';

    }

    #   RECAP variables --->
    #
    #   $dest1 nom de l'aeroport de depart
    #   $dest2 nom de l'aeroport d'arrivée
    #   $date date du depart
    #   $adults nombre d'adulte
    #   $children nombre d'enfant
    #   $travel_class choix de la classe voyage
    #   $tabNameAdult tableau des noms des personnes adultes
    #   $tabPrenomAdult tableau des prenoms des personnes adultes
    #   $tabDateAdult tableau de la date de naissance des personnes adultes
    #   $tabMailAdult tableau du mail des adultes
    #   $tabNameChild tableau des noms des personnes enfants
    #   $tabPrenomChild tableau des prenoms des personnes enfants
    #   $tabDateChild tableau de la date de naissance des personnes enfants
    #   $tabMailChild tableau des noms des personnes enfants



    for ($i = 1; $i <= $adults; $i++) {

        $id = $idcon->prepare("SELECT count(*) FROM passagers");
        $id->execute();
        $id = $id->fetch();


        $a = $idcon->prepare("SELECT idvol from vol WHERE nomaeroport = ? and nomaeroport__atterit = ?");
        $a->execute([$dest1, $dest2]);
        $a = $a->fetch();


        $query = $idcon->prepare("Select iddatevol from datevol where idvol = ?");
        $query->execute([$idvol]);
        $queryfleych = $query->fetchAll();

        $q = $idcon->prepare("INSERT INTO passagers (IDPassager,Nom,Prenom,AddresseMail,DateDeNaissance,idDateVol,isyoung)
    VALUES (?,?,?,?,?,?,?)");
        $q->execute([$id[0] + 1, $tabNameAdult[$i], $tabPrenomAdult[$i], $tabMailAdult[$i], $tabDateAdult[$i], $queryfleych[0][0], 0]);

    }


    for ($i = 1; $i <= $children; $i++) {
        $id = $idcon->prepare("SELECT count(*) FROM passagers");
        $id->execute();
        $id = $id->fetch();


        $a = $idcon->prepare("SELECT idvol from vol WHERE nomaeroport = ? and nomaeroport__atterit = ?");
        $a->execute([$dest1, $dest2]);
        $a = $a->fetch();


        $query = $idcon->prepare("Select iddatevol from datevol where idvol = ?");
        $query->execute([$idvol]);
        $queryfleych = $query->fetchAll();

        $q = $idcon->prepare("INSERT INTO passagers (IDPassager,Nom,Prenom,AddresseMail,DateDeNaissance,idDateVol,isyoung)
    VALUES (?,?,?,?,?,?,?)");
        $q->execute([$id[0] + 1, $tabNameChild[$i], $tabPrenomChild[$i], $tabMailChild[$i], $tabDateChild[$i], $queryfleych[0][0], 1]);

    }


    ?>

</div>
<br>
<br>
<img style="width: 50%; margin-left: 25%;" src="../img/aviontete.png">
<div style="width: 60%; margin-left: 20%;" id="invoice">
    <h2>Thanks for your reservation, below you can see your invoice, if you want to take your ticket click on <a href="my_flyght_auth.php">My flight</a>.</h2><br>
    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="foo" class="btn btn-info"><i class="fa fa-file-pdf-o"></i>download my invoice</button>
        </div>
        <br>
        <br>
    </div>

    <div style="border: solid black;" id="my_fact" class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="https://lobianijs.com">
                            <img src="../img/logo1.png" data-holder-rendered="true" />
                        </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="https://lobianijs.com">
                                Wonder'airlines
                            </a>
                        </h2>
                        <div>35 avenue du champs de manoeuvre, 44470, Carquefou</div>
                        <div>02 98 03 84 00</div>
                        <div>wonderairline@gmail.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to"><?php echo $tabNameAdult[1].' '.$tabPrenomAdult[1]?></h2>
                        <div class="email"><a href="mailto:john@example.com"><?php echo $tabMailAdult[1]?></a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE <?php echo mt_rand() . "\n"; ?></h1>
                        <div class="date">Date : <?php echo date('l jS \of F Y h:i:s A');?></div>

                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-left">DESCRIPTION</th>
                        <th class="text-right">TICKET PRICE</th>
                        <th class="text-right">NBR TICKETS</th>
                        <th class="text-right">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="no">01</td>
                        <td class="text-left"><h3>
                               Adult ticket
                            </h3>
                            <br>
                            <p><?php echo 'Flight '.$idvol.'. Ticket from '.$dest1.' to '.$dest2.' on '.$date.'.'; ?></p>

                        </td>
                        <td class="unit"><?php echo $prix.'$';?></td>
                        <td class="qty"><?php echo $adults;?></td>
                        <td class="total"><?php echo $adults*$prix.'$'?></td>
                    </tr>
                    <tr>
                        <td class="no">02</td>
                        <td class="text-left"><h3>
                                Child ticket
                            </h3>
                            <br>
                            <p><?php echo 'Flight '.$idvol.'. Ticket from '.$dest1.' to '.$dest2.' on '.$date.'.'; ?></p>

                            <p>Warning : children often ruin the holidays you still have 24 hours to change your mind !</p>
                        </td>
                        <td class="unit"><?php echo $prix_enfant.'$';?></td>
                        <td class="qty"><?php echo $children;?></td>
                        <td class="total"><?php echo $children*$prix_enfant.'$'?></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">SUBTOTAL</td>
                        <td><?php echo ($children*$prix_enfant)+($adults*$prix).'$'?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">TAX 10% (for us)</td>
                        <td><?php echo (($children*$prix_enfant)+($adults*$prix))*0.1.'$'?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td><?php echo ((($children*$prix_enfant)+($adults*$prix))*0.1)+($children*$prix_enfant)+($adults*$prix).'$'?></td>
                    </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 50% will be made on unpaid balances after 30 days.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature.
            </footer>
        </div>
        <div></div>
    </div>

</div>
<br>
<br>
<br>
<br>


</body>
<script src="../JS/telechargement_billet.js"></script>
</html>






