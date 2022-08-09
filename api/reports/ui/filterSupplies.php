<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$SUPPLIES = [];

if ($_POST["fromDate"] && $_POST["toDate"]) {
    $FROM = $_POST["fromDate"];
    $TO = $_POST["toDate"];
    $SUPPLIES = FilterSupplies($FROM, $TO, true, $database);
} else {
    $SUPPLIES = GetSupplies($database);
    $SUPPLIES = SuppliesAsDay($SUPPLIES);
}

$TABLE =  CreateTable($SUPPLIESHEADER, $SUPPLIESBODY,  $SUPPLIES, "trans_id", 3, true);

echo json_encode([
    "data" => $SUPPLIES,
    "table" => $TABLE
]);