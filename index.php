<?php
include './vendor/autoload.php';
$config = include 'config.php';

$app = new Controller($config);

if (!isset($argv[1])) {
    Logger::errorPrint('Dinner items not found');
}

$products = explode(',',$argv[1]);

if(!isset($products[0])) {
    Logger::errorPrint('Dinner items not found');
}

try{
    $result = $app->getOptimalRestaurant($products);
} catch (Exception $e) {
    Logger::errorPrint($e->getMessage());
    return;
}

if(!$result) {
    Logger::resultNotFoundPrint();
    return;
}

Logger::resultPrint($result);
