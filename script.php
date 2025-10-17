<?php
// On démarre la session pour pouvoir utiliser la variable $_SESSION.
session_start();

// 1. Inclure le fichier de configuration de la base de données.
require_once 'config.php';

/**
 * Gère la redirection vers la page d'accueil avec un message de session.
 * @param string $type Le type de message ('success' ou 'danger').
 * @param string $text Le contenu du message à afficher.
 */
function redirect_with_message($type, $text) {
    // On stocke le message et son type dans la session.
    $_SESSION['message'] = [
        'type' => $type,
        'text' => $text
    ];
    
    // Si c'est une erreur, on sauvegarde les données du formulaire pour les réafficher.
    if ($type === 'danger') {
        $_SESSION['form_data'] = $_POST;
    }

    // On redirige vers la page du formulaire.
    header('Location: index.php');
    // On arrête l'exécution du script pour s'assurer que la redirection a lieu immédiatement.
    exit();
}

// 2. Vérifier que la méthode de la requête est bien POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Récupérer et nettoyer les données du formulaire.
    $prenom = trim(htmlspecialchars($_POST['prenom']));
    $nom = trim(htmlspecialchars($_POST['nom']));
    $email = trim(htmlspecialchars($_POST['email']));
    $adresse = trim(htmlspecialchars($_POST['adresse']));
    $code_postal = trim(htmlspecialchars($_POST['code_postal']));
    $ville = trim(htmlspecialchars($_POST['ville']));
    $sujet = trim(htmlspecialchars($_POST['sujet']));
    $message = trim(htmlspecialchars($_POST['message']));
    $telephone = !empty($_POST['telephone']) ? trim(htmlspecialchars($_POST['telephone'])) : NULL;
    $site_web = !empty($_POST['site_web']) ? trim(htmlspecialchars($_POST['site_web'])) : NULL;

    // 4. Valider les données.
    if (empty($prenom) || empty($nom) || empty($email) || empty($adresse) || empty($code_postal) || empty($ville) || empty($sujet) || empty($message)) {
        redirect_with_message('danger', 'Erreur : Veuillez remplir tous les champs obligatoires.');
    }
    if (!filter_var($code_postal, FILTER_VALIDATE_INT)) {
        redirect_with_message('danger', 'Erreur : Le code postal doit être un nombre valide.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect_with_message('danger', "Erreur : Le format de l'adresse e-mail n'est pas valide.");
    }
    if ($site_web && !filter_var($site_web, FILTER_VALIDATE_URL)) {
        redirect_with_message('danger', "Erreur : Le format de l'URL du site web n'est pas valide.");
    }

    // 5. Préparer et exécuter la requête SQL.
    $sql = "INSERT INTO contacts (prenom, nom, email, telephone, adresse, code_postal, ville, site_web, sujet, message) 
            VALUES (:prenom, :nom, :email, :telephone, :adresse, :code_postal, :ville, :site_web, :sujet, :message)";

    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
        $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
        $stmt->bindParam(':site_web', $site_web, PDO::PARAM_STR);
        $stmt->bindParam(':sujet', $sujet, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        
        $stmt->execute();

        // Si tout s'est bien passé, on redirige avec un message de succès.
        redirect_with_message('success', 'Message envoyé avec succès ! Merci de nous avoir contactés.');

    } catch (PDOException $e) {
        // En cas d'erreur de base de données, on redirige avec un message d'erreur générique.
        redirect_with_message('danger', 'Erreur : Quelque chose s\'est mal passé. Veuillez réessayer plus tard.');
    }

} else {
    // Si quelqu'un accède à ce script directement, on le redirige vers le formulaire.
    header('Location: index.php');
    exit();
}
?>