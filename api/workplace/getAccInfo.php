<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php

$ACCNAME = $_POST["accessory"];
$ACC = GetAccessory($ACCNAME, true, $database);

echo json_encode($ACC);