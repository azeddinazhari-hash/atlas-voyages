<?php
require_once 'config.php';

$success_message = "";
$error_message = "";

// Capture l'offre depuis l'URL si elle existe
$offre_choisie = isset($_GET['offre']) ? htmlspecialchars($_GET['offre']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitization et récupération des données
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $offre = htmlspecialchars(trim($_POST['offre']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation basique
    if (empty($nom) || empty($email) || empty($telephone) || empty($ville)) {
        $error_message = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "L'adresse email n'est pas valide.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservations (nom, email, telephone, ville, offre, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $telephone, $ville, $offre, $message]);

            $success_message = "<div>Merci <strong>$nom</strong> ! Votre demande a été enregistrée avec succès. Notre équipe vous contactera rapidement.</div>";
        } catch (PDOException $e) {
            $error_message = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}
?>

<?php include 'header.php'; ?>

<main class="container my-5 py-5 section-reveal">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="contact-wrapper glass-panel p-5 rounded-4 shadow-lg position-relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="shape-blob shape-1"></div>
        <div class="shape-blob shape-2"></div>
        
        <div class="position-relative z-index-2">
          <div class="text-center mb-5">
            <span class="text-primary fw-bold text-uppercase tracking-wide">Parlons de votre voyage</span>
            <h1 class="display-5 fw-bold mt-2 text-dark">Contactez-nous</h1>
            <p class="text-muted mt-2">Prêt à planifier votre prochaine aventure ? Laissez-nous un message.</p>
          </div>

          <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex flex-column align-items-center text-center p-4" role="alert">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-check-circle-fill text-success mb-3" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
              <div class="fs-5"><?php echo $success_message; ?></div>
              <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
              <?php echo $error_message; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <form action="contact.php" method="POST" id="contactForm" class="needs-validation" novalidate>
            <div class="row g-4">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control premium-input" id="nom" name="nom" placeholder="Votre Nom" required>
                  <label for="nom">Nom complet</label>
                  <div class="invalid-feedback">Veuillez entrer votre nom.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="email" class="form-control premium-input" id="email" name="email" placeholder="Votre Email" required>
                  <label for="email">Adresse Email</label>
                  <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="tel" class="form-control premium-input" id="telephone" name="telephone" placeholder="Téléphone" required>
                  <label for="telephone">Numéro de téléphone</label>
                  <div class="invalid-feedback">Veuillez entrer votre numéro.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control premium-input" id="ville" name="ville" placeholder="Ville" required>
                  <label for="ville">Votre ville</label>
                  <div class="invalid-feedback">Veuillez entrer votre ville.</div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-4">
                  <input type="text" class="form-control premium-input bg-light text-primary fw-bold" id="offre" name="offre" value="<?php echo $offre_choisie; ?>" readonly placeholder="Offre choisie">
                  <label for="offre">Offre choisie</label>
                </div>
                <div class="form-floating">
                  <textarea class="form-control premium-input" id="message" name="message" placeholder="Message" style="height: 150px"></textarea>
                  <label for="message">Comment pouvons-nous vous aider ? / Date souhaitée, nombre de personnes...</label>
                </div>
              </div>
              <div class="col-12 text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow hover-scale fw-bold submit-btn">
                  Envoyer le message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>
