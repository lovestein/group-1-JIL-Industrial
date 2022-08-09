<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php

$PAYDATA = json_decode($_POST["payData"], true);
$SUMMARY = array_filter(json_decode($_POST["summary"], true));

$i = 0;

foreach ($SUMMARY["sales"] as $SALE) {
    if ($SALE["sale"]["product_category"] === $LOCALPRODUCTCATEGORY[0]) {
        unset($SALE["sale"]["product_acc"]);    
    } else {
        unset($SALE["sale"]["product_tank"]);
        unset($SALE["sale"]["tank_type"]);
    }
    
    $SUMMARY["sales"][$i] = $SALE;
    $i++;
}

try {
    echo InsertPOS($PAYDATA, $SUMMARY, $database);
} catch (\Throwable $th) {
    echo $th;
}