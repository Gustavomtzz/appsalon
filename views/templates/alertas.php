<!-- Alertas Error -->
<?php if (isset($errores['error'])) : ?>
    <?php foreach ($errores['error'] as $error) : ?>
        <p class="descripcion-pagina alerta-error"><?php echo $error ?></p>
<?php endforeach;
endif; ?>
<?php if (isset($errores['exito'])) : ?>
    <?php foreach ($errores['exito'] as $exito) : ?>
        <p class="descripcion-pagina alerta-exito"><?php echo $exito ?></p>
<?php endforeach;
endif; ?>


<!-- Alertas exito -->
<?php if (isset($mensaje)) : ?>
    <?php if ($mensaje === 1) : ?>
        <p id="alerta-index" class="alerta-exito">Cuenta Creada Correctamente</p>
    <?php endif; ?>
    <?php if ($mensaje === 2) : ?>
        <p id="alerta-index" class="alerta-exito">Iniciando Sesión</p>
    <?php endif; ?>
    <?php if ($mensaje === 3) : ?>
        <p id="alerta-index" class="alerta-exito">Password Reestablecido Correctamente</p>
    <?php endif; ?>
<?php endif; ?>