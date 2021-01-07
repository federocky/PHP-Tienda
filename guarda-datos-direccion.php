<?php 

 //Primero necesitamos el id del cliente que conseguimos con su email.
 $consulta_id = $conexion->query("SELECT id FROM cliente WHERE email = '$email'");
 $row = $consulta_id->fetch_object();
 $id_cliente = $row->id;
 $consulta_id->close();

 $calle = $_POST["calle"];
 $provincia = $_POST["provincia"];
 $ciudad = $_POST["ciudad"];
 $cp = $_POST["codigo_postal"];
 $escalera = $_POST["escalera"];
 $piso = $_POST["piso"];
 $puerta = $_POST["puerta"];



?>