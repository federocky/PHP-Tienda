<?php 

include("conexion.php");
session_start();


//con esta consulta generamos todos los productos dinamicamente
$consulta = $conexion->query("SELECT * FROM producto");
$carro = [];

/**
 * Cuando pincho en el icono del carro de algun producto se ejecuta el siguiente codigo
 */
if(isset($_POST["agrega-carro"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Compruebo que existe el carro en $session y trabajo en una variable local
    //para evitar comprobarlo varias veces.
    $carro = isset($_SESSION["carro"]) ? $_SESSION["carro"] : [];

    //el value de agrera carro es el codigo del producto en la BBDD 
    $claveProducto = $_POST["agrega-carro"];

    //si ya contiene el producto sumo 1 y si no lo tengo en el carro lo pongo. 
    if(array_key_exists($claveProducto, $carro)){
        $carro[$claveProducto] += 1;
    } else {
        $carro[$claveProducto] = 1;
    }

    //actualizo el carro en la sesion.
    $_SESSION["carro"] = $carro;

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimascota</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/estilos-header-menu2.css">
    <link rel="stylesheet" href="css/estilos-footer2.css">
    <link rel="stylesheet" href="css/estilos-tienda-main2.css">
    <link rel="stylesheet" href="css/filtro.css">
    <script src="https://kit.fontawesome.com/447e95072e.js" crossorigin="anonymous"></script>

</head>

<body>

    <header>
         <?php include("header-nav.php") ?> 
    </header>

    <main>

        <?php include("filtros-tienda.php") ?>

        <section class="articulos">

            <!-- cargamos los productos dinamicamente -->
            <?php while($row = $consulta->fetch_object()): ?>
                
                <article>
                    <img src="<?= $row->img?>" alt="cama-perro">
                    <h4><?= $row->nombre?></h4>
                    <p>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </p>
                    
                    <p id="precio"><?= $row->precio?>€</p>
                    
                    <div class="agregar-carro">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <button class="botonArticulo"  name="agrega-carro" value="<?= $row->id?>"><i class="fas fa-cart-arrow-down"></i></button>
                        </form>
                    </div>
                </article>
                
                <?php endwhile; ?>      

            </section>

    </main>

    <footer>
        <?php include("footer.php"); ?>
    </footer>


</body>
</html>