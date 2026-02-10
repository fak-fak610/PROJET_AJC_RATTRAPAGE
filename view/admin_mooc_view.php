<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin MOOC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gestion des MOOC</h1>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <input type="hidden" name="action" value="ajouter">
        <div class="mb-2"><input type="text" name="titre" class="form-control" placeholder="Titre"></div>
        <div class="mb-2"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
        <div class="mb-2"><input type="text" name="image" class="form-control" placeholder="Chemin de l'image (ex: assets/images/data_science.png)"></div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>

    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Titre</th><th>Description</th><th>Image</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($moocs as $mooc): ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $mooc['id'] ?>">
                    <td><?= $mooc['id'] ?></td>
                    <td><input type="text" name="titre" value="<?= htmlspecialchars($mooc['titre']) ?>" class="form-control"></td>
                    <td><textarea name="description" class="form-control"><?= htmlspecialchars($mooc['description']) ?></textarea></td>
                    <td><input type="text" name="image" value="<?= htmlspecialchars($mooc['image']) ?>" class="form-control"></td>
                    <td>
                        <button type="submit" name="action" value="modifier" class="btn btn-primary btn-sm">Modifier</button>
                        <button type="submit" name="action" value="supprimer" class="btn btn-danger btn-sm"
                                onclick="return confirm('Supprimer ce MOOC ?');">Supprimer</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
