<?php 

include("conexion.php");
session_start();
$email = $_SESSION["email"];
$total = $_SESSION["total"];
$carro = $_SESSION["carro"];
$id_cliente = "";
$id_domicilio = "";
$id_compra = "";
$precio_producto = "";

//Una vez el cliente ha pagado recogemos los datos y los guardamos en la bbdd
if(isset($_POST["pagado"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

    /**
     * solicitamos a la BBDD datos necesarios del cliente para almacenar la compra.
     * el order by domicilio.id es para mandarlo a la ultima direccion agregada. 
     * FIXME:necesita mejorar para utilizar direcciones temporales.
     */ 
    $consulta_datos_cliente = $conexion->query("SELECT id_cliente, domicilio.id FROM cliente
                                                JOIN domicilio ON cliente.id = domicilio.id_cliente
                                                WHERE cliente.email = '$email' 
                                                ORDER by domicilio.id DESC");
                                        

    $row = $consulta_datos_cliente->fetch_object();

    $id_domicilio = $row->id;
    $id_cliente = $row->id_cliente;


    //Almacenamos dichos datos.
    if((        $conexion->query("INSERT INTO compra (id_cliente, id_domicilio, id_metodo_pago, total) VALUES
                    ($id_cliente, $id_domicilio, 2, $total)")
        ) == true) {
            print_r("todo cojonudo");
            //si todo va bien recuperamos el id de la compra para introducir el detalle.
            $consulta = $conexion->query("SELECT id FROM compra ORDER BY fecha DESC LIMIT 1");
            $row = $consulta->fetch_object();
            $id_compra = $row->id;

            //una vez obtenido el id de la compra ingresamos el detalle.
            $consulta = $conexion->stmt_init();
            $consulta->prepare("INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio) VALUES
                                (?, ?, ?, ?)");

            foreach ($carro as $codigo => $cantidad) {
                //primero obtenemos el precio del producto que no hemos guardado.
                $consulta_precio = $conexion->query("SELECT precio FROM producto WHERE id = '$codigo'");
                $row = $consulta_precio->fetch_object();
                $precio_producto = $row->precio;

                //una vez hecho esto ingresamos el detalle
                $consulta->bind_param("ssss", $id_compra, $codigo, $cantidad, $precio_producto);
                $consulta->execute();
            }

            $consulta->close();

            $_SESSION["carro"] = array(); //TODO: cuando implemente area de usuario me llevara ahi para ver mis ultimas compras.
            header("location:tienda.php");

        } else {
            print_r("algo fue mal bro");
    }



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pulse pagar para finalizar la compra</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
    <input type="submit" name="pagado" value="Pagar">
</form>

<style>
    input {
        padding: 20px;
        cursor: pointer;
    }
</style>
</body>
</html>