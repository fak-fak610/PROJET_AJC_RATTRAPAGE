<?php
require_once __DIR__ . '/../config.php';

class BibliothequeController {
    public function index() {
        global $pdo;

        // ============================
        // 🔹 Récupération actualités GNews
        // ============================
        $apiKey = "ae96fb6d699b01c0e5223faa80df57e5";
        $maxNews = 12;

        $url = "https://gnews.io/api/v4/top-headlines?topic=technology&lang=fr&country=fr&max={$maxNews}&apikey={$apiKey}";
        $response = @file_get_contents($url);
        $actualites = [];

        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['articles'])) {
                $actualites = $data['articles'];
            }
        }

        include __DIR__ . '/../view/bibliotheque_view.php';

    }

}
