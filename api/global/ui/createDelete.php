<?php include  '../../../system.php' ?>
<?php include  '../../../data.php' ?>
<?php include  "../../../database.php" ?>

<?php 
$TARGET = $_POST["target"];
?>

<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2><?php echo 'DELETE ' . strtoupper($TARGET) ?></h2>
            </div>
            <div class="popup-center">
                <div class="info-container">
                    <h3>Deleting <?php echo $_POST["count"] ?> <?php echo ucwords($TARGET) ?>/s</h3>
                    <p>Do you really want to delete this <?php echo ucwords($TARGET) ?>/s?</p>
                </div>
            </div>
            <div class="popup-bot">
                <div class="buttons">
                    <div class="icon-button small green save-button">
                        <div class="icon">
                            <?php echo UseIcon("check") ?>
                        </div>
                        <div class="text">
                            <span>Delete</span>
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