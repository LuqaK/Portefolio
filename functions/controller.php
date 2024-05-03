<?php
/** Controller */
require_once 'model.php';
include_once 'security.php';
include_once 'service.php';

class Controller
{
    private $action;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();    
        }
        if (isset($_GET['action'])){
            $this->action = $_GET['action'];
        }else{
            $this->action = 'home';
        }
    }

    public function routeRequest(){
        try{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                Security::verifyCsrfToken();
            }
            switch($this->action){
                case 'register':
                    $this->handleRegisterAction();
                    break;
                case 'login':
                    $this->handleLoginAction();
                    break;
                case 'dashboard':
                    $this->showDashboard();
                    break;
                case 'update':
                    $this->handleUpdateAction();
                    break;
                case 'close':
                    $this->handleCloseAction();
                    break;
                case 'logout':
                    $this->handleLogoutAction();
                    break;
                default:
                    $this->showHome();
                    break;
            }
        }catch(Exception $e){
            $error_message = $e->getMessage();
            require_once 'view/error.php';
        }
    }

    private function handleRegisterAction(){
        Service::handleRegisterAction();
    }
    private function handleLoginAction(){
        Service::handleLoginAction();
    }
    private function showDashboard(){
        include_once 'view/dashboard.php';
    }
    private function handleUpdateAction(){
        Service::handleUpdateAction();
    }
    private function handleCloseAction(){
        Service::handleCloseAction();
    }
    private function handleLogoutAction(){
        Service::handleLogoutAction();
    }
    private function showHome(){
        include_once 'view/home.php';
    }
}

//$controller = new Controller();
//$controller->routeRequest();



/*

if (session_status() == PHP_SESSION_NONE) {
    session_start();    
}
/**
 * Contrôleur principal qui gère les différentes actions
 
function controller() {
    try{
    // Démarrer la session (si elle n'est pas déjà active)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Routes
    if (isset($_GET['action'])) {
        $action = $_GET['action'];        
        // Protection CSRF pour toutes les actions POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            functions\verifyCsrfToken();
        }

        switch ($action) {
            case 'register':
                handleRegisterAction();
                break;
            case 'login':
                handleLoginAction();
                break;
            case 'dashboard':
                include_once 'templates/dashboard.php';
                break;
            case 'update':
                handleUpdateAction();
                break;
            case 'close':
                handleCloseAction();
                break;
            case 'logout':
                handleLogoutAction();
                break;
            default:
                include_once 'templates/home.php';
                break;
        }
    } else {
        include_once 'templates/home.php';
    }
}catch(Exception $e){
    $error_message = $e->getMessage();
    require_once 'templates/error.php';
}
}
*/

?>