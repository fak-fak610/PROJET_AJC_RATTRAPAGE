<?php
session_start();
require_once '../config.php';
require_once '../model/Database.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'articles':
        require_once '../controller/ArticlesController.php';
        $controller = new ArticlesController();
        $controller->index();
        break;

    case 'bibliotheque':
        require_once '../controller/BibliothequeController.php';
        $controller = new BibliothequeController();
        $controller->index();
        break;

    case 'livres':
        require_once '../controller/LivresController.php';
        $controller = new LivresController();
        $controller->index();
        break;

    case 'formations':
    require_once '../view/formation_view.php';
    break;

    case 'mooc':
        require_once '../controller/MoocController.php';
        $controller = new MoocController();
        $controller->index();
        break;

    case 'doc':
        require_once '../controller/DocController.php';
        $controller = new DocController();
        $controller->index();
        break;

    case 'documents':
        require_once '../controller/UploadController.php';
        $controller = new UploadController();
        $controller->index();
        break;

    case 'admin_login':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->login();
        break;

    case 'admin_dashboard':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;

    case 'admin_moocs':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->moocs();
        break;

    case 'admin_mooc_create':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->moocCreate();
        break;

    case 'admin_mooc_edit':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->moocEdit();
        break;

    case 'admin_mooc_delete':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->moocDelete();
        break;

    case 'admin_livres':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->livres();
        break;

    case 'admin_livre_create':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->livreCreate();
        break;

    case 'admin_livre_edit':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->livreEdit();
        break;

    case 'admin_livre_delete':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->livreDelete();
        break;

    case 'admin_logout':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->logout();
        break;

    case 'admin_users':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->users();
        break;

    case 'admin_user_change_role':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->userChangeRole();
        break;

    case 'admin_user_delete':
        require_once '../controller/AdminController.php';
        $controller = new AdminController();
        $controller->userDelete();
        break;

    case 'admin_mooc':
        require_once '../controller/AdminMoocController.php';
        $controller = new AdminMoocController();
        $controller->index();
        break;

    case 'connexion':
        require_once '../controller/LoginController.php';
        $controller = new LoginController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->index();
        }
        break;

    case 'inscription':
        require_once '../controller/InscriptionController.php';
        $controller = new InscriptionController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->index();
        }
        break;

    case 'profil':
        require_once '../controller/LoginController.php';
        $controller = new LoginController();
        $controller->profile();
        break;

    case 'mes_favoris':
        require_once '../controller/MoocController.php';
        $controller = new MoocController();
        $controller->favorites();
        break;

    case 'mot_de_passe_oublie':
        require_once '../controller/LoginController.php';
        $controller = new LoginController();
        $controller->forgotPassword();
        break;

    case 'deconnexion':
        require_once '../controller/LoginController.php';
        $controller = new LoginController();
        $controller->logout();
        break;

    case 'upload':
        require_once '../controller/UploadController.php';
        $controller = new UploadController();
        $controller->upload();
        break;

        
    case 'mooc_revolution':
        require_once __DIR__ . '/../controller/MoocRevolutionController.php';
        $controller = new MoocRevolutionController();
        $controller->index();
        break;

    default:
        require_once '../controller/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}
?>
