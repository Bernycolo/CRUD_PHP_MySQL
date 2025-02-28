<?php
    include "conexion.php";
?>
<?php

    mysqli_select_db($conexion, "productosdb");

    $identificador = $_POST["identificador"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $directorioSubida = "imagenes/";
    $max_file_size = 5120000;
    $extesionesValidas = array("png", "jpg", "jpeg");

    if (isset($_FILES["imagen"])) {
        $errores = 0;
        $nombreArchivo = $_FILES["imagen"]["name"];
        $fileSize = $_FILES["imagen"]["size"];
        $directorioTemporal = $_FILES["imagen"]["tmp_name"];
        $tipoArchivo = $_FILES["imagen"]["type"];
        $arrayArchivo = pathinfo($nombreArchivo);
        $extension = $arrayArchivo["extension"];

        if (!in_array($extension, $extesionesValidas)) {
            echo "Error: el archivo no es una imagen válida";
            $errores = 1;
        }
        if ($fileSize > $max_file_size) {
            echo "Error: el archivo es demasiado grande";
            $errores = 1;
        }
        if ($errores == 0) {
            $nombreCompleto = $directorioSubida . $nombreArchivo;
            if (move_uploaded_file($directorioTemporal, $nombreCompleto)) {
                $insertar = "INSERT INTO productos (id_producto, nombre, descripcion, precio, fotografia) VALUES ($identificador, '$nombre', '$descripcion', $precio, '$nombreArchivo')";
                mysqli_query($conexion, $insertar);
                header("Location: alta_ok.php");
                echo "El archivo se ha subido correctamente";
            } else {
                echo "Error: no se ha podido subir el archivo";
            }
        }
    }



?>