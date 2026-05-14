<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';

// Ajouter une offre
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $titre = htmlspecialchars($_POST['titre']);
    $destination = htmlspecialchars($_POST['destination']);
    $description = htmlspecialchars($_POST['description']);
    $prix = (float)$_POST['prix'];
    $duree = htmlspecialchars($_POST['duree']);
    $image_url = htmlspecialchars($_POST['image_url']);
    $inclus = htmlspecialchars($_POST['inclus']);
    
    $stmt = $pdo->prepare("INSERT INTO offres (titre, destination, description, prix, duree, image_url, inclus) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $destination, $description, $prix, $duree, $image_url, $inclus]);
    header('Location: admin_offres.php?msg=added');
    exit;
}

// Supprimer une offre
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $pdo->prepare("DELETE FROM offres WHERE id = ?")->execute([(int)$_GET['id']]);
    header('Location: admin_offres.php?msg=deleted');
    exit;
}

$offres = $pdo->query("SELECT * FROM offres ORDER BY date_creation DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion des Offres - Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css?v=2">
  <script>window.gtranslateSettings = {"default_language":"fr","languages":["fr","ar","en"],"wrapper_selector":".gtranslate_wrapper"}</script>
  <script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js" defer></script>
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-5">
    <div class="container-fluid px-5">
      <a class="navbar-brand fw-bold" href="dashboard.php">Atlas Voyages Admin</a>
      
      <!-- Admin Navigation -->
      <div class="collapse navbar-collapse ms-4">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Réservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active fw-bold" href="admin_offres.php">Gestion des Offres</a>
          </li>
        </ul>
      </div>

      <div class="d-flex align-items-center">
        <a href="index.php" class="btn btn-outline-light me-2 rounded-pill">Aller au site</a>
        <a href="logout.php" class="btn btn-light rounded-pill fw-bold text-primary">Déconnexion</a>
        <div class="gtranslate_wrapper ms-3"></div>
      </div>
    </div>
  </nav>

  <div class="container-fluid px-5 mb-5">
    <?php if (isset($_GET['msg'])): ?>
      <?php if ($_GET['msg'] == 'added'): ?>
        <div class="alert alert-success rounded-pill px-4 shadow-sm">L'offre a été ajoutée avec succès.</div>
      <?php elseif ($_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success rounded-pill px-4 shadow-sm">L'offre a été supprimée.</div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="row g-4">
      <!-- Formulaire d'ajout -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <h4 class="fw-bold text-primary mb-4">Ajouter une nouvelle offre</h4>
          <form action="admin_offres.php" method="POST">
            <input type="hidden" name="action" value="add">
            
            <div class="mb-3">
              <label class="form-label text-muted">Titre de l'offre</label>
              <input type="text" name="titre" class="form-control rounded-3" placeholder="Ex: Magie de Marrakech" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-muted">Destination / Ville</label>
              <input type="text" name="destination" class="form-control rounded-3" placeholder="Ex: Marrakech" required>
            </div>
            
            <div class="mb-3">
              <label class="form-label text-muted">Prix (Dhs)</label>
              <input type="number" name="prix" class="form-control rounded-3" placeholder="Ex: 2500" required>
            </div>

            <div class="mb-3">
              <label class="form-label text-muted">Durée</label>
              <input type="text" name="duree" class="form-control rounded-3" placeholder="Ex: 7 Jours / 6 Nuits" required>
            </div>

            <div class="mb-3">
              <label class="form-label text-muted">Lien de l'image (URL)</label>
              <input type="text" name="image_url" class="form-control rounded-3" placeholder="Ex: images/marrakech.jpg" required>
              <small class="text-muted">Mettez une URL depuis internet ou un chemin local comme images/turquie.jpg</small>
            </div>

            <div class="mb-3">
              <label class="form-label text-muted">Ce qui est inclus (séparé par des virgules)</label>
              <input type="text" name="inclus" class="form-control rounded-3" placeholder="Vol, Hôtel 5 étoiles, Petit déjeuner" required>
            </div>

            <div class="mb-4">
              <label class="form-label text-muted">Description complète</label>
              <textarea name="description" class="form-control rounded-3" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Ajouter l'offre</button>
          </form>
        </div>
      </div>

      <!-- Liste des offres -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark m-0">Offres Actuelles</h4>
            <span class="badge bg-primary rounded-pill px-3 py-2"><?php echo count($offres); ?> Offres</span>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light text-muted">
                <tr>
                  <th class="py-3">Image</th>
                  <th class="py-3">Titre & Info</th>
                  <th class="py-3">Prix</th>
                  <th class="py-3 text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($offres) > 0): ?>
                  <?php foreach($offres as $o): ?>
                  <tr>
                    <td style="width: 80px;">
                      <img src="<?php echo htmlspecialchars($o['image_url']); ?>" alt="img" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;">
                    </td>
                    <td>
                      <div class="fw-bold text-dark"><?php echo htmlspecialchars($o['titre']); ?></div>
                      <div class="text-muted small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                        <?php echo htmlspecialchars($o['destination']); ?> | 
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock me-1" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>
                        <?php echo htmlspecialchars($o['duree']); ?>
                      </div>
                    </td>
                    <td class="fw-bold text-primary"><?php echo number_format($o['prix'], 0, ',', ' '); ?> DHS</td>
                    <td class="text-end">
                      <a href="admin_offres.php?action=delete&id=<?php echo $o['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Supprimer cette offre ?');">Supprimer</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center py-5 text-muted">Aucune offre. Ajoutez-en une !</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
