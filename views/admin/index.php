<h1 class="nombre-pagina">Panel de Administrador</h1>

<?php

include_once __DIR__ . "/../templates/barra.php";
?>
<h2 class="descripcion-pagina">Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario"">
        <div class=" campo-cita">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?>" />
</div>
</form>
</div>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>
<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita) :
            if ($idCita !== $cita->id) : ?>
                <?php $total = 0; ?>
                <li>
                    <p>ID: <span><?php echo $cita->id ?></span> </p>
                    <p>Hora: <span><?php echo $cita->hora ?></span> </p>
                    <p>Cliente: <span><?php echo $cita->cliente ?></span> </p>
                    <p>Email: <span><?php echo $cita->email ?></span> </p>
                    <p>Telefono: <span><?php echo $cita->telefono ?></span> </p>
                    <h3>Servicios</h3>
                <?php
                $idCita = $cita->id;
            endif;
            $total += $cita->precio; ?>
                <p class="servicio"><span><?php echo $cita->servicio . " " . $cita->precio; ?></span> </p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                if (esUltimo($actual, $proximo)) :
                ?>
                    <div class="barra">
                        <p class="total">Total: <span>$ <?php echo $total; ?></span></p>
                        <form action="/api/eliminar" method="POST" id="formEliminarCita">
                            <input type="submit" class="boton-rojo" value="Eliminar Cita" onclick="confirmDelete(event)">
                            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                        </form>
                    </div>
            <?php endif;
            endforeach; ?>
    </ul>


</div>

<?php
$script = "<script src='build/js/buscador.js'></script> <script src='//cdn.jsdelivr.net/npm/sweetalert2@10'></script>"
?>