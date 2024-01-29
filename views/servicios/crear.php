<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Crea un nuevo serivicio para ofrecer a tus clientes</p>

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

<?php include_once __DIR__ . '/../templates/alertas.php';?>




<form action="/servicios/crear" method="post" class="formulario"> <!--HOOOOOOOOOOOOOOOOOOOOOOOOOOOOO YA ENTENDI EL ACTION, HAY QUE PONERLE DONDE VA A MANDAR EL POST, ESO ES LA URL QUE ESTA EN PUBLIC/INDEX!-->

        <?php include_once __DIR__ . '/formulario.php' ?>

        <input type="submit" class="boton" value="Guardar">

</form>