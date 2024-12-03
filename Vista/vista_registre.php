<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar-se</title>
    <!-- Enllaç al fitxer CSS específic per a login i registre -->
    <link rel="stylesheet" href="../Vista/Estils/login_registre.css">
</head>
<body>

<div class="form-container">
    <h1>Registrar-se</h1>
    
    <!-- Missatge d'error -->
    <p class="error"><?php echo htmlspecialchars($error_message ?? ''); ?></p>

    <form action="../Model/register.php" method="POST">
        <label for="username">Nom d'usuari:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
        
        <label for="email">Correu electrònic:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        
        <label for="password">Contrasenya:</label>
        <input type="password" name="password" required>
        
        <label for="confirm_password">Confirmar Contrasenya:</label>
        <input type="password" name="confirm_password" required>
        
        <button type="submit" class="button">Registrar-se</button>
    </form>
    <a href="login.php" class="button">Tornar a l'inici de sessió</a>
</div>

</body>
</html>
