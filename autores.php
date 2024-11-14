<?php
// autores.php
require_once 'config/database.php';

try {
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    $query = "SELECT a.*, COUNT(t.id_titulo) as num_libros 
              FROM autores a 
              LEFT JOIN titulos t ON a.id_autor = t.id_pub 
              GROUP BY a.id_autor 
              ORDER BY a.apellido, a.nombre";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores - Librería Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Librería Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="autores.php">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Nuestros Autores</h1>

        <div class="row">
            <?php foreach($autores as $autor): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($autor['nombre'] . ' ' . $autor['apellido']); ?>
                            </h5>
                            <p class="card-text">
                                <strong>Ubicación:</strong><br>
                                <?php echo htmlspecialchars($autor['ciudad'] . ', ' . $autor['estado'] . ', ' . $autor['pais']); ?>
                            </p>
                            <p class="card-text">
                                <strong>Libros publicados:</strong> 
                                <?php echo $autor['num_libros']; ?>
                            </p>
                            <?php if($autor['telefono']): ?>
                                <p class="card-text">
                                    <strong>Contacto:</strong><br>
                                    📞 <?php echo htmlspecialchars($autor['telefono']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <footer class="bg-dark text-white mt-5 py-3">
        <div class="container text-center">
            <p>&copy; 2024 Librería Online. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>