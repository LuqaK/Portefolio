<!-- login.php -->
<?php 
include_once 'parts/header.php'; ?>
<main>
    <section>
        <h1>Connexion</h1>
        <form action="index.php?action=login" method="post">
        <?php if (isset($_SESSION['csrf_token'])) : ?>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <?php endif; ?>
            <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" class = "inputRequired" required><br>
            <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" class = "inputRequired" required><br>
            <button type="submit">Se connecter</button>
        </form>
    </section>
</main>

<?php include_once 'parts/footer.php'; ?>