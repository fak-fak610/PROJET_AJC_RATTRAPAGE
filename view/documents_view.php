<?php include("includes/header.php"); ?>

<section class="upload-hero">
  <div class="container position-relative text-center upload-hero__content">
    <h1 class="display-5 fw-bold text-white mb-2">Bibliothèque numérique</h1>
    <p class="lead text-white-50 mb-4">Partagez et consultez des documents informatiques utiles.</p>

    <div class="upload-card card shadow-lg mx-auto">
      <div class="card-body p-4">
        <h5 class="mb-2">Partager un document informatique</h5>
        <p class="text-muted small mb-3">Formats autorisés : PDF, DOC, DOCX, PPTX, TXT, ODT, XLSX</p>

        <?php if (!empty($uploadMessage)): ?>
          <div class="alert <?= str_starts_with($uploadMessage,'✅') ? 'alert-success' : 'alert-danger' ?> py-2 mb-3">
            <?= htmlspecialchars($uploadMessage) ?>
          </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="upload-form">
          <input type="file"
                 name="doc"
                 class="form-control form-control-sm mb-2"
                 accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.odt,.xlsx"
                 required>
          <button type="submit" class="btn btn-primary btn-sm w-100">Uploader</button>
        </form>

        <small class="text-muted d-block mt-2">
          Astuce : privilégiez des fichiers légers pour un accès rapide et plus écologique.
        </small>
      </div>
    </div>

    <?php if(!empty($files)): ?>
        <h5 class="mt-4 text-white"> Derniers fichiers uploadés :</h5>
        <div class="d-flex overflow-auto pb-2">
            <?php foreach($files as $file): ?>
                <a href="<?= $dir . urlencode($file) ?>" download
                   class="card text-center text-dark me-2"
                   style="min-width: 150px; flex: 0 0 auto;">
                    <div class="card-body p-2">
                        <?= htmlspecialchars($file) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-white small mt-2">Aucun document n’a encore été uploadé.</p>
    <?php endif; ?>

  </div>
</section>

<?php include("../includes/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
