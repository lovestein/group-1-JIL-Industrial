<?php include '../../system.php' ?>
<?php include '../../data.php' ?>
<?php include '../../database.php' ?>

<?php 
$SEARCH = $_POST["search"];
$CUSTOMERS = SearchCustomers($SEARCH, null, $database);

try {

echo CreateTable($CUSTOMERHEADER, $CUSTOMERBODY,  $CUSTOMERS, "cust_id", 6, false);
} catch (\Throwable $th) {
    echo $th;
}