<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Escribe tu nuevo password a continuacion:</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php'; //no se porque el / inicial pero funciona

    if ($error){
        return;
    }
?>

<form class="formulario" method="POST"> <!--COMO no tiene action lo manda igual a este mismo .php-->

    <div class="campo">
    <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nuevo Password"
        >
    </div>

    <input type="submit" class="boton" value="Confirmar Nueva contraseña">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuanta? Crear una</a>
</div>