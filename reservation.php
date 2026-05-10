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
    <link rel="stylesheet" href="css/reservationstyle.css" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réserver une salle — Workspace Connect</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet" />
  
</head>
<body>

<!-- ══════════════ LEFT PANEL ══════════════ -->
<aside class="panel-left">
  <div class="left-top">
    <div class="brand">
      <div class="brand-dot"></div>
      <span class="brand-name">Workspace Connect</span>
    </div>

    <p class="left-eyebrow">Réservation en ligne</p>
    <h1 class="left-title">Réservez<br>votre <em>espace</em><br>de travail.</h1>
    <p class="left-desc">Choisissez parmi nos salles équipées, disponibles 7j/7. </p>
  </div>

  <div>
    <div class="rooms">
      <div class="room-chip active" onclick="selectRoom(1, this)">
        <div class="room-chip-left">
          <span class="room-number">01</span>
          <div>
            <div class="room-name">Salle Confluence</div>
            <div class="room-floor">3ème étage</div>
          </div>
        </div>
        <span class="room-cap">10 pers.</span>
      </div>
      <div class="room-chip" onclick="selectRoom(2, this)">
        <div class="room-chip-left">
          <span class="room-number">02</span>
          <div>
            <div class="room-name">Salle Horizon</div>
            <div class="room-floor">2ème étage</div>
          </div>
        </div>
        <span class="room-cap">20 pers.</span>
      </div>
      <div class="room-chip" onclick="selectRoom(3, this)">
        <div class="room-chip-left">
          <span class="room-number">03</span>
          <div>
            <div class="room-name">Salle Atrium</div>
            <div class="room-floor">RDC</div>
          </div>
        </div>
        <span class="room-cap">6 pers.</span>
      </div>
      <div class="room-chip" onclick="selectRoom(4, this)">
        <div class="room-chip-left">
          <span class="room-number">04</span>
          <div>
            <div class="room-name">Salle Zénith</div>
            <div class="room-floor">4ème étage</div>
          </div>
        </div>
        <span class="room-cap">30 pers.</span>
      </div>
    </div>

    <div class="left-bottom">
      <div class="step-indicator">
        <div class="step-dot active"></div>
        <div class="step-dot"></div>
        <div class="step-dot"></div>
        <span class="step-label">Étape 1 sur 3</span>
      </div>
    </div>
  </div>
</aside>

