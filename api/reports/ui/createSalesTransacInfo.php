<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$ID = $_POST["id"];
$TRANSACTION = GetTransaction($ID, $database);
$ITEMS = GetTransactionItems($TRANSACTION['trans_id'], $database);
$ITEMS = array_map(function($item, $db) {
    $product = GetProductByRef($item['ref_id'], $db);
    $type = GetProductType($product['prod_type'], false, $db);

    if ($type['prod_type_id'] == '1') {
        $prodType = GetTankTypeByRef($item['ref_id'], $db);
        $tank = GetTank($prodType['tank_id'], false, $db);

        $item['product'] = $prodType['tank_type_name'];
        $item['prod_type'] = $tank['tank_name'];

    } else {
        $prodType = GetAccessoryByRef($item['ref_id'], $db);
        $accType = GetAccessoryType($prodType['acc_type_id'], false, $db);

        $item['product'] = $prodType['acc_name'];
        $item['prod_type'] = $accType['acc_type_name'];
    }

    return $item; 
}, $ITEMS, array_fill(0, count($ITEMS), $database));
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
                    <h1>Transaction Product Items</h1>
                </div>
            </div>
            <div class="popup-body">

                <?php echo CreateTable($TRANSACORDERHEADER, $TRANSACORDERBODY, $ITEMS, "pos_product_id", -1, true) ?>

            </div>
        </div>
    </div>
</div>