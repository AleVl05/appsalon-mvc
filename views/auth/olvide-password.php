<h1 class="nombre-pagina">Resetear Password</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuacion</p>


<?php 
    include_once __DIR__ . '/../templates/alertas.php' //no se porque el / inicial pero funciona
?> 

<form action="/olvide" class="formulario" method="POST">

    <div class="campo">
    <label for="email">E-mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
        >
    </div>

    <input type="submit" class="boton" value="Resetear password">

</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuanta? Crear una</a>
</div>