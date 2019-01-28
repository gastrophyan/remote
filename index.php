<?php
require_once "../vendor/autoload.php";
require_once "Database.class.php";

$db = new Database();
d($db);
d($db->migrateDatabase());
d($db->seedDatabase());
d($db->getProducts());
d($db->getProduct(1));
d($db->test("hejhej"));

$test = [];
$arr = [];
//$arr = array_push($test, "hej");

d($test);

echo $test[0];
$fika = array_push($arr,42);
$db->getProduct(0);