<!-- ══════════════ RIGHT PANEL ══════════════ -->
<main class="panel-right">

  <div class="form-header">
    <p class="form-step-tag">Formulaire de réservation</p>
    <h2 class="form-title">Vos informations<br>& disponibilités</h2>
  </div>

  <form action="reservation.php" method="POST" novalidate>

    <!-- Identité -->
    <div class="section">
      <p class="section-label">Identité</p>
      <div class="grid-2">
        <div class="field">
          <label for="nom">Nom <span style="color:var(--gold)">*</span></label>
          <input type="text" id="nom" name="nom" placeholder="Dupont" required />
        </div>
        <div class="field">
          <label for="prenom">Prénom <span style="color:var(--gold)">*</span></label>
          <input type="text" id="prenom" name="prenom" placeholder="Marie" required />
        </div>
        <div class="field">
          <label for="email">Email <span style="color:var(--gold)">*</span></label>
          <input type="email" id="email" name="email" placeholder="marie@exemple.fr" required />
        </div>
        <div class="field">
          <label for="telephone">Téléphone <span style="color:var(--gold)">*</span></label>
          <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78" required />
        </div>
      </div>
    </div>

    <!-- Créneau -->
    <div class="section">
      <p class="section-label">Date & horaires</p>
      <div class="grid-2">
        <div class="field">
          <label for="date">Date <span style="color:var(--gold)">*</span></label>
          <input type="text" id="date" name="date" placeholder="JJ/MM/AAAA" pattern="\d{2}/\d{2}/\d{4}" required />
          
          <script>
            const dateInput = document.getElementById('date');
            dateInput.addEventListener('input', function() {
              let value = this.value.replace(/\D/g, '').slice(0, 8);
              if (value.length >= 5) {
                value = value.replace(/(\d{2})(\d{2})(\d{4})/, '$1/$2/$3');
              } else if (value.length >= 3) {
                value = value.replace(/(\d{2})(\d{2})/, '$1/$2');
              }
              this.value = value;
            });

              </script>
        </div>
        <div class="field">
          <label for="creneau">Créneau <span style="color:var(--gold)">*</span></label>
          <select id="creneau" name="creneau" required>
            <option value="" disabled selected>Sélectionner…</option>
            <option>08h00 - 09h30</option>
            <option>09h00 - 10h30</option>
            <option>10h00 - 11h30</option>
            <option>11h00 - 12h30</option>
            <option>13h00 - 14h30</option>
            <option>14h00 - 15h30</option>
            <option>15h00 - 16h30</option>
            <option>16h00 - 17h30</option>
            <option>17h00 - 18h30</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Salle -->
    <div class="section">
      <p class="section-label">Salle & participants</p>

      <div class="salle-grid" style="margin-bottom:1rem">

        <label class="salle-card selected">
          <input type="radio" name="id_salle" value="1" checked />
          <div class="salle-card-num">01</div>
          <div class="salle-card-name">Confluence</div>
          <div class="salle-card-meta">3ème étage · 10 pers.</div>
          <div class="salle-check">
            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
              <polyline points="1 4 4 7 9 1" stroke="#0D0F0E" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </label>

        <label class="salle-card">
          <input type="radio" name="id_salle" value="2" />
          <div class="salle-card-num">02</div>
          <div class="salle-card-name">Horizon</div>
          <div class="salle-card-meta">2ème étage · 20 pers.</div>
          <div class="salle-check">
            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
              <polyline points="1 4 4 7 9 1" stroke="#0D0F0E" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </label>

        <label class="salle-card">
          <input type="radio" name="id_salle" value="3" />
          <div class="salle-card-num">03</div>
          <div class="salle-card-name">Atrium</div>
          <div class="salle-card-meta">RDC · 6 pers.</div>
          <div class="salle-check">
            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
              <polyline points="1 4 4 7 9 1" stroke="#0D0F0E" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </label>

        <label class="salle-card">
          <input type="radio" name="id_salle" value="4" />
          <div class="salle-card-num">04</div>
          <div class="salle-card-name">Zénith</div>
          <div class="salle-card-meta">1ère étage · 15 pers.</div>
          <div class="salle-check">
            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
              <polyline points="1 4 4 7 9 1" stroke="#0D0F0E" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </label>

         <label class="salle-card">
          <input type="radio" name="id_salle" value="5" />
          <div class="salle-card-num">05</div>
          <div class="salle-card-name">Bercy</div>
          <div class="salle-card-meta">4ème étage · 30 pers.</div>
          <div class="salle-check">
            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
              <polyline points="1 4 4 7 9 1" stroke="#0D0F0E" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </label>

      </div>

      <div class="field">
        <label for="nb_personnes">Nombre de participants <span style="color:var(--gold)">*</span></label>
        <input type="number" id="nb_personnes" name="nb_personnes" min="1" max="100" placeholder="Ex : 8" required />
      </div>
    </div>

    <!-- Modalité -->
    <div class="section">
      <p class="section-label">Précisions</p>
      <div class="field">
        <label for="modalite">Modalité / Objet de la réunion</label>
        <textarea id="modalite" name="modalite" placeholder="Décrivez l'objet de votre réunion, les équipements nécessaires…"></textarea>
      </div>
    </div>

    <!-- Submit -->
    <div class="submit-area">
      <button type="submit" class="btn-submit">
        Confirmer la réservation
        <svg class="btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
        </svg>
      </button>
    </div>

  </form>
</main>

<script>
  // Sync left panel chips with radio cards
  function selectRoom(id, chip) {
    document.querySelectorAll('.room-chip').forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    const radio = document.querySelector(`.salle-card input[value="${id}"]`);
    if (radio) radio.click();
  }

  // Sync radio cards → left panel chips
  document.querySelectorAll('.salle-card input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.room-chip').forEach((c, i) => {
        c.classList.toggle('active', i === parseInt(radio.value) - 1);
      });
    });
  });

  // Set min date to today
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('date').setAttribute('min', today);
</script>

</body>
</html>