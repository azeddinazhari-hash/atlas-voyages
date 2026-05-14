<?php
session_start();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérification basique basée sur le plan
    if ($username === 'admin' && $password === 'azeddine azhari') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion - Admin Atlas Voyages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-5">
      <div class="card premium-card border-0 shadow-lg p-5">
        <div class="text-center mb-4">
          <h2 class="fw-bold text-primary">Atlas Voyages Admin</h2>
          <p class="text-muted">Connectez-vous à votre tableau de bord</p>
        </div>
        
        <?php if ($error): ?>
          <div class="alert alert-danger rounded-3"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="form-floating mb-3">
            <input type="text" class="form-control premium-input" id="username" name="username" placeholder="Nom d'utilisateur" required>
            <label for="username">Nom d'utilisateur</label>
          </div>
          <div class="form-floating mb-4">
            <input type="password" class="form-control premium-input" id="password" name="password" placeholder="Mot de passe" required>
            <label for="password">Mot de passe</label>
          </div>
          <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">Se connecter</button>
        </form>
        <div class="text-center mt-4">
          <a href="index.php" class="text-decoration-none text-muted">< Retour au site</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
