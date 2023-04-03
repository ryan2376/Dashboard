<?php

 require_once 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb+srv://nmurigi:2461314454@cluster0.3tythl5.mongodb.net/?retryWrites=true&w=majority");
$companydb = $client ->companydb;

$result1 = $companydb -> createCollection('empcollection');

var_dump($result1);



?>