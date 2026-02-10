<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque numérique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/projet_ajc_php/css/bibli.css?v=1.2">
</head>

<body>

<?php include '../includes/header.php'; ?>


<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $images = [
            "https://blog.editions-verone.com/wp-content/uploads/2024/03/Les-ressources-en-ligne-pour-les-ecrivains-Sites-web-forums-et-communautes-pour-trouver-du-soutien-et-des-conseils-1536x861.jpg",
            "https://maisons-alfort.fr/wp-content/uploads/2020/06/base_1110x338_livres.jpg",
            "https://www.ssf-fr.org/wp-content/uploads/2020/03/951727.large--800x418.png",
             "https://img.freepik.com/photos-gratuite/nature-morte-livres-contre-technologie_23-2150062975.jpg",
            
            
        ];
        foreach ($images as $index => $url) {
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active'><img src='$url' class='d-block w-100 img-fluid' alt='carousel image $index'></div>";
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
    <h1 class="display-5 fw-bold">Bibliothèque numérique</h1>
    <p class="lead">Accédez à une large sélection de ressources pédagogiques pour enrichir votre apprentissage.</p>

   <?php
    $categories = [
        ['label' => 'Bibliotheque', 'url' => 'index.php?page=bibliotheque'],
        ['label' => 'Articles', 'url' => 'index.php?page=articles'],
        ['label' => 'Documents', 'url' => 'index.php?page=doc'],
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

    
        </div>
    </div>
</div>
<?php
$apiKey = "ae96fb6d699b01c0e5223faa80df57e5"; 
$maxNews = 12;

$url = "https://gnews.io/api/v4/top-headlines?topic=technology&lang=fr&country=fr&max={$maxNews}&apikey={$apiKey}";

// Récupération des données
$response = file_get_contents($url);
$actualites = [];

if($response !== false){
    $data = json_decode($response, true);
    if(isset($data['articles'])){
        $actualites = $data['articles'];
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="nouveautes-section">
    <p class="lead">Actualités Tech</p>
    <div class="nouveautes-row">
        <?php if(!empty($actualites)): ?>
            <?php foreach($actualites as $actu): ?>
                <div class="nouveaute-card">
                    <img src="<?= htmlspecialchars($actu['image'] ?? 'https://via.placeholder.com/300x180?text=Tech') ?>" alt="actualité tech">
                    <div class="content">
                        <p><?= htmlspecialchars($actu['title']) ?></p>
                        <a href="<?= htmlspecialchars($actu['url']) ?>" target="_blank">Lire l'article</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune actualité pour le moment.</p>
        <?php endif; ?>
    </div>
</div>


<?php include '../includes/footer.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
