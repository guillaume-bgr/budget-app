<?php require_once __DIR__.'/libraries/database.php'; 
require_once __DIR__.'/functions.php';
require_once __DIR__.'/inc/sanitize.php';
$answers = showUsers(0, 6);
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
    <div class="row mt-3">
        <div class="col-6 align-self-center"> 
            <div class="w-75 mx-auto border-right border-left">
                <div class="px-3">
                    <h1 class="">Ajouter un utilisateur</h1>
                    <form class="" method="post" autocomplete="off">
                    <div class="">
                        <label class="h4" for="first_name">Prénom</label>
                        <input type="text" id="first_name" name="first_name" class="form-control"<?= isset($errors['firstname'])? 'is-invalid' : '';?>">
                        <p class="<?= isset($errors['firstname'])? 'text-danger form-text mt-0' : '';?>">
                            <?= isset($errors['firstname'])? $errors['firstname'] : '';?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="h4" for="last_name" class="form-label">Nom</label>
                        <input type="text" id="last_name" name="last_name" class="form-control <?= isset($errors['lastname'])? 'is-invalid' : '';?>">
                        <p class="<?= isset($errors['lastname'])? 'text-danger form-text mt-0' : '';?>">
                            <?= isset($errors['lastname'])? $errors['lastname'] : '';?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="h4" for="birth_date" class="form-label">Date de Naissance</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control <?= isset($errors['birthdate'])? 'is-invalid' : '';?>">
                        <p class="<?= isset($errors['birthdate'])? 'text-danger form-text mt-0' : '';?>">
                        <?= isset($errors['birthdate'])? $errors['birthdate'] : '';?>
                        </p>
                    </div>   
                    <button type="submit" class="btn-warning">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>
        <div class="d-flex flex-column align-items-center col-6 align-self-center">
            <div class="title d-flex justify-content-between align-items-center">
                <h2>Derniers utilisateurs ajoutés</h1>
            </div>
                <?php foreach($answers as $answer) {?>
                <div class="user d-flex justify-content-between border-bottom border-top pt-2">
                    <div>
                        <h4 class="mb-1"><?= $answer['first_name'] ?><span class="text-warning">
                                <?= $answer['last_name'] ?></span></h3>
                            <h5 class="date"><?= $answer['birth_date'] ?>
                        </h4>
                    </div>
                    <div>
                        <h5 class=""><i class="fas fa-coins mr-1"></i> <?= $answer['totalinc']-$answer['totalexp'] ?>€
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
<?php require_once __DIR__.'/inc/footer.php';