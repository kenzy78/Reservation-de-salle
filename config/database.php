<?php
require_once 'config/database.php';

$stmt   = $pdo->query('SELECT * FROM salle');
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/indexstyle.css">
    <title>Nos salles — CHOP TA SALLE</title>
</head>
<body>

    <header class="header">
        <img src="./image/logo.jpg" alt="logo">
        <nav>
            <ul class="border">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="salles.php">Nos salles</a></li>
                <li><a href="reservation.php">Réserver</a></li>
            </ul>
        </nav>
    </header>

    <main>
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

</body>
</html>