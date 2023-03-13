<?php

require "autoload.php";

$router = new Router();
$router->checkRoute();

$newOrderManager = new OrderManager("anthonycormier_projetfinal", "3306", "b.3wa.io", "anthonycormier", "f7af5a3387016b3d12b42619a8ad2703");
$order = $newOrderManager->getOrderById(4);
var_dump($order);
?>