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

        // Verificar si s'ha passat un ID
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            // Eliminar l'usuari de la base de dades
            $stmt = $pdo->prepare("DELETE FROM usuaris WHERE id = ?");
            if ($stmt->execute([$id])) {
                echo "<p>Usuari esborrat correctament.</p>";
            } else {
                echo "<p>No s'ha pogut esborrar l'usuari.</p>";
            }
        } else {
            echo "<p>ID no proporcionat.</p>";
        }
        ?>
        <a href="../Vista/vista_usuaris.php" class="button">Tornar a la llista d'usuaris</a>
        <a href="../index.php" class="button">Tornar a l'Inici</a>
    </div>
</body>
</html>