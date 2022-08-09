<?php 
include "./database.php";
include "./data.php";
include "./system.php";

$SUPPLIERS = GetSuppliers($database);
$BUTTONS = [
    [
        "name" => "table-add-button",
        "text" => "ADD",
        "icon" => "plus",
        "classes" => ["extra-small"]
    ],
    [
        "name" => "table-refresh-button",
        "text" => "REFRESH",
        "icon" => "refresh",
        "classes" => ["extra-small"]
    ],
    [
        "name" => "table-delete-button",
        "text" => "DELETE",
        "icon" => "delete",
        "classes" => ["extra-small", "hide"]
    ],
    [
        "name" => "table-edit-button",
        "text" => "EDIT",
        "icon" => "edit",
        "classes" => ["extra-small", "hide"]
    ],
    [
        "name" => "table-selected-button",
        "text" => "SELECTED",
        "icon" => "check",
        "classes" => ["extra-small", "hide"]
    ],
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPPLIERS</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="project-content">
        <?php echo CreateNavLinks("SUPPLIERS", []) ?>
        <div class="main-body">
            <div class="body-content">
                <div class="top-side">
                    <div class="info-container">
                        <div class="headline">
                            <h1>SUPPLIERS LISTS MANAGEMENT</h1>
                        </div>
                        <div class="flex-content">
                            <div class="buttons">
                                <?php foreach($BUTTONS as $button): ?>
                                <?php echo CreateButton($button["name"], $button["icon"], $button["text"], $button["classes"]) ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="search-engine-parent">
                                <input type="text" class="search-engine table-item-search-engine">
                                <div class="search-engine-button">
                                    <div class="icon">
                                        <?php echo UseIcon('search') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bot-side">
                    <div class="grid-table-container">
                        <div class="table-content">
                            <?php echo CreateTable($SUPPLIERHEADER, $SUPPLIERBODY,  $SUPPLIERS, "sup_id", -1, false) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-containers">

    </div>

    <script type="module" src="./assets/js/suppliers.js"></script>
</body>

</html>