<?php 
include "./data.php";
include "./system.php";
include "./database.php";

$EXPENSESCATEGORY = ["Vehicle Gasoline", "Vehicle Maintenance", "Mobile Load", "Others"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORE EXPENSES</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="project-content">
        <?php echo CreateNavLinks("WORKSPACE", [
             [
                "name" => "POINT OF SALES",
                "path" => "./workplace.php",
            ],
            [
                "name" => "STORE EXPENSES",
                "path" => "./store_expenses.php",
                "active" => true

            ], 
            [
                "name" => "TRANSACTION SUPPLIES",
                "path" => "./transaction_supplies.php",
            ],
        ]) ?>

        <div class="main-body">
            <div class="margined-content">
                <div class="flex-two-row-container">
                    <div class="row">
                        <div class="sales-form-container">
                            <div class="container-header">
                                <h1>Select Expenses</h1>
                                <p>Choose category of expenses to record.</p>
                            </div>
                            <div class="container-body">
                                <form action="" class="form-container">
                                    <div class="form-group">
                                        <div class="error-container">
                                            <?php echo CreateComboBox("expenses", "", ToKeyValsObj($EXPENSESCATEGORY), "Expenses Category") ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="error-container">
                                            <input type="number" class="text" name="price" placeholder="Price">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php 
                                            echo CreateButton("add-submit-btn", "", "Add", ["extra-small"])
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row row-right">
                        <div class="row-table point-of-sale-table">
                            <div class="row-header">
                                <h1>Store Expenses</h1>
                                <div class="form-group">
                                    <div class="flex-content mix">
                                        <div class="time">
                                            <p class=>As of <?php 
                                            $date = new DateTime("now");
                                            echo $date->format( 'd/m/Y, H:i:s' );
                                            ?>
                                            </p>
                                        </div>
                                        <div class="input-date hide">
                                            <div class="form-group" style="padding:0;margin:0">
                                                <div class="error-container">
                                                    <input type="date" class="text" name="custom_date"
                                                        placeholder="Price">
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo CreateButton("create-date-button", "edit", "", ["fix"]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row-body">
                                <?php echo CreateTable($EXPENSESHEADER, $EXPENSESBODY, [], null, 3, true) ?>
                            </div>
                            <div class="row-footer">
                                <form action="" class="point-of-sales-form">
                                    <div class="form-group">
                                        <div class="flex-sub">
                                            <div class="sub-left">
                                                <p>Sub Total </p>
                                            </div>
                                            <div class="sub-right">
                                                <div class="res-circle">
                                                    <span>PHP <span class="total-amount">0</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php 
                                            echo CreateButton("submit-point-of-sale", "", "Record", ["full-width"])
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-containers"></div>
    <script src="./assets/js/expenses.js" type="module"></script>
</body>

</html>