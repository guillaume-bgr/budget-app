<?php 

function paginate() {
    if (isset($_GET['pageindex'])) {
        $pageindex = $_GET['pageindex'];
    }
    else {
        $pageindex = 0;
    }
    return $pageindex;
}

function deleteIncome() {
    $pdo = getDatabase();
    $sql = "DELETE
            FROM `incomes`        
            WHERE `inc_id` = :inc";
$req = $pdo->prepare($sql);
$req->bindValue(':inc', $_GET['inc_id'], PDO::PARAM_INT);
$req->execute();
}

function deleteExpense() {
    $pdo = getDatabase();
    $sql = "DELETE
            FROM `expenses`        
            WHERE `exp_id` = :exp";
$req = $pdo->prepare($sql);
$req->bindValue(':exp', $_GET['exp_id'], PDO::PARAM_INT);
$req->execute();
}

function calcIncomes($user) {
    $pdo = getDatabase();
    $sql = "SELECT SUM(`inc_amount`) AS `inc_amount` FROM `incomes`
            WHERE `user_id` = :user";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $user, PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function calcExpenses($user) {
    $pdo = getDatabase();
    $sql = "SELECT SUM(`exp_amount`) AS `exp_amount` FROM `expenses`
            WHERE `user_id` = :user";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $user, PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function calcIncome() {
    $pdo = getDatabase();
    $sql = "SELECT SUM(`inc_amount`) AS `inc_amount` FROM `incomes` WHERE `user_id` = :user";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $_GET['user_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function calcExpense() {
    $pdo = getDatabase();
    $sql = "SELECT SUM(`exp_amount`) AS `exp_amount` FROM `expenses` WHERE `user_id` = :user";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $_GET['user_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function showUserIncomes() {
    $pdo = getDatabase();
    $sql = "SELECT `inc_id`, `inc_cat_name`, `inc_amount`, DATE_FORMAT(inc_receipt_date, '%d/%m/%Y') AS `inc_receipt_date` FROM `incomes`
            INNER JOIN `incomes_categories` ON `incomes_categories`.`inc_cat_id`=`incomes`.`inc_cat_id`
            WHERE `user_id` = :user
            ORDER BY `inc_id` DESC";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $_GET['user_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function showUserExpenses() {
    $pdo = getDatabase();
    $sql = "SELECT `exp_id`, `exp_amount`, `exp_label`, DATE_FORMAT(exp_date, '%d/%m/%Y') AS `exp_date` FROM `expenses`
            WHERE `user_id` = :user
            ORDER BY `exp_id` DESC";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $_GET['user_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}   

function showSingleIncome() {
    // Si on ne veut pas de pagination passer 0 en paramètre
    $pdo = getDatabase();
    $sql = "SELECT * FROM `incomes` WHERE inc_id=:inc";
$req = $pdo->prepare($sql);
$req->bindValue(':inc', $_GET['inc_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function modifyIncome($incomes, $inc_cat_ids) {
    $pdo = getDatabase();
    $sql = "UPDATE `incomes`
            SET `inc_amount` = :amount, `inc_cat_id` = :cat, `inc_receipt_date` = NOW()
            WHERE `inc_id` = :inc";
    $req = $pdo->prepare($sql);
    $req->bindValue(':amount', $incomes, PDO::PARAM_STR);
    $req->bindValue(':cat', $inc_cat_ids, PDO::PARAM_INT);
    $req->bindValue(':inc', $_GET['inc_id'], PDO::PARAM_INT);
    $req->execute();
    return $req;
}

function showSingleUser() {
    // Si on ne veut pas de pagination passer 0 en paramètre
    $pdo = getDatabase();
    $sql = "SELECT `users`.`user_id`, `first_name`, `last_name`, DATE_FORMAT(birth_date, '%Y-%m-%d') AS birth_date, DATE_FORMAT(birth_date, '%d/%m/%y') AS birth_date_display, SUM(`incomes`.`inc_amount`) AS `totalinc`, SUM(`expenses`.`exp_amount`) AS `totalexp`
        FROM `users`
        LEFT JOIN `incomes` ON `users`.`user_id`=`incomes`.`user_id`
        LEFT JOIN `expenses` ON `users`.`user_id`=`expenses`.`user_id`
        WHERE `users`.`user_id` = :user";
$req = $pdo->prepare($sql);
$req->bindValue(':user', $_GET['user_id'], PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function showCategories() {
    $pdo = getDatabase();
    $sql = "SELECT * FROM `incomes_categories`";
    $req = $pdo->query($sql);
    $answers = $req->fetchAll(PDO::FETCH_ASSOC);
    return $answers;
}

function modifyUser($first_name, $last_name, $birth_date, $user_id) {
    $pdo = getDatabase();
    $sql = "UPDATE `users`
            SET `first_name` = :firstname, `last_name` = :lastname, `birth_date` = :birthdate
            WHERE `user_id` = :user";
    $req = $pdo->prepare($sql);
    $req->bindValue(':firstname', $first_name, PDO::PARAM_STR);
    $req->bindValue(':lastname', $last_name, PDO::PARAM_STR);
    $req->bindValue(':birthdate', $birth_date, PDO::PARAM_STR);
    $req->bindValue(':user', $user_id, PDO::PARAM_INT);
    $req->execute();
    return $req;
}

function createUserIncome($user_id, $incomes, $inc_cat_ids) {
    $pdo = getDatabase();
    $sql = "INSERT INTO `incomes` (`inc_amount`, `inc_receipt_date`, `inc_cat_id`, `user_id`) VALUES
    (:income, NOW(), :category, :user)";
    $req = $pdo->prepare($sql);
    $req->bindValue(':income', $incomes, PDO::PARAM_STR);
    $req->bindValue(':category', $inc_cat_ids, PDO::PARAM_STR);
    $req->bindValue(':user', $user_id, PDO::PARAM_INT);
    $req->execute();
    return $req;
}

function createUserExpense($user_id, $expenses, $exp_labels) {
    $pdo = getDatabase();
    $sql = "INSERT INTO `expenses` (`exp_amount`, `exp_date`, `exp_label`, `user_id`) VALUES
    (:expense, NOW(), :label, :user)";
    $req = $pdo->prepare($sql);
    $req->bindValue(':expense', $expenses, PDO::PARAM_STR);
    $req->bindValue(':label', $exp_labels, PDO::PARAM_STR);
    $req->bindValue(':user', $user_id, PDO::PARAM_INT);
    $req->execute();
    return $req;
}

function showUsers($pageindex, $pagination) {
    // Si on ne veut pas de pagination passer 0 en paramètre
    $offset = ($pageindex*$pagination);
    $pdo = getDatabase();
    $sql = "SELECT `users`.`user_id`, `first_name`, `last_name`, DATE_FORMAT(birth_date, '%d/%m/%Y') AS birth_date, SUM(inc_amount) AS `totalinc`, SUM(exp_amount) AS `totalexp`
        FROM `users`
        LEFT JOIN `incomes` ON `users`.`user_id`=`incomes`.`user_id`
        LEFT JOIN `expenses` ON `users`.`user_id`=`expenses`.`user_id`
        GROUP BY `users`.`user_id`
        ORDER BY `users`.`user_id` DESC
        LIMIT :offset, :pagination";
$req = $pdo->prepare($sql);
$req->bindValue(':offset', $offset, PDO::PARAM_INT);
$req->bindValue(':pagination', $pagination, PDO::PARAM_INT);
$req->execute();
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}   

function totalEntries() {
    $pdo = getDatabase();
    $sql = "SELECT  COUNT(*) as 'totalEntries'
    FROM `users`";
$req = $pdo->query($sql);
$answers = $req->fetchAll(PDO::FETCH_ASSOC);
return $answers;
}

function addUser($first_name, $last_name, $birth_date) {
    $pdo = getDatabase();
    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `birth_date`) VALUES
    (:firstname, :lastname, :birthdate)";
    $req = $pdo->prepare($sql);
    $req->bindValue(':firstname', $first_name, PDO::PARAM_STR);
    $req->bindValue(':lastname', $last_name, PDO::PARAM_STR);
    $req->bindValue(':birthdate', $birth_date, PDO::PARAM_STR);
    $req->execute();
    return $req;
}