<?php

include __DIR__ . "./functions.php";

function UseIcon($name, $p = '')
{
    $SOME = empty($p) ? '' : $p;
    $PATH = __DIR__ . "/" . $SOME . "assets/media/icons/";
    $ICON = $PATH . $name . ".svg";

    if (file_exists($ICON)) {
        return file_get_contents($ICON);
    }
    else {
        return null;
    }
}


function ToKeysObj($data, $key, $keyText)
{
    $keys = [];

    foreach ($data as $item) {
        $value = ["value" => $item[$key], "text" => $item[$keyText]];

        array_push(
            $keys,
            $value
        );
    }

    return $keys;
}
function ToKeyValsObj($data)
{
    $arr = [];

    foreach ($data as $item) {
        $value = ["value" => $item, "text" => $item];

        array_push(
            $arr,
            $value
        );
    }

    return $arr;
}

function CreateComboBox($name, $value, $contents, $placeholder = "")
{
    $v = isset($contents[0]) ? (isset($contents[0]["value"]) ? $contents[0]["value"] : $contents[0]) : "";
    $output = '
            <div class="custom-combo-box ' . $name . '">
                <div class="content">
                    <input type="text" name="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" autoComplete="off" data-for="combo" data-value="' . $v . '">
                    <div class="icon">';
    $output .= UseIcon("down");
    $output .= '</div></div>';
    $output .= '<div class="floating-container">';

    if ($contents && isset($contents) && count($contents)) {
        foreach ($contents as $item) {
            if (isset($item["value"])) {
                $output .= '
                            <div class="item" value="' . $item["value"] . '"><span>' . $item["text"] . '</span></div>
                        ';
            }
            else {
                $output .= '
                            <div class="item"><span>' . $item . '</span></div>
                        ';
            }
        }

    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function CreateCheckbox()
{
    $output = '
    <div class="custom-checkbox-parent">
        <div class="checkbox-content">
            <label class="custom-checkbox">
                <input type="checkbox" class="table-checkbox">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    ';

    return $output;
}

function CreateAddMinusButton($name, $value = 1, $className = "", $margin = false)
{
    $m = $margin ? 'margin-right' : '';
    $output = '
    <div class="add-minus-button ' . $className . '">
        <div class="small-circular-button minus-btn">
            <div class="icon">
                ' . UseIcon("minus") . '
            </div>
        </div>
        <div class="txt">
            <input type="number" name="' . $name . '" value="' . $value . '" input-type="add-minus" >
        </div>

        <div class="small-circular-button add-btn">
            <div class="icon">
            ' . UseIcon("plus") . '
            </div>
        </div>
    </div>
    ';

    return $output;
}

function CreateButton($name = '', $icon = 'plus', $text = "", $classes = [])
{
    $cc = count($classes) > 0 ? implode(" ", $classes) : '';
    return '
    <div class="icon-button margin-10 ' . $name . ' ' . $cc . '">
        <div class="icon" style="margin-right: ' . (empty($text) ? '0px' : '5px') . '">
            ' . UseIcon($icon) . '
        </div>
        <div class="text"><span> ' . $text . '</span></div>
    </div>
';
}


function CreateTableItem($item, $idname, $bodyitems, $button, $nocheckbox)
{
    $output = '';
    $output .= '<tr class="body-item" data-id="' . ($idname ? $item[$idname] : "") . '">';

    if (!$nocheckbox) {
        $output .= '<td>' . CreateCheckbox() . '</td>';
    }

    if ($button >= 0) {
        $btnitems = array_fill(0, $button + 1, $button);
        $bitem = array_fill(0, count($bodyitems), $item);
        $ranged = range(0, $button);
        $contents = array_map(function ($key, $val, $r, $b) {
            return $r === $b ? $key : (isset($val[$key]) ? $val[$key] : "");
        }, $bodyitems, $bitem, $ranged, $btnitems);

        $i = 0;

        foreach ($contents as $content) {
            if ($i === $button) {
                $output .= '
                <td style="display:flex;justify-content:center; align-items:center;">
                    <div class="icon-button extra-small" style="max-width: 120px; display: block;">
                        <div class="text">
                            <span>' . $content . '</span>
                        </div>
                    </div>
                </td>
                ';
            }
            else {
                $output .= '<td>' . ($content ? $content : ($content == "0" ? "0" : "N/A")) . '</td>';
            }
            $i++;
        }
    }
    else {
        $bitem = array_fill(0, count($bodyitems), $item);
        $contents = array_map(function ($key, $val) {
            return $val[$key];
        }, $bodyitems, $bitem);

        foreach ($contents as $content) {
            $output .= '<td>' . $content . '</td>';
        }
    }

    $output .= '</tr>';

    return $output;
}

function CreateTable($headeritems, $bodyitems, $data, $idname, $button = -1, $nocheckbox = false)
{
    $output = '<div class="custom-grid-table"><table>';

    $output .= '<thead class="grid-table-header"><tr>';

    if (!$nocheckbox) {
        $output .= '<th>' . CreateCheckbox() . '</th>';
    }

    foreach ($headeritems as $item) {
        $output .= '<th>' . $item . '</th>';
    }

    $output .= '</tr></thead>';

    $output .= '<tbody class="grid-table-body">';

    foreach ($data as $item) {
        $output .= CreateTableItem($item, $idname, $bodyitems, $button, $nocheckbox);
    }

    $output .= '</tbody>';

    $output .= '</table></div>';
    return $output;
}


function CreateFN($category, $extension)
{
    $id = uniqid();
    return strtolower($category) . '-' . $id . '.' . $extension;
}


function ReadImagesFNFrom($dir)
{
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            $images = array();
            while (($file = readdir($dh)) !== false) {
                if (!is_dir($dir . $file)) {
                    $images[] = $file;
                }
            }
            closedir($dh);
            asort($images, SORT_NUMERIC);
            return $images;
        }
    }
    return null;
}

