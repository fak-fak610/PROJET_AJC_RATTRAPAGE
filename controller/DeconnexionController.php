<?php
class DeconnexionController {
    public function index() {
        session_start();
        session_destroy();
        header('Location: connexion.php');
        exit;
    }
}
?>
