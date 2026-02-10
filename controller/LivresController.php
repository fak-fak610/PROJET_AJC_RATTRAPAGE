<?php
require_once __DIR__ . '/../model/Livres.php';

class LivresController {

    public function index() {
        $livres = Livres::getAll();
        require __DIR__ . '/../view/livres_view.php';
    }

}
