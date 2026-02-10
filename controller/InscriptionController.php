<?php
require_once '../model/User.php';

class InscriptionController {
    public function index() {
        include '../view/inscription.php';
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $errors = [];

        if (!$username) {
            $errors[] = "Le nom d'utilisateur est requis.";
        }
        if (!$email) {
            $errors[] = "L'adresse e-mail est requise.";
        }
        if (!$password) {
            $errors[] = "Le mot de passe est requis.";
        }
        if (!$confirm_password) {
            $errors[] = "La confirmation du mot de passe est requise.";
        }

        if ($password) {
            if (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
            }
            if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
                $errors[] = "Le mot de passe doit contenir au moins un symbole (ex: !@#$%^&*).";
            }
        }

        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        if ($username && User::getByUsername($username)) {
            $errors[] = "Ce nom d'utilisateur est déjà pris.";
        }
        if ($email && User::getByEmail($email)) {
            $errors[] = "Cette adresse e-mail est déjà utilisée.";
        }

        if (empty($errors)) {
            User::create($username, $email, $password);
            $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header('Location: index.php?page=connexion');
            exit;
        } else {
            include '../view/inscription.php';
        }
    }
}
?>
