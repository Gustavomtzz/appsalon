<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>


<table class="tabla">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($servicios as $servicio) : ?>
            <tr>
                <td><?php echo $servicio->nombre ?></td>
                <td><?php echo $servicio->precio ?></td>
                <td>
                    <form method="POST" action="/servicios/eliminar">
                        <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                        <input type="submit" class="boton-rojo w-100" value="Borrar">
                    </form>

                    <a href="/servicios/actualizar?id=<?php echo $servicio->id; ?>" class="boton-naranja w-100">Actualizar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>