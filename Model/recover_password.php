<!-- Daniel Torres Sanchez -->
<?php
// Iniciar sessió
session_start();

// Incloure la connexió a la base de dades
require "db_connection.php";

// Incloure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/Exception.php';
require '../lib/PHPMailer.php';
require '../lib/SMTP.php';

// Funció per enviar el correu amb PHPMailer
function enviarCorreu($emailC, $textC) {
    $mail = new PHPMailer(true);
    try {
        // Configuració del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'd.torres2@sapalomera.cat';
        $mail->Password   = 'vjka sytx lzyp dvkz';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Configuració dels destinataris
        $mail->setFrom('d.torres2@sapalomera.cat', 'Daniel Torres');
        $mail->addAddress($emailC);

        // Contingut del correu
        $mail->isHTML(true);
        $mail->Subject = 'Recuperació de Contrasenya';
        $mail->Body    = $textC;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Inicialitzar missatge d'error
$error_message = "";
$success_message = "";

// Si el formulari és enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Comprovar si l'email existeix a la base de dades
    $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generar un token de recuperació
        $token = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("UPDATE usuaris SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->execute([$token, $email]);

        // Enviar el correu de recuperació
        $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;
        $message = "Fes clic al següent enllaç per restablir la teva contrasenya: <a href='$resetLink'>$resetLink</a>";

        if (enviarCorreu($email, $message)) {
            $success_message = "S'ha enviat un correu electrònic amb les instruccions per restablir la contrasenya.";
        } else {
            $error_message = "No s'ha pogut enviar el correu electrònic. Prova-ho més tard.";
        }
    } else {
        $error_message = "No s'ha trobat cap compte amb aquest correu electrònic.";
    }
}

// Incloure la vista de recuperació de contrasenya
include "../Vista/vista_nova_contrasenya.php";
?>
