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

$data = $myTable->getRows(); // Read all rows
var_dump($data);

$data = $myTable->getRow('id_cust', 11); // Read one row
var_dump($data);

// Teste la méthode INSERT
// $myTable->setTable('products');
// $status = $myTable->insert(array(
//     'id_prod' => 1,
//     'name' => 'Pain buns x4',
//     'qty' => 100,
//     'price' => .5
// ));
// var_dump($status);

// Teste la méthode UPDATE
$myTable->setTable('products');
var_dump($myTable->update(array(
    'qty' => 90,
    'price' => .65
), 'id_prod', 1));

$myTable->setTable('customers');
var_dump($myTable->update(array(
    'fname' => 'Lesly',
    'dob' => '1967-11-11'
), 'id_cust', 1));
