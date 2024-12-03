<!-- Daniel Torres Sanchez -->
<?php
// Incloure la connexió a la base de dades
require "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        $error_message = "Les contrasenyes no coincideixen.";
    } else {
        // Verificar si el token és vàlid i no ha expirat
        $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE reset_token = ? AND reset_expiration > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            // Actualitzar la contrasenya i eliminar el token
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuaris SET password = ?, reset_token = NULL, reset_expiration = NULL WHERE reset_token = ?");
            $stmt->execute([$hashed_password, $token]);
            $success_message = "Contrasenya restablerta correctament.";
        } else {
            $error_message = "Token no vàlid o expirat.";
        }
    }
}
include "../Vista/vista_reset_password.php";
?>