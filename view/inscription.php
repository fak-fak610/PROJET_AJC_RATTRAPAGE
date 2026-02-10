<?php include '../includes/header.php'; ?>

<main class="container d-flex flex-column align-items-center justify-content-center" style="min-height:80vh;">
    <section class="w-100" style="max-width:400px;">
        <h1 class="mb-3 text-center">Inscription</h1>
        <p class="lead text-center mb-4">Rejoignez notre communauté !</p>

        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center"><?= $success; ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="registration-form" method="post" action="index.php?page=inscription">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" autocomplete="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                <small class="form-text text-muted">Le mot de passe doit contenir au moins 6 caractères, un chiffre et un symbole (ex: !@#$%^&*).</small>
            </div>
            <div class="mb-4">
                <label for="confirm-password" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm_password" autocomplete="new-password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
        </form>

        <p class="mt-3 text-center">
            Déjà inscrit ? <a href="index.php?page=connexion">Se connecter</a>
        </p>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
