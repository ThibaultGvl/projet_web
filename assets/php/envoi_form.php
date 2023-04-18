<?php
require_once 'models/Comment.php';
require_once 'models/Database.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $comment = $_POST['commentaire'];
    $errors = [];
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($email)) {
        $errors['email'] = 'Veuillez saisir un email valide';
    }
    if (!$name || !is_string($name) || strlen($name) > 255) {
        $errors['user'] = 'Veuillez saisir votre nom';
    }
    if (!$comment || !is_string($comment)) {
        $errors['comment'] = 'Veuillez saisir un commentaire';
    }

    if (empty($errors)) {
        $commentObj = new Comment($email, $name, $comment);
        $db = new Database('db/');
        $db->insertComment($commentObj);
        $_SESSION['success_message'] = "Votre commentaire a été créé avec succès.";
    }
    else {
        $_SESSION['success_message'] = "Votre commentaire n'a pas pu être créé.";
    }
}

header('Location: ../../index.php');
exit();

?>