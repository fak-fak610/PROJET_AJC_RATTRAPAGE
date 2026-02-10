<?php include '../includes/header.php';?>

<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $images = [
            "https://www.inha.fr//app/uploads/2023/06/doc-hors-format-760x570.jpg",
            "https://cdn.prod.website-files.com/5d6697e04531522c6b9ca2a8/61028f7e90ece0936fc42bd2_qu_est_ce%20qu_une%20GED_.png",
            "https://www.synomega.com/wp-content/uploads/2020/10/synomega-infogerance-informatique-ile-de-france-Teletravail-se%CC%81curite-informatique-partage-Documents-article.jpg",
            "https://www.puceplume.fr/wp-content/uploads/2021/10/La-GED.png"
        ];
        foreach ($images as $index => $url) {
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active'>
                    <img src='$url' class='d-block w-100 img-fluid' alt='carousel image $index' style='object-fit: cover; max-height: 500px;'>
                  </div>";
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>



<div class="container mt-5 text-center">
    <h1 class="display-5 fw-bold">Documents</h1>
    <p class="lead">Explorez notre collection organisée de documents numériques dédiés à l'informatique. Retrouvez des guides pratiques, des manuels, des études et des ressources pédagogiques pour enrichir vos connaissances et rester à jour avec les dernières tendances technologiques.</p>

    <?php
    $categories = [
        ['label' => 'Bibliotheque', 'url' => 'index.php?page=bibliotheque'],
        ['label' => 'Articles', 'url' => 'index.php?page=articles'],
        ['label' => 'Documents', 'url' => 'index.php?page=documents'],
        ['label' => 'Livres', 'url' => 'index.php?page=livres'],
    ];
    ?>
    <div class="row mt-4 justify-content-center">
        <?php foreach ($categories as $cat): ?>
            <div class="col-6 col-md-2 mb-2">
                <a href="<?= $cat['url'] ?>" class="btn btn-outline-dark w-100"><?= $cat['label'] ?></a>
            </div>
        <?php endforeach; ?>
    </div>



        <div id="page2" class="flip-page back">
            <h3>Partager un document</h3>
            <p>Uploader un fichier informatique</p>
            <a href="index.php?page=documents" class="btn btn-success">⬆️ Uploader un document</a>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>

<!-- Scripts -->
<link rel="stylesheet" href="assets/css/flipbook.css?v=1.0">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/flipbook.js?v=1.0"></script>
