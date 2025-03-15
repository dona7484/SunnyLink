<?php

// Activer l'affichage des erreurs en développement (à désactiver en production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Définition des routes disponibles
$routes = [
    '/' => 'HomeController@index', // Page d'accueil
    '/login' => 'AuthController@login', // Page de connexion
    '/register' => 'AuthController@register', // Page d'inscription
    '/dashboard' => 'DashboardController@index', // Tableau de bord
    '/registerUser' => 'AuthController@registerUser', // Formulaire d'enregistrement
    '/dashboard' => 'DashboardController@index',
    '/loginUser' => 'AuthController@loginUser',// Connexion des utilisateurs
    '/logout' => 'AuthController@logout',// Déconnexion des utilisateurs
    '/updateProfile' => 'AuthController@updateProfile',
    '/profile' => 'DashboardController@profile',


];

// Récupérer l'URL demandée
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/SunnyLink/public'; // Assure-toi que c'est le bon chemin
$route = str_replace($base_path, '', $request_uri);
$route = explode('?', $route)[0]; // Supprimer les paramètres GET

// Vérifier si la route existe
if (array_key_exists($route, $routes)) {
    list($controller, $method) = explode('@', $routes[$route]);

    // Vérifier l'existence du fichier contrôleur
    $controllerFile = "../app/controllers/$controller.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        // Vérifier si la classe et la méthode existent
        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                die("❌ Erreur : Méthode `$method` introuvable.");
            }
        } else {
            die("❌ Erreur : Classe `$controller` introuvable dans `$controllerFile`.");
        }
    } else {
        die("❌ Erreur : Le fichier contrôleur `$controllerFile` est introuvable.");
    }
} else {
    http_response_code(404);
    die("❌ Erreur 404 : Page non trouvée.");
}
