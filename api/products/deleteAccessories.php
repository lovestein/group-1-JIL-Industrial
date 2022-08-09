<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$ACCESSORIES = explode(",", $_POST["accessories"]);

echo DeleteAccessories($ACCESSORIES, $database);