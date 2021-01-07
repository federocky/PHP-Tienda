<?php 

include("conexion.php");


if(isset($_POST["alta"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    //aqui falta validacion

    $usuario = $_POST["usuario"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $administrador = $_POST["administrador"];
    $contrasenia = $_POST["contrasenia"];


    if(
    $conexion->query("INSERT INTO empleado (nombre_usuario, nombre, apellidos, email, contrasenia, administrador) VALUES
                        ('$usuario', '$nombre', '$apellidos', '$email', '$contrasenia', '$administrador')")) {
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

        <h3>Nombre usuario</h3>
        <input type="text" name="usuario" value="<?= isset($row->nombre_usuario) ? $row->nombre_usuario : ""; ?>">

        <h3>Nombre</h3>
        <input type="text" name="nombre" value="<?= isset($row->nombre) ? $row->nombre : ""; ?>">

        <h3>Apellidos</h3>
        <input type="text" name="apellidos" value="<?= isset($row->apellidos) ? $row->apellidos : ""; ?>">

        <h3>Email</h3>
        <input type="text" name="email" value="<?= isset($row->email) ? $row->email : ""; ?>">

        <h3>Contraseña</h3>
        <input type="text" name="contrasenia" value="<?= isset($row->contrasenia) ? $row->contrasenia : ""; ?>">

        <h3>administrador</h3>
        <input type="text" name="administrador" value="<?= isset($row->administrador) ? $row->administrador : ""; ?>">

        <input type="submit" name="alta" value="Alta">
        
        </form>

    <?php elseif(isset($resultado) && $resultado): ?>

        <p>Empleado creado correctamente</p>

    <?php else: ?>

        <p>Algo ha ido mal, intentelo mas tarde</p>

    <?php endif ?>

    
</body>
</html>