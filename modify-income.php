<?php require_once __DIR__.'/libraries/database.php'; 
require_once __DIR__.'/inc/sanitize.php';
require_once __DIR__.'/functions.php';
$answers = showSingleUser();
$categories = showCategories();
$details = showSingleIncome();
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
        <form class="mb-5" method="post" autocomplete="off">
        <div class="ml-3 w-75 mb-3">
            <label class="h4" for="income" class="form-label">Modifier le revenu :</label>
            <input type="number" id="income" name="income"  value="<?= $details[0]['inc_amount'] ?>"class="form-control <?= isset($errors['income'])? 'is-invalid' : '';?>">
            <p class="<?= isset($errors['income'])? 'text-danger form-text mb-0' : '';?>">
                <?= isset($errors['income'])? $errors['income'] : '';?>
            </p>
            <p class="mb-0">Catégorie du revenu :</p>
            <select class="form-control-sm" name="inc_cat_id" id="inc_cat_id" selected="<?= $details[0]['inc_cat_id'] ?>">
                <?php foreach($categories as $category) { ?>
                    <option value="<?= $category['inc_cat_id'] ?>"><?= $category['inc_cat_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="row justify-content-end mb-5">
            <button type="submit" class="mr-5 btn-warning text-white">Valider</button>
        </div>
        </form>
    </div>
</div>
<?php require_once __DIR__.'/inc/footer.php';