<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$TRANSACTIONS = GetTransactions(true, $database);
echo CreateTable($TRANSACTIONHEADER, $TRANSACTIONBODY,  $TRANSACTIONS, "trans_id", 6, true);