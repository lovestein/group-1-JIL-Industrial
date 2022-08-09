<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$DEPOSITED = $_POST["deposited"];
$CUSTOMERID = $_POST["customerID"];
$CUSTOMER = GetCustomer($CUSTOMERID, false, $database);
$TANKS = GetTanks($database);

$TANKNAME = "";

if (filter_var($CUSTOMER, FILTER_VALIDATE_BOOL)) {
    $TANK = GetTank($CUSTOMER['cust_type'], false, $database);
    if ( filter_var($TANK, FILTER_VALIDATE_BOOLEAN)) {
    
        $TANKTYPE = GetTankType($CUSTOMER['cust_type'], $CUSTOMER['tank_deposited'], false, $database);
    
        $TANK = GetTank(getIn($CUSTOMER, "tank_deposited"), false, $database);
        $TANKNAME =  isset($TANK) ? $TANK["tank_name"] : "";
    
    }
    
}


function getIn($ar, $v) {
    if (isset($ar[$v])) {
        return $ar[$v];
    } else {
        return null;
    }
}

?>

<?php if ($DEPOSITED === "Yes"): ?>

<div class="form-group">
    <div class="error-container">
        <?php echo CreateComboBox("tank_deposited", $TANKNAME, ToKeysObj($TANKS, "tank_id", "tank_name"), "TANK DEPOSITED") ?>
    </div>
</div>
<div class="form-group">
    <div class="error-container">
        <input type="number" value="<?php echo getIn($CUSTOMER, "tank_on_hand") ?>" name="tank_on_hand" class="text"
            placeholder="TANK ON HAND">
    </div>
</div>
<div class="form-group">
    <div class="error-container">
        <input type="number" value="<?php echo getIn($CUSTOMER, "content_price") ?>" name="content_price" class="text"
            placeholder="CONTENT PRICE">
    </div>
</div>
<div class="form-group">
    <div class="error-container">
        <input type="number" value="<?php echo getIn($CUSTOMER, "cash_deposited") ?>" name="cash_deposited" class="text"
            placeholder="CASH DEPOSIT">
    </div>
</div>

<div class="form-group">
    <div class="error-container">
        <input type="number" value="<?php echo getIn($CUSTOMER, "price_rent") ?>" name="price_rent" class="text"
            placeholder="RENTAL PRICE">
    </div>
</div>
<!--
<div class="form-group">
    <div class="error-container">
        <input type="number" value="<?php //echo getIn($CUSTOMER, "total_amount") ?>" name="total_amount" class="text"
            placeholder="TOTAL AMOUNT">
    </div>
</div>-->
<?php endif; ?>