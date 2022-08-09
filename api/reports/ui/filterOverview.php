<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$SALES = [];
$EXPENSES = [];

if ($_POST["fromDate"] && $_POST["toDate"]) {
    $FROM = $_POST["fromDate"];
    $TO = $_POST["toDate"];
    $SALES = FilterTransactions($FROM, $TO, true, $database);
    $EXPENSES = FilterExpenses($FROM, $TO, true, $database);

} else {
    $SALES = GetTransactions(true, $database);
    $EXPENSES = GetExpenses($database, true);
} 

$OVERVIEW = GetInventorySummary($SALES, $EXPENSES);
$SUMMARYDATA = $OVERVIEW["overview"];
$TABLE = CreateTable($OVERVIEWHEADER, $OVERVIEWBODY,  $SUMMARYDATA, "", -1, true);

echo json_encode([
    "data" => $OVERVIEW["total"],
    "table" => $TABLE
]);