<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$SUPPLIERS = GetSuppliers($database);
$SUPPLIERID = $_POST["supplier"];
$SUPPLIER = GetSupplier($SUPPLIERID, false, $database);
?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2>EDIT SUPPLIER</h2>
            </div>
            <div class="popup-center">
                <form action="" class="popup-form">
                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $SUPPLIER["company_name"] ?>" name="company_name"
                                class="text" placeholder="COMPANY NAME">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $SUPPLIER["contact_no"] ?>" name="contact_no"
                                class="text" placeholder="CONTACT NUMBER">
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