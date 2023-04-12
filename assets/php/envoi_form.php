<?php
require_once 'Comment.php';
require_once 'Database.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $user = $_POST['name'] ?? null;
    $comment = $_POST['commentaire'] ?? null;

    // Validate inputs
    $errors = [];
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Veuillez saisir un email valide';
    }
    if (!$user) {
        $errors['user'] = 'Veuillez saisir votre nom';
    }
    if (!$comment) {
        $errors['comment'] = 'Veuillez saisir un commentaire';
    }

    if (empty($errors)) {
        // Create Comment object and insert into database
        $commentObj = new Comment($email, $user, $comment);
        $db = new Database();
        $db->insertComment($commentObj);
    }
}
session_start();
$_SESSION['success_message'] = "Votre commentaire a été créé avec succès.";
header('Location: ../../index.php');
exit();
?>