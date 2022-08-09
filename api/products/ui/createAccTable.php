<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 

$ACCESSORIES = GetAccessories($database);
$ACCESSORIES = array_map(function($ac, $db) {
    $ac["acc_type_id"] = GetAccessoryType($ac["acc_type_id"], false, $db)["acc_type_name"];
    return $ac;
}, $ACCESSORIES, array_fill(0, count($ACCESSORIES), $database));
echo CreateTable($ACCHEADERS, $ACCBODYS,  $ACCESSORIES, "acc_id", -1, false);