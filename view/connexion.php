<?php
include '../includes/header.php';
?>

<main class="container d-flex flex-column align-items-center justify-content-center" style="min-height:70vh;">
    <section class="w-100" style="max-width:400px;">
        <h1 class="mb-3 text-center">Connexion</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?page=connexion">
            <div class="mb-3">
                <label for="login" class="form-label">Adresse e-mail ou nom d'utilisateur</label>
                <input type="text" class="form-control" id="login" name="login" required autocomplete="username">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
        <p class="mt-3 text-center">
            Mot de passe oublié ? <a href="index.php?page=mot_de_passe_oublie">Réinitialiser</a>
        </p>
        <p class="mt-2 text-center">
            Pas de compte ? <a href="index.php?page=inscription">Créer un compte</a>
        </p>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
