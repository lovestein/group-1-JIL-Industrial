<?php
include "../../../database.php";
include "../../../system.php";

$SALE = json_decode($_POST["sale"], true);
$category = $SALE["product_category"];
$product = $SALE["product_tank"];
$quantity = $SALE["quantity"];
$price = $SALE["price"];

$DATA = [
    "name" => $product,
    "quantities" => $quantity,
    "price" => $price,
    "total" => floatval($price) * intval($quantity),
];



// echo json_encode($DATA);