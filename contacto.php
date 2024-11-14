<?php
// contacto.php
require_once 'config/database.php';

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $database = Database::getInstance();
        $db = $database->getConnection();
        
        $query = "INSERT INTO contacto (nombre, correo, asunto, comentario, estado) 
                  VALUES (:nombre, :correo, :asunto, :comentario, 'nuevo')";
        
        $stmt = $db->prepare($query);
        
        $params = array(
            ':nombre' => trim($_POST['nombre']),
            ':correo' => trim($_POST['correo']),
            ':asunto' => trim($_POST['asunto']),
            ':comentario' => trim($_POST['comentario'])
        );
        
        if ($stmt->execute($params)) {
            $mensaje = "¡Gracias por tu mensaje! Te responderemos lo antes posible.";
        }
    } catch(PDOException $e) {
        $error = "Error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Librería Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="css/contacto.css">
</head>
<body>
    <!-- Navbar igual que en las otras páginas -->
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
                        <a class="nav-link" href="autores.php">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">Formulario de Contacto</h1>
                    </div>
                    <div class="card-body">
                        <?php if ($mensaje): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $mensaje; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form id="contactForm" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       required maxlength="100">
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu nombre completo.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" 
                                       required maxlength="100">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un correo electrónico válido.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" 
                                       required maxlength="200">
                                <div class="invalid-feedback">
                                    Por favor, ingresa el asunto de tu mensaje.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comentario" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="comentario" name="comentario" 
                                          rows="5" required maxlength="65535"></textarea>
                                <div class="invalid-feedback">
                                    Por favor, escribe tu mensaje.
                                </div>
                                <div class="form-text">
                                    Máximo 65,535 caracteres.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Enviar mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="bg-dark text-white mt-5 py-3">
        <div class="container text-center">
            <p>&copy; 2024 Librería Online. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/validacion.js">
        
    </script>

    
</body>
</html>