function GetImagesFromDir($dir)
{
    $images = [];
    $file_display = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
    if (file_exists($dir) == false) {
        return ["Directory \'', $dir, '\' not found!"];
    }
    else {
        $dir_contents = scandir($dir);
        foreach ($dir_contents as $file) {
            $file_type = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($file_type, $file_display) == true) {
                $images[] = $file;
            }
        }
        return $images;
    }
}


function UploadProductImageFromPath($category, $fromPath, $topath = "./assets/media/uploads/")
{
    $extension = pathinfo($fromPath, PATHINFO_EXTENSION);
    $filename = CreateFN($category, $extension);
    $path = $topath . $filename;
    $imageData = file_get_contents($fromPath);
    $upload = file_put_contents($path, $imageData);
    if ($upload)
        return $filename;
    else
        return false;
}

function UploadProductImageFromTmp($file, $category)
{
    $target_dir = __DIR__ . "/assets/media/uploads/";
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $filename = CreateFN($category, $extension);
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $msg = "";
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
    }
    else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return ["status" => true, "filename" => $filename, "message" => $msg];
        }
        else {
            $msg = "Sorry, there was an error uploading your file.";
            return ["status" => false, "filename" => $filename, "message" => $msg];
        }
    }
}

function CreateNavLinks($title, $links)
{
    $output = '
        <div class="main-navbar">
        <div class="nav-content">
            <div class="nav-left">
                <div class="company-brand">
                    <div class="icon"></div>
                    <div class="text">
                        <h1>' . $title . '</h1>
                    </div>
                </div>
                <div class="main-button-container">
                    <a href="./" class="main-button">
                        <p>HOME</p>
                    </a>
                </div>
            </div>
            <div class="nav-right">
                <div class="nav-buttons">';

    foreach ($links as $link) {
        $isActive = isset($link["active"]);
        $output .= '
        <div class="nav-button-container">
            <a href="' . $link["path"] . '" class="nav-button ' . ($isActive ? "active" : "") . '">
                <span>' . $link["name"] . '</span>
            </a>
        </div>
        ';
    }

    $output .= '     
                </div>
            </div>
        </div>
    </div>
    ';

    return $output;
}

