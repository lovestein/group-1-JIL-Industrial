<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 
$SEARCH = $_POST["search"];
$TANKS = SearchTanks($SEARCH, null, $database);

echo CreateTable($TANKHEADERS, $TANKBODYS,  $TANKS, "tank_id", 2, false);