<?php include '../includes/header.php'; ?>

<main class="container py-5">

    <section class="mb-5 text-center">
        <h1>Bienvenue sur le Centre MOOC</h1>
        <p>Découvrez nos MOOC et notre bibliothèque en ligne.</p>
        <a href="index.php?page=mooc" class="btn btn-primary">Commencer à apprendre</a>
    </section>

    <section class="row text-center justify-content-center mb-5">
        <div class="col-md-6 mb-3">
            <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="fas fa-laptop-code fa-3x mb-3"></i>
                    <h2>MOOC</h2>
                    <p>Accédez à nos cours en ligne ouverts et massifs.</p>
                </div>
                <a href="index.php?page=mooc" class="btn btn-outline-primary mt-2">Voir les MOOC</a>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <i class="fas fa-book fa-3x mb-3"></i>
                    <h2>Bibliothèque</h2>
                    <p>Explorez notre vaste collection de ressources pédagogiques.</p>
                </div>
                <a href="index.php?page=bibliotheque" class="btn btn-outline-primary mt-2">Voir la bibliothèque</a>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="text-center mb-4">
            <h2 class="mb-2">Cours à la Une</h2>
            <p class="mb-3 text-muted">Des cours en ligne pour découvrir, apprendre, progresser et réussir</p>
            <a href="index.php?page=mooc" class="btn btn-primary">Plus de cours</a>
        </div>

        <div class="row g-4">
            <?php if (empty($coursAlaUne)): ?>
                <p class="text-center">Aucun cours à la une pour le moment.</p>
            <?php else: ?>
                <?php foreach ($coursAlaUne as $cours): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo filter_var($cours['image'], FILTER_VALIDATE_URL) ? htmlspecialchars($cours['image']) : '../' . htmlspecialchars($cours['image']); ?>" class="card-img-top" alt="Illustration du cours : <?= htmlspecialchars($cours['titre']) ?>" style="max-height:180px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($cours['titre']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($cours['description']) ?></p>
                                <a href="../details/mooc_detail.php?id=<?= $cours['id'] ?>" class="btn btn-primary mt-auto">Voir le cours</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-5">
        <h2 class="mb-4 text-center">Actualités locales</h2>
        <div class="row justify-content-center">
            <?php if (empty($actus)): ?>
                <p class="text-center">Aucune actualité disponible.</p>
            <?php else: ?>
                <?php foreach ($actus as $actu): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($actu['titre']) ?></h5>
                                <p class="text-muted small mb-2"><?= date('d/m/Y', strtotime($actu['date_evt'])) ?></p>
                                <p><?= htmlspecialchars($actu['texte']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Section Actualités éducatives (NewsAPI) - Marche maintenant avec ta clé valide -->
    <section class="mb-5">
        <h2 class="mb-4 text-center">Actualités éducatives</h2>
        <div class="row justify-content-center">
            <?php if (empty($news)): ?>
                <p class="text-center">Aucune actualité disponible pour le moment.</p>
            <?php else: ?>
                <?php foreach ($news as $article): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <?php if(!empty($article['urlToImage'])): ?>
                                <img src="<?= htmlspecialchars($article['urlToImage']) ?>" class="card-img-top" alt="Image illustrant l'actualité éducative : <?= htmlspecialchars($article['title']) ?>" style="max-height:180px; object-fit:cover;">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5><?= htmlspecialchars($article['title']) ?></h5>
                                <p class="text-muted small mb-2"><?= date('d/m/Y H:i', strtotime($article['publishedAt'])) ?></p>
                                <p><?= htmlspecialchars($article['description'] ?? '') ?></p>
                                <?php if (!empty($article['url'])): ?>
                                    <a href="<?= htmlspecialchars($article['url']) ?>" class="btn btn-outline-primary btn-sm mt-auto" target="_blank">Lire plus</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-5">
        <h2 class="mb-4 text-center">
            <i class="fas fa-headphones"></i> Dernières émissions France Culture
        </h2>
        <div class="row justify-content-center">
            <?php if (empty($radioShows)): ?>
                <p class="text-center">Aucune émission disponible pour le moment (dernières 24h). Vérifiez les logs ou élargissez la période à 7 jours.</p>
            <?php else: ?>
                <?php foreach ($radioShows as $show):
                    $diffusion = $show['diffusion'];
                    $podcast = $diffusion['podcastEpisode'] ?? null;
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5><?= htmlspecialchars($diffusion['title']) ?></h5>
                                <p class="text-muted small mb-2"><?= htmlspecialchars($diffusion['standFirst'] ?? 'Émission éducative') ?></p>
                                <?php if ($podcast): ?>
                                    <p class="card-text"><?= htmlspecialchars($podcast['title']) ?></p>
                                    <p class="text-muted small">Date : <?= date('d/m/Y H:i', strtotime($diffusion['published_date'])) ?> | Durée : <?= gmdate('H:i', $podcast['duration']) ?></p>
                                    <a href="<?= htmlspecialchars($podcast['playerUrl']) ?>" class="btn btn-outline-primary btn-sm mt-auto" target="_blank">Écouter le podcast</a>
                                <?php else: ?>
                                    <?php if (!empty($diffusion['url'])): ?>
                                        <a href="<?= htmlspecialchars($diffusion['url']) ?>" class="btn btn-outline-primary btn-sm mt-auto" target="_blank">Voir l'émission</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php include '../includes/footer.php'; ?>
