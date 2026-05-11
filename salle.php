<?php
require_once 'config/database.php';

// Récupérer l'id dans l'URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header('Location: salles.php');
    exit;
}

// Récupérer la salle
$stmt = $pdo->prepare('SELECT * FROM salle WHERE id_salle = ?');
$stmt->execute([$id]);
$salle = $stmt->fetch(PDO::FETCH_ASSOC);

// Si la salle n'existe pas, rediriger
if (!$salle) {
    header('Location: salles.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/indexstyle.css">
    <link rel="stylesheet" href="css/indexstyle.css">
    <title><?= htmlspecialchars($salle['nom']) ?> — CHOP TA SALLE</title>
</head>
<body>

<header class="header">
    <img src="./image/logo.jpg" alt="logo d'entreprise">
    <h2 class="header-titre">WorkSpace Connect</h2>
    <nav>
        <ul class="nav-list">
            <li><a href="index.php" class="nav-btn">Accueil</a></li>
            <li><a href="salles.php" class="nav-btn">Nos salles</a></li>
            <li><a href="reservation.php" class="nav-btn">Réserver</a></li>
        </ul>
    </nav>
</header>


    <main style="max-width:800px; margin:40px auto; padding:0 20px;">

        <!-- Image grande -->
        <img src="./image/<?= htmlspecialchars($salle['image']) ?>"
             alt="<?= htmlspecialchars($salle['nom']) ?>"
             style="width:100%; height:350px; object-fit:cover; border-radius:10px;">

        <!-- Infos -->
        <h1 style="margin-top:24px;"><?= htmlspecialchars($salle['nom']) ?></h1>

        <p style="color:gray; margin:8px 0;">
            👥 Capacité : <?= $salle['capacité'] ?> personnes
        </p>

        <p style="font-size:1.4rem; font-weight:bold; color:brown;">
            <?= $salle['prix'] ?>€ / heure
        </p>

        <p style="margin:16px 0; line-height:1.7;">
            <?= htmlspecialchars($salle['description']) ?>
        </p>

        <p><strong>Équipements :</strong> <?= htmlspecialchars($salle['équipements']) ?></p>

        <!-- Boutons -->
        <div style="margin-top:30px; display:flex; gap:12px;">
            <a href="salles.php">
                <button class="details">← Retour aux salles</button>
            </a>
            <a href="reservation.php?id=<?= $salle['id_salle'] ?>">
                <button class="ajouter">Réserver cette salle</button>
            </a>
        </div>

    </main>
   <footer class="footer">
        <p>© 2026 WorkSpace Connect — 📍 Paris | 📞 01 23 45 67 89 | ✉️ contact@workspaceconnect.fr</p>
    </footer>
</body>
</html>