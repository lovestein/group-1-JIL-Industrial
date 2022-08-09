<?php 
include "./database.php";
include "./data.php";
include "./system.php";

$EXPENSES = GetExpenses($database);
$EXPENSES = ExpensesAsDay($EXPENSES);
$BUTTONS = [
    [
        "name" => "table-refresh-button",
        "text" => "REFRESH",
        "icon" => "refresh",
        "classes" => ["extra-small"]
    ],
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPENSES REPORT</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="project-content">
        <?php echo CreateNavLinks("REPORTS", [
            [
                "name" => "OVERVIEW",
                "path" => "./reports.php",
            ],
            [
                "name" => "SALES HISTORY",
                "path" => "./sales_history.php",
            ],
            [
                "name" => "EXPENSES HISTORY",
                "path" => "./expenses_history.php",
                "active" => true
            ],
            [
                "name" => "SUPPLIES HISTORY",
                "path" => "./supplies_history.php",
            ],
        ]) ?>
        <div class="main-body">
            <div class="body-content">
                <div class="top-side">
                    <div class="info-container">
                        <div class="headline">
                            <h1>EXPENSES STATEMENT REPORTS</h1>
                        </div>
                        <div class="flex-content">
                            <div class="buttons">
                                <?php foreach($BUTTONS as $button): ?>
                                <?php echo CreateButton($button["name"], $button["icon"], $button["text"], $button["classes"]) ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="buttons">
                                <div class="mix-input mix">
                                    <div class="left">
                                        <p>From</p>
                                    </div>
                                    <div class="right">
                                        <div class="form-group">
                                            <div class="error-container">
                                                <input type="date" name="from-date" class="text"
                                                    placeholder="FROM DATE">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mix-input mix">
                                    <div class="left">
                                        <p>To</p>
                                    </div>
                                    <div class="right">
                                        <div class="form-group">
                                            <div class="error-container">
                                                <input type="date" name="to-date" class="text" placeholder="TO DATE">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mix-input mix">
                                    <div class="left">
                                        <p>Total Expenses</p>
                                    </div>
                                    <div class="right">
                                        <div class="form-group">
                                            <div class="error-container">
                                                <input type="text" name="total-expenses" class="text"
                                                    placeholder="TOTAL EXPENSES" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bot-side">
                    <div class="grid-table-container">
                        <div class="table-content">
                            <?php echo CreateTable($EXPENSESTABLEHEADER, $EXPENSESTABLEBODY,  $EXPENSES, "exp_id", 3, true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-containers">
    </div>

    <script type="module" src="./assets/js/expenses_reports.js"></script>
</body>

</html>