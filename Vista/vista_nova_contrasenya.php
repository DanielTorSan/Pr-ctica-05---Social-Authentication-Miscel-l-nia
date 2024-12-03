<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contrasenya</title>
    <link rel="stylesheet" href="../Vista/Estils/reenviar_contrasenya.css">
</head>
<body>
<div class="container">
    <div class="principalBox">
        <h1>Recuperar Contrasenya</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <form action="../Model/recover_password.php" method="POST">
            <div class="form-group">
                <label for="email">Correu electrònic:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" class="btn-submit">Enviar Instruccions</button>
        </form>
        <a href="login.php">Tornar a l'inici de sessió</a>
    </div>
</div>
</body>
</html>
