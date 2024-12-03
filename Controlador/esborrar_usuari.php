<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuaris</title>
    <link rel="stylesheet" href="../Vista/Estils/estils.css">
</head>
<body>
    <div class="container">
        <h1>Eliminar Usuaris</h1>
        <?php
        session_start();
        require "../Model/db_connection.php";

        // Verificar si l'usuari és administrador
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            echo "<p>No tens permís per esborrar usuaris. Inicia sessió com a administrador.</p>";
            exit();
        }

        // Obtenir la llista d'usuaris
        $stmt = $pdo->prepare("SELECT id, username, email FROM usuaris WHERE role != 'admin'");
        $stmt->execute();
        $usuaris = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (empty($usuaris)): ?>
            <p>No hi ha usuaris per eliminar.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($usuaris as $usuari): ?>
                    <li>
                        <?php echo htmlspecialchars($usuari['username']); ?> (<?php echo htmlspecialchars($usuari['email']); ?>)
                        <a href="../Controlador/esborrar_usuari.php?id=<?php echo $usuari['id']; ?>" class="button delete-user" onclick="return confirm('Estàs segur que vols esborrar aquest usuari?');">Esborrar</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="../index.php" class="button">Tornar a l'Inici</a>
    </div>
</body>
</html>