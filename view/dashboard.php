<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// Récupérer les informations de l'utilisateur connecté
$userRepository = new UserRepository();
$userRepository->getUserInfos($_SESSION['user_id']);
include_once 'view/parts/header.php';
?>
<main>
    <section>
        <h1>Tableau de bord</h1>
        <!-- Afficher les informations de l'utilisateur connecté -->
        <?php             
            // Récupérer l'ID de l'utilisateur à partir de la session ou d'une autre source
            $userID = $_SESSION['user_id'];
            // Appeler la fonction getUserInfos pour obtenir les informations de l'utilisateur
            $userRepository = new UserRepository();
            $userInfo = $userRepository->getUserInfos($userID);
            // Utiliser les informations récupérées
            echo "Nom: " . $userInfo['nom'];
            echo "Prénom: " . $userInfo['prenom'];
            echo "Adresse: " . $userInfo['adresse'];
            echo "Email: " . $userInfo['email'];
        ?>

            <div class = "register">Evenement 1 : Repas de midi <br></div>
            <div class = "register">Evenement 2 : Soirée <br></div>
            <div class = "register">Evenement 3 : Gonflable <br></div>

        <!--Supprimer le compte -->
        <form action="index.php?action=close" method="post">
            <input type="hidden" name="csrf_token" value="<?= Security::sanitizeInput($_SESSION['csrf_token']); ?>">
            <button class="close-button" type="submit" name="delete_user">Supprimer mon compte</button>
        </form>


    </section>
</main>

<?php
include_once 'view/parts/footer.php';
?>