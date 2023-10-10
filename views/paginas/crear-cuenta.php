<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">LLena el siguiente formulario para crear una cuenta</p>
<?php include_once __DIR__ . "/../templates/alertas.php";
?>
<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <input type="text" name="nombre" id="nombre" class="campo-input" value="<?php echo s($usuario->nombre); ?>" required>
        <label for="nombre" class="campo-lbl"><span>Nombre</span></label>
    </div>
    <div class="campo">
        <input type="text" name="apellido" id="apellido" class="campo-input" value="<?php echo s($usuario->apellido); ?>" required>
        <label for="apellido" class="campo-lbl"><span>Apellido</span></label>
    </div>
    <div class="campo">
        <input type="tel" name="telefono" id="telefono" class="campo-input" value="<?php echo s($usuario->telefono); ?>" required>
        <label for="telefono" class="campo-lbl"><span>Telefono</span></label>
    </div>
    <div class="campo">
        <input type="email" name="email" id="email" class="campo-input" value="<?php echo s($usuario->email); ?>" required>
        <label for="email" class="campo-lbl"><span>Email</span></label>
    </div>
    <div class="campo">
        <input type="password" name="password" id="password" class="campo-input" required>
        <label for="password" class="campo-lbl"><span>Password</span></label>
    </div>


    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>