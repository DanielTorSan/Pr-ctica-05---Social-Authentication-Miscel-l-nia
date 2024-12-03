<!-- Daniel Torres Sanchez -->
<?php

// Iniciar sessió
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incloure la connexió a la base de dades i el fitxer de gestió d'IDs
require "../Model/db_connection.php";
require "../Model/id_manager.php";

// Habilitar el reporte d'errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si l'usuari està loguejat
if (!isset($_SESSION['user_id'])) {
    echo "<p>No tens permís per inserir articles. Inicia sessió primer.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Inicialitzar missatge d'error i èxit
$error_message = "";
$success_message = "";

// Verificar si s'ha enviat una sol·licitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenir les dades del formulari
    $titol = $_POST['titol'] ?? null;
    $cos = $_POST['cos'] ?? null;
    $imatge = $_FILES['imatge'] ?? null;

    // Validar que tots els camps estiguin presents
    if ($titol && $cos && $imatge) {
        // Validar el tipus de fitxer
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($imatge['type'], $allowed_types)) {
            // Crear la carpeta de destinació si no existeix
            $upload_dir = '../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Moure el fitxer a la carpeta de destinació
            $imatge_path = $upload_dir . basename($imatge['name']);
            if (move_uploaded_file($imatge['tmp_name'], $imatge_path)) {
                try {
                    // Obtenir el següent ID disponible
                    $nouID = obtenirIDMinim($pdo);

                    // Preparar la consulta d'inserció amb el nou ID
                    $stmt = $pdo->prepare("INSERT INTO articles (ID, titol, cos, imatge, created_by) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$nouID, $titol, $cos, $imatge_path, $user_id]);

                    // Reajustar els IDs després de la inserció
                    reajustarIDs($pdo);

                    // Confirmació d'inserció
                    $success_message = "Article inserit correctament!";
                    // Vaciar els camps del formulari
                    $titol = $cos = $imatge = "";

                } catch (PDOException $e) {
                    // Mostrar error en cas de fallada
                    $error_message = "Error en inserir l'article: " . $e->getMessage();
                }
            } else {
                $error_message = "Error en pujar la imatge.";
            }
        } else {
            $error_message = "Tipus de fitxer no permès. Només es permeten arxius JPG i PNG.";
        }
    } else {
        // Si falten camps, mostrar un missatge d'error
        $error_message = "Tots els camps són obligatoris!";
    }
}

// Incloure la vista
include "../Vista/vista_inserir.php";
?>