<!-- Daniel Torres Sanchez -->
<?php
// Model/login.php

// Iniciar sessió
session_start();

// Incloure la connexió a la base de dades
require "db_connection.php";

// Inicialitzar missatge d'error
$error_message = "";

// Inicialitzar la variable de l'usuari per omplir el formulari
$usuari = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';

// Si el formulari és enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember']);

    // Incrementar el contador de intents fallidos
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Verificar reCAPTCHA si hi ha 3 o més intents fallits
    if ($_SESSION['login_attempts'] >= 3) {
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        $recaptchaSecret = 'YOUR_SECRET_KEY'; // Substitueix per la teva clau secreta de reCAPTCHA
        $recaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';

        // Enviar la sol·licitud de verificació de reCAPTCHA
        $response = file_get_contents($recaptchaURL . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        // Comprovar si la verificació de reCAPTCHA ha estat exitosa
        if (!$responseKeys['success']) {
            $error_message = "Verificació de reCAPTCHA fallida. Torna-ho a intentar.";
        }
    }

    if (empty($error_message)) {
        // Comprovar les credencials de l'usuari
        $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Restablir el contador d'intents fallits
            $_SESSION['login_attempts'] = 0;

            $_SESSION['user_id'] = $user['id']; // Configurar l'ID de l'usuari a la sessió
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $user['role']; // Guardar el rol del usuario en la sesión

            if ($rememberMe) {
                // Generar un token únic
                $token = bin2hex(random_bytes(16));
                // Guardar el token a la base de dades
                $stmt = $pdo->prepare("UPDATE usuaris SET remember_token = ? WHERE id = ?");
                $stmt->execute([$token, $user['id']]);
                // Establir una cookie amb el token
                setcookie("remember_token", $token, time() + (86400 * 30), "/"); // Cookie de 30 dies
            } else {
                setcookie("remember_token", "", time() - 3600, "/");
            }

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            $error_message = "Nom d'usuari o contrasenya incorrectes.";
        }
    }
}

// Incloure la vista de login
include "../Vista/vista_login.php";
?>