function CreatePreOrderID($database)
{
    $found = false;
    while (!$found) {
        $preorderid = rand(50, 200);
        if (!CountRow("orders", ["pre_order_id" => $preorderid], $database)) {
            $found = true;
            return $preorderid;
        }
    }
}


// POINT OF SALES FUNCTIONS

function CreateCustomer($basic, $details, $database)
{
    $cust_id = Insert("customers", $basic, $database, true);

    if ($cust_id && isset($details)) {
        return Update("customers", $details, ["cust_id" => $cust_id], $database);
    }

    return $cust_id;
}

function GetCustomerTypes($database)
{
    return Select("customer_type", null, true, $database);
}

function GetCustomerType($type, $forname, $database)
{
    $id = ["cust_type_id" => $type];
    $name = ["cust_type_name" => $type];

    return Select("customer_type", $forname ? $name : $id, false, $database);
}

function GetCustomers($database)
{
    return Select("customers", null, true, $database);
}

// END POINT OF SALES FUNCTIONS

// STORE OF EXPENSE FUNCTIONS

// END STORE OF EXPENSE FUNCTIONS

// TRANSACTION SUPPLIES FUNCTIONS

function InsertProduct($product, $database)
{
    return Insert("product", $product, $database);
}

function GetSuppliers($database)
{
    return Select("supplier", null, true, $database);
}
function CreateSupplier($supplier, $database)
{
    return Insert("supplier", $supplier, $database);
}

function EditSupplier($suppID, $supplier, $database)
{
    return Update("supplier", $supplier, ["sup_id" => $suppID], $database);
}

function DeleteSuppliers($suppliers, $database)
{
    foreach ($suppliers as $supplier) {
        Delete("supplier", ["sup_id" => $supplier], $database);
    }

    return true;
}

function GetSupplier($supplier, $forname, $database)
{
    $id = ["sup_id" => $supplier];
    $name = ["company_name" => $supplier];

    return Select("supplier", $forname ? $name : $id, false, $database);
}

function SearchSupplier($search, $filter, $database)
{
    return Search("supplier", $search, ["company_name", "contact_no"], $filter, $database);
}

function GetTransactions($asDay, $database)
{
    $TRANSACTIONS = Select("point_of_sales", null, true, $database);

    return $asDay ? TransactionAsDay($TRANSACTIONS) : $TRANSACTIONS;
}

function GetTransaction($transacID, $database)
{
    return Select("point_of_sales", ["trans_id" => $transacID], false, $database);
}

function GetTransactionItems($transacID, $database)
{
    return Select("point_of_sales_product", ["pos_id" => $transacID], true, $database);
}

function GetExpenseItems($expID, $database)
{
    return Select("store_expenses_item", ["exp_id" => $expID], true, $database);
}

function GetExpenses($database, $asDay = false)
{
    $EXPENSE = Select("store_expenses", null, true, $database);

    if (!$asDay) {
        return $EXPENSE;
    }
    else {
        return ExpensesAsDay($EXPENSE);
    }

}

function GetExpense($exp_id, $database)
{
    return Select("store_expenses", ["exp_id" => $exp_id], false, $database);
}

function GetSupplies($database)
{
    return Select("transaction_supplies", null, true, $database);
}

function GetTransactionSupply($transacID, $database)
{
    return Select("transaction_supplies", ["trans_id" => $transacID], false, $database);
}

function GetTransacSupplyItems($transacID, $database)
{
    return Select("transaction_supplies_product", ["trans_id" => $transacID], true, $database);
}

function GetIndexWSameTimestamp($timestamp, $arr)
{
    if (!count($arr)) {
        return -1;
    }

    $i = 0;

    foreach ($arr as $item) {
        if (IFTimeStampSameDay(strtotime($timestamp), strtotime($item))) {
            return $i;
        }

        $i++;
    }

    return -1;
}

