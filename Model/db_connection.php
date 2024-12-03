<!-- Daniel Torres Sanchez -->
<?php
// Conexió a la base de dades 
/*
try {
    $pdo = new PDO("mysql:host=bbdd.danitorres.cat; dbname=ddb239237", "ddb239237", "P@ssw0rd");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la connexió: " . $e->getMessage());
}
*/
?>
 
<?php
// Conexió a la base de dades
try {
    $pdo = new PDO("mysql:host=localhost;dbname=pt05_dani_torres", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la connexió: " . $e->getMessage());
}
?>