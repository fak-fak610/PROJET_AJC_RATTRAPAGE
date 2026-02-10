<?php
include '../includes/header.php';
?>

<main class="container d-flex flex-column align-items-center justify-content-center" style="min-height:80vh;">
    <section class="w-100" style="max-width:400px;">
        <h2 class="mb-4 text-center">Mon profil</h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success text-center"><?= $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($messages)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($messages as $message): ?>
                        <li><?= htmlspecialchars($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
            <form method="post" action="index.php?page=profil">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <hr>
            <h5 class="mt-4">Changer le mot de passe</h5>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Mettre à jour mon profil</button>
            </div>
        </form>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
