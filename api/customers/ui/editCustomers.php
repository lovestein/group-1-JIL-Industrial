<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$CUSTOMERID = $_POST["customer"];
$CUSTOMER = GetCustomer($CUSTOMERID, false, $database);
$TYPES = GetCustomerTypes($database);
$TYPES = array_filter($TYPES, function($type) {
    return $type["cust_type_name"] !== "Walk-in";
});

$CUSTOMERTYPE = GetCustomerType($CUSTOMER["cust_type"], false, $database);

$ISDEPOSITED = isset($CUSTOMER["tank_deposited"]) && $CUSTOMER["tank_deposited"] != "0";
$YESORNO = $ISDEPOSITED ? "Yes" : "No";
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
                            <?php echo CreateComboBox("cust_type", $CUSTOMERTYPE["cust_type_name"], ToKeysObj($TYPES, "cust_type_id", "cust_type_name"), "CUSTOMER TYPE") ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container">
                            <input type="text" value="<?php echo $CUSTOMER["cust_name"] ?>" name="cust_name"
                                class="text" placeholder="CUSTOMER NAME">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $CUSTOMER["cust_contact_no"] ?>" name="cust_contact_no"
                                class="text" placeholder="CUSTOMER NUMBER">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $CUSTOMER["cust_address"] ?>" name="cust_address"
                                class="text" placeholder="ADDRESS">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container">
                            <?php echo CreateComboBox("tank_deposited_bool", $YESORNO, ["Yes","No"], "Diposited Tank?") ?>
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