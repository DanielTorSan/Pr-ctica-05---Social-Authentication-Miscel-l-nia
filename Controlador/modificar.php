<!-- Daniel Torres Sanchez -->
<?php
// Iniciar sessió
session_start();

// Habilitar el reporte d'errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incloure la connexió a la base de dades
require "../Model/db_connection.php";

// Verificar si s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recollir les dades del formulari
    $id = $_POST['id'];
    $nou_cos = $_POST['cos'];
    $nou_titol = $_POST['titol'];
    $nova_imatge = $_FILES['imatge'] ?? null;

    // Cridar a la funció per modificar l'article
    modificarArticle($pdo, $id, $nou_cos, $nou_titol, $nova_imatge);
    header("Location: ../index.php"); // Redirigir després de modificar
    exit();
}

// Funció per modificar un article a la base de dades
function modificarArticle($pdo, $id, $nou_cos, $nou_titol, $nova_imatge) {
    // Actualitzar el cos i el títol de l'article
    $stmt = $pdo->prepare("UPDATE articles SET cos = ?, titol = ? WHERE ID = ?");
    $stmt->execute([$nou_cos, $nou_titol, $id]);

    // Si es proporciona una nova imatge, actualitzar-la
    if ($nova_imatge && $nova_imatge['error'] === UPLOAD_ERR_OK) {
        $imatgeTmpPath = $nova_imatge['tmp_name'];
        $imatgeName = basename($nova_imatge['name']);
        $imatgePath = "../uploads/" . $imatgeName;

        // Moure la nova imatge a la carpeta de càrregues
        move_uploaded_file($imatgeTmpPath, $imatgePath);

        // Actualitzar la ruta de la imatge a la base de dades
        $stmt = $pdo->prepare("UPDATE articles SET imatge = ? WHERE ID = ?");
        $stmt->execute([$imatgePath, $id]);
    }
}

// Si es proporciona un ID, obtenir les dades de l'article per mostrar-les al formulari
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE ID = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if (!$article) {
        echo "Article no trobat."; // Si no es troba l'article, mostrar missatge
        exit();
    }
} else {
    echo "ID no proporcionat.";
    exit();
}

// Incloure la vista per mostrar el formulari
include "../Vista/vista_modificar.php";
?>
