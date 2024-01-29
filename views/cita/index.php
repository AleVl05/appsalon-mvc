<div class="barra">
    <p>Hola: <?php echo $nombre ?></p>

    <a href="/logout">Cerrar Sesion</a>
    
</div>

<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus citas a continuacion</p>

<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>


    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>  <!--aqui se inyecta todo desde JS-->
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <div id="servicios" class="listado-servicios"></div>

        
        <form class="formulario" method="post" action="/">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre ?>" 
                    disabled
                    
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+ 1 day')) ?>" 
                    
                    
                >
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora"
                >
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>"> <!--por ser tipo hidden no se ve--> 
            
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button> <!--laquo dibuja "<<"-->
        <button id="siguiente" class="boton">siguiente &raquo;</button> <!--raquo dibuja ">>"-->
    </div>


</div>

<?php $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'> </script>


"; ?>