<?php
include "../../../data.php";
include "../../../system.php";
include "../../../database.php";

$ACCESSORY = $_POST["accessory"];
$ACC = GetAccessoryType($ACCESSORY, false, $database);
$TYPES = GetTypeAccessories($ACCESSORY, $database);

?>

<?php if (count($TYPES)) : ?>

<div class="form-group">
    <div class="error-container">
        <?php 
        echo CreateComboBox("accessory", $TYPES[0]["acc_name"], ToKeysObj($TYPES, "acc_price", "acc_name"), "Products")
    ?>
    </div>
</div>
<?php else: ?>
<p style="margin-left: 15px">No Product Under <?php echo $ACC["acc_type_name"] ?></p>
<?php endif; ?>

<div class="form-group">
    <div class="error-container">
        <input type="text" value="<?php echo isset($TYPES[0]) ? $TYPES[0]["acc_on_hand"] . ' Available' : ""?>"
            name="acc_quantity_on_hand" class="text" placeholder="AVAILABLE" disabled>
    </div>
</div>