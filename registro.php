<?php include('header.php'); ?>

<style>
    .form-container {
        max-width: 400px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: bold;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .form-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #673AB7;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .form-container input[type="submit"]:hover {
        background-color: #5e35b1;
    }

    .form-container p {
        text-align: center;
        margin-top: 15px;
    }

    .form-container a {
        color: #673AB7;
        text-decoration: none;
        font-weight: bold;
    }

    .form-container a:hover {
        text-decoration: underline;
    }
</style>

<div class="form-container">
    <h2>Registro</h2>

    <form method="POST" action="procesar_registro.php">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>

        <label for="confirmar_clave">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_clave" name="confirmar_clave" required>

        <input type="submit" value="Registrar">
    </form>

    <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí.</a></p>
</div>

<?php include('footer.php'); ?>
