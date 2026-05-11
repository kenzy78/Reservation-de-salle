<?php
require_once 'config/database.php';

$stmt = $pdo->query('SELECT * FROM salle ORDER BY id_salle LIMIT 4');
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/indexstyle.css">
    <title>WorkSpace Connect</title>
</head>
<body>
    <header class="header">
        <img src="./image/logo.jpg" alt="logo d'entreprise">
        <h2 class="header-titre">WorkSpace Connect</h2>
        <nav>
            <ul class="nav-list">
                <li><a href="index.php" class="nav-btn active">Accueil</a></li>
                <li><a href="salles.php" class="nav-btn">Nos salles</a></li>
                <li><a href="reservation.php" class="nav-btn">Réserver</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="nom">
            <h1>Bienvenue sur WorkSpace Connect</h1>
            <p>Le site de réservation de salles de réunion pour les entreprises</p>
        </div>

        <section class="sgrille">
            <div class="grille">

                <?php foreach ($salles as $salle) : ?>
                <div class="product">
                    <div class="image">
                        <img src="./image/<?= htmlspecialchars($salle['image']) ?>"
                             alt="<?= htmlspecialchars($salle['nom']) ?>"
                             width="200px" height="200px">
                    </div>
                    <div class="textes">
                        <h4 class="productName"><?= htmlspecialchars($salle['nom']) ?></h4>
                        <p class="description"><?= htmlspecialchars($salle['description']) ?></p>
                        <h5 class="prix"><?= $salle['prix'] ?>€/h</h5>
                    </div>
                    <div class="boutons">
                        <a href="salle.php?id=<?= $salle['id_salle'] ?>">
                            <button class="details">Détails</button>
                        </a>
                        <a href="reservation.php?id=<?= $salle['id_salle'] ?>">
                            <button class="ajouter">Réserver</button>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </section>
    </main>

    <footer class="footer">
        <p>© 2026 WorkSpace Connect — 📍 Paris | 📞 01 23 45 67 89 | ✉️ contact@workspaceconnect.fr</p>
    </footer>
</body>
</html>