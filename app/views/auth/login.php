<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sélectionne le formulaire et ajoute un écouteur d'événements sur "submit"
            document.getElementById("loginForm").addEventListener("submit", function (e) {
                e.preventDefault(); // Empêche le rechargement de la page

                let formData = new FormData(this); // Récupère les données du formulaire

                fetch("/SunnyLink/public/loginUser", { // Envoie les données en AJAX
                    method: "POST",
                    body: formData
                })
                .then(response => response.text()) // Convertit la réponse en texte
                .then(data => {
                    if (data.includes("✅ Connexion réussie")) {
                        window.location.href = "/SunnyLink/public/dashboard"; // Redirige si succès
                    } else {
                        document.getElementById("loginMessage").innerHTML = data; // Affiche les erreurs
                    }
                })
                .catch(error => console.error("Erreur AJAX :", error)); // Capture et affiche les erreurs AJAX
            });
        });
    </script>
</head>
<body>
    <h1>Connexion</h1>
    <form id="loginForm">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
    <p id="loginMessage"></p> <!-- Affichage des messages AJAX -->
    <p>Pas encore inscrit ? <a href="/SunnyLink/public/register">Créer un compte</a></p>
</body>
</html>
