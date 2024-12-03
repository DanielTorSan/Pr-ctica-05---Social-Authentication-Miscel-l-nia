<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Article</title>
    <link rel="stylesheet" href="../Vista/Estils/modificar.css">
</head>
<body>
    <div class="container">
        <div class="principalBox">
            <h1>Modificar Article</h1>
            <!-- Formulari per modificar el títol, cos i imatge de l'article -->
            <form method="POST" action="../Controlador/modificar.php" class="box" enctype="multipart/form-data">
                <!-- Camp ocult per enviar el ID en enviar el formulari -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <label for="titol">Nou Títol:</label>
                <!-- Camp de text per al nou títol de l'article -->
                <input type="text" name="titol" id="titol" value="<?php echo htmlspecialchars($article['titol']); ?>" required><br>

                <label for="cos">Nou Cos:</label>
                <!-- Camp de text per al nou contingut de l'article -->
                <input type="text" name="cos" id="cos" value="<?php echo htmlspecialchars($article['cos']); ?>" required><br>

                <label for="imatge">Nova Imatge:</label>
                <!-- Camp de càrrega de fitxers per a la nova imatge -->
                <input type="file" name="imatge" id="imatge" accept="image/*"><br>

                <input type="submit" value="Modificar Article" class="submit-button">
            </form>
            
            <a href="../index.php">Tornar a l'Inici</a>
        </div>
    </div>
</body>
</html>