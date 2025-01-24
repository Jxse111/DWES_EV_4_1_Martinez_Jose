<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != "administrador") {
    session_destroy();
    header("location:login.html");
} else {
    echo nl2br("Bienvenido " . $_SESSION['usuario'] . ", " . $_SESSION['rol']);
    ?>
    <!DOCTYPE html>
    <!--
    Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
    Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
            <?php
            require_once './funcionesValidacion.php';
            $conexionBD = new mysqli();
            $mensajeExito = "Lista de mensajes de exito: ";
            $mensajeError = "Lista de mensajes de error: ";

            try {
                $conexionBD->connect("localhost", "root", "", "espectaculos");
            } catch (Exception $ex) {
                $mensajeError .= "ERROR: " . $ex->getMessage();
                $conexionBD->close();
            }
            try {
                $consultaTipos = $conexionBD->query("SELECT DISTINCT tipo FROM espectaculo");
                while ($tipos = $consultaTipos->fetch_assoc()) {
                    $tablaTipos[] = $tipos;
                }
                $consultaGrupos = $conexionBD->query("SELECT cdgrupo,nombre FROM grupo");
                while ($grupos = $consultaGrupos->fetch_assoc()) {
                    $tablaGrupos[$grupos["cdgrupo"]] = $grupos["nombre"];
                }

                $codigoSinFiltrar = filter_input(INPUT_POST, "cdespec");
                $nombreSinFiltrar = filter_input(INPUT_POST, "nombre");
                $estrellasSinFiltrar = filter_input(INPUT_POST, "estrellas");
                $tiposSinFiltrar = filter_input(INPUT_POST, "tipo");
                $grupoSinFiltrar = filter_input(INPUT_POST, "grupo");
                $conjuntoCampos = $nombreSinFiltrar && $codigoSinFiltrar && $estrellasSinFiltrar && $tiposSinFiltrar && $grupoSinFiltrar;
                if ($conjuntoCampos) {
                    $codigo = validarCodigoEspectaculo($codigoSinFiltrar);
                    $nombre = validarNombreEspectaculo($nombreSinFiltrar);
                    $estrellas = validarEstrellasEspectaculo($estrellasSinFiltrar);
                    $tipo = validarTipoEspectaculo($tiposSinFiltrar);
                    $grupo = validarGrupo($grupoSinFiltrar);
                    $camposValidados = $codigo && $nombre && $estrellas && $tipo && $grupo;
//                    echo var_dump($codigo, $nombre, $estrellas, $tipo, $grupo);
                    if ($camposValidados && $grupo != 0) {
                        $consultaInsercionEspectaculos = $conexionBD->stmt_init();
                        $consultaInsercionEspectaculos->prepare("INSERT INTO espectaculo (cdespec,nombre,tipo,estrellas,cdgru) VALUES (?,?,?,?,?)");
                        $consultaInsercionEspectaculos->bind_param("sssis", $codigo, $nombre, $tipo, $estrellas, $grupo);
                        if ($consultaInsercionEspectaculos->execute()) {
                            $mensajeExito .= "Inserción realizada con exito.";
                        } else {
                            $mensajeError .= "La inserción no se ha podido realizar.";
                        }
                    } else {
                        $mensajeError = "Los datos son inválidos o incorrectos.";
                    }
                }
            } catch (Exception $ex) {
                $mensajeError .= "ERROR: " . $ex->getMessage();
            }
            ?>
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <label>Introduce el codigo del espectáculo:</label>
                <input type="text" name="cdespec" value="<?php if (filter_has_var(INPUT_POST, "cdespec")) echo $codigoSinFiltrar ?>"><br><br>
                <label>Introduce el nombre del espectáculo</label>
                <input type="text" name="nombre" value="<?php if (filter_has_var(INPUT_POST, "nombre")) echo $nombreSinFiltrar ?>"><br><br>
                <label>Selecciona el tipo del espectáculo: </label>
                <select name="tipo">
                    <option value="0">Selecciona un tipo</option>
                    <?php
                    if ($tablaTipos) {
                        foreach ($tablaTipos as $tipoEspectaculo) {
                            foreach ($tipoEspectaculo as $valor) {
                                ?>
                                <option value = "<?php echo $valor ?>"><?php echo $valor ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select><br><br>
                <label>Introduce un número de estrellas para el espectáculo:</label>
                <input type="number" name="estrellas" value="<?php if (filter_has_var(INPUT_POST, "estrellas"))  ?>"><br><br>
                <label>Selecciona el grupo del espectáculo:</label>
                <select name="grupo">
                    <option value="0">Selecciona un grupo</option>
                    <?php
                    if ($tablaGrupos) {
                        foreach ($tablaGrupos as $codigoGrupo => $nombreGrupo) {
                            ?>
                            <option value = "<?php echo $codigoGrupo ?>"><?php echo $nombreGrupo ?></option>
                            <?php
                        }
                    }
                    ?>
                </select><br><br>
                <button type="submit" name="enviar">Insertar</button>
            </form><br><br>
            <?php
            include_once './cerrarSesion.html';
        }
        ?>
        <h2>Lista de mensajes:</h2>
        <ul>
            <li><?php echo $mensajeExito; ?></li>
            <li><?php echo $mensajeError; ?></li>
        </ul>

    </body>
</html>
