<?php include '../../../system.php' ?>
<?php include '../../../data.php' ?>
<?php include '../../../database.php' ?>

<?php
$EXPENSES = GetExpenses(true, $database);
$EXPENSES = ExpensesAsDay($EXPENSES);
echo CreateTable($EXPENSESTABLEHEADER, $EXPENSESTABLEBODY,  $EXPENSES, "exp_id", 3, true);