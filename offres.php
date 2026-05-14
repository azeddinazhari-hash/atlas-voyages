<?php 
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM offres ORDER BY date_creation DESC");
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Données par défaut si la base est vide
if (count($offres) === 0) {
    $offres = [
        [
            'titre' => 'Week-end à Marrakech', 'destination' => 'Marrakech', 'prix' => 1500, 'duree' => '3 Jours / 2 Nuits',
            'image_url' => 'photo-5.jpeg', 'inclus' => 'Transport touristique, Hôtel 4 étoiles avec petit-déjeuner, Visite guidée.'
        ],
        [
            'titre' => 'Circuit Nord Magique', 'destination' => 'Chefchaouen', 'prix' => 2200, 'duree' => '4 Jours / 3 Nuits',
            'image_url' => 'photo-11.jpeg', 'inclus' => 'Transport VIP, Hébergement en riad, Visite Akchour, Cap Spartel.'
        ],
        [
            'titre' => 'Aventure Saharienne', 'destination' => 'Ouarzazate', 'prix' => 3500, 'duree' => '5 Jours / 4 Nuits',
            'image_url' => 'photo-88.jpeg', 'inclus' => 'Transport en 4x4, Nuit en bivouac de luxe, Randonnée chamelière.'
        ],
        [
            'titre' => 'Évasion à Essaouira', 'destination' => 'Essaouira', 'prix' => 1200, 'duree' => '2 Jours / 1 Nuit',
            'image_url' => 'photo-9.jpeg', 'inclus' => 'Transport, Hôtel de charme, Visite de la Sqala, Dîner fruits de mer.'
        ],
        [
            'titre' => 'Découverte de Casablanca', 'destination' => 'Casablanca', 'prix' => 1800, 'duree' => '3 Jours / 2 Nuits',
            'image_url' => 'photo-10.jpeg', 'inclus' => 'Transport, Hôtel moderne, Visite Mosquée Hassan II.'
        ],
        [
            'titre' => 'Séjour Balnéaire à Agadir', 'destination' => 'Agadir', 'prix' => 2800, 'duree' => '4 Jours / 3 Nuits',
            'image_url' => 'photo-12.jpeg', 'inclus' => 'Vol, Hôtel Resort 5 étoiles, Demi-pension, Crocoparc.'
        ]
    ];
}

include 'header.php'; 
?>
<main class="container my-5 py-5 section-reveal">
  <div class="text-center mb-5" data-aos="fade-up">
    <span class="text-primary fw-bold text-uppercase tracking-wide">Voyages & Circuits</span>
    <h1 class="display-4 fw-bold mt-2">Nos Meilleures Offres</h1>
    <p class="lead text-muted mt-3 max-w-700 mx-auto">Partez à l'aventure avec nos circuits soigneusement sélectionnés pour vous offrir des expériences mémorables.</p>
  </div>
  
  <div class="row g-5">
    <?php foreach($offres as $index => $o): ?>
    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3 + 1) * 100; ?>">
      <div class="card premium-card offre-card h-100 border-0 position-relative">
        <div class="price-badge shadow-sm"><?php echo number_format($o['prix'], 0, ',', ' '); ?> DH</div>
        <div class="card-img-wrapper">
            <img src="<?php echo htmlspecialchars($o['image_url']); ?>" class="card-img-top premium-img" alt="<?php echo htmlspecialchars($o['destination']); ?>">
        </div>
        <div class="card-body d-flex flex-column p-4">
          <h4 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($o['titre']); ?></h4>
          <div class="d-flex align-items-center mb-3 text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>
            <span class="fw-semibold"><?php echo htmlspecialchars($o['duree']); ?></span>
          </div>
          <p class="card-text text-muted flex-grow-1">Inclus : <?php echo htmlspecialchars($o['inclus']); ?></p>
          <a href="contact.php?offre=<?php echo urlencode($o['titre']); ?>" class="btn btn-primary rounded-pill w-100 py-2 mt-3 hover-scale fw-bold">Réserver ce séjour</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include 'footer.php'; ?>
