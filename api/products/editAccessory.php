<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$ACCESSORYID = $_POST["accessoryID"];
$ACCESSORY = json_decode($_POST["accessory"], true);
$ACCESSORYTYPE = GetAccessoryType($ACCESSORY["acc_type"], true, $database);

unset($ACCESSORY["acc_type"]);

$ACCESSORY["acc_type_id"] = $ACCESSORYTYPE["acc_type_id"];

echo EditAccessory($ACCESSORYID, $ACCESSORY, $database);