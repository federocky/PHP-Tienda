<?php 

   
$calle = "";
$provincia = "";
$ciudad = "";
$cp = "";
$numero = "";
$escalera = "";
$piso = "";
$puerta = "";

$errores= [];



// la validacón de ciudad y provincia podria estar mejor con un select, pero nos conformamos con que no este vacía
if(  preg_match("/\d{5}/",$_POST["codigo_postal"] )) $cp = $_POST["codigo_postal"];
else $errores["codigo"] = "<span style='color: red'>Debe ingresar un codigo postal válido, 5 numeros</span>";

if(!empty($_POST["ciudad"])) $ciudad = $_POST["ciudad"];
else $errores["ciudad"] = "<span style='color: red'>Debe ingresar alguna ciudad válido</span>";

if(!empty($_POST["provincia"])) $provincia = $_POST["provincia"];
else $errores["provincia"] = "<span style='color: red'>Debe ingresar alguna provincia válido</span>";

if(!empty($_POST["calle"])) $calle = $_POST["calle"];
else $errores["calle"] = "<span style='color: red'>Debe ingresar alguna calle válido</span>";



?>