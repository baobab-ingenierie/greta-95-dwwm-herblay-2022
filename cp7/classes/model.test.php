<?php
include_once '../includes/constants.inc.php';
include_once 'database.class.php';
include_once 'model.class.php';

echo '<h2>Instanciation de la classe Model</h2>';

// $myTable = new Model(HOST, PORT, BASE, USER, PASS);
$myTable = new Model(HOST, PORT, BASE, USER, PASS, 'menus');
var_dump($myTable);

// $myTable->setTable('Customers_2');
$myTable->setTable('customers');
var_dump($myTable);
