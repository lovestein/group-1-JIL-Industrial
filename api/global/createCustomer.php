<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$BASIC = json_decode($_POST["basic"], true);
$DETAILS = $_POST["details"];

$BASIC["cust_type"] = GetCustomerType($BASIC["cust_type"], true, $database)["cust_type_id"];

try {
    echo CreateCustomer($BASIC, $DETAILS, $database);
} catch (\Throwable $th) {
    echo $th;
}