<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">inicia sesion con tus datos</p>


<?php 
    include_once __DIR__ . '/../templates/alertas.php' //no se porque el / inicial pero funciona
?>

<form class="formulario" method="post" action="/">

    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu E-mail"
            name="email"
        >
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu contraseña"
            name="password"
        >
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>









