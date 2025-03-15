<?php 
// Vérifie si la session est déjà active avant de l'initialiser
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: /SunnyLink/public/login");
    exit();
}

// Récupérer l'avatar depuis la session ou mettre une image par défaut
$avatar = !empty($_SESSION["user_avatar"]) ? "/SunnyLink/public/uploads/" . $_SESSION["user_avatar"] : "/SunnyLink/public/assets/default-avatar.png";
?>

<img src="<?= $avatar ?>" alt="Photo de profil" style="width: 150px; height: 150px; border-radius: 50%;">

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("profileForm").addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch("/SunnyLink/public/updateProfile", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("profileMessage").innerHTML = data;
                })
                .catch(error => console.error("Erreur AJAX :", error));
            });
        });
    </script>
</head>
<body>
    <h1>Mon Profil</h1>
    <form id="profileForm">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" required>

        <label for="password">Nouveau mot de passe :</label>
        <input type="password" id="password" name="password">
        <label for="avatar">Photo de profil :</label>
        <input type="file" id="avatar" name="avatar" accept="image/*">

        <button type="submit">Mettre à jour</button>
    </form>
    <p id="profileMessage"></p>
    <p><a href="/SunnyLink/public/dashboard">Retour au tableau de bord</a></p>
</body>
</html>
