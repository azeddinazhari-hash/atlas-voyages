<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';

// Gestion des actions (Suppression & Statut)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] == 'delete') {
        $pdo->prepare("DELETE FROM reservations WHERE id = ?")->execute([$id]);
        header('Location: dashboard.php?msg=deleted');
        exit;
    } elseif ($_GET['action'] == 'toggle') {
        $stmt = $pdo->prepare("SELECT statut FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        if ($res) {
            $new_status = ($res['statut'] == 'Traité') ? 'Nouveau' : 'Traité';
            $pdo->prepare("UPDATE reservations SET statut = ? WHERE id = ?")->execute([$new_status, $id]);
        }
        header('Location: dashboard.php?msg=status');
        exit;
    }
}

// Récupérer toutes les réservations
$stmt = $pdo->query("SELECT * FROM reservations ORDER BY date_creation DESC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Atlas Voyages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css?v=2">

  <!-- GTranslate Config -->
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
            <a class="nav-link active fw-bold" href="dashboard.php">Réservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_offres.php">Gestion des Offres</a>
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
      <?php if ($_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success rounded-pill px-4 shadow-sm">La réservation a été supprimée.</div>
      <?php elseif ($_GET['msg'] == 'status'): ?>
        <div class="alert alert-success rounded-pill px-4 shadow-sm">Le statut a été mis à jour.</div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold text-dark">Dernières Réservations & Messages</h2>
      <span class="badge bg-primary rounded-pill px-3 py-2 fs-6"><?php echo count($reservations); ?> Total</span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden premium-card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-borderless mb-0 align-middle">
            <thead class="bg-light text-muted">
              <tr>
                <th class="px-4 py-3">ID</th>
                <th class="py-3">Client</th>
                <th class="py-3">Contact</th>
                <th class="py-3">Ville</th>
                <th class="py-3">Offre Choisie</th>
                <th class="py-3">Message</th>
                <th class="py-3">Statut</th>
                <th class="py-3 text-end pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($reservations) > 0): ?>
                <?php foreach ($reservations as $res): ?>
                <tr class="border-bottom">
                  <td class="px-4"><span class="badge bg-secondary-subtle text-secondary rounded-pill">#<?php echo $res['id']; ?></span></td>
                  <td class="fw-bold text-dark">
                    <?php echo htmlspecialchars($res['nom']); ?>
                    <div class="text-muted small fw-normal"><?php echo date('d/m/Y H:i', strtotime($res['date_creation'])); ?></div>
                  </td>
                  <td>
                    <div><a href="mailto:<?php echo htmlspecialchars($res['email']); ?>" class="text-decoration-none"><?php echo htmlspecialchars($res['email']); ?></a></div>
                    <div class="text-muted small"><?php echo htmlspecialchars($res['telephone']); ?></div>
                  </td>
                  <td><?php echo htmlspecialchars($res['ville']); ?></td>
                  <td>
                    <?php if (!empty($res['offre'])): ?>
                      <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2"><?php echo htmlspecialchars($res['offre']); ?></span>
                    <?php else: ?>
                      <span class="text-muted fst-italic">Demande générale</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $res['id']; ?>">
                      Voir
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="msgModal<?php echo $res['id']; ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow">
                          <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title fw-bold">Message de <?php echo htmlspecialchars($res['nom']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body pt-3 pb-4">
                            <p class="mb-0 text-muted lh-lg"><?php echo nl2br(htmlspecialchars($res['message'])); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?php 
                      $statut = isset($res['statut']) ? $res['statut'] : 'Nouveau';
                      if ($statut == 'Traité') {
                        echo '<span class="badge bg-success rounded-pill px-3 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>Traité</span>';
                      } else {
                        echo '<span class="badge bg-warning text-dark rounded-pill px-3 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-hourglass-split me-1" viewBox="0 0 16 16"><path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 14v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.35z"/></svg>Nouveau</span>';
                      }
                    ?>
                  </td>
                  <td class="text-end pe-4">
                    <a href="dashboard.php?action=toggle&id=<?php echo $res['id']; ?>" class="btn btn-sm <?php echo ($statut == 'Traité') ? 'btn-outline-warning' : 'btn-success'; ?> rounded-pill" title="Changer le statut">
                      <?php echo ($statut == 'Traité') ? 'Marquer Non Traité' : 'Marquer Traité'; ?>
                    </a>
                    <a href="dashboard.php?action=delete&id=<?php echo $res['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill ms-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');" title="Supprimer">
                      X
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-inbox mb-3 opacity-50" viewBox="0 0 16 16"><path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625A.5.5 0 0 1 16 8.5V13a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5a.5.5 0 0 1 .158-.35l3.65-4.562zM1 8.5V13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5h-4.32a2.5 2.5 0 0 1-4.36 0H1z"/></svg>
                    <br>Aucune réservation pour le moment.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
