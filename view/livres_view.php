<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque numérique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/projet_ajc_php/assets/css/bibli.css?v=1.5">
</head>

<body>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="banniere-europeana">
  <div class="overlay-flou">
    <h1>Découvrez le patrimoine culturel numérique</h1>
    <p> Découvrez notre collection complète de livres et ressources en ligne </p>
  </div>
</div>

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

<section class="explore-themes" id="carrousel-livres">
  <h2>Explorez par thème</h2>

  <div class="carousel-container">
    <button class="prev">&#10094;</button>

    <div class="carousel">

      <!-- LIVRES x1 -->
      <?php foreach ($livres as $livre): ?>
        <a href="<?= htmlspecialchars($livre['lien']) ?>" target="_blank" class="card" style="text-decoration:none; color:inherit;">
          <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </a>
      <?php endforeach; ?>

      <!-- LIVRES x2 -->
      <?php foreach ($livres as $livre): ?>
        <a href="<?= htmlspecialchars($livre['lien']) ?>" target="_blank" class="card" style="text-decoration:none; color:inherit;">
          <img src="<?= htmlspecialchars($livre['image']) ?>" alt="<?= htmlspecialchars($livre['titre']) ?>">
          <p><?= htmlspecialchars($livre['titre']) ?></p>
        </a>
      <?php endforeach; ?>

    </div>

    <button class="next">&#10095;</button>
  </div>
</section>


<script>
const carousel = document.querySelector('.carousel');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');

prev.addEventListener('click', () => {
    carousel.scrollBy({ left: -250, behavior: 'smooth' });
});
next.addEventListener('click', () => {
    carousel.scrollBy({ left: 250, behavior: 'smooth' });
});

let autoScroll = setInterval(() => {
    if (carousel.scrollLeft >= (carousel.scrollWidth / 2)) {
        carousel.scrollLeft = 0;
    }
    carousel.scrollLeft += 2;
}, 20);

function restartAuto() {
    clearInterval(autoScroll);
    setTimeout(() => {
        autoScroll = setInterval(() => {
            if (carousel.scrollLeft >= (carousel.scrollWidth / 2)) {
                carousel.scrollLeft = 0;
            }
            carousel.scrollLeft += 2;
        }, 20);
    }, 800);
}

prev.addEventListener('click', restartAuto);
next.addEventListener('click', restartAuto);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
