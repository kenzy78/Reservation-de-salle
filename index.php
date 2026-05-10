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
            <div class="product"> 
                <div class="image">
                    <img src="./image/salle1.jpg" alt="salle" width="200px" height="200px">                
                </div>           
                <div class="textes">
                    <h4 class="productName">Salle 1</h4>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <h5 class="prix">1500€</h5>
                </div>
                <div class="boutons">
                    <a href="salle.php?id=1"><button class="details">Détails</button></a>
                    <a href="reservation.php?id=1"><button class="ajouter">Réserver</button></a>
                </div>
            </div>

            <div class="product"> 
                <div class="image">
                    <img src="./image/salle2.jpg" alt="salle" width="200px" height="200px">                
                </div>           
                <div class="textes">
                    <h4 class="productName">Salle 2</h4>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <h5 class="prix">1500€</h5>
                </div>
                <div class="boutons">
                    <a href="salle.php?id=2"><button class="details">Détails</button></a>
                    <a href="reservation.php?id=2"><button class="ajouter">Réserver</button></a>
                </div>
            </div>

            <div class="product"> 
                <div class="image">
                    <img src="./image/salle3.jpg" alt="salle" width="200px" height="200px">                
                </div>           
                <div class="textes">
                    <h4 class="productName">Salle 3</h4>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <h5 class="prix">1500€</h5>
                </div>
                <div class="boutons">
                    <a href="salle.php?id=3"><button class="details">Détails</button></a>
                    <a href="reservation.php?id=3"><button class="ajouter">Réserver</button></a>
                </div>
            </div>

            <div class="product"> 
                <div class="image">
                    <img src="./image/salle4.jpg" alt="salle" width="200px" height="200px">                
                </div>           
                <div class="textes">
                    <h4 class="productName">Salle 4</h4>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <h5 class="prix">1500€</h5>
                </div>
                <div class="boutons">
                    <a href="salle.php?id=4"><button class="details">Détails</button></a>
                    <a href="reservation.php?id=4"><button class="ajouter">Réserver</button></a>
                </div>
            </div>

            <div class="product"> 
                <div class="image">
                    <img src="./image/salle5.jpg" alt="salle" width="200px" height="200px">                
                </div>           
                <div class="textes">
                    <h4 class="productName">Salle 5</h4>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    <h5 class="prix">1500€</h5>
                </div>
                <div class="boutons">
                    <a href="salle.php?id=5"><button class="details">Détails</button></a>
                    <a href="reservation.php?id=5"><button class="ajouter">Réserver</button></a>
                </div>
            </div>

        </div>
</section>

        </main>

        <footer>
            <p>© 2026 WorkSpace Connect — 📍 Paris | 📞 01 23 45 67 89 | ✉️ contact@workspaceconnect.fr</p>
        </footer>
    </body>
</html>