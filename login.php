<?php
include("./header.php");
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="text-center mb-4">Iniciar Sesión</h2>

          <form method="POST" action="procesar_login.php">
            <div class="mb-3">
              <label for="usuario" class="form-label">Usuario:</label>
              <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña:</label>
              <input type="password" class="form-control" id="clave" name="clave" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success">Ingresar</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="cambiar_pass.php">¿Olvidaste tu contraseña? Cambiarla aquí.</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("./footer.php"); ?>


