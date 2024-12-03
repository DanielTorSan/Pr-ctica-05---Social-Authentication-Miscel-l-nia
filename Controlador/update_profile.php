<!-- Daniel Torres Sanchez -->
<?php
// Iniciar sessió
session_start();

// Incloure la connexió a la base de dades
require_once "../Model/db_connection.php";
require_once "../Model/id_manager.php";

// Verificar si l'usuari està loguejat
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Model/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Obtener los datos actuales del usuario
$stmt = $pdo->prepare("SELECT username, email, avatar FROM usuaris WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no hi ha avatar, establir un valor per defecte
if (!$user['avatar']) {
    $user['avatar'] = "default_user_img.png"; // Una imatge predeterminada
}

// Definir la variable user_AV
$user_AV = '../uploads/avatars/' . $user['avatar'];

// Inicialitzar missatge d'error
$error_message = "";

// Gestionar el canvi d'avatar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'] ?? null;
    $email = $_POST['email'] ?? null;
    $oldPassword = $_POST['old_password'] ?? null;
    $newPassword = $_POST['new_password'] ?? null;
    $confirmPassword = $_POST['confirm_password'] ?? null;

    // Si es proporciona una nova imatge, actualitzar-la
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarTmpPath = $_FILES['avatar']['tmp_name'];
        $avatarName = uniqid() . "_" . basename($_FILES['avatar']['name']);
        $avatarPath = "../uploads/avatars/" . $avatarName;

        // Moure la nova imatge a la carpeta de càrregues
        if (move_uploaded_file($avatarTmpPath, $avatarPath)) {
            // Actualitzar la ruta de l'avatar a la base de dades
            $stmt = $pdo->prepare("UPDATE usuaris SET avatar = :avatar WHERE id = :id");
            $stmt->execute(['avatar' => $avatarName, 'id' => $userId]);
            $_SESSION['avatar'] = $avatarName; // Actualitzar la sessió amb la nova imatge
            $user['avatar'] = $avatarName; // Actualitzar la variable userAvatar
        } else {
            $error_message = "Error al pujar la imatge.";
        }
    }

    // Gestionar el canvi de nickname
    if ($nickname) {
        $stmt = $pdo->prepare("UPDATE usuaris SET username = :username WHERE id = :id");
        $stmt->execute(['username' => $nickname, 'id' => $userId]);
        $_SESSION['user'] = $nickname; // Actualitzar la sessió amb el nou nom d'usuari
    }

    // Validar y actualizar el correo electrónico
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("UPDATE usuaris SET email = :email WHERE id = :id");
        $stmt->execute(['email' => $email, 'id' => $userId]);
    } elseif ($email) {
        echo "El correu electrònic no és vàlid.";
        exit();
    }

    // Comprovar i actualitzar la contrasenya si es proporciona
    if ($oldPassword && $newPassword && $confirmPassword) {
        // Comprovar si la contrasenya antiga és correcta
        $stmt = $pdo->prepare("SELECT password FROM usuaris WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $userPassword = $stmt->fetchColumn();

        if ($userPassword && password_verify($oldPassword, $userPassword)) {
            $error_message = validar_contrasenya($newPassword);
            if (empty($error_message)) {
                if ($newPassword === $confirmPassword) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE usuaris SET password = :password WHERE id = :id");
                    $stmt->execute(['password' => $hashedPassword, 'id' => $userId]);
                } else {
                    echo "Les contrasenyes no coincideixen.";
                    exit();
                }
            } else {
                echo $error_message;
                exit();
            }
        } else {
            echo "La contrasenya antiga és incorrecta.";
            exit();
        }
    }

    header("Location: ../index.php");
    exit();
}

// Incloure la vista per mostrar el formulari
$data = [
    'user_AV' => $user_AV,
    'user' => $user, // Pasar los datos del usuario a la vista
    'error_message' => $error_message,
];
extract($data);
include "../Vista/editar_perfil.php";

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
?>
