<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 

$TANKS = GetTanks($database);

echo CreateTable($TANKHEADERS, $TANKBODYS,  $TANKS, "tank_id", 2, false);