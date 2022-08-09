<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$SUPPLIES = GetSupplies(true, $database);
$SUPPLIES = SuppliesAsDay($SUPPLIES);
echo CreateTable($SUPPLIESHEADER, $SUPPLIESBODY,  $SUPPLIES, "trans_id", 3, true);