function TransactionAsDay($TRANSACTIONS)

{
    $COMPILED = [];

    foreach ($TRANSACTIONS as $transaction) {
        if (!empty($COMPILED)) {
            $transactionDate = $transaction['date_of_transaction'];
            $find = GetIndexWSameTimestamp($transactionDate, array_column($COMPILED, "date_of_transaction"));

            if ($find >= 0) {
                $COMPILED[$find]['no_of_items'] = intval($COMPILED[$find]['no_of_items']) + intval($transaction['no_of_items']);
                $COMPILED[$find]['sub_total'] = floatval($COMPILED[$find]['sub_total']) + floatval($transaction['sub_total']);
                $COMPILED[$find]['cash_paid'] = floatval($COMPILED[$find]['cash_paid']) + floatval($transaction['cash_paid']);
                $COMPILED[$find]['total_sales'] = floatval($COMPILED[$find]['total_sales']) + floatval($transaction['total_sales']);
                $COMPILED[$find]['trans_id'] = $COMPILED[$find]['trans_id'] . ',' . $transaction['trans_id'];

                $COMPILED[$find]['cust_id']++;
            }
            else {
                $transaction['cust_id'] = 1;
                array_push($COMPILED, $transaction);
            }

        }
        else {
            $transaction['cust_id'] = 1;
            array_push($COMPILED, $transaction);
        }
    }

    return $COMPILED;
}


function ExpensesAsDay($EXPENSES)

{
    $COMPILED = [];

    foreach ($EXPENSES as $expense) {
        if (!empty($COMPILED)) {
            $transactionDate = $expense['date_made'];
            $find = GetIndexWSameTimestamp($transactionDate, array_column($COMPILED, "date_made"));

            if ($find >= 0) {
                $COMPILED[$find]['total_expenses'] = intval($COMPILED[$find]['total_expenses']) + intval($expense['total_expenses']);
                $COMPILED[$find]['total'] = intval($COMPILED[$find]['total']) + intval($expense['total']);
                $COMPILED[$find]['exp_id'] = $COMPILED[$find]['exp_id'] . ',' . $expense['exp_id'];
            }
            else {
                array_push($COMPILED, $expense);
            }

        }
        else {
            array_push($COMPILED, $expense);
        }
    }

    return $COMPILED;
}


function SuppliesAsDay($SUPPLIES)

{
    $COMPILED = [];

    foreach ($SUPPLIES as $supply) {
        if (!empty($COMPILED)) {
            $transactionDate = $supply['date_delivered'];
            $find = GetIndexWSameTimestamp($transactionDate, array_column($COMPILED, "date_delivered"));

            if ($find >= 0) {
                $COMPILED[$find]['prod_quantity'] = intval($COMPILED[$find]['prod_quantity']) + intval($supply['prod_quantity']);
                $COMPILED[$find]['delivery_price'] = intval($COMPILED[$find]['delivery_price']) + intval($supply['delivery_price']);
                $COMPILED[$find]['trans_id'] = $COMPILED[$find]['trans_id'] . ',' . $supply['trans_id'];
            }
            else {
                array_push($COMPILED, $supply);
            }

        }
        else {
            array_push($COMPILED, $supply);
        }
    }

    return $COMPILED;
}

function FilterTransactions($from, $to, $sameDay, $database)
{
    $TRANSACTIONS = SelectBetween("point_of_sales", "date_of_transaction", $from, $to, $database);

    if (!$sameDay) {
        return $TRANSACTIONS;
    }
    else {
        return TransactionAsDay($TRANSACTIONS);
    }
}

function FilterExpenses($from, $to, $sameDay, $database)
{
    $EXPENSES = SelectBetween("store_expenses", "date_made", $from, $to, $database);

    if (!$sameDay) {
        return $EXPENSES;
    }
    else {
        return ExpensesAsDay($EXPENSES);
    }
}

