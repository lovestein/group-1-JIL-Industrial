<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$IDS = explode(",", $_POST["id"]);
$SUPPLIES = array_map(function($id, $db) {
    $transaction = GetTransactionSupply($id, $db);

    if (isset($transaction['sup_id'])) {
        $supplier = GetSupplier($transaction['sup_id'], false, $db);
        $transaction['sup_id'] = $supplier['company_name'];
    }

    return $transaction;
}, $IDS, array_fill(0, count($IDS), $database));

?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-long-container">
            <div class="close-btn">
                <div class="icon">
                    <?php echo UseIcon('close') ?>
                </div>
            </div>

            <div class="popup-header">
                <div class="headline">
                    <h1>Transaction Supply Info</h1>
                </div>
            </div>
            <div class="popup-body">
                <?php echo CreateTable($SUPPLIESNORMALHEADER, $SUPPLIESNORMALBODY, $SUPPLIES, "trans_id", 5, true) ?>
            </div>
        </div>
    </div>
</div>