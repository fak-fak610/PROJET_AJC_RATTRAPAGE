<?php
// view/admin/login.php
// Variables attendues : $error
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - Connexion</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-page">
<div class="admin-container">
<h1>Connexion administrateur</h1>


<?php if (!empty($error)): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>


<form method="post" action="index.php?page=admin_login" class="form-admin">
<label>Utilisateur
<input type="text" name="username" required>
</label>


<label>Mot de passe
<input type="password" name="password" required>
</label>


<div class="form-actions">
<button type="submit" class="btn">Se connecter</button>
</div>
</form>


</div>
</body>
</html>