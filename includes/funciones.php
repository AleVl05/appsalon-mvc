<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//una wea que se le ocurrio al profe

function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo) {
        return true;
    }
    return false;
}

//verifica que el usuario inicio sesion y si no lo hizo lo lleva a la pagina de iniciar session_id

function isAuth() :void {
    if(!isset($_SESSION['login'])){ //si no esta logeado
        header('Location: /'); 
    }
}

function isAdmin() :void {
    if(!isset($_SESSION['admin'])){ //si no esta logeado
        header('Location: /'); 
    }
}