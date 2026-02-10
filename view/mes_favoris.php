<?php
include '../includes/header.php';
?>

<main class="container mt-5">
    <h2 class="mb-4">Mes MOOC favoris</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <div class="row g-4">
        <?php if (empty($favoris)): ?>
            <div class="col-12">
                <div class="alert alert-warning">Aucun favori pour l'instant.</div>
            </div>
        <?php else: ?>
            <?php foreach ($favoris as $mooc): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 text-center">
                        <img src="<?php echo filter_var($mooc['image'], FILTER_VALIDATE_URL) ? htmlspecialchars($mooc['image']) : '../assets/images/' . htmlspecialchars($mooc['image']); ?>" class="card-img-top" style="max-height:180px; object-fit:cover;" alt="Illustration du MOOC favori : <?= htmlspecialchars($mooc['titre']) ?>">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h4 class="card-title"><?= htmlspecialchars($mooc['titre']) ?></h4>
                            <p class="card-text text-truncate"><?= htmlspecialchars($mooc['description']) ?></p>
                            <a href="../details/mooc_detail.php?id=<?= $mooc['id'] ?>" class="btn btn-primary my-2">Voir le MOOC</a>
                            <form method="post" action="index.php?page=mes_favoris" style="margin-top:10px;">
                                <input type="hidden" name="action" value="supprimer_favori" />
                                <input type="hidden" name="mooc_id" value="<?= $mooc['id'] ?>" />
                                <button type="submit" class="btn btn-outline-danger btn-sm">Retirer des favoris</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
