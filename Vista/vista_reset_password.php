<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablir Contrasenya</title>
    <link rel="stylesheet" href="../Vista/Estils/restablir_contrasenya.css">
</head>
<body>
    <div class="container">
        <div class="principalBox">
            <h1>Restablir Contrasenya</h1>

            <!-- Missatges d'error o èxit -->
            <?php if (isset($error_message)): ?>
                <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <!-- Formulari -->
            <form action="../Model/reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">

                <div class="form-group">
                    <label for="password">Nova Contrasenya:</label>
                    <input type="password" id="password" name="password" placeholder="Escriu la nova contrasenya" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contrasenya:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma la nova contrasenya" required>
                </div>

                <button type="submit" class="btn-submit">Restablir Contrasenya</button>
            </form>
        </div>
    </div>
</body>
</html>
