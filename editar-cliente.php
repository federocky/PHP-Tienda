<?php 

include("conexion.php");
session_start();

$id = $_SESSION["id"];

$consulta = $conexion->query("SELECT * FROM cliente WHERE id = '$id'");
$row = $consulta->fetch_object();


if(isset($_POST["editar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    //aqui falta la validacion

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $fecha = $_POST["fecha"];
    $activo = $_POST["activo"];

    if(
    $conexion->query("UPDATE cliente SET 
                        nombre = '$nombre',
                        apellidos = '$apellidos',
                        email = '$email',
                        fecha_alta = '$fecha',
                        activo = '$activo'
                        WHERE id = $id")) {
                            $resultado = true;
                        } else {
                            $resultado = false;
                        }
    

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <a href="administracion.php">Volver</a>

    <?php if(!isset($resultado)):?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">

        <h3>Nombre</h3>
        <input type="text" name="nombre" value="<?= isset($row->nombre) ? $row->nombre : ""; ?>">

        <h3>Apellidos</h3>
        <input type="text" name="apellidos" value="<?= isset($row->apellidos) ? $row->apellidos : ""; ?>">

        <h3>Email</h3>
        <input type="text" name="email" value="<?= isset($row->email) ? $row->email : ""; ?>">

        <h3>Fecha alta</h3>
        <input type="text" name="fecha" value="<?= isset($row->fecha_alta) ? $row->fecha_alta : ""; ?>">

        <h3>Activo</h3>
        <input type="text" name="activo" value="<?= isset($row->activo) ? $row->activo : ""; ?>">

        <input type="submit" name="editar" value="Editar">
        
        </form>

    <?php elseif(isset($resultado) && $resultado): ?>

        <p>Cliente editado correctamente</p>

    <?php else: ?>

        <p>Algo ha ido mal, intentelo mas tarde</p>

    <?php endif ?>

    
</body>
</html>