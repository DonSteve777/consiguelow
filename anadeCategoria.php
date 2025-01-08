<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\FormularioCategoria;
$form = new FormularioCategoria();
$html = $form->gestiona();
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
<div class="row">
    <div class="col-4">
    </div>
    <div class="col-4">
        <div class="d-flex flex-column bg-light m-3">
            <h1 class="m-2">Añadir categoria</h1>
            <?php
                echo $html;
            ?>
        </div>
    </div>
    <div class="col-4">
    </div>
</div>  
    </body>
</html>