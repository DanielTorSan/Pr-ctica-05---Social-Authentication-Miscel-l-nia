<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista d'articles de Peixos</title>
    <link rel="stylesheet" href="Vista/Estils/estils.css">
</head>
<body>

<?php
require "Model/activitat_usuari.php";
require "Model/db_connection.php";
require "Model/id_manager.php";

$loggedIn = isset($_SESSION['user']);
$usuari = $loggedIn ? $_SESSION['user'] : null;
$user_id = $_SESSION['user_id'] ?? null;
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$articlesPerPagina = 5;
$paginaActual = $_GET['pagina'] ?? 1;
$offset = ($paginaActual - 1) * $articlesPerPagina;

$order = $_GET['order'] ?? 'date_desc';
$orderBy = 'data_creacio DESC';

switch ($order) {
    case 'date_asc':
        $orderBy = 'data_creacio ASC';
        break;
    case 'title_asc':
        $orderBy = 'titol ASC';
        break;
    case 'title_desc':
        $orderBy = 'titol DESC';
        break;
}

$search = $_GET['search'] ?? '';
$searchQuery = '';
$orderSearch = '';

if ($search) {
    $searchQuery = "WHERE titol LIKE :search";
    $orderSearch = "LOCATE(:search, titol), ";
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM articles $searchQuery");
if ($search) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}
$stmt->execute();
$totalArticles = $stmt->fetchColumn();
$totalPagines = ceil($totalArticles / $articlesPerPagina);

$stmt = $pdo->prepare("SELECT * FROM articles $searchQuery ORDER BY $orderSearch $orderBy LIMIT :limit OFFSET :offset");
if ($search) {
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $articlesPerPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si no se encuentran artículos, mostrar un mensaje
$searchNotFound = empty($articles) && $search;
?>

<!-- Barra de navegación -->
<div class="navbar">
    <div class="navbar-brand">🐟 Peixos</div>
    <div class="navbar-right">
        <?php if ($loggedIn): ?>
            <img src="<?php echo isset($_SESSION['avatar']) ? htmlspecialchars('uploads/avatars/' . $_SESSION['avatar']) : 'uploads/avatars/default_user_img.png'; ?>" alt="Avatar" class="avatar">
            <span>Benvingut, <?php echo htmlspecialchars($usuari); ?></span>
            <a href="Vista/editar_perfil.php" class="button profile">Editar Perfil</a>
            <a href="Model/logout.php" class="button logout">Tancar Sessió</a>
            <?php if ($isAdmin): ?>
                <a href="Vista/vista_usuaris.php" class="button view-users">Veure Usuaris</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="Model/login.php" class="button login">Iniciar Sessió</a>
            <a href="Model/register.php" class="button register">Registrar-se</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h1>Llista d'articles de Peixos</h1>

    <!-- Botón para insertar un artículo, visible solo si el usuario está logueado -->
    <?php if ($loggedIn): ?>
        <div class="insert-button">
            <a href="Controlador/inserir.php" class="button insert-article">Inserir Article</a>
        </div>
    <?php endif; ?>

    <!-- Formulario de ordenación -->
    <form method="GET" action="index.php" class="order-form">
        <label for="order">Ordenar per:</label>
        <select name="order" id="order" onchange="this.form.submit()">
            <option value="date_desc" <?php echo $order === 'date_desc' ? 'selected' : ''; ?>>Data (descendent)</option>
            <option value="date_asc" <?php echo $order === 'date_asc' ? 'selected' : ''; ?>>Data (ascendent)</option>
            <option value="title_asc" <?php echo $order === 'title_asc' ? 'selected' : ''; ?>>Títol (A-Z)</option>
            <option value="title_desc" <?php echo $order === 'title_desc' ? 'selected' : ''; ?>>Títol (Z-A)</option>
        </select>
    </form>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="index.php" class="search-form">
        <input type="text" name="search" placeholder="Cerca per títol" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cercar</button>
    </form>

    <div class="articles">
        <?php if ($searchNotFound): ?>
            <p class="no-articles">No s'ha trobat cap resultat per la cerca "<?php echo htmlspecialchars($search); ?>".</p>
        <?php endif; ?>
        <?php if (empty($articles) && !$searchNotFound): ?>
            <p class="no-articles">No hi ha articles publicats encara.</p>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <div class="article" id="article-<?php echo $article['ID']; ?>">
                    <img src="<?php echo htmlspecialchars('uploads/' . $article['imatge']); ?>" alt="Imatge de <?php echo htmlspecialchars($article['titol']); ?>" class="article-image">
                    <h2><?php echo htmlspecialchars($article['titol'] ?? 'Títol no disponible'); ?></h2>
                    <p><?php echo htmlspecialchars($article['cos'] ?? 'Contingut no disponible'); ?></p>
                    <?php if ($loggedIn && ($isAdmin || $article['created_by'] == $user_id)): ?>
                        <div class="article-actions">
                            <a href="Controlador/modificar.php?id=<?php echo $article['ID']; ?>" class="button edit-article">Editar</a>
                            <a href="Controlador/esborrar.php?id=<?php echo $article['ID']; ?>" class="button delete-article" onclick="return confirm('Estàs segur que vols esborrar aquest article?');">Esborrar</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Navegación de Paginación -->
    <div class="pagination">
        <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?php echo $paginaActual - 1; ?>&order=<?php echo htmlspecialchars($order); ?>&search=<?php echo htmlspecialchars($search); ?>" class="button">Anterior</a>
        <?php endif; ?>

        <span class="page-info">Pàgina <?php echo $paginaActual; ?> de <?php echo $totalPagines; ?></span>

        <?php if ($paginaActual < $totalPagines): ?>
            <a href="?pagina=<?php echo $paginaActual + 1; ?>&order=<?php echo htmlspecialchars($order); ?>&search=<?php echo htmlspecialchars($search); ?>" class="button">Següent</a>
        <?php endif; ?>
    </div>
</div>

<?php if ($search): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var article = document.querySelector(".article");
            if (article) {
                article.scrollIntoView({ behavior: "smooth" });
            }
        });
    </script>
<?php endif; ?>

<script>
    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.onclick = resetTimer;
        document.onscroll = resetTimer;

        function logout() {
            fetch('Model/activitat_usuari.php')
                .then(() => {
                    window.location.href = 'Model/logout.php';
                });
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, 2400000);  // 40 minutos
        }
    };

    inactivityTime();
</script>

</body>
</html>