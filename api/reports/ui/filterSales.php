<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$TRANSACTIONS = [];

if ($_POST["fromDate"] && $_POST["toDate"]) {
    $FROM = $_POST["fromDate"];
    $TO = $_POST["toDate"];
    $TRANSACTIONS = FilterTransactions($FROM, $TO, true, $database);
} else {
    $TRANSACTIONS = GetTransactions(true, $database);
}

$TABLE = CreateTable($TRANSACTIONHEADER, $TRANSACTIONBODY,  $TRANSACTIONS, "trans_id", 6, true);

echo json_encode([
    "data" => $TRANSACTIONS,
    "table" => $TABLE
]);