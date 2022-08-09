<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 

$SUPPLIERS = GetSuppliers($database);

echo CreateTable($SUPPLIERHEADER, $SUPPLIERBODY,  $SUPPLIERS, "sup_id", -1, false);