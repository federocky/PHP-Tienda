<?php 

include("conexion.php");
session_start();

$total = 0;
$mail = "";

$tengo_direccion = false;
$sesion_iniciada = false;
$mandar_otra_direccion = isset($_POST["mandar_otra_direccion"]) ? true : false;


/**
 * Si no tengo direccion del cliente o bien este quiere mandar el pedido a una direccion
 * alternativa.
 */
if(isset($_POST["guardar_direccion"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_SESSION["email"];
    $mandar_otra_direccion = true;

    
    include("validacion-formulario-direccion.php");

    //si los datos son correctos
    if(empty($errores)) {


        include("guarda-datos-direccion.php");


        //guardamos la dirección y mandamos a la pasarela.
        if($conexion->query("INSERT INTO domicilio (id_cliente, calle, provincia, ciudad, cp, numero, escalera, piso, puerta) VALUES
                        ($id_cliente, '$calle', '$provincia', '$ciudad', '$cp', '$numero', '$escalera', '$piso', '$puerta');
    ")) header("location: pasarela_pagos.php");

    }

}


//Si ya tenia su direccion y el cliente ha pulsada en enviar a esa direccion
if(isset($_POST["enviar_aqui"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    header("location: pasarela_pagos.php");
}



//Si el usuario ha iniciado sesion
if(isset($_SESSION["email"])) {

    $sesion_iniciada = true; //sabemos que esta de alta para mostrar en el html

    $email = $_SESSION["email"];

    //si es false el usuario ya marco la opcion mandar a otra direccion, no necesitamos conocer la direccion guardada.
    if(!$mandar_otra_direccion) {
        
        $consulta_direccion = $conexion->query("SELECT * FROM domicilio WHERE id_cliente = (SELECT id FROM cliente WHERE email = '$email')");
        
        //si tengo direccion del cliente guardo sus valor y los muestro
        if($consulta_direccion->num_rows > 0) {
            
            $tengo_direccion = true; //pasa a true para saber que mostrar en el html
            
            $row = $consulta_direccion->fetch_object();
            
            $calle = $row->calle; 
            $provincia = $row->provincia;
            $ciudad = $row->ciudad;
            $cp = $row->cp;
            $numero = $row->numero;
            $escalera = $row->escalera;
            $piso = $row->piso;
            $puerta = $row->puerta;
            
        }

    }

        
} else {
    /* print_r("no estas logado"); */
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio</title>
    <link rel="stylesheet" href="css/estilos-header-menu2.css">
    <link rel="stylesheet" href="css/estilos-footer2.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/datos-envio.css">
</head>
<body>
    <header>
         <?php include("header-nav.php") ?> 
    </header>

    <main>

        <!-- si el cliente esta registrado y tengo su direccion lo muestro-->
        <?php if($tengo_direccion): ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="form-confirmar-direccion">
                <h4>Calle:</h4>
                <p><?=$calle?></p>

                <h4>Provincia:</h4>
                <p><?=$provincia?></p>

                <h4>Ciudad:</h4>
                <p><?=$ciudad?></p>

                <h4>CP:</h4>
                <p><?=$cp?></p>

                <h4>Número:</h4>
                <p><?=$numero?></p>

                <h4>Escalera:</h4>
                <p><?=$escalera?></p>

                <h4>Piso:</h4>
                <p><?=$piso?></p>

                <h4>Puerta:</h4>
                <p><?=$puerta?></p>

                <button name="enviar_aqui">Mandar a esta dirección</button>
                <button name="mandar_otra_direccion" id="otra">Mandar a otra dirección</button>
            </form>
            
        
        <?php endif; ?>

        <!-- si el cliente no tiene direccion o quiere ingresar otra-->
        <?php if($sesion_iniciada && !$tengo_direccion || $mandar_otra_direccion): ?>
            
            
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="form-direccion">
                <?php include("formulario-direccion.php") ?>
            </form>
        <?php endif; ?>

        <!-- si el cliente no ha iniciado sesion-->
        <?php if(!$sesion_iniciada): ?>
            <form action="<?php echo htmlspecialchars("login.php") ?>" class="form-confirmar">
            <h1>Debe iniciar sesion para realizar un pedido</h1>
            <button>Iniciar sesión</button>
            </form>
        <?php endif; ?>    


        <!-- esto se imprime en cualquier caso-->
        <form action="<?php echo htmlspecialchars("datos-envio.php") ?>" class="form-confirmar">
            <p>Subtotal: <?= $total ?></p>
            <p>Gastos de envio: 4.95</p>
            <p>Total: <?= $total +4.95?></p>
            <?php $_SESSION["total"] = $total ?>
            <a href="tienda.php">Volver a la tienda</a>
        </form>
    </main>
        
    <footer>
        <?php include("footer.php");  ?> 
    </footer>
</body>
</html>