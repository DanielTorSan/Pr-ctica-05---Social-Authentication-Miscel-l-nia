<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Incloure la connexió a la base de dades
require "../Model/db_connection.php";

// Verificar si l'usuari està loguejat
if (!isset($_SESSION['user_id'])) {
    echo "<p>No tens permís per esborrar articles. Inicia sessió primer.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Verificar si s'ha passat un ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Verificar que l'article pertany a l'usuari loguejat
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE ID = ? AND created_by = ?");
    $stmt->execute([$id, $user_id]);
    $article = $stmt->fetch();

    if ($article) {
        // Preparar i executar la consulta per eliminar l'article
        $stmt = $pdo->prepare("DELETE FROM articles WHERE ID = ?");
        if ($stmt->execute([$id])) {
            echo "<p>Article esborrat correctament.</p>";
            header("Location: ../index.php");
            exit();
        } else {
            echo "<p>No s'ha pogut esborrar l'article.</p>";
        }
    } else {
        echo "<p>No tens permís per esborrar aquest article.</p>";
    }
} else {
    echo "<p>ID no proporcionat.</p>";
}
?>
