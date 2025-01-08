<?php
use es\fdi\ucm\aw\Pedido;


require_once __DIR__.'/includes/config.php';


function listadoPedidos()
{
  $user = $_SESSION['userid'];
  $username = $_SESSION['nombre'];
  $html = '';
  $pedido= Pedido::getByUser($user);
  $counter = count($pedido);
  if($counter == 0){
    $html.=<<<EOF
    <div class="alert alert-info">
    <strong>Hola $username!</strong> Aun no tienes pedido nada, compra algo.
    </div>
    EOF;   
  }
  $html.=<<<EOF
  <ul class="list-group">
EOF;
if (is_array($pedido)){
  foreach($pedido as $p){
      $idPedido = $p->id();
      $idProd = $p->producto();
      $html.=<<<EOF
          <li class="list-group-item">
              <div class="d-flex flex-row">
                  <div class="p-2 m-3 flex-fill">
                      <p>Pedido nº: $idPedido</p>
                  </div>
                  <div class="p-2 m-3 flex-fill">
                      <p>Producto: $idProd</p>
                  </div>
                  <div class="d-flex flex-wrap align-content-center">
                  <form action="cancelaPedido.php" method="POST">
                  <button type="submit" class="btn btn-danger role="link" name="item" value="$idPedido">Cancelar</button>
                  </form>
                  </div>
          </li>     
EOF;
  }
  $html.=<<<EOF
  </ul>
EOF;
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
</head>

    <body>
    <?php
                require("includes/common/cabecera.php");
            ?>
        <div class="container mt-3">
            <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <h1 class="text-center">Pedidos del usuario</h1>
                    <?php
                        echo listadoPedidos();
                    ?>
                    </div>
                <div class="col-3"></div>
            </div>
        </div>  
    </body>
</html>




