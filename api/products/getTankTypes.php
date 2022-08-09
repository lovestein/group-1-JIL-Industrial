<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 
$TANKID = $_POST["tank"];
echo json_encode(GetTankTypes($TANKID, $database));