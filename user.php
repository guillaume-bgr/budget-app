<?php require_once __DIR__.'/libraries/database.php'; 
require_once __DIR__.'/functions.php';
$answers = showSingleUser();
if (isset($_GET['inc_id'])) {
    deleteIncome($_GET['inc_id']);
}
if (isset($_GET['exp_id'])) {
    deleteExpense($_GET['exp_id']);
}
$incomes = showUserIncomes();
$expenses = showUserExpenses();
$totalinc = calcIncome();
$totalexp = calcExpense();
require_once __DIR__.'/inc/header.php';?>
<div class="header-top position-fixed w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="header w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="mt-3 ml-3 home h4 d-flex align-items-center"><a class="text-white" href="index.php"><i class="ml-2 mr-2 fas fa-arrow-alt-circle-left"></i>Retour</a></div>
    </div>
    <div class="singleuser border-right border-left w-50 mx-auto mt-5">
        <div class="pl-3 d-flex align-items-center justify-content-between">
            <h1 class="mb-0"><?= $answers[0]['first_name'] ?> <span class="text-warning"><?= $answers[0]['last_name']?></span></h1>
            <a href="modify.php?user_id=<?= $answers[0]['user_id'] ?>"><button class="btn-warning text-white"><i class="mb-0 h4 fas fa-user-edit"></i></button></a>
        </div>
        <h2 class="ml-3 birthdate"><?= $answers[0]['birth_date_display'] ?></h2>
        <div class="money ml-0 w-50"><h2 class="ml-2">Solde : <?= $totalinc[0]['inc_amount']-$totalexp[0]['exp_amount'] ?> €</h2></div>
        <div class="row">
            <div class="col-6 border-right pr-0">
                <h4 class="ml-4">Revenus</h4>
                <form method="post">
                <?php foreach($incomes as $income) {?>
                    <div class="d-flex justify-content-between mt-3 ml-2">
                        <div class="w-50 d-flex flex-column ml-4"><h5 class="mr-5 mb-0"><?= $income['inc_cat_name'] ?></h5><h5 class="date"><?= $income['inc_receipt_date'] ?></h5></div>
                        <div class="ml-1 d-flex"><h5 class="ml-3 mb-0 text-success align-self-center">+<?= $income['inc_amount'] ?></h5><a href="modify-income.php?user_id=<?= $_GET['user_id'] ?>&inc_id=<?= $income['inc_id'] ?>" class="text-decoration-none ml-2 align-self-center btn-warning h-50 d-flex"><i class="align-self-center p-1 text-white fas fa-pencil-alt"></i></a><a href="user.php?user_id=<?= $_GET['user_id'] ?>&inc_id=<?= $income['inc_id'] ?>" class="text-decoration-none ml-2 align-self-center btn-danger h-50 d-flex"><i class="align-self-center p-1 text-white fas fa-times-circle"></i></a></div>
                    </div>
                <?php }; ?>
            </div>
            <div class="col-6">
                <h4 class="ml-2">Dépenses</h4>
                <?php foreach($expenses as $expense) {?>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="w-50 d-flex flex-column ml-3"><h5 class="mr-5 mb-0"><?= $expense['exp_label'] ?></h5><h5 class="date"><?= $expense['exp_date'] ?></h5></div>
                        <div class="ml-1 d-flex"><h5 class="mb-0 text-danger align-self-center">-<?= $expense['exp_amount'] ?></h5><a href="modify-income.php?user_id=<?= $_GET['user_id'] ?>&exp_id=<?= $expense['exp_id'] ?>" class="text-decoration-none ml-2 align-self-center btn-warning h-50 d-flex"><i class="align-self-center p-1 text-white fas fa-pencil-alt"></i></a><a href="user.php?user_id=<?= $_GET['user_id'] ?>&exp_id=<?= $expense['exp_id'] ?>" class="text-decoration-none ml-2 align-self-center btn-danger h-50 d-flex"><i class="align-self-center p-1 text-white fas fa-times-circle"></i></a></div>
                    </div>
                <?php }; ?>
                </form>
            </div>
        </div>
    </div>
</div>

