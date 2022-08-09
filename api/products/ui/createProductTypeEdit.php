<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$TANK = GetTank($_POST["tank"], false, $database);
$TYPES = GetTankTypes($TANK["tank_id"], $database);

$TYPES = array_map(function($type) {
    $type['tank_type_name'] = $type['tank_type_name'] . ' (' . $type['type_size'] .')';
    return $type;
}, $TYPES);

?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2>EDIT TANK</h2>
            </div>
            <div class="popup-center">
                <form action="" class="popup-form">
                    <div class="form-group">
                        <div class="error-container">
                            <?php echo CreateComboBox("tank_type", "", ToKeysObj($TYPES, "ref_id", "tank_type_name"), "TANK TYPE") ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup-bot">
                <div class="buttons">
                    <div class="icon-button small red reset-button">
                        <div class="icon">
                            <?php echo UseIcon('backspace') ?>
                        </div>
                        <div class="text">
                            <span>Reset</span>
                        </div>
                    </div>
                    <div class="icon-button small green save-button">
                        <div class="icon">
                            <?php echo UseIcon('check')  ?>
                        </div>
                        <div class="text">
                            <span>Save</span>
                        </div>
                    </div>
                    <div class="icon-button small lightgray cancel-button">
                        <div class="icon">
                            <?php echo UseIcon('back')  ?>
                        </div>
                        <div class="text">
                            <span>Cancel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>