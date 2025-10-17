<?php
// On démarre la session au tout début de la page.
session_start();

// On récupère les anciennes données du formulaire en cas d'erreur, puis on les supprime de la session.
// L'opérateur de coalescence nulle (??) est utilisé pour éviter une erreur si 'form_data' n'existe pas.
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <?php
            // On vérifie si un message est stocké dans la session.
            if (isset($_SESSION['message'])):
                // On détermine la classe de l'alerte Bootstrap ('alert-success' ou 'alert-danger').
                $alert_type = $_SESSION['message']['type'] === 'success' ? 'alert-success' : 'alert-danger';
            ?>
                <div class="alert <?= $alert_type; ?> text-center" role="alert">
                    <?= htmlspecialchars($_SESSION['message']['text']); ?>
                </div>
            <?php
                // On supprime le message de la session pour qu'il ne s'affiche qu'une seule fois.
                unset($_SESSION['message']);
            endif;
            ?>

            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center">Contactez-nous</h2>
                </div>
                <div class="card-body p-4">
                    <form action="script.php" method="post">
                        
                        <h4 class="mb-3">Informations Personnelles</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Ex: Jean" required value="<?= htmlspecialchars($form_data['prenom'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex: Dupont" required value="<?= htmlspecialchars($form_data['nom'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required value="<?= htmlspecialchars($form_data['email'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone <small class="text-muted">(Optionnel)</small></label>
                                <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Ex: +32475123456" value="<?= htmlspecialchars($form_data['telephone'] ?? ''); ?>">
                            </div>
                        </div>

                        <hr>
                        
                        <h4 class="mb-3">Adresse</h4>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse (Numéro et rue)</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Ex: 123, rue de la gare" required value="<?= htmlspecialchars($form_data['adresse'] ?? ''); ?>">
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="code_postal" class="form-label">Code Postal</label>
                                <input type="number" class="form-control" id="code_postal" name="code_postal" placeholder="Ex: 1000" required value="<?= htmlspecialchars($form_data['code_postal'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="ville" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville" placeholder="Ex: Bruxelles" required value="<?= htmlspecialchars($form_data['ville'] ?? ''); ?>">
                            </div>
                        </div>

                        <hr>

                        <h4 class="mb-3">Votre Message</h4>
                        <div class="mb-3">
                            <label for="site_web" class="form-label">Site Web <small class="text-muted">(Optionnel)</small></label>
                            <input type="url" class="form-control" id="site_web" name="site_web" placeholder="https://www.votresite.com" value="<?= htmlspecialchars($form_data['site_web'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet de votre message" required value="<?= htmlspecialchars($form_data['sujet'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" placeholder="Écrivez votre message ici..." required><?= htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Envoyer le Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>