<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 

$NAME = $_POST["name"];
$TYPES = json_decode($_POST["types"], true);

try {
    echo CreateTank($NAME, $TYPES, $database);
} catch (\Throwable $th) {
    echo $th;
}