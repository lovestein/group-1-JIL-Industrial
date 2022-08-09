<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$CUSTOMERID = $_POST["customerID"];
$BASIC = json_decode($_POST["basic"], true);
$DETAILS = json_decode($_POST["details"], true);

$BASIC["cust_type"] = GetCustomerType($BASIC["cust_type"], true, $database)["cust_type_id"];

if (isset($DETAILS['tank_deposited'])) {
    $DETAILS["tank_deposited"] = GetTank($DETAILS["tank_deposited"], true, $database)["tank_id"];
}

try {
    echo EditCustomer($CUSTOMERID, $BASIC, $DETAILS, $database);
} catch (\Throwable $th) {
    echo $th;
}