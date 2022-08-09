<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 
$SEARCH = $_POST["search"];
$SUPPLIERS = SearchSupplier($SEARCH, null, $database);
echo CreateTable($SUPPLIERHEADER, $SUPPLIERBODY,  $SUPPLIERS, "sup_id", -1, false);