<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$TANKS = explode(",", $_POST["tanks"]);

try {
    echo DeleteTanks($TANKS, $database);
} catch (\Throwable $th) {
    echo $th;
}