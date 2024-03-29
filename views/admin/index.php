<h1 class="nombre-pagina">Panel de administracion</h1>

<div class="barra">
    <p>Hola: <?php echo $nombre ?></p>
    <a href="/logout">Cerrar Sesion</a>
</div>  

<?php 
    if(isset($_SESSION['admin'])) { ?>
        <div class="barra-servicios">
            <a class="boton" href="/admin">Ver Citas</a>
            <a class="boton" href="/servicios">Ver Servicios</a>
            <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
        </div>
<?php } ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
            type="date"
            id="fecha"
            name="fecha"
            value="<?php echo $fecha; ?>" 
            >
        </div>
    </form>
</div>

<?php 
    if(count($citas)=== 0)  {
        echo "<h3>No hay citas en esta fecha</h3>";

    }
?>


<div class="citas-admin">
    <ul class="citas">
    <?php 
    $idCita = 0;
        foreach($citas as $key => $cita) { 
            if($idCita !== $cita->id){
            $total = 0;
            ?>
            <li>
                <p>ID: <span><?php echo $cita->id; ?></span></p>
                <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                <p>Email: <span><?php echo $cita->email; ?></span></p>
                <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                <h3>Servicios:</h3>
                <?php $idCita = $cita->id; ?>
            <?php } //FIN DEL IF 
                $total += $cita->precio
                ?>   
                
                <p class="servicio"><span><?php echo $cita->servicio . " " . $cita->precio ; ?></span></p>

                <?php 
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;

                    if(esUltimo($actual, $proximo)){ ?>
                        <p class="total">Total: <span>$<?php echo $total; ?></span></p>
                    

                    <form action="api/eliminar" method="post">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>"> 
                        <input type="submit" class="boton-eliminar" value="Eliminar"> 
                    </form>

                    <?php } ?>
            
        <?php } // FIN DEL FOREACH ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>