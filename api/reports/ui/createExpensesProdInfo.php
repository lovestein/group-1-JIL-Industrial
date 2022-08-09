<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$ID =  $_POST["id"];
$EXPENSES = GetExpenseItems($ID, $database);

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
                    <h1>Expenses List</h1>
                </div>
            </div>
            <div class="popup-body">
                <?php echo CreateTable($EXPENSESITEMSHEADER, $EXPENSESITEMSBODY, $EXPENSES, "store_exp_item", -1, true) ?>
            </div>
        </div>
    </div>
</div>