<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SunnyLink</title>
    <script>
    // Attendre que le DOM soit complètement chargé avant d'exécuter le script
    document.addEventListener("DOMContentLoaded", function () {

        // Sélectionne le formulaire avec l'ID "registerForm"
        document.getElementById("registerForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Empêche le formulaire de provoquer un rechargement de la page

            // Récupère les données du formulaire sous forme d'objet FormData
            let formData = new FormData(this);

            // Effectue une requête AJAX vers la route `/SunnyLink/public/registerUser`
            fetch("/SunnyLink/public/registerUser", {
                method: "POST", // Méthode HTTP utilisée pour envoyer les données
                body: formData  // Envoie les données du formulaire
            })
            .then(response => response.text()) // Convertit la réponse du serveur en texte
            .then(data => {
                // Insère la réponse du serveur (message de succès ou d'erreur) dans la page
                document.getElementById("registerMessage").innerHTML = data;
            })
            .catch(error => console.error("Erreur AJAX :", error)); // Capture et affiche les erreurs éventuelles dans la console
        });

    });
</script>
</head>
<body>
    <h1>Inscription</h1>
    
    <form id="registerForm"> <!-- ID pour Ajax -->
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">S'inscrire</button>
    </form>
    <p id="registerMessage"></p>  <!-- Zone pour afficher le message de réponse -->
    <p>Déjà un compte ? <a href="/SunnyLink/public/login">Se connecter</a></p>
</body>
</html>
