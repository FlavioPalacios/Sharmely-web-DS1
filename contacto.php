<?php
include('conexion_bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitizar
    $nombre   = trim($_POST['nombre']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $mensaje  = trim($_POST['mensaje']);

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('❌ Correo inválido');</script>";
        exit;
    }

    // 1️⃣ Insertar cliente (con prepared statement)
    $stmtCliente = $conexion->prepare(
        "INSERT INTO clientes (nombre_completo, correo, telefono) VALUES (?, ?, ?)"
    );
    $stmtCliente->bind_param("sss", $nombre, $correo, $telefono);

    if ($stmtCliente->execute()) {

        $id_cliente = $stmtCliente->insert_id;
        $stmtCliente->close();

        // 2️⃣ Insertar cotización (con prepared statement)
        $stmtCot = $conexion->prepare(
            "INSERT INTO cotizaciones (id_cliente, mensaje) VALUES (?, ?)"
        );
        $stmtCot->bind_param("is", $id_cliente, $mensaje);

        if ($stmtCot->execute()) {
            echo "<script>alert('✅ Cotización enviada correctamente');</script>";
        } else {
            echo "<script>alert('❌ Error al guardar cotización');</script>";
        }

        $stmtCot->close();
        
    } else {
        echo "<script>alert('❌ Error al registrar cliente');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="contacto_css.css" />
  <link rel="stylesheet" href="inicio_css.css" />
  <link rel="stylesheet" href="">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
  <title>Contacto Sharmelly</title>
</head>


<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoS-a1WA_k4fWUNSOeBQRhprB8EDMbJIRxow&s" 
     alt="Logo Sharmelly" width="50" class="me-2 rounded-circle border border-warning">
      Concretos Sharmelly
    </a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="Inicio.html">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="producto.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="servicios.html">Servicios</a></li>
        <li class="nav-item"><a class="nav-link" href="nosotros.html">Nosotros</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
      </ul>

      <!-- Carrito -->
      <ul class="navbar-nav ms-3">
        <li class="nav-item submenu position-relative">
          <img src="https://cdn-icons-png.flaticon.com/512/833/833314.png" alt="Carrito">
          <div id="carrito">
            <table class="table table-sm" id="lista-carrito">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <a href="#" id="vaciar-carrito" class="btn-3">Vaciar carrito</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<section class="contacto container my-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold text-primary">Contáctanos</h1>
    <p class="lead">Estamos aquí para ayudarte con tu proyecto</p>
  </div>

  <div class="row g-4">
    <!-- Formulario -->
    <div class="col-lg-6">
      <form action="contacto.php" method="post">
  <div class="mb-3">
    <label class="form-label fw-semibold">Tu nombre</label>
    <input type="text" class="form-control" name="nombre" placeholder="Ingresa tu nombre completo" required>
  </div>

  <div class="mb-3">
    <label class="form-label fw-semibold">Correo electrónico</label>
    <input type="email" class="form-control" name="correo" placeholder="correo@email.com" required>
  </div>

  <div class="mb-3">
    <label class="form-label fw-semibold">Teléfono</label>
    <input type="tel" class="form-control" name="telefono" placeholder="+51 999 999 999" required>
  </div>

  <div class="mb-3">
    <label class="form-label fw-semibold">¿En qué podemos ayudarte?</label>
    <textarea class="form-control" name="mensaje" rows="4" placeholder="Describe tu proyecto y los materiales que necesitas..." required></textarea>
  </div>

  <button type="submit" class="btn-enviar w-100 py-2">Enviar Solicitud</button>
</form>


    </div>

    <!-- Información de contacto -->
    <div class="col-lg-6">
      <div class="card shadow-lg border-0 p-4 h-100">
        <h3 class="fw-bold text-primary mb-3">Información de Contacto</h3>
        <p><strong>Dirección:</strong><br> San Jerónimo , Cusco, Peru</p>

        <p><strong>Teléfonos:</strong><br> +51 973 336 118<br> +51 960651744</p>

        <p><strong>Correo:</strong><br> sharmely_hu@hotmail.com </p>

        <p><strong>Horario de Atención:</strong><br>
          <b>Lunes - Viernes:</b> 8:00 AM - 6:00 PM<br>
          <b>Sábados:</b> 8:00 AM - 2:00 PM<br>
          <b>Domingos:</b> Cerrado
        </p>

        <div class="text-center mt-4">
          <a href="tel:+51915333762" class="btn-llamar">📞 Llamar Ahora</a>
        </div>
      </div>
    </div>
  </div>

</section>

<footer>
  <div class="container text-center">
    <p>
      <strong>Teléfono:</strong> +51 915333762 | 
      <strong>Email:</strong> info@sharmelly.com | 
      <strong>Dirección:</strong> Cusco, Perú
    </p>
    <p><strong>Participantes:</strong><br>
      Canal Sayago Pabel 100%<br>
      De los Ríos Cano Franco Sebastián 100%<br>
      Luza Grajeda Fernanda Astrid 100%<br>
      Palacios Rozas Flavio Alejandro 100%
    </p>
    <div class="d-flex justify-content-center gap-3">
      <a href="https://www.facebook.com/people/Concretos-Sharmelly/61553685533331/#"><i class="bi bi-facebook fs-3"></i></a>
      <a href="#"><i class="bi bi-instagram fs-3"></i></a>
      <a href="#"><i class="bi bi-whatsapp fs-3"></i></a>
    </div>
  </div>
</footer>
<!-- Bootstrap JS  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>