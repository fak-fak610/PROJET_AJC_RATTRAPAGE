<?php
require_once 'model/User.php';

class ProfilController {
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: connexion.php');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $user = User::getById($user_id);

        include 'view/profil.php';
    }

    public function update() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: connexion.php');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($new_password && $new_password === $confirm_password) {
            User::update($user_id, $username, $email, $new_password);
        } else {
            User::update($user_id, $username, $email);
        }

        $_SESSION['profil_message'] = 'Profil mis à jour avec succès.';
        header('Location: profil.php');
        exit;
    }
}
?>
