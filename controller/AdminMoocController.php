<?php
require_once '../model/Mooc.php';

class AdminMoocController {
    public function index() {
        $message = "";

        // ajouter
        if (isset($_POST['action']) && $_POST['action'] == 'ajouter') {
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? ''; // chemin du fichier image
            if ($titre && $description) {
                Mooc::create($titre, $description, $image);
                $message = "MOOC ajouté !";
            }
        }

        // supprimer
        if (isset($_POST['action']) && $_POST['action'] == 'supprimer' && isset($_POST['id'])) {
            Mooc::delete($_POST['id']);
            $message = "MOOC supprimé !";
        }

        // modifier
        if (isset($_POST['action']) && $_POST['action'] == 'modifier') {
            $id = $_POST['id'] ?? '';
            $titre = $_POST['titre'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $_POST['image'] ?? '';
            if ($id && $titre && $description) {
                Mooc::update($id, $titre, $description, $image);
                $message = "MOOC modifié !";
            }
        }

        // Liste des MOOC
        $moocs = Mooc::getAll();

       require_once '../view/admin_mooc_view.php';
    }
}
?>
