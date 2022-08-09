<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$TANKID = $_POST["tank"];
$TANKTYPES = GetTankTypes($TANKID, $database);

?>


<div class="popup-container-parent">
    <div class="popup-background"></div>
    <div class="popup-content">
        <div class="popup-long-container">
            <div class="close-btn">
                <div class="icon">
                    <?php echo UseIcon('close') ?>
                </div>
            </div>

            <div class="popup-header">
                <div class="headline">
                    <h1>Tank Types</h1>
                </div>
            </div>
            <div class="popup-body">
                <?php echo CreateTable($TANKTYPEHEADER, $TANKTYPEBODY, $TANKTYPES, "tank_type_id", -1, true) ?>
            </div>
        </div>
    </div>