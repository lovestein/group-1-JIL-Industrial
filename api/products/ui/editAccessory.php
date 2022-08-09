<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$ACCESSORY = GetAccessory($_POST["accessory"], false, $database);
$TYPES = GetAccessoryTypes($database);
$ACCESSORYTYPE = GetAccessoryType($ACCESSORY["acc_type_id"], false, $database);

?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2>ADD ACCESSORY</h2>
            </div>
            <div class="popup-center">
                <form action="" class="popup-form">
                    <div class="form-group">
                        <div class="error-container">
                            <?php echo CreateComboBox("acc_type", $ACCESSORYTYPE["acc_type_name"], ToKeysObj($TYPES, "acc_type_id", "acc_type_name"), "ACCESSORY TYPE") ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container">
                            <input type="text" value="<?php echo $ACCESSORY["acc_name"] ?>" name="acc_name" class="text"
                                placeholder="ACCESSORY NAME">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="number" value="<?php echo $ACCESSORY["acc_on_hand"] ?>" name="acc_on_hand"
                                class="text" placeholder="ON HAND">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="number" value="<?php echo $ACCESSORY["acc_price"] ?>" name="acc_price"
                                class="text" placeholder="PRICE">
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