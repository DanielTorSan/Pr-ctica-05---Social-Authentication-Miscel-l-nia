<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió</title>
    <link rel="stylesheet" href="../Vista/Estils/login_registre.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="form-container">
    <h1>Iniciar Sessió</h1>
    
    <!-- Missatge d'error -->
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form action="../Model/login.php" method="POST">
        <label for="username">Nom d'usuari:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($usuari); ?>" required>
        
        <label for="password">Contrasenya:</label>
        <input type="password" name="password" id="password" required>
        
        <div class="remember-me">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Recorda'm</label>
        </div>

        <!-- reCAPTCHA -->
        <?php if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3): ?>
            <div class="g-recaptcha" data-sitekey="6LdN55EqAAAAAE8FoR6rmXLn3lZA_S94AwUZo9Xa"></div>
        <?php endif; ?>

        <button type="submit" class="button">Iniciar Sessió</button>
    </form>

    <a href="../Vista/vista_registre.php" class="button">Registrar-se</a>
    <a href="recover_password.php" class="button">Recuperar Contrasenya</a>
    <a href="../index.php" class="button">Tornar a l'inici</a>
</div>

</body>
</html>
