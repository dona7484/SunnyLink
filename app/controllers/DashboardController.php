<?php
// Vérifie si une session est active avant de la démarrer
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Si l'utilisateur n'est pas connecté, il est redirigé vers /login.
class DashboardController {
    public function index() {
        if (!isset($_SESSION["user_id"])) {
            header("Location: /SunnyLink/public/login");
            exit();
        }

        require_once "../app/views/dashboard.php";
    }

public function profile() {
    // Vérifie si l'utilisateur est bien connecté
    if (!isset($_SESSION["user_id"])) {
        header("Location: /SunnyLink/public/login");
        exit();
    }

    // Inclure la vue du profil
    require_once "../app/views/profile.php";
}
}

?>

