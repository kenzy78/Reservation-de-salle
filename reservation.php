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
