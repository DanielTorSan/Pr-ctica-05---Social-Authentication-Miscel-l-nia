<?php
session_start();

// Tiempo máximo de inactividad en segundos (40 minutos)
$inactivitat_maxima = 2400;

// Verificar la última actividad del usuario
if (isset($_SESSION['last_activity'])) {
    $inactivitat = time() - $_SESSION['last_activity'];
    if ($inactivitat > $inactivitat_maxima) {
        // Si el tiempo de inactividad excede el máximo, cerrar la sesión
        session_unset();
        session_destroy();
        header("Location: logout.php");
        exit();
    }
}

// Actualizar la última actividad del usuario
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        let inactivityTime = function () {
            let time;
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;

            function logout() {
                fetch('activitat_usuari.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'expired') {
                            window.location.href = 'logout.php';
                        }
                    });
            }

            function resetTimer() {
                clearTimeout(time);
                time = setTimeout(logout, 20000);  // 20 segundos
            }
        };

        inactivityTime();
    </script>
</body>
</html>