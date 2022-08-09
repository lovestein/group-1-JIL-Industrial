<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$IDS = explode(",", $_POST["id"]);
$TRANSACTIONS = array_map(function($id, $db) {
    $transaction = GetTransaction($id, $db);

    if (isset($transaction['cust_id'])) {
        $customer = GetCustomer($transaction['cust_id'], false, $db);
        $transaction['cust_id'] = $customer['cust_name'];
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
                    <h1>Sales Info</h1>
                </div>
            </div>
            <div class="popup-body">
                <?php echo CreateTable($TRANSACTIONNORMALHEADER, $TRANSACTIONNORMALBODY, $TRANSACTIONS, "trans_id", 8, true) ?>
            </div>
        </div>
    </div>
</div>