<h1>Introduzca su direccion</h1>

                <h4>Calle:</h4> <?= isset($errores["calle"]) ? $errores["calle"] : "" ?>
                <input type="text" name="calle" value="<?= isset($calle) ? $calle : "" ?>">

                <h4>Provincia:</h4> <?= isset($errores["provincia"]) ? $errores["provincia"] : "" ?>
                <input type="text" name="provincia" value="<?= isset($provincia) ? $provincia : "" ?>">

                <h4>Ciudad:</h4> <?= isset($errores["ciudad"]) ? $errores["ciudad"] : "" ?>
                <input type="text" name="ciudad" value="<?= isset($ciudad) ? $ciudad : "" ?>">

                <h4>CP:</h4> <?= isset($errores["codigo"]) ? $errores["codigo"] : "" ?>
                <input type="text" name="codigo_postal" value="<?= isset($cp) ? $cp : "" ?>">

                <h4>Número:</h4>
                <input type="text" name="numero">

                <h4>Escalera:</h4>
                <input type="text" name="escalera">

                <h4>Piso:</h4>
                <input type="text" name="piso">

                <h4>Puerta:</h4>
                <input type="text" name="puerta">


                <button name="guardar_direccion">Enviar datos</button>
                <input type="reset">
                
            
        