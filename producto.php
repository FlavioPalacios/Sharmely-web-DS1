<?php
include('conexion_bd.php');

$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>






<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - Concretos Sharmelly</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Tu CSS personalizado -->
  <link rel="stylesheet" href="inicio_css.css">
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
          <div class="position-relative">
            <img src="https://cdn-icons-png.flaticon.com/512/833/833314.png" alt="Carrito" id="icono-carrito">
            <span id="contador-carrito" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">0</span>
          </div>
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
            <p class="fw-bold mt-2 text-end" id="total"></p>
            <a href="#" id="vaciar-carrito" class="btn-3">Vaciar carrito</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header -->
<header class="encabezado-productos text-center py-5">
  <h1 class="titulo-seccion">Nuestros Productos</h1>
  <p class="subtitulo-seccion">
    Encuentra todo lo que necesitas para tu proyecto de construcción con la calidad que nos caracteriza.
  </p>
</header>

<!-- Productos puiesto con la base de datos -->
<section class="container my-5">
  <h2 class="text-center mb-4">Nuestros Productos</h2>
  <div class="row g-4">

  <?php while($fila = $resultado->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card h-100">
        <img src="<?php echo htmlspecialchars($fila['imagen']); ?>" 
             class="card-img-top" 
             alt="<?php echo htmlspecialchars($fila['nombre']); ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($fila['nombre']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($fila['descripcion']); ?></p>
          <p><strong>S/ <?php echo number_format($fila['precio'], 2); ?></strong></p>
          <button class="btn btn-comprar agregar-carrito" 
                  data-id="<?php echo $fila['id_producto']; ?>"
                  data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>" 
                  data-precio="<?php echo $fila['precio']; ?>">Comprar</button>
        </div>
      </div>
    </div>
  <?php endwhile; ?>

  </div>
</section>


<!-- Footer -->
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🛒 Script del carrito -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const carritoBody = document.querySelector("#lista-carrito tbody");
  const vaciarCarritoBtn = document.querySelector("#vaciar-carrito");
  const totalEl = document.querySelector("#total");
  const contador = document.querySelector("#contador-carrito");
  const botones = document.querySelectorAll(".agregar-carrito");

  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  renderizarCarrito();

  botones.forEach(boton => {
    boton.addEventListener("click", () => {
      const nombre = boton.getAttribute("data-nombre");
      const precio = parseFloat(boton.getAttribute("data-precio"));

      carrito.push({ nombre, precio });
      localStorage.setItem("carrito", JSON.stringify(carrito));
      renderizarCarrito();
      mostrarMensaje(`${nombre} añadido al carrito 🛒`);
    });
  });

  vaciarCarritoBtn.addEventListener("click", (e) => {
    e.preventDefault();
    carrito = [];
    localStorage.removeItem("carrito");
    renderizarCarrito();
  });

  function renderizarCarrito() {
    carritoBody.innerHTML = "";
    let total = 0;

    carrito.forEach((item, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${item.nombre}</td>
        <td>S/ ${item.precio.toFixed(2)}</td>
        <td><button class="btn btn-danger btn-sm eliminar" data-index="${index}">X</button></td>
      `;
      carritoBody.appendChild(row);
      total += item.precio;
    });

    totalEl.textContent = carrito.length > 0 ? "Total: S/ " + total.toFixed(2) : "";
    contador.textContent = carrito.length;

    document.querySelectorAll(".eliminar").forEach(boton => {
      boton.addEventListener("click", (e) => {
        const index = e.target.dataset.index;
        carrito.splice(index, 1);
        localStorage.setItem("carrito", JSON.stringify(carrito));
        renderizarCarrito();
      });
    });
  }

  function mostrarMensaje(texto) {
    const msg = document.createElement("div");
    msg.textContent = texto;
    msg.style.position = "fixed";
    msg.style.bottom = "30px";
    msg.style.right = "30px";
    msg.style.background = "#1E88E5";
    msg.style.color = "#fff";
    msg.style.padding = "10px 20px";
    msg.style.borderRadius = "8px";
    msg.style.boxShadow = "0 0 10px rgba(0,0,0,0.2)";
    msg.style.zIndex = "9999";
    msg.style.opacity = "0";
    msg.style.transition = "opacity 0.5s ease";
    document.body.appendChild(msg);

    setTimeout(() => (msg.style.opacity = "1"), 100);
    setTimeout(() => {
      msg.style.opacity = "0";
      setTimeout(() => msg.remove(), 500);
    }, 2000);
  }
});
</script>

</body>
</html>
