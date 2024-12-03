<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Destruir totes les variables de sessió
session_unset();

// Destruir la sessió
session_destroy();

// Eliminar les cookies de l'usuari si existeixen
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/'); // Expirar la cookie establint el temps en el passat
}
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/'); // Expirar la cookie establint el temps en el passat
}

// Redirigir a la pàgina principal
header("Location: ../index.php");
exit();
?>
