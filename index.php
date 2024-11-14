<?php
// index.php
require_once 'config/database.php';

try {
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    // Consulta para obtener libros con información de autores
    $query = "SELECT t.*, a.nombre as autor_nombre, a.apellido as autor_apellido 
              FROM titulos t 
              LEFT JOIN autores a ON t.id_pub = a.id_autor 
              ORDER BY t.fecha_pub DESC";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería Online</title>
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
                        <a class="nav-link active" href="index.php">Libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="autores.php">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Catálogo de Libros</h1>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach($libros as $libro): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Por: <?php echo htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellido']); ?>
                            </h6>
                            <p class="card-text">
                                <strong>Tipo:</strong> <?php echo htmlspecialchars($libro['tipo']); ?><br>
                                <strong>Fecha de publicación:</strong> 
                                <?php echo date('d/m/Y', strtotime($libro['fecha_pub'])); ?><br>
                                <?php if(!empty($libro['notas'])): ?>
                                    <strong>Notas:</strong> <?php echo htmlspecialchars($libro['notas']); ?>
                                <?php endif; ?>
                            </p>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">
                                        <?php if($libro['precio']): ?>
                                            €<?php echo number_format($libro['precio'], 2); ?>
                                        <?php else: ?>
                                            Precio no disponible
                                        <?php endif; ?>
                                    </span>
                                    <span class="badge bg-<?php echo ($libro['contrato'] == 'S') ? 'success' : 'warning'; ?>">
                                        <?php echo ($libro['contrato'] == 'S') ? 'Disponible' : 'Consultar disponibilidad'; ?>
                                    </span>
                                </div>
                            </div>
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