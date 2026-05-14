<?php
// init_db.php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connexion sans spécifier de base de données
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la base de données
    $sql = "CREATE DATABASE IF NOT EXISTS atlas_voyages CHARACTER SET utf8 COLLATE utf8_general_ci";
    $pdo->exec($sql);
    echo "Base de données 'atlas_voyages' créée ou déjà existante.<br>";

    // Utilisation de la base
    $pdo->exec("USE atlas_voyages");

    // Création de la table reservations
    $sql_table = "CREATE TABLE IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telephone VARCHAR(50) NOT NULL,
        ville VARCHAR(100) NOT NULL,
        offre VARCHAR(255) DEFAULT NULL,
        message TEXT,
        statut VARCHAR(50) DEFAULT 'Nouveau',
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql_table);
    echo "Table 'reservations' vérifiée avec succès.<br>";

    // Ajout de la colonne statut si elle n'existe pas (pour les anciennes installations)
    try {
        $pdo->exec("ALTER TABLE reservations ADD COLUMN statut VARCHAR(50) DEFAULT 'Nouveau'");
        echo "Colonne 'statut' ajoutée à la table 'reservations'.<br>";
    } catch (PDOException $e) {
        // La colonne existe probablement déjà, on ignore l'erreur
    }

    // Création de la table offres
    $sql_offres = "CREATE TABLE IF NOT EXISTS offres (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        destination VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        prix DECIMAL(10,2) NOT NULL,
        duree VARCHAR(100) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        inclus TEXT,
        date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql_offres);
    echo "Table 'offres' créée avec succès.<br>";

    // Insérer des offres par défaut si la table est vide
    $stmt = $pdo->query("SELECT COUNT(*) FROM offres");
    if ($stmt->fetchColumn() == 0) {
        $offres_defaut = [
            ['Week-end à Marrakech', 'Marrakech', 'Inclus : Transport touristique, Hôtel 4 étoiles avec petit-déjeuner, Visite guidée.', 1500, '3 Jours / 2 Nuits', 'photo-5.jpeg', 'Transport, Hôtel, Visite'],
            ['Circuit Nord Magique', 'Chefchaouen', 'Inclus : Transport VIP aller-retour, Hébergement en riad authentique, Visite.', 2200, '4 Jours / 3 Nuits', 'photo-11.jpeg', 'Transport, Riad, Visites'],
            ['Aventure Saharienne', 'Ouarzazate', 'Inclus : Transport en 4x4, Nuit en bivouac de luxe sous les étoiles, Randonnée chamelière.', 3500, '5 Jours / 4 Nuits', 'photo-88.jpeg', '4x4, Bivouac, Chameaux'],
            ['Évasion à Essaouira', 'Essaouira', 'Inclus : Transport, Hôtel de charme au cœur de la médina, Visite de la Sqala.', 1200, '2 Jours / 1 Nuit', 'photo-9.jpeg', 'Transport, Hôtel, Dîner'],
            ['Découverte de Casablanca', 'Casablanca', 'Inclus : Transport, Hôtel moderne, Visite guidée de la Mosquée Hassan II.', 1800, '3 Jours / 2 Nuits', 'photo-10.jpeg', 'Transport, Hôtel, Visites'],
            ['Séjour Balnéaire à Agadir', 'Agadir', 'Inclus : Vol aller-retour, Hôtel Resort 5 étoiles avec accès direct à la plage.', 2800, '4 Jours / 3 Nuits', 'photo-12.jpeg', 'Vol, Resort 5*, Demi-pension']
        ];
        
        $insert = $pdo->prepare("INSERT INTO offres (titre, destination, description, prix, duree, image_url, inclus) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($offres_defaut as $o) {
            $insert->execute($o);
        }
        echo "6 Offres par défaut ont été ajoutées pour tester !<br>";
    }

    echo "<br><a href='index.php'>Retour à l'accueil</a>";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
