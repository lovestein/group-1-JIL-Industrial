<?php 
include "./data.php";
include "./system.php";
include "./database.php";

$CUSTOMERS = GetCustomers($database);
$TANKS = GetTanks($database);
$PRODUCTYPES = GetProductTypes($database);
$ACCESSORIES = GetAccessoryTypes($database);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POINT OF SALES</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="project-content">
        <?php echo CreateNavLinks("WORKSPACE", [
             [
                "name" => "POINT OF SALES",
                "path" => "./workplace.php",
                "active" => true
            ],
            [
                "name" => "STORE EXPENSES",
                "path" => "./store_expenses.php",
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
                                <h1>Select Product</h1>
                                <p>Choose product to add to checkout.</p>
                            </div>
                            <div class="container-body">
                                <form action="" class="form-container">
                                    <div class="form-group">
                                        <div class="error-container">
                                            <?php echo CreateComboBox("product_category", "", ToKeyValsObj($LOCALPRODUCTCATEGORY), "Product Category") ?>
                                        </div>
                                    </div>
                                    <div class="form-group tanks hide">
                                        <div class="error-container">
                                            <?php echo CreateComboBox("product_tank", $TANKS[0]["tank_name"], ToKeysObj($TANKS, "tank_id", "tank_name"), "Products") ?>
                                        </div>
                                    </div>
                                    <div class="form-group accessories hide">
                                        <div class="error-container">
                                            <?php echo CreateComboBox("product_acc", $ACCESSORIES[0]["acc_type_name"], ToKeysObj($ACCESSORIES, "acc_type_id", "acc_type_name"), "Products") ?>
                                        </div>
                                    </div>
                                    <div class="for-tanks hide"></div>
                                    <div class="for-acc hide"></div>
                                    <div class="form-group">
                                        <div class="mix control">
                                            <div class="left">
                                                <div class="error-container">
                                                    <?php echo CreateAddMinusButton("quantity", 1,"quantity-add-minus", true) ?>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <div class="error-container">
                                                    <input type="number" class="text" name="price" placeholder="Price">
                                                </div>
                                            </div>
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
                                <h1>Point of Sales</h1>
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
                                <?php echo CreateTable($POINTSALEHEADER, $POINTSALEBODY, [], null, 4, true) ?>
                            </div>
                            <div class="row-footer">

                                <form action="" class="point-of-sales-form">
                                    <div class="form-group">
                                        <div class="flex-content end">
                                            <?php echo CreateComboBox("customer", "", (count($CUSTOMERS)  ? ToKeysObj($CUSTOMERS, "cust_id", "cust_name") : ""), "Customer") ?>
                                            <?php echo CreateButton("create-customer-button", "plus", "", ["fix"]) ?>
                                        </div>
                                    </div>
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
                                            echo CreateButton("submit-point-of-sale", "", "PROCEED TO PAYMENT", ["full-width"])
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
    <script src="./assets/js/mainscript.js" type="module"></script>
</body>

</html>