<?php 

include("conexion.php");
session_start();

$id = $_SESSION["id"];

$consulta = $conexion->query("SELECT * FROM producto WHERE id = '$id'");
$row = $consulta->fetch_object();


if(isset($_POST["editar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    //aqui falta la validacion

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $marca = $_POST["marca"];
    $stock = $_POST["stock"];
    $img = $_POST["img"];

    if(
    $conexion->query("UPDATE producto SET 
                        nombre = '$nombre',
                        descripcion = '$descripcion',
                        precio = $precio,
                        marca = '$marca',
                        stock = $stock,
                        img = '$img'
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

        <h3>Descripcion</h3>
        <input type="text" name="descripcion" value="<?= isset($row->descripcion) ? $row->descripcion : ""; ?>">

        <h3>precio</h3>
        <input type="text" name="precio" value="<?= isset($row->precio) ? $row->precio : ""; ?>">

        <h3>Marca</h3>
        <input type="text" name="marca" value="<?= isset($row->marca) ? $row->marca : ""; ?>">

        <h3>Stock</h3>
        <input type="text" name="stock" value="<?= isset($row->stock) ? $row->stock : ""; ?>">

        <h3>Ruta img</h3>
        <input type="text" name="img" value="<?= isset($row->img) ? $row->img : ""; ?>">

        <input type="submit" name="editar" value="Editar">
        
        </form>

    <?php elseif(isset($resultado) && $resultado): ?>

        <p>Producto editado correctamente</p>

    <?php else: ?>

        <p>Algo ha ido mal, intentelo mas tarde</p>

    <?php endif ?>

    
</body>
</html>