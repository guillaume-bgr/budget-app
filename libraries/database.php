<?php function getDatabase() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=budget-app-new;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo 'Erreur';
        die();
    }
    return $pdo;
}
