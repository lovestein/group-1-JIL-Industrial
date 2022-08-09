<?php
include "../../data.php";

$CATEGORY = $_POST["category"];
if ($CATEGORY === $LOCALPRODUCTCATEGORY[0]) {
    echo json_encode(array(
        "category" => $CATEGORY,
        "categories" => $LOCALPRODUCTCATEGORY,
        "products" => $LOCALTANKS,
        "types" => $TANKTYPE,
    ));
}
else {
    echo json_encode(array(
        "category" => $CATEGORY,
        "categories" => $LOCALPRODUCTCATEGORY,
        "products" => $LOCALACCESSORIES,
    ));

}