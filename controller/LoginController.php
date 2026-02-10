<?php
require_once('../model/User.php');

class LoginController {
    public function index() {
        include('../view/connexion.php');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];

            require_once '../model/Database.php';
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE (username = ? OR email = ?) AND role = 'admin'");
            $stmt->execute([$login, $login]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['user_role'] = $admin['role'];
                header('Location: index.php?page=admin_dashboard');
                exit;
            }

            $user = User::login($login, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                header('Location: index.php?page=home');
                exit;
            }
                session_start();
                $_SESSION['message'] = "Identifiants incorrects - Vérifiez votre nom d'utilisateur et mot de passe";
                header('Location: index.php?page=connexion');
                exit;
            }
        }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $errors = [];

            if (strlen($username) < 3) {
                $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Adresse e-mail invalide.";
            }
            if (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }

            if (empty($errors)) {
                if (User::create($username, $email, $password)) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                } else {
                    $errors[] = "Cet utilisateur existe déjà.";
                }
            }
        }

        require_once '../view/inscription.php';
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=connexion');
            exit;
        }

        // Récupérer le rôle de l'utilisateur
        $user = User::getById($_SESSION['user_id']);
        $_SESSION['user_role'] = $user['role'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            $messages = [];

            if (strlen($username) < 3) {
                $messages[] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $messages[] = "Adresse e-mail invalide.";
            }

            if (!empty($new_password)) {
                if (strlen($new_password) < 6) {
                    $messages[] = "Le mot de passe doit contenir au moins 6 caractères.";
                } elseif ($new_password !== $confirm_password) {
                    $messages[] = "Les mots de passe ne correspondent pas.";
                } else {
                    User::updatePassword($_SESSION['user_id'], $new_password);
                    $success = "Mot de passe mis à jour.";
                }
            }

            if (empty($messages) && empty($new_password)) {
                User::update($_SESSION['user_id'], $username, $email);
                $_SESSION['username'] = $username;
                $success = "Profil mis à jour.";
            }
        }

        $user = User::getById($_SESSION['user_id']);
        require_once '../view/profil.php';
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = User::getByEmail($email);
                if ($user) {
                    $new_password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
                    User::updatePassword($user['id'], $new_password);
                    $success = "Voici votre nouveau mot de passe : <strong>$new_password</strong><br>Changez-le dès votre prochaine connexion.";
                } else {
                    $error = "Aucun utilisateur avec cet e-mail.";
                }
            } else {
                $error = "Adresse e-mail invalide.";
            }
        }

        require_once '../view/mot_de_passe_oublie.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }
}
?>
