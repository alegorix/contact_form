<?php
// config.php
// Ce fichier contient les paramètres de connexion à la base de données
// et établit la connexion PDO.

// --- Paramètres de la Base de Données ---
// Définir les constantes pour les détails de la connexion.
// C'est une bonne pratique d'utiliser des constantes pour éviter que ces valeurs ne changent accidentellement.
define('DB_HOST', 'localhost');                 // Le serveur où votre base de données est hébergée (généralement 'localhost')
define('DB_NAME', 'formulaire_contact_db');     // Le nom de votre base de données
define('DB_USER', 'root');                      // Le nom d'utilisateur pour accéder à la base de données
define('DB_PASS', 'root');                          // Le mot de passe de l'utilisateur (laissez vide si vous n'en avez pas en local)
define('DB_CHARSET', 'utf8mb4');                // Le jeu de caractères pour la connexion

// --- Création de la Connexion PDO ---
// PDO (PHP Data Objects) est une extension de PHP qui fournit une interface cohérente
// pour accéder à différentes bases de données. C'est plus sécurisé et flexible que les anciennes fonctions mysql_* ou mysqli_*.

try {
    // DSN (Data Source Name) : Contient les informations nécessaires pour se connecter à la base de données.
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    // Options PDO pour la connexion.
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance des exceptions en cas d'erreurs, ce qui facilite leur gestion.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Définit le mode de récupération par défaut sur un tableau associatif.
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées pour une meilleure sécurité.
    ];

    // On crée une nouvelle instance de PDO pour établir la connexion.
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

} catch (PDOException $e) {
    // Si la connexion échoue, une exception est capturée.
    // Il est important de gérer l'erreur correctement pour ne pas exposer d'informations sensibles.
    // Dans un environnement de production, vous enregistreriez cette erreur dans un fichier journal au lieu de l'afficher.
    die("ERREUR : Impossible de se connecter à la base de données. " . $e->getMessage());
}
?>