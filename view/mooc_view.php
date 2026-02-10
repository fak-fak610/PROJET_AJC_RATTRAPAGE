<?php include '../includes/header.php'; ?>

<main class="container mt-5">
    <section class="text-center mb-4">
        <h1 class="display-5">Bienvenue sur le Centre MOOC</h1>
        <p class="lead">Découvrez nos formations en ligne et MOOC.</p>
    </section>

    <div class="row g-4 justify-content-center">
        <?php if ($totalMoocs == 0): ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    Aucun MOOC disponible<?= $q !== '' ? " pour la recherche « " . htmlspecialchars($q) . " »" : "" ?>.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($currentMoocs as $mooc): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 mooc-card">
                        <img src="<?php echo filter_var($mooc['image'], FILTER_VALIDATE_URL) ? htmlspecialchars($mooc['image']) : '../' . htmlspecialchars($mooc['image']); ?>" class="card-img-top mooc-image" alt="Illustration MOOC" style="max-height:200px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title h5"><?= htmlspecialchars($mooc['titre']) ?></h3>
                            <p class="card-text"><?= htmlspecialchars($mooc['description']) ?></p>
                            <a href="../details/mooc_detail.php?id=<?= $mooc['id'] ?>" class="btn btn-primary mt-auto">
                                Voir le MOOC
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="../public/index.php?page=mooc&q=<?= urlencode($q) ?>&p=<?= $page-1 ?>">&laquo; Précédent</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="../public/index.php?page=mooc&q=<?= urlencode($q) ?>&p=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="../public/index.php?page=mooc&q=<?= urlencode($q) ?>&p=<?= $page+1 ?>">Suivant &raquo;</a>
            </li>
        </ul>
    </nav>
</main>

<?php include '../includes/footer.php'; ?>
