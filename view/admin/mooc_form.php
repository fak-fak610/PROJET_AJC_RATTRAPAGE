<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Modifier' : 'Créer' ?> un MOOC - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <h5 class="text-white px-3">Admin Panel</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin_dashboard">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="index.php?page=admin_moocs">
                                <i class="fas fa-graduation-cap"></i> MOOCs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin_livres">
                                <i class="fas fa-book"></i> Livres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="index.php?page=admin_logout">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $isEdit ? 'Modifier' : 'Créer' ?> un MOOC</h1>
                    <a href="index.php?page=admin_moocs" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $type ?> alert-dismissible fade show">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <!-- Colonne gauche -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="titre" name="titre" 
                                       value="<?= htmlspecialchars($mooc['titre'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($mooc['description'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="image_url" name="image_url" 
                                           placeholder="URL de l'image (ex: https://...)" 
                                           value="<?= htmlspecialchars($mooc['image'] ?? '') ?>">
                                </div>
                                <div class="text-center my-2"><strong>OU</strong></div>
                                <input type="file" class="form-control" id="image_file" name="image_file"
                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" onchange="previewImage(this)">
                                <small class="text-muted">Formats acceptés : JPG, JPEG, PNG, GIF, WEBP (max 5 Mo)</small>
                                
                                <?php if (!empty($mooc['image'])): ?>
                                    <div class="mt-2">
                                        <img src="../<?= htmlspecialchars($mooc['image']) ?>" 
                                             id="image_preview" 
                                             alt="Aperçu" 
                                             style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                    </div>
                                <?php else: ?>
                                    <img id="image_preview" src="#" alt="Aperçu" style="max-width: 200px; max-height: 150px; display: none; margin-top: 10px; object-fit: cover;">
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vidéo</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="video_url" name="video_url"
                                           placeholder="URL de la vidéo (YouTube, etc.)"
                                           value="<?= htmlspecialchars($mooc['video'] ?? '') ?>">
                                </div>
                                <div class="text-center my-2"><strong>OU</strong></div>
                                <input type="file" class="form-control" id="video_file" name="video_file"
                                       accept="video/mp4,video/avi,video/quicktime,video/webm">
                                <small class="text-muted">Formats acceptés : MP4, AVI, MOV, WEBM (max 100 Mo)</small>

                                <?php if (!empty($mooc['video']) && !filter_var($mooc['video'], FILTER_VALIDATE_URL)): ?>
                                    <div class="mt-2 alert alert-info">
                                        <i class="fas fa-video"></i> Vidéo actuelle : <?= basename($mooc['video']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Audio (MP3)</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="audio_url" name="audio_url"
                                           placeholder="URL de l'audio"
                                           value="<?= htmlspecialchars($mooc['audio'] ?? '') ?>">
                                </div>
                                <div class="text-center my-2"><strong>OU</strong></div>
                                <input type="file" class="form-control" id="audio_file" name="audio_file"
                                       accept="audio/mpeg,audio/wav,audio/ogg,audio/aac,audio/mp4">
                                <small class="text-muted">Formats acceptés : MP3, WAV, OGG, AAC, M4A (max 50 Mo)</small>

                                <?php if (!empty($mooc['audio']) && !filter_var($mooc['audio'], FILTER_VALIDATE_URL)): ?>
                                    <div class="mt-2 alert alert-info">
                                        <i class="fas fa-music"></i> Audio actuel : <?= basename($mooc['audio']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Colonne droite -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duree" class="form-label">Durée</label>
                                <input type="text" class="form-control" id="duree" name="duree" 
                                       placeholder="Ex: 6 semaines" 
                                       value="<?= htmlspecialchars($mooc['duree'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="effort" class="form-label">Effort</label>
                                <input type="text" class="form-control" id="effort" name="effort" 
                                       placeholder="Ex: 15 heures" 
                                       value="<?= htmlspecialchars($mooc['effort'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="rythme" class="form-label">Rythme</label>
                                <select class="form-select" id="rythme" name="rythme">
                                    <option value="">-- Choisir --</option>
                                    <option value="Auto-rythmé" <?= ($mooc['rythme'] ?? '') == 'Auto-rythmé' ? 'selected' : '' ?>>Auto-rythmé</option>
                                    <option value="Guidé" <?= ($mooc['rythme'] ?? '') == 'Guidé' ? 'selected' : '' ?>>Guidé</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quizz" class="form-label">Quiz (HTML)</label>
                                <textarea class="form-control" id="quizz" name="quizz" rows="5" placeholder="<strong>Question :</strong> ...?"><?= htmlspecialchars($mooc['quizz'] ?? '') ?></textarea>
                                <small class="text-muted">Vous pouvez utiliser du HTML</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $isEdit ? 'Mettre à jour' : 'Créer' ?>
                        </button>
                        <a href="index.php?page=admin_moocs" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aperçu de l'image
        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Validation Bootstrap
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>