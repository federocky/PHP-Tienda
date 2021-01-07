<?php 

    $ordenarPor = "";
    $limiteInferior = 0;
    $limitar = 12;
    $buscar = "";
    $imprimirBuscar = "";
    

    if(isset($_REQUEST["filtrar"]) || isset($_REQUEST["anterior"]) ||isset($_REQUEST["siguiente"])) {

        $consulta = $conexion->query("SELECT * FROM producto");
        $cantidadArticulos = $consulta->num_rows;

        if($_POST["ordenar"] != "orden") {
            switch ($_POST["ordenar"]) {
                case 'precio-asc':
                    $ordenarPor = 'ORDER BY precio asc';
                    break;

                case 'precio-desc':
                    $ordenarPor = 'ORDER BY precio desc';
                    break;   
                
                case 'nombre':
                    $ordenarPor = 'ORDER BY nombre';
                    break;
            }
        }

        if($_POST["por-pagina"] != 12) {
            $limitar = $_POST["por-pagina"];
        }


        if(isset($_POST["siguiente"])){

            $limiteInferior = $_POST["siguiente"];
            if($limiteInferior + $limitar < $cantidadArticulos) $limiteInferior += $limitar;

        }else if (isset($_POST["anterior"])) {

            $limiteInferior = $_POST["anterior"];
            if ($limiteInferior > 0) $limiteInferior -= $limitar;

        }  

        

        $consulta = $conexion->query("SELECT * FROM producto $ordenarPor LIMIT $limiteInferior ,$limitar");
        

    }


    if(isset($_POST["buscar"]) && $_SERVER["REQUEST_METHOD"] == "POST") {


        if(!empty($_POST["palabra"])){
            $imprimirBuscar = $_POST["palabra"];
            $buscar = "LIKE '%".$_POST["palabra"]."%'";
        }

        

        $consulta = $conexion->query("SELECT * FROM producto WHERE nombre $buscar");
    }


?>



<section class="filtro">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" class="form_buscar">
        <input type="search" placeholder="busca tus productos..." name="palabra" value="<?= $imprimirBuscar ?>"> <input type="submit" name="buscar" value="Buscar">
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" class="form_filtrar">
        <select name="ordenar" >
            <option value="orden">Ordenar por...</option>
            <option value="precio-asc" <?= $ordenarPor == 'ORDER BY precio asc' ? "selected" : "" ?>>Precio ascendente</option>
            <option value="precio-desc" <?= $ordenarPor == 'ORDER BY precio desc' ? "selected" : "" ?>>Precio descendente</option>
            <option value="nombre" <?= $ordenarPor == 'ORDER BY nombre' ? "selected" : "" ?>>Nombre</option>
        </select>

        <label for="por-pagina"><p>Articulos por página:</p></label>
        <select name="por-pagina">Cantidad por pagina:
            <option value="12">12</option>
            <option value="4" <?= $limitar == 4 ? "selected" : "" ?>>4</option>
            <option value="8" <?= $limitar == 8 ? "selected" : "" ?>>8</option>
        </select>

        <input type="submit" name="filtrar" value="filtrar">

        <?php if($limitar != 12): ?>
            <button class="paginacion" name="anterior" value="<?=$limiteInferior?>">Anterior</button>
            <button class="paginacion" name="siguiente" value="<?=$limiteInferior?>">Siguiente</button>
        <?php endif; ?>

        
    </form>

</section>