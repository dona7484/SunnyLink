<?php
// Classe HomeController : C'est un contrôleur qui gère les requêtes liées à la page d'accueil.
// Méthode index : Cette méthode est appelée lorsque l'utilisateur accède à la page d'accueil. Elle charge la vue associée à cette page.
// require_once "../app/views/home.php" : Cette ligne inclut le fichier de la vue home.php, qui contient le code HTML de la page d'accueil.
class HomeController {
    public function index() {
        // Charger la vue de la page d'accueil
        require_once "../app/views/home.php";
    }
}
