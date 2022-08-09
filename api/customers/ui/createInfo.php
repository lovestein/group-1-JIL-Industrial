<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php 
$CUSTOMERID = $_POST["id"];
$CUSTOMER = GetCustomer($CUSTOMERID, false, $database);
$CUSTOMERS = [$CUSTOMER];

$VALUES = array_map(function($text, $key, $customer, $db) {
    $tank = GetTank($customer['tank_deposited'], false, $db);
    
    if($tank) {
        $customer["tank_deposited"] = $tank['tank_name'];
    }
    
    return [
        "text" => $text,
        "value" => $customer[$key]
    ];
} , $CUSTOMERINFOHEADER, $CUSTOMERINFOBODY, array_fill(0, count($CUSTOMERINFOHEADER), $CUSTOMER), array_fill(0, count($CUSTOMERINFOHEADER), $database));

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
                    <h1>Customer Info</h1>
                </div>
            </div>
            <div class="popup-body">
                <div class="info-container">
                    <?php foreach($VALUES as $value): ?>
                    <div class="info-item">
                        <div class="item-left">
                            <div class="text">
                                <span><?php echo $value["text"] ?>:</span>
                            </div>
                        </div>
                        <div class="item-right">
                            <div class="box">
                                <div class="text">
                                    <span><?php echo $value["value"] ? $value["value"] : "N/A" ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>