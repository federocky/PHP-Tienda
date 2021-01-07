<?php

    session_start();
    include("conexion.php");

    //sirve para mostrar la cabecera de la compra con el total y la fecha
    $numeroCompra = 0;

    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
    $direccionCambiada = false;
    $mostrarFormulario = false;

    //si el cliente ha pulsado en logout
    if (isset($_POST["logout"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        unset($_SESSION["email"]);
        unset($_SESSION["nombre"]);
        if (isset($_SESSION["administrador"])) unset($_SESSION["administrador"]);
        header("location: tienda.php");
    }

    /**
     * Si se pulsa en compras mostramos un historial con todas las compras del cliente
     */
    if (isset($_POST["compras"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        $consulta = $conexion->query("SELECT cliente.id, 
        detalle_compra.id_producto, detalle_compra.cantidad, detalle_compra.precio,
        compra.id, compra.total, compra.fecha, 
        producto.nombre, producto.descripcion, 
        producto.img, producto.marca 
        FROM cliente 
        JOIN compra ON cliente.id = compra.id_cliente
        JOIN detalle_compra ON compra.id =  detalle_compra.id_compra 
        JOIN producto ON detalle_compra.id_producto = producto.id
        WHERE cliente.email = '$email'");

    }

    /**
     * Si se pulsa en baja damos de baja al cliente, es un borrado logico
     */
    if (isset($_POST["baja"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $deBaja = "Ha ocurrido un error, intentelo mas tarde";
        if($conexion->query("UPDATE cliente SET activo = 0 WHERE email = '$email'")){
            $deBaja = "Su cuenta ha sido dada de baja <a href='tienda.php'>SALIR</a>";
            unset($_SESSION["email"]);
            unset($_SESSION["nombre"]);
        };

    }

    /**
     * Aqui el cliente siempre vera su ultima direccion guardada.
     */
    if (isset($_POST["direccion"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $consulta = $conexion->query("SELECT * FROM domicilio
                                    JOIN cliente on cliente.id = domicilio.id_cliente
                                    WHERE email = '$email' ORDER BY 1 DESC LIMIT 1");

    }

    //Necesito saber si tengo que moestrar el formulario
    if(isset($_POST["cambiar-direccion"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $mostrarFormulario = true;
    }



    if(isset($_POST["guardar_direccion"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        include("validacion-formulario-direccion.php");
        
        if(empty($errores)) {

            include("guarda-datos-direccion.php");
    
            //guardamos la dirección
            if($conexion->query("INSERT INTO domicilio (id_cliente, calle, provincia, ciudad, cp, numero, escalera, piso, puerta) VALUES
                            ($id_cliente, '$calle', '$provincia', '$ciudad', '$cp', '$numero', '$escalera', '$piso', '$puerta');
        ")) $direccionCambiada = true;
    
        } else {
            $mostrarFormulario = true;
        }

    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/estilos-header-menu2.css">
    <link rel="stylesheet" href="css/estilos-footer2.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/area-usuario.css">
</head>
<body>
    <header>    
         <?php include("header-nav.php") ?> 
    </header>
<a href=""></a>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <button name="compras" id="btn-compras">Compras</button>
            <button name="direccion" id="btn-direccion">Dirección</button>
            <button name="baja" id="btn-baja">Dar de baja</button>
        </form>

        <div class="contenedor-usuario-principal">

            <!-- Aqui mostramos al cliente el historial de compras -->
            <?php if(isset($_POST["compras"]) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>

                <?php while($row = $consulta->fetch_object()): 

                    if( $numeroCompra != $row->id ) {
                        $numeroCompra = $row->id;?>

                        <p class='total'>Total de la compra: <?= $row->total?></p>
                        <p class='fecha'>Fecha de la compra: <?= $row->fecha?></p>

                    <?php } ?>


                    <div class='articulo-comprado'>
                        <img src='<?= $row->img?>' alt='imagen'>
                        <div>
                            <p class='titulo-articulo'><?= $row->nombre?> 
                            <p class="descripcion-articulo"><?=$row->descripcion?></p>
                            <p class="cantidad-articulo">Cantidad: <?=$row->cantidad?></p>
                            <p class="marca-articulo">Marca: <?= $row->marca?></p>
                            <p class="precio-unidad"><?= $row->precio?></p>

                        </div>
                    </div>

                <?php endwhile;?>


            <!-- aqui mostramos la direccion cuando se pulsa en direccion -->
            <?php elseif (isset($_POST["direccion"]) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>

                <?php while($row = $consulta->fetch_object()): ?>


                    <div class='direccion'>
                        <h3>Calle:</h3>
                        <p><?= $row->calle ?></p>

                        <h3>Provincia:</h3>
                        <p><?= $row->provincia ?></p>

                        <h3>Ciudad:</h3>
                        <p><?= $row->ciudad ?></p>

                        <h3>CP:</h3>
                        <p><?= $row->cp ?></p>

                        <h3>Numero:</h3>
                        <p><?= $row->numero ?></p>

                        <h3>Escalera:</h3>
                        <p><?= $row->escalera ?></p>

                        <h3>Piso:</h3>
                        <p><?= $row->piso ?></p>

                        <h3>Puerta:</h3>
                        <p><?= $row->puerta ?></p>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                            <button id="cambiaDireccion" name="cambiar-direccion">Cambiar direccion</button>
                        </form>
                    </div>

                <?php endwhile;?>

            <!-- cuando pulsa baja mostramos mensaje -->
            <?php elseif (isset($_POST["baja"]) && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <h3><?= $deBaja ?></h3>

            <!-- Mostramos el formulario de cambio de direccion -->
            <?php elseif ($mostrarFormulario): ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="form-direccion">
                <?php include("formulario-direccion.php") ?>
                </form>

            <!-- una vez este cambiada mostramos los cambios -->
            <?php elseif ($direccionCambiada): ?>    

                <h3>La direccion ha sido actualizada</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                            <button name="direccion">Ver direccion</button>
                </form>

            <?php else : ?>
                <h1>Hola <?= isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "" ?></h1>
            <?php endif ?>
        </div>
    </main>

    <footer>
        <?php include("footer.php"); ?>
    </footer>

</body>
</html>