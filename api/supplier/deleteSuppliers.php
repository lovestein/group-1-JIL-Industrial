<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$SUPPLIERS = explode(",", $_POST["suppliers"]);

echo DeleteSuppliers($SUPPLIERS, $database);