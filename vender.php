<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\FormularioVender;


$html='';
if(!isset($_SESSION['login'])){
    $html=<<<EOF
    <div class="alert alert-info" role="alert">
            No has iniciado sesión, inicia sesión </br>
            <center><a href="login.php">Login<a/><center>
    </div>
EOF;
}
else{
    $form = new FormularioVender(); 
    $html = $form->gestiona();
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
        <div class="container-fluid bg-light">
            <div class="row">
                <div class="col-md-4 col-12">
                </div>
                <div class="col-md-4 col-12">
                    <div class="d-flex flex-column bg-light mt-3">
                        <h1 class="m-2">Subir un producto</h1>
                        <?php echo $html; ?>
                        <?php require("includes/common/footer.php"); ?>
                    </div>
                </div>
                <div class="col-md-4 col-12">
            </div>
        </div>
        
    </body>
</html>