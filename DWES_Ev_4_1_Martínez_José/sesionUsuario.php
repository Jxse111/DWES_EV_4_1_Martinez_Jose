<?php
session_start();
if (isset($_SESSION['usuario'])) {
    switch ($_SESSION['rol']) {
        case "administrador" :
            header("Location: alta_espectaculo.php");
            break;
        case "usuario":
            header("Location: reservar_espectaculo.php");
            break;
        case "invitado":
            header("Location: ver_espectaculos.php");
            break;
    }
}
$caducidadSesion = 1200;
if (isset($_SESSION['hora_inicio'])) {
    $tiempoTranscurridoSesion = time() - $_SESSION['hora_inicio'];

    //Si el tiempo transcurrido se excede del límite
    if ($tiempoTranscurridoSesion > $caducidadSesion) {
        session_destroy(); //Eliminamos la sesión
        header("Location: login.html"); //Redirigimos al formulario de inicio de sesión al usuario de la sesión
    }
} else {
    $_SESSION['hora_inicio'] = time();
}
//echo var_dump($_SESSION);
if (isset($_SESSION['usuario'])) {
    echo nl2br("Ya estas logeado, " . $_SESSION['rol'] . "\n");
    //Si el usuario de la sesión coincide con el que se ha inciado sesión se actualiza la hora de la sesión a la actual
    if ($_SESSION['usuario'] === filter_input(INPUT_POST, "usuarioIniciado")) {
        $_SESSION['hora_inicio'] = time();
    } else {
        //Sino se elimina la sesión 
        session_destroy(); //Eliminamos la sesión
        header("Location: login.html"); //Redirigimos al formulario de inicio de sesión al usuario de la sesión
    }
    ?> 
    <br><br>
    <?php
    //Mostramos la web de ejemplo
//    include_once './index.html';
    ?> 
    <?php
    //Si se pulsa en cerrar sesión se borra la sesión y vuelve al formulario principal
    include_once './cerrarSesion.html';
    if (filter_has_var(INPUT_POST, "recuerdame")) {
        setcookie("usuarioLogeadoPreviamente", filter_input(INPUT_POST, "usuarioIniciado"), 3600);
    }
}


