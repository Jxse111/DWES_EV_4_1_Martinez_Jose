<?php
require_once './funcionesValidacion.php';
require_once './funcionesBaseDeDatos.php';
$mensajeError = "Mensajes de error : ";
$mensajeExito = "Mensajes de éxito: ";
$mensajeBienvenida = "Bienvenido,";
/* En el caso de que se pulse el boton Crear cuenta del formulario de inicio de sesión,
 *  serás redirigido al formulario de registro
 */
if (filter_has_var(INPUT_POST, "Registrarse")) {
    header("Location: registro.html");
    die();
} elseif (filter_has_var(INPUT_POST, "Entrar")) {
//Comprobamos que exista la sesión
    if (isset($_SESSION['usuario'])) {
        $mensajeSesion .= "El usuario registrado tiene una sesión activa";
    } else {
// Creación de la conexión
        $conexionBD = new mysqli();

//Intento de conexión a la base de datos
        try {
            $conexionBD->connect("localhost", "root", "", "espectaculos");
        } catch (Exception $ex) {
            $mensajeError .= "ERROR: " . $ex->getMessage();
        }
//Sino existe la sesión Iniciamos la sesión
        session_start();
        $_SESSION['usuario'] = validarUsuarioExistente(filter_input(INPUT_POST, "usuarioExistente"), $conexionBD);
        $conexionBD->close(); //Cierro la conexión a la base de datos
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
            <?php
            // Creación de la conexión
            $conexionBD = new mysqli();

            //Intento de conexión a la base de datos
            try {
                $conexionBD->connect("localhost", "root", "", "espectaculos");
            } catch (Exception $ex) {
                $mensajeError .= "ERROR: " . $ex->getMessage();
            }
            //Si el boton entrar  del formulario de inicio de sesión se pulsa, realiza las siguientes operaciones.
            if (filter_has_var(INPUT_POST, "Entrar")) {
                try {
                    //Validamos el usuario con los datos de la base de datos
                    $usuarioLogin = validarUsuarioExistente(filter_input(INPUT_POST, "usuarioExistente"), $conexionBD);
                    //Recogemos el usuario registrado del formulario
                    if ($usuarioLogin) {
                        //Extraemos la contraseña del usuario ya registrado
                        $conexionBD->autocommit(false);
                        $consultaSesiones = $conexionBD->query("SELECT contraseña FROM usuarios WHERE login='$usuarioLogin'");
                        if ($consultaSesiones->num_rows > 0) {
                            $contraseña = $consultaSesiones->fetch_all(MYSQLI_ASSOC);
                            foreach ($contraseña as $contraseñaExistente) {
                                //Si las dos contraseñas cifradas son exactas, el inico de sesión se realiza con exito.
                                $contraseñaEncriptada = hash("sha512", filter_input(INPUT_POST, "contraseñaExistente"));
                                $esValida = $contraseñaEncriptada === $contraseñaExistente['contraseña'];
                                $registroExistoso = $consultaSesiones->num_rows > 0 && $esValida;
                                if ($esValida) {
                                    $mensajeExito .= "Inicio de Sesión realizado con éxito. \n";
                                    $buscarRolUsuarioRegistrado = $conexionBD->query("SELECT id_rol FROM usuarios WHERE login='$usuarioLogin'");
                            if ($buscarRolUsuarioRegistrado) {
                                        $mensajeExito .= "Rol recuperado con éxito.\n";
                                        $rolUsuarioRegistrado = $buscarRolUsuarioRegistrado->fetch_column();
                                        $buscarTipoRolUsuarioRegistrado = $conexionBD->query("SELECT tipo FROM roles WHERE id_rol='$rolUsuarioRegistrado'");
                                        if ($buscarTipoRolUsuarioRegistrado) {
                                            $mensajeExito .= "Tipo de rol encontrado.\n";
                                            $rol = $buscarTipoRolUsuarioRegistrado->fetch_column();
                                            $_SESSION['rol'] = $rol;
                                        } else {
                                            $mensajeError .= "Tipo de rol no encontrado.\n";
                                        }
                                    } else {
                                        $mensajeError .= "No se ha podido recuperar el rol.\n";
                                    }
                                } else {
                                    $mensajeError .= "No se ha podido iniciar sesión, la contraseña o el usuario no son correctos.\n";
                                }
                            }
                        } else {
                            $mensajeError .= "La consulta no se ha podido realizar.\n";
                        }
                    } else {
                        $mensajeError .= "Los datos son inválidos o incorrectos.\n";
                    }
                } catch (Exception $ex) {
                    $mensajeError .= "ERROR: " . $ex->getMessage();
                }
                ?>
                <h2>LISTA DE MENSAJES: </h2>
                <?php if ($mensajeError != "Mensajes de error : " && !$registroExistoso) { ?>
                    <h2>Mensajes de error: </h2>
                    <ul>
                        <li><?php
                            if (isset($mensajeError)) {
                                echo nl2br($mensajeError);
                            }
                            ?></li>
                    <?php } ?>
                </ul>
                <?php if ($mensajeError != "Mensajes de exito : " && $registroExistoso) { ?>
                    <h2>Mensajes de éxito: </h2>
                    <ul>
                        <li><?php
                            if (isset($mensajeExito)) {
                                echo nl2br($mensajeExito);
                            }
                            ?></li>
                    </ul>
                <?php } ?>
            </ul>
            <br><br>
            <?php if ($registroExistoso) { ?>
                <form action="sesionUsuario.php" method="post">
                    <button type="submit" name="Acceder">Acceder</button>
                    <input type="hidden" id="usuarioIniciado" name="usuarioIniciado" value="<?php echo $usuarioLogin ?>">
                    <input type="hidden" id="recuerdame" name="recuerdame" value="<?php
                    if (filter_has_var(INPUT_POST, "Recordar")) {
                        echo filter_input(INPUT_POST, "Recordar");
                    }
                    ?>">
                </form>
                <?php
            }
        }
        ?>
    </body>
    </html>
    <?php
} 
        