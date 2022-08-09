<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$SUPPLIERID = $_POST["supplierID"];
$SUPPLIER = json_decode($_POST["supplier"], true);

echo EditSupplier($SUPPLIERID, $SUPPLIER, $database);