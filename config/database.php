<?php
// hote du sereveur my sql
$host = 'localhost'; 
// nom de la base de données
$dbname = 'sunnylink';
// nom utilisateur par default
$username = 'root'; 
// mdp mysql
$password = ''; 

try {
    // creation connexion mysql avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
   // Activation du mode d'affichage des erreurs en mode Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
// se connecte à MySQL avec PDO
// utilise UTF-8
// affiche une erreur en cas d'echec