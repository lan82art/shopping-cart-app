<?php
require 'CartController.php';

try {
    $CartController = new CartController($argv[1]);
    $CartController->run();
} catch (Exception $e) {
    echo $e->getMessage();
}