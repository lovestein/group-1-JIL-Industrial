<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include "../../../database.php" ?>

<?php
$SUMMARY = json_decode($_POST["summary"], true);
?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2>Pay Order</h2>
            </div>
            <div class="popup-center">
                <form action="" class="popup-form">
                    <div class="form-group">
                        <div class="headline">
                            <h3>Total Amount: <span class="total"><?php echo $SUMMARY["total"] ?></span> PHP</h3>
                            <h3>Change: <span class="change">0</span> PHP</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container">
                            <input type="number" value="" name="cash" class="text" placeholder="ENTER CASH">
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup-bot">
                <div class="buttons">
                    <div class="icon-button small green save-button">
                        <div class="icon">
                            <?php echo UseIcon("check") ?>
                        </div>
                        <div class="text">
                            <span>Pay</span>
                        </div>
                    </div>

                    <div class="icon-button small lightgray cancel-button">
                        <div class="icon">
                            <?php echo UseIcon("back") ?>
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