function FilterSupplies($from, $to, $sameDay, $database)
{
    $SUPPLIES = SelectBetween("transaction_supplies", "date_delivered", $from, $to, $database);

    if (!$sameDay) {
        return $SUPPLIES;
    }
    else {
        return SuppliesAsDay($SUPPLIES);
    }
}

function IFTimeStampSameDay($timestamp1, $timestamp2 = "")
{
    if ($timestamp2 == "") {
        $timestamp2 = time();
    }

    return date("z-Y", $timestamp1) == date("z-Y", $timestamp2);
}



// END TRANSACTION SUPPLIES FUNCTIONS

// PRODUCT FUNCTIONS

function GetTanks($database)
{
    return Select("tank", null, true, $database);

}
function GetTankTypes($tankID, $database)
{
    return Select("tank_type", ["tank_id" => $tankID], true, $database);
}

function GetTankType($tankID, $type, $forname, $database)
{
    $id = ["tank_type_id" => $type, "tank_id" => $tankID];
    $name = ["tank_type_name" => $type, "tank_id" => $tankID];

    return Select("tank_type", $forname ? $name : $id, false, $database);
}

function GetTankTypeByRef($refID, $database)
{
    $data = ["ref_id" => $refID];
    return Select("tank_type", $data, false, $database);
}


function CreateTankType($tankID, $type, $database)
{
    $refID = "ref-" . uniqid() . '-' . uniqid();
    $data = array_merge(["tank_id" => $tankID, "ref_id" => $refID], $type);
    $prodTypeID = GetProductType("Tanks", true, $database)["prod_type_id"];

    if (Insert("tank_type", $data, $database)) {
        $product = [
            "type" => $tankID,
            "prod_type" => $prodTypeID,
            "ref_id" => $refID,
        ];

        return InsertProduct($product, $database);
    }

    return false;
}

function CreateTank($name, $types, $database)
{
    $data = ["tank_name" => $name];
    $tankID = Insert("tank", $data, $database, true);

    foreach ($types as $type) {
        CreateTankType($tankID, $type, $database);
    }

    return true;
}

function EditTankType($tankID, $refID, $type, $database)
{
    $where = ["tank_id" => $tankID, "ref_id" => $refID];
    $data = [
        "tank_type_name" => $type["tank_type_name"],
        "type_quantity_stock" => $type["type_quantity_stock"],
        "type_size" => $type["type_size"],
        "type_on_hand" => $type["type_on_hand"],
        "type_price" => $type["type_price"]
    ];

    return Update("tank_type", $data, $where, $database);
}


function EditTank($tankID, $name, $types, $created, $database)
{
    $data = ["tank_name" => $name];

    if (Update("tank", $data, ["tank_id" => $tankID], $database)) {

        foreach ($types as $key => $val) {
            EditTankType($tankID, $key, $val, $database);
        }

        foreach ($created as $type) {
            CreateTankType($tankID, $type, $database);
        }

        return true;
    }

    return false;
}

function DeleteProductType($tankID, $database)
{
    return Delete("tank_type", ["tank_id" => $tankID], $database);
}

function DeleteTanks($tanks, $database)
{
    foreach ($tanks as $tank) {
        $typeID = GetProductType("tank", true, $database)["ref_id"];
        DeleteProduct($typeID, $tank, $database);
        DeleteProductType($tank, $database);
        Delete("tank", ["tank_id" => $tank], $database);
    }

    return true;
}

function GetTank($tank, $forname, $database)
{
    $id = ["tank_id" => $tank];
    $name = ["tank_name" => $tank];

    return Select("Tank", $forname ? $name : $id, false, $database);
}

function SearchTanks($search, $filter, $database)
{
    return Search("Tank", $search, ["tank_id", "tank_name"], $filter, $database);
}

// for accessories

function GetAccessories($database)
{
    return Select("accessories", null, true, $database);
}

function GetAccessoryByRef($refID, $database)
{
    return Select("accessories", ['ref_id' => $refID], false, $database);
}

