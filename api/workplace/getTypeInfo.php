<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php

$TANKID = $_POST["tank"];
$TANKTYPE = $_POST["type"];
$TYPE = GetTankType($TANKID, $TANKTYPE, true, $database);

echo json_encode($TYPE);