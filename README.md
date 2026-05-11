# WorkSpace Connect 🏢

Site de réservation de salles de réunion en ligne.

## 📋 Description
WorkSpace Connect permet aux entreprises de réserver facilement 
des salles de réunion en ligne. Les utilisateurs peuvent consulter 
les salles disponibles, voir leurs détails et effectuer une réservation.

## 🛠️ Technologies utilisées
- HTML / CSS
- PHP 8
- MySQL (phpMyAdmin)
- XAMPP

## 📁 Structure du projet
Reservation-de-salle/
├── config/
│   └── database.php      # Connexion BDD
├── css/
│   └── indexstyle.css    # Styles globaux
├── image/                # Photos des salles
├── index.php             # Page d'accueil
├── salles.php            # Liste des salles
├── salle.php             # Détail d'une salle
├── reservation.php       # Formulaire de réservation
└── confirmation.php      # Page de confirmation

## 🗄️ Base de données
- **Base** : workspace_connect
- **Tables** : salle, réservation

## 🚀 Installation
1. Installer XAMPP
2. Copier le dossier dans `C:\xampp\htdocs\`
3. Importer la BDD dans phpMyAdmin
4. Ouvrir `localhost/Reservation-de-salle/`

## 👨‍💻 Auteur
Kenzy, Adame — BTS SIO 2026