function GetTypeAccessories($typeID, $database)
{
    return Select("accessories", ["acc_type_id" => $typeID], true, $database);
}

function GetAccessoryTypes($database)
{
    return Select("accessories_type", null, true, $database);
}


function GetAccessoryType($type, $forname, $database)
{
    $id = ["acc_type_id" => $type];
    $name = ["acc_type_name" => $type];

    return Select("accessories_type", $forname ? $name : $id, false, $database);
}

function CreateAccessory($accessory, $database)
{
    $refID = "ref-" . uniqid() . '-' . uniqid();
    $data = array_merge($accessory, ["ref_id" => $refID]);
    $prodTypeID = GetProductType("Accessories", true, $database)["prod_type_id"];
    $accesoryID = $accessory["acc_type_id"];

    if (Insert("accessories", $data, $database, true)) {
        $data = [
            "type" => $accesoryID,
            "prod_type" => $prodTypeID,
            "ref_id" => $refID,
        ];

        return InsertProduct($data, $database);
    }

    return false;
}

function EditAccessory($accID, $accessory, $database)
{
    return Update("accessories", $accessory, ["acc_id" => $accID], $database);
}

function DeleteAccessories($accessories, $database)
{
    foreach ($accessories as $accessory) {
        $typeID = GetProductType("Accessories", true, $database)["prod_type_id"];
        DeleteProduct($typeID, $accessory, $database);
        Delete("accessories", ["acc_id" => $accessory], $database);
    }

    return true;
}

function GetAccessory($accessory, $forname, $database)
{
    $id = ["acc_id" => $accessory];
    $name = ["acc_name" => $accessory];

    return Select("accessories", $forname ? $name : $id, false, $database);
}

function SearchAccessories($search, $filter, $database)
{
    return Search("accessories", $search, ["acc_id", "acc_name", "acc_on_hand", "acc_price"], $filter, $database);
}


// for customers
function DeleteProduct($typeID, $refID, $database)
{
    return Delete("product", ["prod_type" => $typeID, "ref_id" => $refID], $database);
}


function GetProductType($product, $forname, $database)
{
    $id = ["prod_type_id" => $product];
    $name = ["prod_type_name" => $product];

    return Select("product_type", $forname ? $name : $id, false, $database);
}
function GetCustomer($customer, $forname, $database)
{
    $id = ["cust_id" => $customer];
    $name = ["cust_name" => $customer];

    return Select("customers", $forname ? $name : $id, false, $database);
}

function EditCustomer($customerID, $basic, $details, $database)
{
    $where = ["cust_id" => $customerID];
    Update("customers", $basic, $where, $database);

    GetCustomer($customerID, false, $database);

    if (isset($details['tank_deposited'])) {
        return Update("customers", $details, $where, $database);
    }
    else {
        $resetData = [
            "tank_deposited" => NULL,
            "tank_on_hand" => NULL,
            "cash_deposited" => NULL,
            "price_rent" => NULL,
            "content_price" => NULL,
            "total_amount" => NULL
        ];

        return Update("customers", $resetData, $where, $database);
    }
}

function DeleteCustomers($customers, $database)
{
    foreach ($customers as $customer) {
        Delete("customers", ["cust_id" => $customer], $database);
    }

    return true;
}

function SearchCustomers($search, $filter, $database)
{
    return Search("customers", $search, ["cust_id", "cust_name", "cust_address", "cust_contact_no"], $filter, $database);
}

// END PRODUCT FUNCTIONS

// function GetProduct($prod)

function GetProductTypes($database)
{
    return Select("product_type", null, true, $database);
}

function GetProduct($prodTypeCatID, $prodTypeID, $typeID, $database)
{
    $where = [
        "prod_type" => $prodTypeCatID,
        "type" => $prodTypeID,
        "id" => $typeID
    ];

    return Select("product", $where, false, $database);
}

function GetProductByRef($refID, $database)
{
    $where = ["ref_id" => $refID];

    return Select("product", $where, false, $database);
}

