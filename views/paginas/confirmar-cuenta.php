<h1 class="nombre-pagina">Cuenta Confirmada</h1>

<?php if (isset($alertas['exito'])) : ?>
    <?php foreach ($alertas['exito'] as $exito) : ?>
        <p class="descripcion-pagina alerta-exito"><?php echo $exito ?></p>
<?php endforeach;
endif; ?>
<?php if (isset($alertas['error'])) : ?>
    <?php foreach ($alertas['error'] as $error) : ?>
        <p class="descripcion-pagina alerta-error"><?php echo $error ?></p>
<?php endforeach;
endif; ?>

<a href="/" class="boton">Volver a Inicio</a>