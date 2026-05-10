<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="style.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réservation Confirmée</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />


<div class="card">

  <!-- Check icon -->
  <div class="check-wrap">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
  </div>

  <p class="tag">Réservation confirmée</p>
  <h1>Votre salle est réservée !</h1>
  

  <hr class="divider" />

  <!-- Details -->
  <div class="details">

    <div class="detail-row">
      <div class="detail-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
        </svg>
      </div>
      <div class="detail-text">
        <label>Salle</label>
        <strong>Salle Confluence — 3ème étage</strong>
      </div>
    </div>

    <div class="detail-row">
      <div class="detail-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="detail-text">
        <label>Date</label>
        <strong>Lundi 13 mai 2026</strong>
      </div>
    </div>

    <div class="detail-row">
      <div class="detail-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div class="detail-text">
        <label>Horaires</label>
        <strong>09h00 – 11h30 <span style="color:var(--muted);font-weight:400">(2h30)</span></strong>
      </div>
    </div>

    <div class="detail-row">
      <div class="detail-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
      </div>
      <div class="detail-text">
        <label>Participants</label>
        <strong>8 personnes</strong>
      </div>
    </div>

  </div>


  <!-- Actions -->
  <div class="actions">
  
    <button class="btn btn-outline" onclick="window.location.href='index.html'">Retour à l'accueil</button>
  </div>


</div>

</body>
</html>