<?php
include_once 'database.class.php';

echo '<h2>Instanciation</h2>';
$db = new Database();
// $db->host = 'mon_serveur'; // accès public
$db->setHost('mon_serveur');
var_dump($db);
