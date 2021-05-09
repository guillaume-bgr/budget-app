<?php require_once __DIR__.'/libraries/database.php'; 
require_once __DIR__.'/functions.php';
$pageindex = paginate();
if (isset($_GET['pagination'])) {
    $pagination = $_GET['pagination'];
}
else {
    $pagination = 10;
}
$answers = showUsers($pageindex, $pagination);
$entries = totalEntries();

require_once __DIR__.'/inc/header.php';
?>
<div class="header-top position-fixed w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="header w-100 py-1">
    <a href="index.php"><img class="logo pl-4" src="assets/img/logo.svg" alt="Logo"></a>
</div>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-6"> 
            <h1 class="font-italic text-center">Gérez vos finances facilement.</h1>
        </div>
        <div class="d-flex flex-column col-6">
            <div class="title d-flex justify-content-between align-items-center">
                <h2>Liste des utilisateurs</h1>
                <a href="add-user.php"><button class="btn-warning text-white">Ajouter<i class="h5 ml-1 mb-0 fas fa-user-plus"></i></button></a>
            </div>
                <div class="buttons d-flex justify-content-between">
                    <a class=""
                        href="index.php<?= ($pageindex<1)? '' : '?pageindex='.($pageindex-1); ?><?= isset($_GET['pagination'])? '&pagination='.$_GET['pagination'] : ''; ?>"><button
                            type="button" class="btn-warning text-white font-weight-bold">
                            <i class="h6 fas fa-long-arrow-alt-left"></i></button></a>
                        <form class="d-flex">
                            <select class="form-control" name="pagination">
                                <option class="" value="">Nombre de résultats par page</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                            </select>
                            <button type="submit" class="btn-success"><i class="fas fa-check"></i></button>
                        </form>
                        <a class=""
                            href="index.php?<?= ((($pageindex+1)*$pagination)<($entries[0]['totalEntries']))? 'pageindex='.($pageindex+1) : '' ; ?><?= isset($_GET['pagination'])? '&pagination='.$_GET['pagination'] : ''; ?>"><button
                                type="button" class="btn-warning text-white font-weight-bold">
                                <i class="h6 fas fa-long-arrow-alt-right"></i></button></a>
                </div>
                <div class="mb-3">
                    <?php foreach($answers as $answer) {?>
                    <?php $incomes = calcIncomes($answer['user_id']) ?>
                    <?php $expenses = calcExpenses($answer['user_id']) ?>
                    <div class="user d-flex justify-content-between border-bottom border-top pt-2">
                    <div>
                        <h4 class="mb-1"><?= $answer['first_name'] ?><span class="text-warning">
                                <?= $answer['last_name'] ?></span></h4>
                            <h4 class="date"><?= $answer['birth_date'] ?>
                        </h4>
                    </div>
                    <div>
                        <h4 class=""><i class="fas fa-coins mr-1"></i> <?= $incomes[0]['inc_amount']-$expenses[0]['exp_amount'] ?>€
                            </h4>
                            <p class="text-right mb-1 font-weight-bold"><a
                                    href="user.php?user_id=<?= $answer['user_id'] ?>">Voir<i
                                        class="text-primary ml-1 fas fa-user h5"></i></a></p>
                    </div>
                    </div>  
                    <?php } ?>  
                </div>
        </div>
    </div>
</div>
<?php require_once __DIR__.'/inc/footer.php';