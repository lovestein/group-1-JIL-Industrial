<?php
    include "../../../system.php";
    include "../../../database.php";

    $TANKID = $_POST["tank"];
    $TYPENAME = $_POST["type"];
    $REFID = $_POST["refID"];
    $TANK = GetTank($TANKID, false, $database);
    $TYPE = GetTankTypeByRef($REFID, $database);

?>
<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-container">
            <div class="popup-top">
                <h2><?php echo $TYPE ? "EDIT" : "CREATE" ?> TYPE</h2>
            </div>
            <div class="popup-center">
                <?php ?>
                <form action="" class="popup-form">


                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $TYPE && isset($TYPE) ? $TYPE["tank_type_name"] :"" ?>"
                                name="tank_type_name" class="text" placeholder="TYPE NAME">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="error-container ">
                            <input type="text" value="<?php echo $TYPE ? $TYPE["type_size"] :"" ?>" name="type_size"
                                class="text" placeholder="SIZE">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="number" value="<?php echo $TYPE ? $TYPE["type_quantity_stock"] :"" ?>"
                                name="type_quantity_stock" class="text" placeholder="QUANTITY STOCK">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="number" value="<?php echo $TYPE ? $TYPE["type_on_hand"] :"" ?>"
                                name="type_on_hand" class="text" placeholder="ON HAND">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="error-container ">
                            <input type="number" value="<?php echo $TYPE ? $TYPE["type_price"] :"" ?>" name="type_price"
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