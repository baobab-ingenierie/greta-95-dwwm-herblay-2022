<?php
include_once '../classes/database.class.php';
include_once '../includes/constants.inc.php';

echo '<h2>Instanciation de la classe Database</h2>';

// $db = new Database();
$db = new Database(HOST, PORT, BASE, USER, PASS);

// $db->host = 'mon_serveur'; // accès public
$db->setHost('localhost');

// $db->setPort(-457);
$db->setPort(3306);

// $db->setDbname('my_database_1');
$db->setDbname('herblay');

// $db->setUser('lesly3');
$db->setUser('root');

// $db->setPass('P@ssW_0rd&!');
$db->setPass('root');

var_dump($db);

// Teste le premier mot d'une requête
$sql1 = 'UPDATE customers SET fname = \'Tintin\' WHERE id_cust = 12';
$sql2 = 'SELECT * FROM customers';
$sql = explode(' ', $sql2);
echo $sql[0];

// $data = $db->getResult('DELETE FROM customers WHERE id_cust=?', array(100));
$data = $db->getResult('SELECT * FROM customers WHERE fname=?', array('lesly'));
var_dump($data);
$data = $db->getResult('SHOW tables');
var_dump($data);

$data = $db->getJSON('SELECT * FROM customers WHERE fname=?', array('lesly'));
echo '<p>' . $data . '</p>';
$data = $db->getJSON('SHOW tables');
echo '<p>' . $data . '</p>';
