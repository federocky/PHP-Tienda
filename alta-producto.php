<?php 

include("conexion.php");

if(isset($_POST["alta"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    //aqui falta la validacion

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $marca = $_POST["marca"];
    $stock = $_POST["stock"];
    $img = $_POST["img"];

    if(
    $conexion->query("INSERT INTO producto (nombre, descripcion, precio, marca, stock, img) VALUES
                    ('$nombre', '$descripcion', '$precio', '$marca', '$stock', '$img')")) {
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

        <input type="submit" name="alta" value="Alta">
        
        </form>

    <?php elseif(isset($resultado) && $resultado): ?>

        <p>Producto creado correctamente</p>

    <?php else: ?>

        <p>Algo ha ido mal, intentelo mas tarde</p>

    <?php endif ?>

    
</body>
</html>