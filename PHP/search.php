<?php
require_once 'connexpdo.php';

$dsn = 'pgsql:host=localhost;port=5432;dbname=wondairlines;';
$user = 'postgres';
$db = connexpdo($dsn, $user);


$a = array();
$query = "SELECT nomaeroport, nomville FROM aeroport ORDER BY nomville";
$result = $db->prepare($query);
$result->execute();
$res = $result->fetchAll();
foreach ($res as $data){
    array_push($a, $data[0]);
    array_push($a, $data[1]);
}

$q = "";

$search = "";

if ($q == "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($a as $name) {
        $search .= "$name,";
    }
}

echo $search;


?>