<?php

function connexpdo($base, $user){
    try {
        $dbh = new PDO($base, $user);
    } catch (PDOException $e){
        echo 'Connexion échouée : '.$e->getMessage();
    }
    return $dbh;
}

function create_card($id_vol,$nom,$prenom,$date, $prix, $distance, $villeDep, $villeArr, $heureDep, $heureArr){
    echo '<div id="my_ticket" style="width: 80%; margin-left: 10%; border: solid black 1px; border-radius: 30px;">';
    echo '<h1 style="margin-left: 2%;">
            Récapitulatif commande pour le vol '.$id_vol.'
          </h1>';
    echo '<p style="margin-left: 2%;">
            Nom : '.$nom.', Prenom'.$prenom.', le '.$date.'.<br>
            Pour la somme de '.$prix.'
          </p>';
    echo '<h4>Info vol : départ de '.$villeDep.' à '.$heureDep.'. Arrivée '.$villeArr.' à '.$heureArr.'
          </h4>';
    echo '<p style="margin-left: 2%;">
            <br>Distance parcourue : '.$distance.'
          </p>';
    echo '</div>';

}



?>