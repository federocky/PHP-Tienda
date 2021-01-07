<?php 


include("conexion.php");

session_start();
$registrado = true;
$errores = [];
$email = "";
$password = "";

/**
 * Compruebo si el usuario esta registrado, entendemos que si, a menos que
 * se pulse en el boton registrate que es cuando recibiremos por get registrado
 * = false;
 */
if(isset($_GET["registrado"])) {
    if($_GET["registrado"] == false ) $registrado = false;
}
if(isset($_POST["registrado"])) {
    $registrado = false;
} 

if(isset($_SESSION["email"])){
    $email = $_SESSION["email"];
}



/**
 * Si se pulsa el boton iniciar sesion realizamos las validaciones comprobamos en la BBDD
 * y damos la respuesta.
 */
if(isset($_POST["iniciar-sesion"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    
    //validacion
    if(empty($_POST["email"]) || empty($_POST["password"])) $errores["vacio"] = "<span style='color:red'>Debe rellenar ambos campos</span>";

    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) $errores["email"] = "<span style='color:red'>Debe introducir un email válido</span>";
    else $email = $_POST["email"];

    if(strlen($_POST["password"]) <= 8) $errores["password"] = "<span style='color:red'>La contraseña debe ser mayor de 8 caracteres</span>";
    else $password = $_POST["password"];


    if(empty($errores)){

        //compruebo si es un empleado
        $consulta_administrador = $conexion->query("SELECT * FROM empleado WHERE email = '$email'");

        if($row = $consulta_administrador->fetch_object()) {
            //aqui habria que tener empleado normal y administrador pero lo dejamos asi para esta practica
            
                if($row->activo == 0){
                    $inactivo = "<span style='color:red'>Esta cuenta ha sido dada de baja, para reactivarla escribanos a: loArregloEnseguida@gmail.com</span>";
                }else {

                    //TODO: implementar password verify cuando tenga el CRUD de empleado
                    if($password == $row->contrasenia) {
                        $_SESSION["email"] = $email;
                        $_SESSION["nombre"] = $row->nombre;
                        $_SESSION["administrador"] = true;
                        
                        header("location: tienda.php");
                        
                    } 
                }

            

        //si no es un empleado es un cliente o nada    
        } else {

            $consulta = $conexion->query("SELECT * FROM cliente WHERE email = '$email'");

            if($row = $consulta->fetch_object()) {
                //comprobamos si la cuenta esta de alta
                if($row->activo == 0){
                    $inactivo = "<span style='color:red'>Esta cuenta ha sido dada de baja, para reactivarla escribanos a: loArregloEnseguida@gmail.com</span>";
                }else {

                    //si todo esta bien verificamos el password
                    if(password_verify($password, $row->contrasenia)) {
                        $_SESSION["email"] = $email;
                        $_SESSION["nombre"] = $row->nombre;
                        
                        header("location: tienda.php");
                        
                    } 
                }

            } else {
                $emailInexistente = "<span style='color:red'>No esta registrado en el sistema</span>";
            }
        
        }

    }
}


/**
 * Si se pulsa en registrarse realizamos las validaciones y en caso positivo
 * guardamos en la BBDD y mandamos al login.
 */
if(isset($_POST["registrarse"])){
    $nombre = "";
    $apellidos = "";
    $privacidad = false;

    //validamos el nombre
    if(isset($_POST["nombre"])  && !empty($_POST["nombre"])) $nombre = $_POST["nombre"];
    else $errores["nombre"] = "<span style='color:red'>Debe introducir un nombre</span>";

    //validamos el apellido
    if(isset($_POST["apellidos"])  && !empty($_POST["apellidos"])) $apellidos = $_POST["apellidos"];
    else $errores["apellido"] = "<span style='color:red'>Debe introducir un apellido</span>";

    //validamos el email.
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) $errores["email"] = "<span style='color:red'>Debe introducir un email válido</span>";
    else $email = $_POST["email"];

    //validamos las contraseñas
    if(strlen($_POST["password"]) <= 8) $errores["password"] = "<span style='color:red'>La contraseña debe ser mayor de 8 caracteres</span>";
    if($_POST["password"] != $_POST["repPassword"]) $errores["password"] = "<span style='color:red'>Las contraseñas no coinciden</span>";
    else $password = $_POST["password"];

    //comprobamos la privacidad
    if(isset($_POST["privacidad"]) && $_POST["privacidad"] == 1)  $privacidad = true;
    else $errores["privacidad"] = "<span style='color:red'>Debe aceptar la politica de privacidad</span>";
    


    if(empty($errores)){

        //variable para mostrar error por pantalla
        $emailExiste = "";

        $consulta = $conexion->query("SELECT * FROM cliente WHERE email = '$email'");

        //si ya tengo el email en la BBDD
        if($consulta->num_rows != 0) {
            $emailExiste = "<span style='color:red'>El email introducido ya esta siendo utilizado</span>";
            
        //si no lo tengo
        } else {
            $passwordCifrado = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $consulta = $conexion->query("INSERT INTO cliente (nombre, apellidos, email, contrasenia) VALUES ('$nombre', '$apellidos', '$email', '$passwordCifrado')");
            if($consulta) {
                $_SESSION["email"] = $email;
                header("location: login.php");

            } else {

            }

        }

    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos-header-menu2.css">
    <link rel="stylesheet" href="css/estilos-footer2.css">
   
    <link rel="stylesheet" href="css/formulario.css">
    <title>Mimascota.com</title>
</head>
<body>
    <header>
        <?= include("header-nav.php");  ?>
    </header>

    <main>

        <div class="container">
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                
                <?php if($registrado): ?>
                    <h2>Inicia sesión</h2>
                    <label for="email">Email:</label> <?= isset($errores["email"]) ? $errores["email"] : "" ?>
                    <input type="text" name="email" value="<?= isset($email) ? $email : "" ?>">

                    <label for="password">Contraseña:</label> <?= isset($errores["password"]) ? $errores["password"] : "" ?>
                    <input type="password" name="password">

                    <?= isset($errores["vacio"]) ? $errores["vacio"] : "" ?>
                    <?= isset($emailInexistente) ? $emailInexistente : "" ?>
                    
                    <?= isset($inactivo) ? $inactivo : "" ?>
                    <input type="submit" name="iniciar-sesion" value="Inicia Sesión">
                    <p>¿No tienes cuenta? <a href="<?= $_SERVER["PHP_SELF"] ?>?registrado= <?= (false)?>">Registrate</a></p>

                <?php else :?>
                    <h2>Registrate</h2>
                    <label for='nombre'>Nombre:</label> <?= isset($errores["nombre"]) ? $errores["nombre"] : "" ?>
                    <input type='text' name='nombre' value="<?= isset($nombre) ? $nombre : "" ?>">
                    

                    <label for='apellidos'>Apellidos:</label> <?= isset($errores["apellido"]) ? $errores["apellido"] : "" ?>
                    <input type='text' name='apellidos' value="<?= isset($apellidos) ? $apellidos : "" ?>">

                    <label for='email'>Email:</label> <?= isset($errores["email"]) ? $errores["email"] : "" ?>
                    <input type='text' name='email' value="<?= isset($email) ? $email : "" ?>">

                    <label for='password'>Contraseña:</label> <?= isset($errores["password"]) ? $errores["password"] : "" ?>
                    <input type='text' name='password' value="<?= !isset($errores["password"]) ? $password : "" ?>" >

                    <label for='repPassword'>Repetir contraseña:</label>
                    <input type='text' name='repPassword' value="<?= !isset($errores["password"]) ? $password : "" ?>">

                    <label for='privacidad'> 
                    <input type='checkbox' name='privacidad' value="1" <?php  if(isset($privacidad) && $privacidad) echo "checked"; ?>>Acepto la politica de privacidad.
                    </label>
                    <?= isset($errores["privacidad"]) ? $errores["privacidad"] : "" ?>
                    <?= isset($emailExiste) ? $emailExiste : "" ?>

                    <input type="hidden" name="registrado" value="false">

                    <?= isset($errores["vacio"]) ? $errores["vacio"] : "" ?>

                    <input type='submit' name='registrarse' value="Registrarse">   
                    <p>¿Tienes cuenta? <a href="<?= $_SERVER["PHP_SELF"] ?>?registrado= <?= (true)?>">Login</a></p>
                <?php endif; ?>
                
            </form>
        </div>

    </main>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>