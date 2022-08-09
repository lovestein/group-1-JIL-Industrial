<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php

$TANK = GetTank($_POST["tank"], false, $database);
$TYPES = GetTankTypes($TANK["tank_id"], $database);

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
                            <input type="text" value="<?php echo $TANK["tank_name"] ?>" name="tank_name" class="text"
                                placeholder="TANK NAME">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="flex-end">
                            <div class="left" style="width:100%">
                                <p class="type-text" data-count="<?php echo count($TANKTYPES) ?>">
                                    <?php if (count($TANKTYPES)): ?>
                                    <?php echo count($TANKTYPES) . " Type/s Applied" ?>
                                    <?php else: ?>
                                    Create Type
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="right">
                                <div class="buttons">
                                    <?php
                                echo CreateButton("edit-type", "edit", "", ["small"])
                            ?>
                                    <?php
                                echo CreateButton("create-type", "plus", "", ["small"])
                            ?>
                                </div>
                            </div>
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