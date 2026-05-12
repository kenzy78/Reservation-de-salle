<?php
require_once 'config/database.php';

$id          = isset($_GET['id']) ? intval($_GET['id']) : 0;
$reservation = null;

if ($id > 0) {
$stmt = $pdo->prepare("
    SELECT r.*, s.nom AS nom_salle, s.prix
    FROM `réservation` r
    JOIN `salle` s ON r.id_salle = s.id_salle
    WHERE r.`id_réservation` = ?
");
    $stmt->execute([$id]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation confirmée — CHOP TA SALLE</title>
    <link rel="stylesheet" href="css/confirmationstyle.css">
    <link rel="stylesheet" href="css/indexstyle.css">
    
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

<div class="confirm-wrap">
    <div class="confirm-card">
        <div class="confirm-icon">✅</div>
        <h1>Réservation confirmée !</h1>

        <?php if ($reservation) : ?>
        <p>Merci <strong><?= htmlspecialchars($reservation['prénom']) ?></strong>, votre réservation a bien été enregistrée.</p>

        <div class="confirm-recap">
            <div class="confirm-recap-row">
                <span>🏢</span>
                <div><label>Salle</label><strong><?= htmlspecialchars($reservation['nom_salle']) ?></strong></div>
            </div>
            <div class="confirm-recap-row">
                <span>📅</span>
                <div><label>Date</label><strong><?= htmlspecialchars($reservation['date']) ?></strong></div>
            </div>
            <div class="confirm-recap-row">
                <span>🕐</span>
                <div><label>Créneau</label><strong><?= htmlspecialchars($reservation['créneau']) ?></strong></div>
            </div>
            <div class="confirm-recap-row">
                <span>👥</span>
                <div><label>Participants</label><strong><?= $reservation['Nb_personnes'] ?> personnes</strong></div>
            </div>
            <div class="confirm-recap-row">
                <span>📧</span>
                <div><label>Email</label><strong><?= htmlspecialchars($reservation['email']) ?></strong></div>
            </div>
        </div>
        <?php else : ?>
        <p>Votre réservation a bien été enregistrée.</p>
        <?php endif; ?>

        <div class="confirm-btns">
            <a href="index.php"><button class="details">🏠 Accueil</button></a>
            <a href="salles.php"><button class="ajouter">Voir les salles</button></a>
        </div>
    </div>
</div>

   <footer class="footer">
        <p>© 2026 WorkSpace Connect — 📍 Paris | 📞 01 23 45 67 89 | ✉️ contact@workspaceconnect.fr</p>
    </footer>

</body>
</html>