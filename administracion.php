<?php 

include("conexion.php");
session_start();

    //Cogemos los datos sea de cliente, empleado o producto
    if(isset($_POST["emple"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $consulta = $conexion->query("SELECT * FROM empleado");

    }

    if(isset($_POST["cli"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $consulta = $conexion->query("SELECT * FROM cliente");
    }

    if(isset($_POST["prod"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $consulta = $conexion->query("SELECT * FROM producto");
    }


    /**
     * Cuando pulsamos en eliminar entramos aqui
     */
    if(isset($_POST["del"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        //guardamos el id
        $_SESSION["id"] = $_POST["del"];
        $id = $_POST["del"];

        //comprobamos si lo que eliminamos es cliente producto o empleado y procedemos.
        if($_POST["dato"] == 'emp') {   

            $conexion->query("UPDATE empleado SET 
                            activo = 0
                            WHERE id = $id");
            
        }else if ($_POST["dato"] == 'cli') {

            $conexion->query("UPDATE cliente SET 
                            activo = 0
                            WHERE id = $id");
            
        }else {
            $conexion->query("UPDATE producto SET 
                            stock = 0
                            WHERE id = $id");
        }

    }

    /**
     * Cuando pulsamos en editar 
     */
    if(isset($_POST["edit"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        //guardamos el id
        $_SESSION["id"] = $_POST["edit"];

        //comprobamos si lo que editamos es un cliente, empleado o producto.
        if($_POST["dato"] == 'emp') header("location: editar-empleado.php");
        else if ($_POST["dato"] == 'cli') header("location: editar-cliente.php");
        else header("location: editar-producto.php");

    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion</title>
</head>
<body>
    <header>
        <h1>Administracion</h1>
    </header>
    <a href="tienda.php">Volver a la tienda</a>

    <main>

        <!-- menu principal donde mostramos empleado producto o clientes -->
        <div class="menu">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <button name="emple">CRUD empleados</button>
                <button name="cli">CRUD cliente</button>
                <button name="prod">CRUD productos</button>
            </form>
        </div>


        <section>
            <!-- Tanto para cliente como empleado mostramos lo mismo -->
            <?php if(isset($_POST["emple"]) || isset($_POST["cli"])): ?>
            
            <!-- este if nos vale para mostrar el boton alta solo en caso de empleado -->
            <?php if(isset($_POST["emple"])) :?>

                <form action="<?php echo htmlspecialchars("alta-empleado.php") ?>" method="POST">
                    <button name="nuevo-emple">Alta empleado</button>
                </form>

            <?php endif; ?>


                <table>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>email</th>
                        <th>Fecha alta</th>
                        <th>Activo</th>
                        <th>
                        </th>
                    </tr>

                    <?php while($row = $consulta->fetch_object()): ?>
                        <tr>
                            <th><?=$row->id?></th>
                            <th><?=$row->nombre?></th>
                            <th><?=$row->apellidos?></th>
                            <th><?=$row->email?></th>
                            <th><?=$row->fecha_alta?></th>
                            <th><?=$row->activo?></th>
                            <th>
                            <!-- el formulario nos vale para editar o eliminar, mando id y el dato: cliente o empleado-->
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                                    <button name="edit" value="<?=$row->id?>">Edit</button>
                                    <button name="del" value="<?=$row->id?>">Del</button>
                                    <input type="hidden" name="dato" value="<?= isset($_POST["cli"]) ? "cli" : "emp" ?>">
                                </form>
                            </th>
                        </tr>

                    <?php endwhile; ?>

                </table>

                <!-- Si se ha marcado producto -->
                <?php elseif(isset($_POST["prod"])): ?>
                    
                    <!-- boton alta producto -->
                    <form action="<?php echo htmlspecialchars("alta-producto.php") ?>" method="POST">
                        <button name="nuevo-prod">Alta producto</button>
                    </form>

                    <table>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Img</th>
                        <th>
                        </th>
                    </tr>

                    <?php while($row = $consulta->fetch_object()): ?>
                        <tr>
                            <th><?=$row->id?></th>
                            <th><?=$row->nombre?></th>
                            <th><?=$row->descripcion?></th>
                            <th><?=$row->precio?></th>
                            <th><?=$row->marca?></th>
                            <th><?=$row->stock?></th>
                            <th><?=$row->img?></th>
                            <th>
                            <!-- el formulario nos vale para editar o eliminar, mando id y el dato: producto-->
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                                    <button name="edit" value="<?=$row->id?>">Edit</button>
                                    <button name="del" value="<?=$row->id?>">Del</button>
                                    <input type="hidden" name="dato" value="prod">
                                </form>
                            </th>
                        </tr>

                    <?php endwhile; ?>

                </table>

                <?php endif; ?>
            
        </section>

    </main>
</body>
</html>