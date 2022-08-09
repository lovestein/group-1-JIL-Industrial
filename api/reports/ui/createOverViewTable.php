<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$SALES = GetTransactions(true, $database);
$EXPENSES = GetExpenses($database, true);
$OVERVIEW = GetInventorySummary($SALES, $EXPENSES);
$SUMMARYDATA = $OVERVIEW["overview"];

echo CreateTable($OVERVIEWHEADER, $OVERVIEWBODY,  $SUMMARYDATA, "", -1, true);