<?php
//include_once 'security.php';
require_once 'model.php';
class Service
{
    public static function handleRegisterAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF
            Security::verifyCsrfToken();
    
            // Récupérer les données du formulaire
            $nom = Security::sanitizeInput($_POST['nom']);
            $prenom = Security::sanitizeInput($_POST['prenom']);
            $adresse = Security::sanitizeInput($_POST['adresse']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            // Valider le formulaire
            $errors = Security::validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);
    
            // Si des erreurs sont présentes, afficher le formulaire avec les erreurs
            if (!empty($errors)) {
                // Ajouter les erreurs au tableau de données pour les afficher dans le formulaire
                $data['errors'] = $errors;
                include_once 'view/register.php';
            } else {
                // Appeler la fonction pour enregistrer l'utilisateur
                $userRepository = new UserRepository();
                $userRepository->registerUser($nom, $prenom, $adresse, $email, $password, $confirmPassword);
                header("Location: index.php?action=login");
                exit();
                /*        
                // Si l'enregistrement est réussi, rediriger vers la page de connexion
                if ($error === true) {
                    header("Location: index.php?action=login");
                    exit();
                } else {
                    // En cas d'erreur, afficher le message d'erreur sur la page d'inscription
                    // Ajouter le message d'erreur au tableau de données pour l'afficher dans le formulaire
                    $data['error'] = $error;
                    include_once 'view/register.php';
                }*/
            }
        } else {
            // Afficher le formulaire d'inscription si la requête n'est pas de type POST
            include_once 'view/register.php';
        }
    }
    public static function handleLoginAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier le jeton CSRF ici avant d'appeler loginUser
            Security::verifyCsrfToken();
    
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $userRepository = new UserRepository();
            $userRepository->loginUser($email, $password);
        } else {
            include_once 'view/login.php';
        }
    }
    public static function handleUpdateAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            Security::verifyCsrfToken();
    
            $id = $_SESSION['user_id'];
            $nom = Security::sanitizeInput($_POST['nom']);
            $prenom = Security::sanitizeInput($_POST['prenom']);
            $adresse = Security::sanitizeInput($_POST['adresse']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
    
            $errors = Security::validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);
    
            if (!empty($errors)) {
                $data['errors'] = $errors;
                include_once 'view/update.php';
            } else {
    
                $userRepository->updateUserInfo($id, $nom, $prenom,$adresse, $email, $password, $confirmPassword);
    
                header("Location: index.php?action=dashboard");
                exit();
            }
    
        } else {
            include_once 'view/update.php';
        }
    }
    public static function handleCloseAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
    
            Security::verifyCsrfToken();
            $userRepository = new UserRepository();
            $userRepository->closeAccount($id);
    
            session_destroy();
    
            header("Location: index.php");
            exit();
        }
    }
    public static function handleLogoutAction(){
        // Détruire la session
        session_destroy();

        // Rediriger vers la page d'accueil
        header("Location: index.php");
        exit();
    }
}

/*

function handleRegisterAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier le jeton CSRF
        functions\verifyCsrfToken();

        // Récupérer les données du formulaire
        $nom = functions\sanitizeInput($_POST['nom']);
        $prenom = functions\sanitizeInput($_POST['prenom']);
        $adresse = functions\sanitizeInput($_POST['adresse']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Valider le formulaire
        $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);

        // Si des erreurs sont présentes, afficher le formulaire avec les erreurs
        if (!empty($errors)) {
            // Ajouter les erreurs au tableau de données pour les afficher dans le formulaire
            $data['errors'] = $errors;
            include_once 'templates/register.php';
        } else {
            // Appeler la fonction pour enregistrer l'utilisateur
            $error = registerUser($nom, $prenom, $adresse, $email, $password, $confirmPassword);

            // Si l'enregistrement est réussi, rediriger vers la page de connexion
            if ($error === true) {
                header("Location: index.php?action=login");
                exit();
            } else {
                // En cas d'erreur, afficher le message d'erreur sur la page d'inscription
                // Ajouter le message d'erreur au tableau de données pour l'afficher dans le formulaire
                $data['error'] = $error;
                include_once 'templates/register.php';
            }
        }
    } else {
        // Afficher le formulaire d'inscription si la requête n'est pas de type POST
        include_once 'templates/register.php';
    }
}

function handleLoginAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier le jeton CSRF ici avant d'appeler loginUser
        functions\verifyCsrfToken();

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        loginUser($email, $password);
    } else {
        include_once 'templates/login.php';
    }
}

function handleUpdateAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        \functions\verifyCsrfToken();

        $id = $_SESSION['user_id'];
        $nom = functions\sanitizeInput($_POST['nom']);
        $prenom = functions\sanitizeInput($_POST['prenom']);
        $adresse = functions\sanitizeInput($_POST['adresse']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);

        if (!empty($errors)) {
            $data['errors'] = $errors;
            include_once 'templates/update.php';
        } else {

            $error = updateUserInfo($id, $nom, $prenom,$adresse, $email, $password, $confirmPassword);

            if ($error === true) {
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $data['error'] = $error;
                include_once 'templates/update.php';
            }
        }

    } else {
        include_once 'templates/update.php';
    }
}

function handleCloseAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];

        functions\verifyCsrfToken();

        closeAccount($id);

        session_destroy();

        header("Location: index.php");
        exit();
    }
}

function handleLogoutAction() {
    // Détruire la session
    session_destroy();

    // Rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}

*/
?>