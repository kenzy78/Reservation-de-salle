<?php
require_once 'config/database.php';

// Récupérer toutes les salles
$stmt  = $pdo->query('SELECT * FROM salle');
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos salles — WorkSpace Connect</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="salles.php">Nos salles</a>
            <a href="reservation.php">Réserver</a>
        </nav>
    </header>

    <main>
        <h1>Nos salles disponibles</h1>

        <div class="grille-salles">
            <?php foreach ($salles as $salle) : ?>
            <div class="card">
                <img src="images/<?= htmlspecialchars($salle['image']) ?>" 
                     alt="<?= htmlspecialchars($salle['nom']) ?>">
                <h2><?= htmlspecialchars($salle['nom']) ?></h2>
                <p>Capacité : <?= $salle['capacite'] ?> personnes</p>
                <p><?= $salle['prix'] ?> € / heure</p>
                <a href="salle.php?id=<?= $salle['id_salle'] ?>">Voir la salle</a>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>