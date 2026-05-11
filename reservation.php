<?php
require_once 'config/database.php';

$errors  = [];
$success = false;

$stmtSalles = $pdo->query('SELECT * FROM salle ORDER BY id_salle');
$salles     = $stmtSalles->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['nom'])) {
    $nom          = trim($_POST["nom"] ?? "");
    $prenom       = trim($_POST["prenom"] ?? "");
    $email        = trim($_POST["email"] ?? "");
    $telephone    = trim($_POST["telephone"] ?? "");
    $date         = trim($_POST["date"] ?? "");
    $creneau      = trim($_POST["creneau"] ?? "");
    $nb_personnes = intval($_POST["nb_personnes"] ?? 0);
    $id_salle     = intval($_POST["id_salle"] ?? 0);
    $modalite     = trim($_POST["modalite"] ?? "");

    // Vérifier que nom et prénom contiennent uniquement des lettres
if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $nom)) {
    $errors[] = "Le nom ne doit contenir que des lettres.";
}
if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $prenom)) {
    $errors[] = "Le prénom ne doit contenir que des lettres.";
}

// Vérifier que le téléphone contient uniquement des chiffres
if (!preg_match('/^[0-9\s\+\-]{8,15}$/', $telephone)) {
    $errors[] = "Le téléphone ne doit contenir que des chiffres.";
}

    if (empty($nom))          $errors[] = "Le nom est requis.";
    if (empty($prenom))       $errors[] = "Le prénom est requis.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                              $errors[] = "L'email est invalide.";
    if (empty($telephone))    $errors[] = "Le téléphone est requis.";
    if (empty($date))         $errors[] = "La date est requise.";
    if (empty($creneau))      $errors[] = "Le créneau est requis.";
    if ($nb_personnes < 1)    $errors[] = "Le nombre de personnes est requis.";
    if ($id_salle < 1)        $errors[] = "Veuillez choisir une salle.";
    if ($id_salle > 0 && $nb_personnes > 0) {
    $stmtCap = $pdo->prepare('SELECT capacité FROM salle WHERE id_salle = ?');
    $stmtCap->execute([$id_salle]);
    $salleChoisie = $stmtCap->fetch(PDO::FETCH_ASSOC);
    
    if ($salleChoisie && $nb_personnes > $salleChoisie['capacité']) {
        $errors[] = "La salle choisie a une capacité maximale de " . $salleChoisie['capacité'] . " personnes. Vous avez indiqué " . $nb_personnes . " participants.";
    }
}
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO réservation (nom, prénom, email, date, créneau, Nb_personnes, id_salle, téléphone, modalité)
                VALUES (:nom, :prenom, :email, :date, :creneau, :nb_personnes, :id_salle, :telephone, :modalite)
            ");
            $stmt->execute([
                ":nom"          => $nom,
                ":prenom"       => $prenom,
                ":email"        => $email,
                ":date"         => $date,
                ":creneau"      => $creneau,
                ":nb_personnes" => $nb_personnes,
                ":id_salle"     => $id_salle,
                ":telephone"    => $telephone,
                ":modalite"     => $modalite,
            ]);
            $id_reservation = $pdo->lastInsertId();
            header("Location: confirmation.php?id=" . $id_reservation);
            exit();
        } catch (PDOException $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }
}

$id_preselect = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une salle — CHOP TA SALLE</title>
    <link rel="stylesheet" href="css/reservationstyle.css">
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

<div class="resa-container">
    <h1 class="resa-titre">Réserver une salle</h1>
    <p class="resa-sous-titre">Remplissez le formulaire pour confirmer votre réservation.</p>

    <?php if (!empty($errors)) : ?>
    <div class="resa-erreurs">
        ⚠️ Veuillez corriger les erreurs suivantes :
        <ul>
            <?php foreach ($errors as $e) : ?>
            <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="resa-card">
        <form method="POST" action="reservation.php">

            <div class="resa-section">
                <p class="resa-section-label">Identité</p>
                <div class="resa-grid-2">
                    <div class="resa-field">
                        <label>Nom *</label>
                        <input type="text" name="nom" placeholder="Dupont"
                               value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                    </div>
                    <div class="resa-field">
                        <label>Prénom *</label>
                        <input type="text" name="prenom" placeholder="Marie"
                               value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                    </div>
                    <div class="resa-field">
                        <label>Email *</label>
                        <input type="email" name="email" placeholder="marie@exemple.fr"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="resa-field">
                        <label>Téléphone *</label>
                        <input type="tel" name="telephone" placeholder="06 12 34 56 78"
                               value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="resa-section">
                <p class="resa-section-label">Date & horaires</p>
                <div class="resa-grid-2">
                    <div class="resa-field">
                        <label>Date *</label>
                        <input type="date" name="date" min="<?= date('Y-m-d') ?>"
                               value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
                    </div>
                    <div class="resa-field">
                        <label>Créneau *</label>
                        <select name="creneau">
                            <option value="">Sélectionner…</option>
                            <?php
                            $creneaux = ['08h00 - 09h30','09h00 - 10h30','10h00 - 11h30',
                                         '11h00 - 12h30','13h00 - 14h30','14h00 - 15h30',
                                         '15h00 - 16h30','16h00 - 17h30','17h00 - 18h30'];
                            foreach ($creneaux as $c) :
                                $sel = (($_POST['creneau'] ?? '') === $c) ? 'selected' : '';
                            ?>
                            <option <?= $sel ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="resa-section">
                <p class="resa-section-label">Choisir une salle</p>
                <div class="salle-chips">
                    <?php foreach ($salles as $i => $s) :
                        $checked = (
                            (isset($_POST['id_salle']) && $_POST['id_salle'] == $s['id_salle']) ||
                            (!isset($_POST['id_salle']) && $id_preselect == $s['id_salle'])
                        );
                    ?>
                    <label class="salle-chip <?= $checked ? 'selected' : '' ?>">
                        <input type="radio" name="id_salle" value="<?= $s['id_salle'] ?>"
                               <?= $checked ? 'checked' : '' ?>
                               onchange="document.querySelectorAll('.salle-chip').forEach(c=>c.classList.remove('selected')); this.closest('.salle-chip').classList.add('selected')">
                        <div class="salle-chip-num"><?= str_pad($i+1, 2, '0', STR_PAD_LEFT) ?></div>
                        <div class="salle-chip-nom"><?= htmlspecialchars($s['nom']) ?></div>
                        <div class="salle-chip-cap">👥 <?= $s['capacité'] ?> pers.</div>
                    </label>
                    <?php endforeach; ?>
                </div>
                <div class="resa-field">
                    <label>Nombre de participants *</label>
                    <input type="number" name="nb_personnes" min="1" max="100" placeholder="Ex : 8"
                           value="<?= htmlspecialchars($_POST['nb_personnes'] ?? '') ?>">
                </div>
            </div>

            <div class="resa-section">
                <p class="resa-section-label">Précisions</p>
                <div class="resa-field">
                    <label>Objet de la réunion</label>
                    <textarea name="modalite" placeholder="Décrivez l'objet de votre réunion…"><?= htmlspecialchars($_POST['modalite'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit" class="resa-submit">✅ Confirmer la réservation</button>

        </form>
    </div>
</div>
   <footer class="footer">
        <p>© 2026 WorkSpace Connect — 📍 Paris | 📞 01 23 45 67 89 | ✉️ contact@workspaceconnect.fr</p>
    </footer>
</body>
</html>