<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$CUSTOMERS = GetCustomers($database);
echo CreateTable($CUSTOMERHEADER, $CUSTOMERBODY,  $CUSTOMERS, "cust_id", 6, false);