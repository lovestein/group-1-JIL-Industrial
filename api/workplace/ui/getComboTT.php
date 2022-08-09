<?php
include "../../../data.php";
include "../../../system.php";
include "../../../database.php";

$TANKID = $_POST["tank"];
$TANK = GetTank($TANKID, false, $database);
$TYPES = GetTankTypes($TANKID, $database);


$TYPES = array_map(function($type) {
    $type['tank_type_name'] = $type['tank_type_name'] . ' (' . $type['type_size'] . ')';
    return $type;
} , $TYPES);

?>

<div class="form-group">
    <div class="error-container">
        <?php 
        echo CreateComboBox("tank_type", $TYPES[0]["tank_type_name"], ToKeysObj($TYPES, "type_price", "tank_type_name"), "Tank Types")
    ?>
    </div>
</div>

<div class="form-group">
    <div class="error-container">
        <input type="text" value="<?php echo $TYPES[0]["type_size"] ?>" name="tank_size" class="text"
            placeholder="TANK SIZE" disabled>
    </div>
</div>

<div class="form-group">
    <div class="error-container">
        <input type="text" value="<?php echo $TYPES[0]["type_on_hand"] . ' Available'?>" name="tank_quantity_on_hand"
            class="text" placeholder="AVAILABLE" disabled>
    </div>
</div>