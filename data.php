<?php

$DATABASE_HOST = "localhost";

$DATABASE_NAME = "jil-industrial";

$DATABASE_USER = "root";

$DATABASE_PASSWORD = "";

$LOCALPRODUCTCATEGORY = ["Tanks", "Accessories"];

$LOCALTANKS = ["Industrial Oxygen", "Medical Oxygen", "Acetylene", "Argon", "Nitrogen", "Carbon Dioxide", "LPG"];

$LOCALACCESSORIES = ["Nuts", "Nozzles", "Gauges", "Mixers", "Others"];

$TANKTYPES = ["Standard (50 LBS)", "Flask Type (5 - 20 LBS)"];

$TANKTYPEFORLPG = ["Standard (11 KGS)", "Large (50 KGS)"];

$POINTSALEHEADER = ["Name", "Quantity", "Price", "Total", "Action"];

$POINTSALEBODY = ["name", "quantities", "price", "total"];

$TANKHEADERS = ["Product Code", "Tank Name", "Action"];

$TANKBODYS = ["tank_id", "tank_name", "View Types"];

$TANKTYPEHEADER = ["Type ID", "Type Name", "Size", "Quantity Stock", "On Hand", "Price"];

$TANKTYPEBODY = ["tank_type_id", "tank_type_name", "type_size", "type_quantity_stock", "type_on_hand", "type_price"];

$ACCHEADERS = ["Product Code", "Accessory Type", "Accessory Name", "On Hand", "Price"];

$ACCBODYS = ["acc_id", "acc_type_id", "acc_name", "acc_on_hand", "acc_price"];

$CUSTOMERHEADER = ["Customer ID", "Customer Type", "Customer Name", "Customer Number", "Address", "Start Date", "Action"];

$CUSTOMERBODY = ["cust_id", "cust_type", "cust_name", "cust_contact_no", "cust_address", "start_date", "View Details"];

$CUSTOMERINFOHEADER = ["Customer Name", "Contact Number", "Address", "Start Date", "Tank Deposited", "Tank On Hand", "Cash Deposited", "Rental Price"];

$CUSTOMERINFOBODY = ["cust_name", "cust_contact_no", "cust_address", "start_date", "tank_deposited", "tank_on_hand", "cash_deposited", "price_rent"];


$SUPPLIERHEADER = ["Company Name", "Contact Number"];

$SUPPLIERBODY = ["company_name", "contact_no"];

$EXPENSESHEADER = ["Expenses Name", "Cash", "Action"];

$EXPENSESBODY = ["expenses", "cash"];
    
$TRANSACTIONHEADER = ["Customers", "# of Items", "Total Sales", "Date", "Action"];

$TRANSACTIONBODY = ["cust_id", "no_of_items", "total_sales", "date_of_transaction", "View"];

$TRANSACTIONNORMALHEADER = ["ID", "Customer", "# of Items", "Sub Total", "Cash", "Change", "Total Sales", "Date", "Action"];

$TRANSACTIONNORMALBODY = ["trans_id", "cust_id", "no_of_items", "sub_total", "cash_paid", "cash_change", "total_sales", "date_of_transaction", "View"];

$TRANSACORDERHEADER = ["ID", "Product Type", "Product", "Price", "Quantity", "Total"];

$TRANSACORDERBODY = ["pos_product_id", "prod_type", "product", "price", "quantity", "total"];

$EXPENSESTABLEHEADER = ["# of Expense", "Total Expense", "Date", "Action"];

$EXPENSESTABLEBODY = ["total_expenses", "total", "date_made", "View"];

$EXPENSESNORMALHEADER = ["ID", "# of Items", "Total", "Date", "Action"];

$EXPENSESNORMALBODY = ["exp_id", "total_expenses", "total", "date_made", "View"];

$EXPENSESITEMSHEADER = ["ID", "Expense Name", "Expense"];

$EXPENSESITEMSBODY = ["store_exp_item", "expenses", "exp_cash"];

$SUPPLIESHEADER = ["Delivery Price", "# of Products", "Date Delivered", "Action"];

$SUPPLIESBODY = ["delivery_price", "prod_quantity", "date_delivered", "View"];

$SUPPLIESNORMALHEADER = ["ID", "Supplier", "Product Quantity", "Delivery Price", "Date", "Action"];

$SUPPLIESNORMALBODY = ["trans_id", "sup_id", "prod_quantity", "delivery_price", "date_delivered", "View"];

$SUPPLIESITEMSHEADER = ["ID", "Product Type", "Product", "Quantity Before", "Quantity After", "Delivered Quantity"];

$SUPPLIESITEMSBODY = ["ts_product_id", "prod_type", "product", "quantity_before", "quantity_after", "quantity"];

$OVERVIEWHEADER = ["Transaction Date", "Sales", "Expenses", "Net Income"];

$OVERVIEWBODY = ["date", "sales", "expenses", "income"];