<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="Estils/editar_perfil.css">
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="../Controlador/update_profile.php" method="POST" enctype="multipart/form-data">
            <!-- Mostrar la imatge de perfil actual -->
            <div class="form-group">
                <label>Imatge de Perfil Actual:</label>
                <img src="<?php echo htmlspecialchars($user_AV); ?>" alt="Avatar" class="avatar">
            </div>

            <!-- Avatar/Imatge -->
            <div class="form-group">
                <label for="avatar">Canviar Avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>

            <!-- Nom d'Usuari -->
            <div class="form-group">
                <label for="nickname">Nom d'Usuari</label>
                <input 
                    type="text" 
                    name="nickname" 
                    id="nickname" 
                    value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" 
                    placeholder="<?php echo htmlspecialchars($user['username'] ?? ''); ?>">
            </div>

            <!-- Correu electrònic -->
            <div class="form-group">
                <label for="email">Correu electrònic</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
            </div>

            <!-- Canviar Contrasenya -->
            <h2>Canviar Contrasenya</h2>
            <div class="form-group">
                <label for="old_password">Contrasenya Actual</label>
                <input type="password" name="old_password" id="old_password" placeholder="Contrasenya Actual">
            </div>
            <div class="form-group">
                <label for="new_password">Nova Contrasenya</label>
                <input type="password" name="new_password" id="new_password" placeholder="Nova Contrasenya">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Nova Contrasenya</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Nova Contrasenya">
            </div>

            <!-- Botó de Submit -->
            <div class="form-group">
                <button type="submit" class="button">Guardar Canvis</button>
            </div>
        </form>
        <!-- Botó per tornar a l'inici -->
        <div class="form-group">
            <a href="../index.php" class="button">Tornar a l'Inici</a>
        </div>
    </div>

    <script>
        let inactivityTime = function () {
            let time;
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;

            function logout() {
                fetch('../Model/activitat_usuari.php')
                    .then(() => {
                        window.location.href = '../Model/logout.php';
                    });
            }

            function resetTimer() {
                clearTimeout(time);
                time = setTimeout(logout, 2400000);  // 40 minutos
            }
        };

        inactivityTime();
    </script>
</body>
</html>
