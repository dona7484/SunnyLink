<?php

class AuthController {
    /**
     * Afficher la page de connexion.
     * Cette méthode est appelée lorsque l'utilisateur accède à la page de connexion.
     * Elle inclut le fichier de vue qui contient le formulaire de connexion.
     */
    public function login() {
        // Inclure le fichier de vue pour la page de connexion
        require_once "../app/views/auth/login.php";
    }

    /**
     * Afficher la page d'inscription.
     * Cette méthode est appelée lorsque l'utilisateur accède à la page d'inscription.
     * Elle inclut le fichier de vue qui contient le formulaire d'inscription.
     */
    public function register() {
        // Inclure le fichier de vue pour la page d'inscription
        require_once "../app/views/auth/register.php";
    }

    public function registerUser() {
        require_once "../config/database.php"; // Connexion à la base de données
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hachage du mot de passe
    
            try {
                // Vérifier si l'email existe déjà
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->rowCount() > 0) {
                    die("❌ Erreur : Cet email est déjà utilisé !");
                }
    
                // Insérer l'utilisateur en base de données
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $password]);
    
                echo "✅ Inscription réussie ! <a href='/SunnyLink/public/login'>Connectez-vous ici</a>";
    
            } catch (PDOException $e) {
                die("❌ Erreur SQL : " . $e->getMessage());
            }
        }
    }

    public function loginUser() {
        require_once "../config/database.php"; // Connexion à la base de données
        session_start(); // Démarrer la session
        session_regenerate_id(true); // Sécurise la session contre le vol de cookies

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
            $password = $_POST["password"];
    
            try {
                // Vérifier si l'utilisateur existe
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($user) {
                    // Vérifier le mot de passe
                    if (password_verify($password, $user["password"])) {
                        // Stocker les infos utilisateur dans la session
                        $_SESSION["user_id"] = $user["id"];
                        $_SESSION["user_name"] = $user["name"];
                        $_SESSION["user_email"] = $user["email"];
                        $_SESSION["user_avatar"] = !empty($user["avatar"]) ? $user["avatar"] : "default-avatar.png"; // Ajout de l'avatar
                        echo "✅ Connexion réussie"; // AJAX va voir ce message et rediriger l'utilisateur
                    } else {
                        echo "❌ Mot de passe incorrect.";
                    }
                } else {
                    echo "❌ Aucun compte trouvé avec cet email.";
                }
    
            } catch (PDOException $e) {
                echo "❌ Erreur SQL : " . $e->getMessage();
            }
        }
    }
    

    public function logout() {
        session_start();
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
        setcookie(session_name(), '', time() - 3600, '/'); // Supprime le cookie de session

        header("Location: /SunnyLink/public/login");
        exit();
    }
    
    public function updateProfile() {
        require_once "../config/database.php"; 
        session_start();
    
        if (!isset($_SESSION["user_id"])) {
            echo "❌ Vous devez être connecté.";
            return;
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $userId = $_SESSION["user_id"];
    
            try {
                // Vérifier si l'email existe déjà pour un autre utilisateur
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $userId]);
    
                if ($stmt->rowCount() > 0) {
                    echo "❌ Cet email est déjà utilisé.";
                    return;
                }
    
                // Mettre à jour les infos (avec ou sans mot de passe)
                if (!empty($_POST["password"])) {
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $password, $userId]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $userId]);
                }
    
                $_SESSION["user_name"] = $name;
                $_SESSION["user_email"] = $email;
    
                echo "✅ Profil mis à jour avec succès !";
    
            } catch (PDOException $e) {
                echo "❌ Erreur SQL : " . $e->getMessage();
            }
        }
    
        // Gestion de l'upload d'image (photo de profil)
        if (!empty($_FILES["avatar"]["name"])) {
            $targetDir = "../public/uploads/";
            
            // Vérifier si le dossier existe, sinon le créer
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
    
            $fileName = basename($_FILES["avatar"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
            // Vérifier les formats autorisés
            $allowTypes = ["jpg", "png", "jpeg", "gif"];
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
                    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                    $stmt->execute([$fileName, $userId]);
    
                    // Mettre à jour la session pour afficher immédiatement la nouvelle image
                    $_SESSION["user_avatar"] = $fileName;
                    
                    echo "✅ Photo de profil mise à jour.";
                } else {
                    echo "❌ Erreur lors de l'upload de l'image.";
                }
            } else {
                echo "❌ Format de fichier non autorisé.";
            }
        }
    
}

public function profile() {
    session_start(); 

    if (!isset($_SESSION["user_id"])) {
        header("Location: /SunnyLink/public/login");
        exit();
    }

    require_once "../app/views/profile.php";
}
}