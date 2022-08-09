<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$SUPPLIER = json_decode($_POST["supplier"], true);

echo CreateSupplier($SUPPLIER, $database);