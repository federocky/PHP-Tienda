<?php 

include("conexion.php");
session_start();

//acumulador
$total = 0;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
    <link rel="stylesheet" href="css/estilos-header-menu2.css">
    <link rel="stylesheet" href="css/estilos-footer2.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/terminar-compra.css">
</head>
<body>
    <header>
         <?php include("header-nav.php") ?> 
    </header>

    <main class="main">

    
    <div class="contenedor-articulos-comprados">

        <?php if(isset($_SESSION["carro"])): ?>

            <?php    
                ///recorremos el carro que es un array
                foreach ($_SESSION["carro"] as $key => $value) :
                
                //pedimos a la BBDD la informacion referente a esos productos
                $consultaProducto = $conexion->query("SELECT * FROM producto WHERE id = '$key'");
                $row = $consultaProducto->fetch_object();
            ?>

            <!-- imprimimos el articulo en pantalla -->
            <div class='articulo-terminar'>
                <img src='<?= $row->img?>' alt='imagen'>
                <div>
                    <p class='titulo-articulo'><?= $row->nombre?> 
                    <p class="descripcion-articulo"><?=$row->descripcion?></p>

                    <!-- esta es la papelera elimina el producto seleccionado-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <button name="papelera" value="<?=$key?>" class="papel"><i class='far fa-trash-alt'></i></button>
                    </form>

                    <p class="precio-unidad"><?= $row->precio?></p>

                    <!-- formulario para el cambio de cantidad-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="formularioNuevo">

                        <input type='text' name='cantidad' class='cantidad-articulos' value='<?= $value ?>'>
                        <p class='precio-articulo'><?= $row->precio * $value?>€</p>
                        <button name="actualizarProducto" value="<?=$key?>" class="boton-refresh"><i class="fas fa-sync-alt"></i></button>

                    </form>
                </div>
            </div>

        <?php endforeach; endif; ?>

    </div>

    <form action="<?php echo htmlspecialchars("datos-envio.php") ?>" class="form-confirmar">
        <p>Subtotal: <?= $total ?></p>
        <p>Gastos de envio: 4.95</p>
        <p>Total: <?= $total +4.95?></p>
        <button name="conrimarCompra">Confirmar compra</button>
        <a href="tienda.php">Volver a la tienda</a>
    </form>

    </main>

    
    <footer>
        <?php include("footer.php");  ?> 
    </footer>
</body>
</html>