<div class="barra">
    <p>Bienvenido <span class="nombreCliente"><?php echo $nombreCliente ?? '' ?></span></p>
    <a href="/logout" class="boton-rojo">Cerrar Sesión</a>
</div>

<?php if (isset($_SESSION['admin'])) : ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php endif; ?>