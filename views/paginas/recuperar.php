<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Reestablece tu password a continuación</p>
<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php if ($error === true) return; ?>
<form method="POST" class="formulario" required>
    <div class="campo">
        <input type="password" name="password" id="password" class="campo-input" required>
        <label for="password" class="campo-lbl"><span>Password</span></label>
    </div>

    <input type="submit" class="boton" value="Guardar Password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear Una</a>
</div>