function InsertPOS($payData, $summary, $database)
{
    $data = [
        "no_of_items" => $summary["products"],
        "sub_total" => $summary["total"],
        "cash_paid" => $payData["cash"],
        "cash_change" => $payData["change"],
        "total_sales" => $summary["total"]
    ];

    if (isset($summary["customer"])) {
        $data["cust_id"] = $summary["customer"];
    }

    if (isset($summary["date"])) {
        $data["date_of_transaction"] = $summary["date"];
    }

    $summary["sales"] = array_column($summary["sales"], "sale");

    $posID = Insert("point_of_sales", $data, $database, true);

    foreach ($summary["sales"] as $sale) {
        $prodtype = GetProductType($sale["product_category"], true, $database);
        $saleData = [
            "price" => $sale["price"],
            "quantity" => $sale["quantity"],
            "total" => $sale["total"]
        ];

        if ($prodtype["prod_type_name"] === "Tanks") {
            $tank = GetTank($sale["product_tank"], true, $database)["tank_id"];
            $tankType = GetTankType($tank, $sale["tank_type"], true, $database);

            $refID = $tankType["ref_id"];
            $onHand = intval($tankType["type_on_hand"]);
            $tank_on_hand = $onHand - intval($saleData["quantity"]);

            $saleData = array_merge($saleData, [
                "ref_id" => $refID,
                "pos_id" => $posID,
            ]);

            Update("tank_type", ["type_on_hand" => $tank_on_hand], ["tank_type_id" => $tankType["tank_type_id"]], $database);
        }
        else {
            $accessory = GetAccessory($sale["accessory"], true, $database);
            $refID = $accessory["ref_id"];
            $onHand = intval($accessory["acc_on_hand"]);
            $acc_on_hand = $onHand - intval($saleData["quantity"]);

            EditAccessory($accessory["acc_id"], ["acc_on_hand" => $acc_on_hand], $database);

            $saleData = array_merge($saleData, [
                "ref_id" => $refID,
                "pos_id" => $posID,
            ]);
        }

        Insert("point_of_sales_product", $saleData, $database);
    }

    return true;
}

function InsertExpenseItem($supplyID, $supply, $database)
{
    return Insert("transaction_supplies_product", $supply, $database);
}

function InsertSupplies($summary, $database)
{
    $data = [
        "prod_quantity" => $summary["products"],
        "delivery_price" => $summary["total"]
    ];

    if (isset($summary["supplier"])) {
        $data["sup_id"] = $summary["supplier"];
    }

    if (isset($summary["date"])) {
        $data["date_delivered"] = $summary["date"];
    }

    $summary["supplies"] = array_column($summary["supplies"], "sale");

    $id = Insert("transaction_supplies", $data, $database, true);

    foreach ($summary["supplies"] as $sale) {
        $prodtype = GetProductType($sale["product_category"], true, $database);
        $saleData = [
            "price" => $sale["price"],
            "quantity" => $sale["quantity"],
            "total" => $sale["total"]
        ];

        $supplyData = [
            "trans_id" => $id,
            "ref_id" => "",
            "quantity_before" => "",
            "quantity_after" => "",
            "quantity" => $sale["quantity"]
        ];

        if ($prodtype["prod_type_name"] === "Tanks") {
            $tank = GetTank($sale["product_tank"], true, $database)["tank_id"];
            $tankType = GetTankType($tank, $sale["tank_type"], true, $database);
            $onHand = intval($tankType["type_on_hand"]);
            $tank_on_hand = $onHand + intval($saleData["quantity"]);

            if (Update("tank_type", ["type_on_hand" => $tank_on_hand], ["tank_type_id" => $tankType["tank_type_id"]], $database)) {
                $supplyData["ref_id"] = $tankType['ref_id'];
                $supplyData["quantity_before"] = $onHand;
                $supplyData["quantity_after"] = $tank_on_hand;
            }
        }
        else {
            $accessory = GetAccessory($sale["accessory"], true, $database);
            $refID = $accessory["ref_id"];
            $onHand = intval($accessory["acc_on_hand"]);
            $acc_on_hand = $onHand + intval($saleData["quantity"]);

            if (EditAccessory($accessory["acc_id"], ["acc_on_hand" => $acc_on_hand], $database)) {
                $supplyData["ref_id"] = $refID;
                $supplyData["quantity_before"] = $onHand;
                $supplyData["quantity_after"] = $acc_on_hand;
            }

        }

        InsertExpenseItem($id, $supplyData, $database);
    }

    return true;
}

