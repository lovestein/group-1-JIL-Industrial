<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$TYPES = GetCustomerTypes($database);
$TYPES = array_filter($TYPES, function($type) {
    return $type["cust_type_name"] !== "Walk-in";
});
?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2>CUSTOMER DATA</h2>
            </div>
            <div class="popup-center">
                <form action="" class="popup-form">
                    <div class="form-group">
                        <div class="error-container">
                            <?php echo CreateComboBox("cust_type", "", ToKeysObj($TYPES, "cust_type_id", "cust_type_name"), "CUSTOMER TYPE") ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container">
                            <input type="text" name="cust_name" class="text" placeholder="CUSTOMER NAME">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" name="cust_contact_no" class="text" placeholder="CUSTOMER NUMBER">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" name="cust_address" class="text" placeholder="ADDRESS">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container">
                            <?php echo CreateComboBox("tank_deposited_bool", "", ["Yes","No"], "DEPOSITED TANK?") ?>
                        </div>
                    </div>

                    <div class="tank-diposited-info"></div>
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