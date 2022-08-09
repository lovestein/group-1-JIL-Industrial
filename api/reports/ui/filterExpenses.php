<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$EXPENSES = [];

if ($_POST["fromDate"] && $_POST["toDate"]) {
    $FROM = $_POST["fromDate"];
    $TO = $_POST["toDate"];
    $EXPENSES = FilterExpenses($FROM, $TO, true, $database);
} else {
    $EXPENSES = GetExpenses($database);
    $EXPENSES = ExpensesAsDay($EXPENSES);
}

$TABLE =  CreateTable($EXPENSESTABLEHEADER, $EXPENSESTABLEBODY,  $EXPENSES, "exp_id", 3, true);

echo json_encode([
    "data" => $EXPENSES,
    "table" => $TABLE
]);