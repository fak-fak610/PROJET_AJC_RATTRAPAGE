<?php
require_once 'model/User.php';

class MotDePasseOublieController {
    public function index() {
        include 'view/mot_de_passe_oublie.php';
    }

    public function reset() {
        $email = $_POST['email'] ?? '';

        if ($email) {
            echo "Un email de réinitialisation a été envoyé à $email.";
        } else {
            echo "Erreur : email requis.";
        }
    }
}
?>
