<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$CUSTOMERS = explode(",", $_POST["customers"]);

try {
    echo DeleteCustomers($CUSTOMERS, $database);
} catch (\Throwable $th) {
    echo $th;
}