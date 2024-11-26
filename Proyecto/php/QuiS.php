<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CelorA</title>
   <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/quis.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous">
    </script>
    <link rel="icon" href="../images/logoCAB.png" type="images/png">
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="http://localhost/Proyecto/php/CelorA.php">
      <img src="../images/logoCAB.png" alt="Logo" class="img-fluid logo-navbar">
    </a>
    <!-- Botón Hamburguesa (Responsive) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Menú y Botón -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="https://www.instagram.com/cristiano/">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Proyecto/php/QuiS.php">Who are we?</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Proyecto/php/ContUs.php">Contact us</a>
        </li>   
      </ul>
      <!-- Botón al extremo derecho -->
      <button class="btn btn-custom ms-lg-auto" type="button" onclick="location.href='http://localhost/Proyecto/php/login.php'">Login</button>
      </div>
  </div>
</nav>
<!-- Carta de informacion -->
<div class="card mb-3 custom-card">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="../images/logosinletras.jpg" class="img-fluid rounded-start" alt="logo">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Who are we?</h5>
        <p class="card-text">We are a team of developers who came together due to the common idea of how obsolete requisition systems can sometimes be 
            Sometimes emergency situations arise that companies cannot predict, but CelorA ensures that losses are minimal.</p>
        <p class="card-text">With CelorA it is easy to work quickly, simply, accessible and satisfying.</p>
        <p class="card-text"> With CelorA you can be confident that your requisition processes are completed professionally.</p>
      </div>
    </div>
  </div>
</div>


<!-- Pie de Pagina -->/
<footer class="footer-custom">
  <div class="container py-3">
    <div class="row">
      <!-- Columna 1: Información de contacto -->
      <div class="col-md-4 text-center text-md-start">
        <h5 class="footer-title">Contact us</h5>
        <p>Email: contacto@celora.com</p>
        <p>Phone number: +52 664 123 4567</p>
      </div>

      <!-- Columna 2: Enlaces -->
      <div class="col-md-4 text-center">
        <h5 class="footer-title">Links</h5>
        <ul class="list-unstyled">
          <li><a href="#">Products</a></li>
          <li><a href="http://localhost/Proyecto/php/QuiS.php">Who we are?</a></li>
          <li><a href="http://localhost/Proyecto/php/ContUs.php">Contact us</a></li>
        </ul>
      </div>

      <!-- Columna 3: Redes sociales -->
      <div class="col-md-4 text-center text-md-end">  
        <h5 class="footer-title">Follow us</h5>  
        <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" 
        width="60" 
        height="60"
        fill="currentColor" 
        class="bi bi-facebook" 
        viewBox="0 0 16 16">
      <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
      </svg>
        </a> 
        <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" 
        width="60" 
        height="60" 
        fill="currentColor" 
        class="bi bi-twitter-x" 
        viewBox="0 0 16 16">
        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
        </svg>
        </a> 
        <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" 
        width="60" 
        height="60" 
        fill="currentColor" 
        class="bi bi-instagram" 
        viewBox="0 0 16 16">
        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
        </svg>
        </a>
        <a href="https://www.threads.net/@realmadrid?hl=es-la" class="social-icon">
        <svg 
        xmlns="http://www.w3.org/2000/svg" 
        width="60" 
        height="60"
        fill="currentColor" 
        class="bi bi-threads" 
        viewBox="0 0 16 16">
        <path d="M6.321 6.016c-.27-.18-1.166-.802-1.166-.802.756-1.081 1.753-1.502 3.132-1.502.975 0 1.803.327 2.394.948s.928 1.509 1.005 2.644q.492.207.905.484c1.109.745 1.719 1.86 1.719 3.137 0 2.716-2.226 5.075-6.256 5.075C4.594 16 1 13.987 1 7.994 1 2.034 4.482 0 8.044 0 9.69 0 13.55.243 15 5.036l-1.36.353C12.516 1.974 10.163 1.43 8.006 1.43c-3.565 0-5.582 2.171-5.582 6.79 0 4.143 2.254 6.343 5.63 6.343 2.777 0 4.847-1.443 4.847-3.556 0-1.438-1.208-2.127-1.27-2.127-.236 1.234-.868 3.31-3.644 3.31-1.618 0-3.013-1.118-3.013-2.582 0-2.09 1.984-2.847 3.55-2.847.586 0 1.294.04 1.663.114 0-.637-.54-1.728-1.9-1.728-1.25 0-1.566.405-1.967.868ZM8.716 8.19c-2.04 0-2.304.87-2.304 1.416 0 .878 1.043 1.168 1.6 1.168 1.02 0 2.067-.282 2.232-2.423a6.2 6.2 0 0 0-1.528-.161"/>
        </svg>
        </a>
      </div>
    </div>

    <hr>
    <div class="text-center">
      <p class="m-0">© 2024 CelorA. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>
    
</body>
</html>