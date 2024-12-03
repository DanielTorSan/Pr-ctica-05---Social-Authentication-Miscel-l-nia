<!-- Daniel Torres Sanchez -->
<?php
// Iniciar la sessió
session_start();

// Incloure la connexió a la base de dades
require "../Model/db_connection.php";

// Inicialitzar missatge d'error
$error_message = "";

// Funció per validar la força de la contrasenya
function validar_contrasenya($password) {
    if (strlen($password) < 8) {
        return "La contrasenya ha de tenir almenys 8 caràcters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "La contrasenya ha de tenir almenys una majúscula.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "La contrasenya ha de tenir almenys una minúscula.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "La contrasenya ha de tenir almenys un número.";
    }
    if (!preg_match('/[\W]/', $password)) {
        return "La contrasenya ha de tenir almenys un caràcter especial.";
    }
    return "";
}

// Funció per validar el correu electrònic
function validar_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El correu electrònic no és vàlid.";
    }
    return "";
}

// Si el formulari és enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recollir dades del formulari
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);

    // Validar que les contrasenyes coincideixen
    if ($password !== $confirm_password) {
        $error_message = "Les contrasenyes no coincideixen.";
    } else {
        // Validar la força de la contrasenya
        $error_message = validar_contrasenya($password);
    }

    // Validar el correu electrònic
    if (empty($error_message)) {
        $error_message = validar_email($email);
    }

    // Comprovar si l'usuari o el correu ja existeixen
    if (empty($error_message)) {
        $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            if ($existing_user['username'] === $username) {
                $error_message = "L'usuari ja existeix. Prova amb un altre.";
            } elseif ($existing_user['email'] === $email) {
                $error_message = "Aquest correu ja està registrat.";
            }
        } else {
            // Encriptar la contrasenya i inserir l'usuari a la base de dades
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuaris (username, password, email) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $hashed_password, $email])) {
                // Iniciar sessió i redirigir a la pàgina principal
                $_SESSION['user_id'] = $pdo->lastInsertId(); // Configurar l'ID de l'usuari a la sessió
                $_SESSION['user'] = $username;
                setcookie("user", $username, time() + 2400, "/"); // Cookie de sessió durant 40min
                header("Location: ../index.php");
                exit(); // Assegurar-se que no s'executi més codi després de la redirecció
            } else {
                $error_message = "Error al registrar-se. Prova-ho més tard.";
            }
        }
    }
}

// Incloure la vista de registre
include "../Vista/vista_registre.php";
?>
