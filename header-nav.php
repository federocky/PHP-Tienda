<?php
    isset($_SESSION["nombre"]) ? $nombre = "Hola, " . $_SESSION["nombre"] : $nombre = "";
    $total = 0;


    /**
     * En los siguientes dos metodos no necesitamos comprobar si hay una sesion abierta
     * por que si se ha podido pulsar el boton ya sabemos que esta abierta.
     */


    /**
     * Al hacer click en la papelera eliminamos el articulo del carro
     */
    if(isset($_POST["papelera"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        
        //eliminamos del carro el articulo que esta en la posicion pulsada.
        unset($_SESSION["carro"][$_POST["papelera"]]);
    }


    /**
     * Al hacer click en el boton de actualizar producto actualizamos el stock de ese producto en carro
     */
    if(isset($_POST["actualizarProducto"]) && $_SERVER["REQUEST_METHOD"] == "POST"){

        $cantidad = 1; //variable auxiliar

        //actualizamos el producto en el carro, utilizando el codigo de producto como clave y el valor introducido como valor
        //previamente evitamos ingresar un numero menor que 1
        if($_POST["cantidad"] > 0) $cantidad = $_POST["cantidad"];
        
        $_SESSION["carro"][$_POST["actualizarProducto"]] = $cantidad;
    }


?>

<div class='header contenedor'>

    <a id='probando' href='#'>
        <img src='icon/logo-pagina.png'>
        <h1>Mimascota <span>.com</span></h1>
    </a>

    <div class='iconos'>
        <div style='color:#fff'> <?= $nombre ?></div>
        <div class='icono-carro'>
            <input type='checkbox' id='icono-carro' name='icono-carro'>
            <label for='icono-carro'><i class='fas fa-shopping-cart'></i></label>
            <div id='cantidad-articulos'><?= isset($_SESSION["carro"]) ? count($_SESSION["carro"]) : "0" ?></div>

            <!-- Aqui comienza el carrito -->
            <div id='contenedor-carrito'>
                
                <section>

                    <div id='contenedor-articulos'>
                        
                        <!-- Si existe $sesion carro es que tengo productos, por tanto los imprimo-->
                        <?php if(isset($_SESSION["carro"])): ?>

                        <?php    
                            ///recorremos el carro que es un array
                            foreach ($_SESSION["carro"] as $key => $value) :
                            
                            //pedimos a la BBDD la informacion referente a ese producto
                            $consultaCarro = $conexion->query("SELECT * FROM producto WHERE id = '$key'");
                            $row = $consultaCarro->fetch_object();

                            //actualizamos el total
                            $total += $row->precio * $value;
                        ?>

                        <!-- imprimimos el articulo en pantalla -->
                        <div class='articulo'>
                            <img src='<?= $row->img?>' alt='imagen'>
                            <div>
                                <p class='titulo-articulo'><?= $row->nombre?> 
                                <!-- esta es la papelera elimina el producto seleccionado-->
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                                    <button name="papelera" value="<?=$key?>" class="papel"><i class='far fa-trash-alt'></i></button>
                                </form>

                                <p class="precio-unidad"><?= $row->precio?></p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="formularioNuevo">

                                    <input type='number' name='cantidad' class='cantidad-articulos' value='<?= $value ?>'>
                                    <p class='precio-articulo'><?= $row->precio * $value?>€</p>
                                    <button name="actualizarProducto" value="<?=$key?>" class="boton-refresh"><i class="fas fa-sync-alt"></i></button>

                                </form>
                            </div>
                        </div>

                        <?php endforeach; endif; ?>

                            
                    </div>
                            
                    <div id='total'>
                    <p>TOTAL: <span><?=$total?></span></p>
                    </div>
                
                    <form action="<?php echo htmlspecialchars('terminarCompra.php')?>" method="POST" class="form-compra">
                        <div id='boton-realizar-compra'>
                            <button class="boton-compra"><i class='fas fa-cart-arrow-down'></i> Realizar compra</p></button>
                        </div>
                    </form>
                
                </section>
            </div>

        </div>

        <div class='icono-usuario'>
            <input type='checkbox' id='icono-user' name='icono-user'>
            <label for='icono-user' id='icono-use' <i class='fas fa-user'></i></label>

            <!-- Menú usuario empieza aqui -->
            <div id="contenedor-login">

                <?php if(isset($_SESSION["email"])): ?>

                    <form action="<?php echo htmlspecialchars("area-usuario.php")?>" method="POST" class="form-area-usuario">
                        <button name="logout" id="btn-logout"><i class="fas fa-power-off"></i> Logout</button>
                        <button id="btn-usuario"><i class="fas fa-user-cog"></i> Area usuario</button>
                    </form>

                    <?php else : ?>

                    <form action="<?php echo htmlspecialchars("login.php")?>" method="POST" class="form-login">
                        <button id="btn-login"><i class="fas fa-power-off"></i> Login</button>
                    </form>

                <?php endif; ?>     

            </div>
        </div>

        <input type='checkbox' id='icono-menu' name='icono-menu'>
        <label for='icono-menu' id='icono-men'><i class='fas fa-bars'></i></label>
    </div>

</div>

<nav>
    <div class='nav contenedor'>
        <ul>
            <li><a href='#'>Inicio</a></li>
            <li><a href='tienda.php'>Tienda</a></li>
            <li><a href='#'>Guardería</a></li>
            <li><a href='#'>Paseos</a></li>
            <li><a href='#'>Peluquería</a></li>
            <li><a href='#'>Compras</a></li>
            <li><a href='#'>Contacto</a></li>
        </ul>
    </div>
</nav>
<?php if (isset($_SESSION["administrador"])): ?>
        <div class="menu-administrador">
            <form action="<?php echo htmlspecialchars("administracion.php")?>" method="POST">
                <button name="administracion">Administracion</button>
            </form>
        </div>
<?php endif; ?>