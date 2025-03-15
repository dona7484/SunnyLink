<?php 
// Vérifier si la session est déjà active avant d’appeler session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: /SunnyLink/public/login");
    exit();
}

// Récupérer l'avatar depuis la session ou afficher une image par défaut
$avatar = !empty($_SESSION["user_avatar"]) ? "/SunnyLink/public/uploads/" . $_SESSION["user_avatar"] : "/SunnyLink/public/assets/default-avatar.png";
?>

<img src="<?= $avatar ?>" alt="Photo de profil" style="width: 100px; height: 100px; border-radius: 50%;">

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION["user_name"]) ?> !</h1>
    <p>Vous êtes connecté.</p>
    <p><a href="/SunnyLink/public/profile">Modifier mon profil</a></p>

    <a href="/SunnyLink/public/logout" class="logout-button">Se déconnecter</a>
</body>
</html>
