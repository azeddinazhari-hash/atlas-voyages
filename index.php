<?php 
require_once 'config.php';
$stmt = $pdo->query("SELECT * FROM offres ORDER BY date_creation DESC LIMIT 3");
$top_offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($top_offres) === 0) {
    $top_offres = [
        [
            'titre' => 'Week-end à Marrakech', 'destination' => 'Marrakech', 'prix' => 1500,
            'image_url' => 'photo-5.jpeg', 'inclus' => 'Transport, Hôtel 4 étoiles, Visite guidée.'
        ],
        [
            'titre' => 'Circuit Nord Magique', 'destination' => 'Chefchaouen', 'prix' => 2200,
            'image_url' => 'photo-11.jpeg', 'inclus' => "Transport VIP, Riad, Visite d'Akchour."
        ],
        [
            'titre' => 'Aventure Saharienne', 'destination' => 'Ouarzazate', 'prix' => 3500,
            'image_url' => 'photo-88.jpeg', 'inclus' => 'Transport 4x4, Bivouac de luxe, Randonnée.'
        ]
    ];
}

include 'header.php'; 
?>

<main>
  <!-- Hero Section with Video Background -->
  <section class="hero-section text-center position-relative overflow-hidden">
    <div class="video-overlay"></div>
    <video class="hero-video" src="images/WhatsApp Vidéo.mp4" autoplay muted loop playsinline></video>
    <div class="hero-content container position-relative z-index-2">
      <h1 class="display-3 fw-bolder text-white mb-4 animate-fade-in-up">
        Rêvez, on vous y emmène.
      </h1>
      <p class="lead text-white-50 mb-5 animate-fade-in-up delay-1">
        Avec Atlas Voyages, partez l’esprit tranquille. ✈️<br>
        Des offres exclusives et un service sur mesure.
      </p>
      <a href="offres.php" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg animate-fade-in-up delay-2 hover-scale">
        Découvrir nos offres
      </a>
    </div>
  </section>

  <!-- Featured Destinations -->
  <section class="container my-5 py-5 section-reveal">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="text-primary fw-bold text-uppercase tracking-wide">Destinations Incontournables</span>
      <h2 class="display-5 fw-bold mt-2">Découvrez les perles du Maroc</h2>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card premium-card h-100 border-0">
          <div class="card-img-wrapper">
            <img src="photo-3.jpeg" class="card-img-top premium-img" alt="Rabat">
          </div>
          <div class="card-body p-4 text-center">
            <h4 class="card-title fw-bold">Rabat</h4>
            <p class="card-text text-muted">La capitale lumineuse, mêlant architecture moderne et histoire millénaire.</p>
            <a href="contact.php" class="btn btn-outline-primary rounded-pill px-4 mt-3 hover-scale">Explorer</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card premium-card h-100 border-0">
          <div class="card-img-wrapper">
            <img src="photo-7.jpg" class="card-img-top premium-img" alt="Marrakech">
          </div>
          <div class="card-body p-4 text-center">
            <h4 class="card-title fw-bold">Marrakech</h4>
            <p class="card-text text-muted">La ville rouge, ses souks vibrants et sa majestueuse Koutoubia.</p>
            <a href="contact.php" class="btn btn-outline-primary rounded-pill px-4 mt-3 hover-scale">Explorer</a>
          </div>
        </div>
      </div>
  
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card premium-card h-100 border-0">
          <div class="card-img-wrapper">
            <img src="photo-8.jpg" class="card-img-top premium-img" alt="Fès">
          </div>
          <div class="card-body p-4 text-center">
            <h4 class="card-title fw-bold">Fès</h4>
            <p class="card-text text-muted">Capitale spirituelle, réputée pour son artisanat et sa médina envoûtante.</p>
            <a href="contact.php" class="btn btn-outline-primary rounded-pill px-4 mt-3 hover-scale">Explorer</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Top Offres -->
  <section class="bg-light py-5 section-reveal">
    <div class="container my-5">
      <div class="text-center mb-5" data-aos="fade-up">
        <span class="text-primary fw-bold text-uppercase tracking-wide">Sélection Exclusive</span>
        <h2 class="display-5 fw-bold mt-2">Nos Top Offres</h2>
      </div>
      <div class="row g-4">
        <?php foreach($top_offres as $index => $o): ?>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
          <div class="card premium-card offre-card h-100 border-0 position-relative">
            <div class="price-badge shadow-sm"><?php echo number_format($o['prix'], 0, ',', ' '); ?> DH</div>
            <div class="card-img-wrapper">
                <img src="<?php echo htmlspecialchars($o['image_url']); ?>" class="card-img-top premium-img" alt="<?php echo htmlspecialchars($o['destination']); ?>" style="height: 250px; object-fit: cover;">
            </div>
            <div class="card-body d-flex flex-column p-4">
              <h4 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($o['titre']); ?></h4>
              <p class="card-text text-muted flex-grow-1 mt-2"><?php echo htmlspecialchars($o['inclus']); ?></p>
              <a href="contact.php?offre=<?php echo urlencode($o['titre']); ?>" class="btn btn-outline-primary rounded-pill w-100 py-2 mt-3 hover-scale fw-bold">Réserver</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-5" data-aos="fade-up">
        <a href="offres.php" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-sm hover-scale">Voir toutes nos offres</a>
      </div>
    </div>
  </section>

  <!-- Pourquoi Nous Choisir -->
  <section class="container my-5 py-5 section-reveal">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="text-primary fw-bold text-uppercase tracking-wide">L'Excellence</span>
      <h2 class="display-5 fw-bold mt-2">Pourquoi Partir Avec Nous ?</h2>
    </div>
    <div class="row g-4 text-center">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 premium-card">
          <div class="icon-box bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/><path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/></svg>
          </div>
          <h4 class="fw-bold">Expertise Locale</h4>
          <p class="text-muted">Des guides locaux passionnés pour vous faire découvrir l'authentique.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 premium-card">
          <div class="icon-box bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16"><path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/></svg>
          </div>
          <h4 class="fw-bold">Service Premium</h4>
          <p class="text-muted">Un accompagnement sur-mesure et des hébergements de qualité.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="p-4 bg-white rounded-4 shadow-sm h-100 premium-card">
          <div class="icon-box bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16"><path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/></svg>
          </div>
          <h4 class="fw-bold">Meilleurs Tarifs</h4>
          <p class="text-muted">Des prix transparents et compétitifs, sans frais cachés.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Avis Clients -->
  <section class="bg-light py-5 section-reveal">
    <div class="container my-5">
      <div class="text-center mb-5" data-aos="fade-up">
        <span class="text-primary fw-bold text-uppercase tracking-wide">Témoignages</span>
        <h2 class="display-5 fw-bold mt-2">Ce que disent nos voyageurs</h2>
      </div>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card premium-card border-0 h-100 p-4">
            <div class="d-flex text-warning mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
            </div>
            <p class="text-muted fst-italic mb-4">"Un voyage inoubliable dans le désert. L'organisation était parfaite et le guide très professionnel. Je recommande vivement !"</p>
            <div class="d-flex align-items-center mt-auto">
              <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 50px; height: 50px;">S</div>
              <div>
                <h6 class="fw-bold mb-0">Sarah M.</h6>
                <small class="text-muted">Aventure Saharienne</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card premium-card border-0 h-100 p-4">
            <div class="d-flex text-warning mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
            </div>
            <p class="text-muted fst-italic mb-4">"Le riad à Chefchaouen était magnifique. Tout a été géré de A à Z par Atlas Voyages, nous n'avions plus qu'à profiter."</p>
            <div class="d-flex align-items-center mt-auto">
              <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 50px; height: 50px;">K</div>
              <div>
                <h6 class="fw-bold mb-0">Karim et Leïla</h6>
                <small class="text-muted">Circuit Nord Magique</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card premium-card border-0 h-100 p-4">
            <div class="d-flex text-warning mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16"><path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.171-.403.59.59 0 0 1 .084-.302.5.5 0 0 1 .36-.282l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .163-.505l2.906-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.002 2.223 8 2.226v9.8z"/></svg>
            </div>
            <p class="text-muted fst-italic mb-4">"Le rapport qualité/prix est excellent. L'hôtel à Marrakech était top, au cœur de la médina. Service client très réactif."</p>
            <div class="d-flex align-items-center mt-auto">
              <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 50px; height: 50px;">A</div>
              <div>
                <h6 class="fw-bold mb-0">Alain D.</h6>
                <small class="text-muted">Week-end à Marrakech</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="container my-5 py-5 section-reveal">
    <div class="bg-primary rounded-4 p-5 text-white position-relative overflow-hidden shadow-lg" data-aos="zoom-in">
      <div class="position-absolute top-0 end-0 opacity-25" style="transform: translate(30%, -30%);">
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/></svg>
      </div>
      <div class="row align-items-center position-relative z-index-2">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="display-6 fw-bold mb-3">Ne manquez aucune offre !</h2>
          <p class="lead mb-0 text-white-50">Inscrivez-vous à notre newsletter pour recevoir nos promotions exclusives et des idées de voyage.</p>
        </div>
        <div class="col-lg-6">
          <form class="d-flex gap-2 bg-white p-2 rounded-pill shadow-sm" onsubmit="event.preventDefault(); alert('Merci pour votre inscription !'); this.reset();">
            <input type="email" class="form-control border-0 rounded-pill px-4" placeholder="Votre adresse email" required>
            <button class="btn btn-dark rounded-pill px-4 fw-bold" type="submit">S'inscrire</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>
