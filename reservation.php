<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "workspace_connect";
$user = "root";
$password = "";

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération et nettoyage des données
    $nom = trim($_POST["nom"] ?? "");
    $prenom = trim($_POST["prenom"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telephone = trim($_POST["telephone"] ?? "");
    $date = trim($_POST["date"] ?? "");
    $creneau = trim($_POST["creneau"] ?? "");
    $nb_personnes = intval($_POST["nb_personnes"] ?? 0);
    $id_salle = intval($_POST["id_salle"] ?? 0);
    $modalite = trim($_POST["modalite"] ?? "");

    // Validation
    if (empty($nom)) $errors[] = "Le nom est requis.";
    if (empty($prenom)) $errors[] = "Le prénom est requis.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                           $errors[] = "L'email est invalide.";
    if (empty($telephone)) $errors[] = "Le téléphone est requis.";
    if (empty($date)) $errors[] = "La date est requise.";
    if (empty($creneau)) $errors[] = "Le créneau est requis.";
    if ($nb_personnes < 1) $errors[] = "Le nombre de personnes est requis.";
    if ($id_salle < 1) $errors[] = "Veuillez choisir une salle.";

    if (empty($errors)) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
                INSERT INTO réservation (nom, prénom, email, date, créneau, Nb_personnes, id_salle, téléphone, modalité)
                VALUES (:nom, :prenom, :email, :date, :creneau, :nb_personnes, :id_salle, :telephone, :modalite)
            ");

            $stmt->execute([
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":email" => $email,
                ":date" => $date,
                ":creneau" => $creneau,
                ":nb_personnes" => $nb_personnes,
                ":id_salle" => $id_salle,
                ":telephone" => $telephone,
                ":modalite" => $modalite,
            ]);

            $id_reservation = $pdo->lastInsertId();

            // Redirection vers la page de confirmation
            header("Location: confirmation.php?id=" . $id_reservation);
            exit();

        } catch (PDOException $e) {
            $errors[] = "Erreur base de données : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réserver une salle</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/reservation.css" />
</head>
<body>

<div class="page-wrap">

  <header class="page-header">
    <p class="site-tag">Workspace Connect</p>
    <h1>Réserver une salle</h1>
    <p class="page-subtitle">Remplissez le formulaire ci-dessous pour confirmer votre réservation.</p>
  </header>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-error">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card">

    <form method="POST" action="reservation.php" novalidate>

      <!-- Identité -->
      <fieldset>
        <legend>Vos informations</legend>
        <div class="form-row two-col">
          <div class="form-group">
            <label for="nom">Nom <span class="req">*</span></label>
            <input type="text" id="nom" name="nom" placeholder="Dupont"
              value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required />
          </div>
          <div class="form-group">
            <label for="prenom">Prénom <span class="req">*</span></label>
            <input type="text" id="prenom" name="prenom" placeholder="Marie"
              value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required />
          </div>
        </div>

        <div class="form-row two-col">
          <div class="form-group">
            <label for="email">Email <span class="req">*</span></label>
            <input type="email" id="email" name="email" placeholder="marie@exemple.fr"
              value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
          </div>
          <div class="form-group">
            <label for="telephone">Téléphone <span class="req">*</span></label>
            <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78"
              value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" required />
          </div>
        </div>
      </fieldset>

      <!-- Réservation -->
      <fieldset>
        <legend>Détails de la réservation</legend>

        <div class="form-row two-col">
          <div class="form-group">
            <label for="date">Date <span class="req">*</span></label>
            <input type="date" id="date" name="date"
              min="<?= date('Y-m-d') ?>"
              value="<?= htmlspecialchars($_POST['date'] ?? '') ?>" required />
          </div>
          <div class="form-group">
            <label for="creneau">Créneau horaire <span class="req">*</span></label>
            <select id="creneau" name="creneau" required>
              <option value="" disabled <?= empty($_POST['creneau']) ? 'selected' : '' ?>>Choisir un créneau</option>
              <?php
              $creneaux = ["08h00 - 09h30","09h00 - 10h30","10h00 - 11h30","11h00 - 12h30",
                           "13h00 - 14h30","14h00 - 15h30","15h00 - 16h30","16h00 - 17h30","17h00 - 18h30"];
              foreach ($creneaux as $c):
                $sel = (($_POST['creneau'] ?? '') === $c) ? 'selected' : '';
              ?>
                <option value="<?= $c ?>" <?= $sel ?>><?= $c ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-row two-col">
          <div class="form-group">
            <label for="id_salle">Salle <span class="req">*</span></label>
            <select id="id_salle" name="id_salle" required>
              <option value="" disabled <?= empty($_POST['id_salle']) ? 'selected' : '' ?>>Choisir une salle</option>
              <option value="1" <?= (($_POST['id_salle'] ?? '') == 1) ? 'selected' : '' ?>>Salle Confluence — 3ème étage (10 pers.)</option>
              <option value="2" <?= (($_POST['id_salle'] ?? '') == 2) ? 'selected' : '' ?>>Salle Horizon — 2ème étage (20 pers.)</option>
              <option value="3" <?= (($_POST['id_salle'] ?? '') == 3) ? 'selected' : '' ?>>Salle Atrium — RDC (6 pers.)</option>
              <option value="4" <?= (($_POST['id_salle'] ?? '') == 4) ? 'selected' : '' ?>>Salle Zénith — 4ème étage (30 pers.)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nb_personnes">Nombre de participants <span class="req">*</span></label>
            <input type="number" id="nb_personnes" name="nb_personnes" min="1" max="100" placeholder="Ex : 8"
              value="<?= htmlspecialchars($_POST['nb_personnes'] ?? '') ?>" required />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="modalite">Modalité / Description</label>
            <textarea id="modalite" name="modalite" rows="3"
              placeholder="Précisez l'objet de la réunion, équipements souhaités…"><?= htmlspecialchars($_POST['modalite'] ?? '') ?></textarea>
          </div>
        </div>

      </fieldset>

      <div class="form-footer">
        <p class="required-note"><span class="req">*</span> Champs obligatoires</p>
        <button type="submit" class="btn-submit">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Confirmer la réservation
        </button>
      </div>

    </form>
  </div>

</div>

</body>
</html>