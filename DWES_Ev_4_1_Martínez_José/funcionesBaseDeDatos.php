<?php

require_once './patrones.php';

function noExisteUsuario($usuario, $conexionBD) {
    $usuarioNoExiste = false;
    $consultaUsuariosExistentes = $conexionBD->query("SELECT login FROM usuarios");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['login'] != $usuario) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function noExisteContraseña($contraseña, $conexionBD) {
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM usuarios");
    $contraseñas = $consultaContraseñasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($contraseñas as $constraseñasExistentes) {
        if ($constraseñasExistentes['contraseña'] != $contraseña) {
            $contraseñaNoExiste = true;
        }
    }
    return $contraseñaNoExiste ? true : false;
}

function existeUsuario($usuario, $conexionBD) {
    $usuarioNoExiste = false;
    $consultaUsuariosExistentes = $conexionBD->query("SELECT login FROM usuarios");
    $usuarios = $consultaUsuariosExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($usuarios as $usuarioExistente) {
        if ($usuarioExistente['login'] == $usuario) {
            $usuarioNoExiste = true;
        }
    }
    return $usuarioNoExiste ? true : false;
}

function existeContraseña($contraseña, $conexionBD) {
    $contraseñaNoExiste = false;
    $consultaContraseñasExistentes = $conexionBD->query("SELECT contraseña FROM usuarios");
    $contraseñas = $consultaContraseñasExistentes->fetch_all(MYSQLI_ASSOC);
    foreach ($contraseñas as $constraseñasExistentes) {
        if ($constraseñasExistentes['contraseña'] == $contraseña) {
            $contraseñaNoExiste = true;
        }
    }
    return $contraseñaNoExiste ? true : false;
}
