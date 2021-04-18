<?php
echo <<< CADENA
<nav class="navbar navbar-expand-lg navbar-light bg-light m-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Posts</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestionar Sitio
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Posts</a></li>
            <li><a class="dropdown-item" href="tags.php">Tags</a></li>
            <li><a class="dropdown-item" href="#">Usuarios</a></li>
            
          </ul>
        </li>
       
      </ul>
      <form class="d-flex" method="POST" action="kill.php">
        <input class="form-control me-2 col-xs-2" type="text" value="{$_SESSION['username']}" placeholder="Search" aria-label="Search" disabled>
        <button class="btn btn-outline-success" type="submit">Salir</button>
      </form>
    </div>
  </div>
</nav>
CADENA;
