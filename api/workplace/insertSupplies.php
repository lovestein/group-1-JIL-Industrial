<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php

$SUMMARY = array_filter(json_decode($_POST["summary"], true));

$i = 0;

foreach ($SUMMARY["supplies"] as $SALE) {
    if ($SALE["sale"]["product_category"] === $LOCALPRODUCTCATEGORY[0]) {
        unset($SALE["sale"]["product_acc"]);    
    } else {
        unset($SALE["sale"]["product_tank"]);
        unset($SALE["sale"]["tank_type"]);
    }
    
    $SUMMARY["supplies"][$i] = $SALE;
    $i++;
}

try {
    // echo json_encode($SUMMARY);
    echo InsertSupplies($SUMMARY, $database);
} catch (\Throwable $th) {
    echo $th;
}