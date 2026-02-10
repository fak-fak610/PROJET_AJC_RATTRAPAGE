<?php
session_start();
require_once '../config.php';
require_once '../model/Database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo = Database::getConnection();
$stmt = $pdo->prepare('SELECT * FROM moocs WHERE id = :id');
$stmt->execute([':id' => $id]);
$mooc = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$mooc) {
    echo "<h1>MOOC introuvable</h1>";
    exit;
}

$isConnected = isset($_SESSION['user_id']);

$favori_ok = null;
if ($isConnected && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'favori') {
    $user_id = $_SESSION['user_id'];
    $favCheck = $pdo->prepare("SELECT COUNT(*) FROM mooc_favoris WHERE user_id=? AND mooc_id=?");
    $favCheck->execute([$user_id, $mooc['id']]);
    if ($favCheck->fetchColumn() == 0) {
        $stmtFav = $pdo->prepare("INSERT INTO mooc_favoris (user_id, mooc_id) VALUES (?, ?)");
        $stmtFav->execute([$user_id, $mooc['id']]);
        $favori_ok = true;
    } else {
        $favori_ok = "already";
    }
}

function getYouTubeEmbedUrl($url) {
    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url;
    }
    
    if (strpos($url, 'archive.org') !== false) {
        return $url;
    }
    
    $videoId = '';
    if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
        $videoId = $matches[1];
    } elseif (preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
        $videoId = $matches[1];
    }
    
    return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $url;
}

$embedUrl = getYouTubeEmbedUrl($mooc['video']);
$isYouTube = strpos($embedUrl, 'youtube.com') !== false;
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <a href="../public/index.php?page=mooc" class="btn btn-secondary mb-3">← Retour</a>
    <h1><?= htmlspecialchars($mooc['titre']) ?></h1>
    <img src="<?php echo filter_var($mooc['image'], FILTER_VALIDATE_URL) ? htmlspecialchars($mooc['image']) : '../' . htmlspecialchars($mooc['image']); ?>" alt="Image MOOC" class="img-fluid mb-3" style="max-height:220px; object-fit:cover"/>

    <p class="lead"><?= htmlspecialchars($mooc['description']) ?></p>

    <div><strong>Durée :</strong> <?= htmlspecialchars($mooc['duree']) ?></div>
    <div><strong>Effort :</strong> <?= htmlspecialchars($mooc['effort']) ?></div>
    <div><strong>Rythme :</strong> <?= htmlspecialchars($mooc['rythme']) ?></div>

    <?php if (!empty($mooc['video'])): ?>
        <div class="my-4">
            <strong>Vidéo du cours :</strong>
            <div class="ratio ratio-16x9">
                <?php if ($isYouTube): ?>
                    <iframe
                        src="<?= htmlspecialchars($embedUrl) ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <video controls>
                        <source src="../<?= htmlspecialchars($embedUrl) ?>" type="video/mp4">
                        Désolé, votre navigateur ne supporte pas les vidéos intégrées.
                    </video>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($mooc['audio'])): ?>
        <div class="my-4">
            <strong>Audio du cours :</strong>
            <div class="mt-3">
                <?php if (filter_var($mooc['audio'], FILTER_VALIDATE_URL)): ?>
                    <audio controls>
                        <source src="<?= htmlspecialchars($mooc['audio']) ?>" type="audio/mpeg">
                        Désolé, votre navigateur ne supporte pas les audios intégrés.
                    </audio>
                <?php else: ?>
                    <audio controls>
                        <source src="../<?= htmlspecialchars($mooc['audio']) ?>" type="audio/mpeg">
                        Désolé, votre navigateur ne supporte pas les audios intégrés.
                    </audio>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($isConnected): ?>
        <form method="post" class="mb-3">
            <input type="hidden" name="action" value="favori">
            <button type="submit" class="btn btn-warning">⭐ Ajouter aux favoris</button>
        </form>
        <?php if ($favori_ok === true): ?>
            <div class="alert alert-success">✅ Ajouté à vos favoris !</div>
        <?php elseif ($favori_ok === "already"): ?>
            <div class="alert alert-info">ℹ️ Ce MOOC est déjà dans vos favoris.</div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-danger mb-3">
            🔒 Connectez-vous pour ajouter ce MOOC à vos favoris !
        </div>
    <?php endif; ?>

    <?php if (!empty($mooc['quizz'])): ?>
        <h4 class="mt-4">📝 Quiz</h4>
        <form method="post" action="#" class="border p-3 bg-light rounded">
            <?= $mooc['quizz']; ?>
            <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
