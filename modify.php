<?php require_once __DIR__.'/libraries/database.php'; 
require_once __DIR__.'/functions.php';
require_once __DIR__.'/inc/sanitize.php';
$answers = showSingleUser();
$categories = showCategories();
$totalinc = calcIncome();
$totalexp = calcExpense();
require_once __DIR__.'/inc/header.php';?>
<div class="header-top position-fixed w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="header w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="mt-3 ml-3 home h4 d-flex align-items-center"><a class="text-white" href="index.php"><i class="ml-2 mr-2 fas fa-arrow-alt-circle-left"></i>Retour</a></div>
    </div>
    <div class="singleuser border-right border-left w-50 mx-auto mt-5">
        <h2 class="ml-3">Modifier le profil</h1>
        <form class="mb-5" method="post" autocomplete="off">
        <div class="ml-3 w-75">
                <label class="h4" for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" value="<?= $answers[0]['first_name'] ?>" class="form-control<?= isset($errors['firstname'])? 'is-invalid' : '';?>">
                <p class="<?= isset($errors['firstname'])? 'text-danger form-text mt-0' : '';?>">
                    <?= isset($errors['firstname'])? $errors['firstname'] : '';?>
                </p>
        </div>
        <div class="ml-3 w-75">
                <label class="h4" for="last_name" class="form-label">Nom :</label>
                <input type="text" id="last_name" name="last_name" value="<?= $answers[0]['last_name'] ?>" class="form-control <?= isset($errors['lastname'])? 'is-invalid' : '';?>">
                <p class="<?= isset($errors['lastname'])? 'text-danger form-text mt-0' : '';?>">
                    <?= isset($errors['lastname'])? $errors['lastname'] : '';?>
                </p>
        </div>
        <div class="ml-3 w-75">
                <label class="h4" for="birth_date" class="form-label">Date de Naissance :</label>
                <input type="date" id="birth_date" name="birth_date" value="<?= $answers[0]['birth_date'] ?>" class="form-control <?= isset($errors['birthdate'])? 'is-invalid' : '';?>">
                <p class="<?= isset($errors['birthdate'])? 'text-danger form-text mt-0' : '';?>">
                <?= isset($errors['birthdate'])? $errors['birthdate'] : '';?>
                </p>
        </div> 
        <div class="money-group ml-0 w-50">
            <h2 class="ml-2 mb-1">Solde : <?= $totalinc[0]['inc_amount']-$totalexp[0]['exp_amount'] ?> €</h2>
            <h5 class="ml-2 mb-1">Total des revenus : <?= $totalinc[0]['inc_amount'] ?> €</h5>
            <h5 class="ml-2 mb-1">Total des dépenses : <?= $totalexp[0]['exp_amount'] ?> €</h5>
        </div>
        <div class="ml-3 w-75 pb-3">
            <label class="h4" for="income" class="form-label">Ajouter un revenu :</label>
            <input type="number" id="income" name="income" class="form-control <?= isset($errors['income'])? 'is-invalid' : '';?>">
            <p class="<?= isset($errors['income'])? 'text-danger form-text mb-0' : '';?>">
                <?= isset($errors['income'])? $errors['income'] : '';?>
            </p>
            <p class="mb-0">Catégorie du revenu :</p>
            <select class="form-control-sm" name="inc_cat_id" id="inc_cat_id">
                <?php foreach($categories as $category) { ?>
                    <option value="<?= $category['inc_cat_id'] ?>"><?= $category['inc_cat_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="ml-3 w-75">   
            <label class="h4" for="expense" class="form-label">Ajouter une dépense:</label>
            <input type="number" id="expense" name="expense" class="form-control <?= isset($errors['expense'])? 'is-invalid' : '';?>">
            <p class="<?= isset($errors['expense'])? 'text-danger form-text mt-0' : '';?>">
            <?= isset($errors['expense'])? $errors['expense'] : '';?>
            </p>
            <label for="exp_label" class="form-label w-100 mt-0 mb-0">Label de la dépense:</label>
            <input type="text" id="exp_label" name="exp_label" class="form-control-sm <?= isset($errors['lastname'])? 'is-invalid' : '';?>">
            <p class="<?= isset($errors['exp_label'])? 'text-danger form-text mt-0' : '';?>">
                    <?= isset($errors['exp_label'])? $errors['exp_label'] : '';?>
            </p>
        </div>
        <div class="row justify-content-end mb-5">
            <button type="submit" class="mr-5 btn-warning text-white">Valider</button>
        </div>
        </form>
    </div>
</div>
<?php require_once __DIR__.'/inc/footer.php';