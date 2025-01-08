<?php
use es\fdi\ucm\aw\Usuario;
use es\fdi\ucm\aw\Aplicacion;

require_once __DIR__.'/includes/config.php';

function muestraTodosUsuarios(){
$app = Aplicacion::getSingleton();
    if ($app->tieneRol('admin', 'Acceso Denegado', 'No tienes permisos suficientes para administrar la web.')) {
   $html = '';
   $users= Usuario::getAll();
   $html.=<<<EOF
  <ul class="list-group">
EOF;
if (is_array($users)){
  foreach($users as $u){
      $idUsuario = $u->id();
      $nombreUsuario= $u->nombreUsuario();
      $html.=<<<EOF
          <li class="list-group-item">
              <div class="d-flex flex-row">
                  <div class="p-2 m-3 flex-fill">
                      <p>Usuario: $nombreUsuario</p>
                  </div>
                  <div class="p-2">
                    <form action="eliminaUsuario.php" method="POST">
                    <button type="submit" class="btn btn-danger role="link" name="deleteUsr" value="$idUsuario">Eliminar usuario</button>
                    </form>
                    </div>
              </div>
          </li>     
EOF;
  }
  $html.=<<<EOF
    </ul>
EOF;
    }
    else{
    $html.="No existen usuarios";
        }
  return $html;
  }
}

?>


<html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Local Consiguelow</title>
    <link rel="icon" href="img/money.ico"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/caja.js"></script> 
</head>

    <body>
        <?php
            require("includes/common/cabecera.php");
        ?>
        <div class="row align-items-start">
        </div>
        <div class="row align-items-center">
            <div class="col-4">
            </div>
            <div class="col-4">
                <div class="m-3">
                <div class="alert alert-success text-center" role="alert">
            <strong>Usuarios de la web</strong>
            <?php
                echo muestraTodosUsuarios();
            ?>
                </div>
            </div>
            <div class="col-4">
            </div>
        </div>
        <div class="row align-items-end">
        </div>    
    </body>
</html>