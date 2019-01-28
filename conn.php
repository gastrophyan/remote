<?php
/**
 * Created by PhpStorm.
 * User: Testuser
 * Date: 2018-03-22
 * Time: 12:52
 */

/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=demo;host=127.0.0.1';
$user = 'root';
$password = '';

$attributes = array(
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);

try {
    $dbh = new PDO($dsn, $user, $password,$attributes);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
