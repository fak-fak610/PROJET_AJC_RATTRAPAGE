<?php include '../includes/header.php'; ?>

<main class="container d-flex flex-column align-items-center justify-content-center" style="min-height:70vh;">
    <section class="w-100" style="max-width:400px;">
        <h2 class="mb-3 text-center">Réinitialiser le mot de passe</h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center"><?= $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error; ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?page=mot_de_passe_oublie">
            <div class="mb-3">
                <label for="email" class="form-label">Votre adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-warning">Envoyer un nouveau mot de passe</button>
            </div>
        </form>
        <p class="mt-2 text-center">
            <a href="index.php?page=connexion">Retour à la connexion</a>
        </p>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
