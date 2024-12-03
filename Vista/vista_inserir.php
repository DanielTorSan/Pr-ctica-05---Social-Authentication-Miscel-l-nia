<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Article</title>
    <link rel="stylesheet" href="../Vista/Estils/inserir.css">
    <link rel="stylesheet" href="../Vista/Estils/reenviar_contrasenya.css">
</head>
<body>
    <div class="container">
        <div class="principalBox">
            <h1>Inserir Article</h1>
            <?php if (!empty($error_message)): ?>
                <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <form method="POST" action="../Controlador/inserir.php" class="box" enctype="multipart/form-data">
                <label for="titol">Títol:</label>
                <input type="text" name="titol" id="titol" required>
                
                <label for="cos">Cos:</label>
                <textarea name="cos" id="cos" required></textarea>
                
                <label for="imatge">Imatge:</label>
                <input type="file" name="imatge" id="imatge" accept="image/*" required>
                
                <button type="submit" class="button">Inserir Article</button>
            </form>
            <a href="../index.php" class="button">Tornar a l'Inici</a>
        </div>
    </div>
</body>
</html>