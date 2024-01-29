<?php
    foreach($alertas as $key => $mensajes){ //evidentemente $alertas es el unico que existe los otros son codinombres o alias para la llave y el valor de el array asociativo
        foreach($mensajes as $mensaje){
?>

            <div class="alerta <?php echo $key ?>">
                <?php echo $mensaje ?>
            </div>

<?php
    }
} 
?>