<h1 class="nombre-pagina">Login</h1>

<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <input type="email" name="email" id="email" class="campo-input" autocomplete="on" required>
        <label for="email" class="campo-lbl"><span>Email</span></label>
    </div>
    <div class=" campo">
        <input type="password" name="password" id="password" class="campo-input" autocomplete="off" required>
        <label for="password" class="campo-lbl"><span>Password</span></label>
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una.</a>
    <a href="/olvide">¿Ólvidaste tu password?</a>
</div>


<?php $script = "<script src='build/js/app.js'> </script>" ?>