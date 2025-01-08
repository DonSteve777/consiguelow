<?php
use es\fdi\ucm\aw\Producto;


require_once __DIR__.'/includes/config.php';

function muestraProdsUsuario(){
  $idUsuario = $_SESSION['userid'];
  $html = '';
  $productoUser= Producto::getByUser($idUsuario);
  if(is_array($productoUser)){
  foreach($productoUser as $pu){
    $html.=$pu->generaTarjeta();
    }
  }
 return $html;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Local Consiguelow</title>
    <link rel="icon" href="img/money.ico"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/productoDetalle.js"></script> 
</head>

    <body>
    <?php
                require("includes/common/cabecera.php");
            ?>
        <div class="container mt-3">
            <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <h1 class="text-center">Productos subidos por el usuario</h1>
                    <?php
                        echo muestraProdsUsuario();
                    ?>
                    </div>
                <div class="col-3"></div>
            </div>
        </div>  
    </body>
</html>