<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php

$SUMMARY = json_decode($_POST["summary"], true);

echo InsertExpenses($SUMMARY, $database);