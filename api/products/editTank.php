<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$TANKID = $_POST["tankID"];
$NAME = $_POST["name"];
$TYPES = json_decode($_POST["types"], true);
$CREATED = json_decode($_POST["created"], true);

echo EditTank($TANKID, $NAME, $TYPES, $CREATED,  $database);