function InsertExpenses($summary, $database)
{
    $data = [
        "total_expenses" => $summary["products"],
        "total" => $summary["total"]
    ];

    if (isset($summary["date"])) {
        $data["date_made"] = $summary["date"];
    }

    $expID = Insert("store_expenses", $data, $database, true);

    if ($expID) {
        foreach ($summary["expenses"] as $expense) {
            $exData = [
                "expenses" => $expense["expenses"],
                "exp_cash" => $expense["price"],
                "exp_id" => $expID
            ];

            Insert("store_expenses_item", $exData, $database);
        }
    }

    return true;
}

function GetInventorySummary($SALES, $EXPENSES)
{
    $SUMMARY = [];

    foreach ($SALES as $sale) {
        $dateT = $sale["date_of_transaction"];

        if (!empty($SUMMARY)) {
            $find = GetIndexWSameTimestamp($dateT, array_column($SUMMARY, "date"));

            if ($find >= 0) {
                $SUMMARY[$find]["sales"] += floatval($sale["total_sales"]);
            }
            else {
                array_push($SUMMARY, ["sales" => floatval($sale["total_sales"]), "date" => $dateT]);
            }
        }
        else {
            array_push($SUMMARY, ["sales" => floatval($sale["total_sales"]), "date" => $dateT]);
        }
    }

    for ($i = 0; $i < count($SUMMARY); $i++) {
        $item = $SUMMARY[$i];

        if (!isset($item["sales"])) {
            $SUMMARY[$i]["sales"] = 0;
        }

        if (!isset($item["expenses"])) {
            $SUMMARY[$i]["expenses"] = 0;
        }
    }

    foreach ($EXPENSES as $expense) {
        $dateT = $expense["date_made"];

        if (!empty($SUMMARY)) {
            $find = GetIndexWSameTimestamp($dateT, array_column($SUMMARY, "date"));

            if ($find >= 0) {
                $SUMMARY[$find]["expenses"] += floatval($expense["total"]);
            }
            else {
                array_push($SUMMARY, ["expenses" => floatval($expense["total"]), "date" => $dateT]);
            }
        }
        else {
            array_push($SUMMARY, ["expenses" => floatval($expense["total"]), "date" => $dateT]);
        }
    }

    for ($i = 0; $i < count($SUMMARY); $i++) {
        $item = $SUMMARY[$i];

        if (!isset($item["sales"])) {
            $SUMMARY[$i]["sales"] = 0;
        }

        if (!isset($item["expenses"])) {
            $SUMMARY[$i]["expenses"] = 0;
        }


        $SUMMARY[$i]["income"] = floatval($SUMMARY[$i]["sales"]) - floatval($SUMMARY[$i]["expenses"]);

    }


    $TOTALSALES = array_reduce(array_column($SUMMARY, "sales"), function ($a, $b) {
        return floatval($a) + floatval($b);
    });

    $TOTALEXPENSES = array_reduce(array_column($SUMMARY, "expenses"), function ($a, $b) {
        return floatval($a) + floatval($b);
    });

    $TOTALINCOME = floatval($TOTALSALES) - floatval($TOTALEXPENSES);

    return [
        "overview" => $SUMMARY,
        "total" => [
            "total_sales" => $TOTALSALES,
            "total_expenses" => $TOTALEXPENSES,
            "total_income" => $TOTALINCOME
        ]
    ];
}