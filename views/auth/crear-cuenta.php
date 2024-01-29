<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php' //no se porque el / inicial pero funciona
?>

<form class="formulario" action="/crear-cuenta" method="POST" >
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
            value="<?php echo s($usuarioEnviado->nombre); ?>"
        >
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu apellido"
            value="<?php echo s($usuarioEnviado->apellido); ?>"
        >
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input 
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu telefono"
            value="<?php echo s($usuarioEnviado->telefono); ?>"
        >
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E- mail"
            value="<?php echo s($usuarioEnviado->email); ?>"
        >
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu password"
            
        >
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">

</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar sesion</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>


