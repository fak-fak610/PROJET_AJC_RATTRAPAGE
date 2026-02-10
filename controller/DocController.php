<?php
class DocController {
    public function index() {
        $images = [
           "https://www.inha.fr//app/uploads/2023/06/doc-hors-format-760x570.jpg",
           "https://cdn.prod.website-files.com/5d6697e04531522c6b9ca2a8/61028f7e90ece0936fc42bd2_qu_est_ce%20qu_une%20GED_.png",
           "https://www.synomega.com/wp-content/uploads/2020/10/synomega-infogerance-informatique-ile-de-france-Teletravail-se%CC%81curite-informatique-partage-Documents-article.jpg",
           "https://www.puceplume.fr/wp-content/uploads/2021/10/La-GED.png"
        ];

        // catégorie pour menu
        $categories = [
            ['label' => 'Bibliotheque', 'url' => 'index.php?page=bibliotheque'],
            ['label' => 'Articles', 'url' => 'index.php?page=articles'],
            ['label' => 'Documents', 'url' => 'index.php?page=documents'],
            ['label' => 'Livres', 'url' => 'index.php?page=livres'],
        ];

        include('../view/doc_view.php');
    }
}
?>
