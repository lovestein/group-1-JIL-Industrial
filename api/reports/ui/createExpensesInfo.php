<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$IDS = explode(",", $_POST["id"]);
$EXPENSES = array_map(function($id, $db) {
    return GetExpense($id, $db);
}, $IDS, array_fill(0, count($IDS), $database));

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
                    <h1>Expenses Info</h1>
                </div>
            </div>
            <div class="popup-body">
                <?php echo CreateTable($EXPENSESNORMALHEADER, $EXPENSESNORMALBODY, $EXPENSES, "exp_id", 4, true) ?>
            </div>
        </div>
    </div>
</div>