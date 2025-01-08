<?php namespace es\fdi\ucm\aw;

class Producto
{
 
public static function getById($id){
    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM productos U WHERE U.id = '%d'", $conn->real_escape_string($id));
    $rs = $conn->query($query);
    $prod = NULL;
    if (!$id){
        echo "product id no puede ser nulo";
        exit();
    }
    if ($rs) {
        if ( $rs->num_rows == 1) {
            $fila = $rs->fetch_assoc();
            $prod=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria'],  $fila['id']);
            
        }else {
            echo "No encuentro productos con id ". $id;
            exit();
        }
        $rs->free();
    } else {
        echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    }
    return $prod;
}

public static function getAliens(){
    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();
    $currentuser=0;
    $result = [];
    /*para que a un usuario no le aparezcan sus propios productos*/
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $currentuser= $_SESSION['userid'];
    }
    $query = sprintf("SELECT * FROM productos P WHERE NOT idVendedor=%d", $conn->real_escape_string($currentuser));
    $rs = $conn->query($query);
    if ($rs) {
        if ( $rs->num_rows > 0) {
            while($fila = $rs->fetch_assoc()) {
                $result[]=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria'],  $fila['id']);
            }
            $rs->free();
        } else {
            $result = 'No se ha cargado ningún producto';
        } 
    }else{
        echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    } 
    return $result;
}

public static function getAllProds(){ //funcion para ver todos los productos de la web
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM productos P");
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            if ( $rs->num_rows > 0) {
                while($fila = $rs->fetch_assoc()) {
                    $result[]=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria'],  $fila['id']);

                }
                $rs->free();
            } else {
                echo 'No se ha cargado ningún producto';
                exit();
            } 
        }else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        } 
        return $result;
}

public static function getByUser($idUsuario){ 
    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM productos P WHERE P.idVendedor =%d", $conn->real_escape_string($idUsuario));
    $rs = $conn->query($query);
    if (!$idUsuario){
        echo "user id no puede ser nulo";
        exit();
    }
    if ($rs) {
        if ( $rs->num_rows > 0) {
            while($fila = $rs->fetch_assoc()) {
                $result[]=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria'],  $fila['id']);
            }
            $rs->free();
        } else {
            echo 'No encuentro productos del usuario';
            exit();
        } 
    }else{
        echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        exit();
    } 
    return $result;
}

    public static function getByName($nombreProd)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM productos P WHERE P.nombre LIKE '%s%%'", $conn->real_escape_string($nombreProd));
        $rs = $conn->query($query);
        $result = [];
        if (!$nombreProd){
            echo "nombre producto no puede ser nulo";
            exit();
        }
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $prod=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria']);
                $prod->id = $fila['id'];
                $result[] = $prod;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    public static function eliminaByName($nombreProd){
        if (!$nombreProd){
            echo "nombre producto no puede ser nulo";
            exit();
        }
        
        $prod = self::getByName($nombreProd); 
        if (!$prod) {
            echo "No encuentro producto ".$nombreProd." para eliminarlo";
            exit();
        }
        else{ 
            return self::elimina($prod); 
        }
    }

    public static function eliminaById($idProd){
        if (!$idProd){
            echo "producto no puede ser nulo";
            exit();
        }
        $prod = self::getById($idProd); 
        if (!$prod) {
            echo "No encuentro producto para eliminarlo";
            exit();
        }
        else{ 
            return self::elimina($prod); 
        }
    }

    private static function elimina($prod)
    {
        $eliminado = false;
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $id = $prod->id; 
        $query=sprintf("DELETE FROM productos WHERE id ='%d'",$conn->real_escape_string($id));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido borrar la categoria: " . $prod->nombre;
                exit();
            }
            elseif ($conn->affected_rows == 1){
                echo "Producto . $prod->nombre . borrado";
                $eliminado =true;
            }
        } else {
            echo "Error al borrar de la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $eliminado;
    }

public static function search($name){
    $html = '';
    $prod = self::getByName($name);
    $html=self::generaBusqueda($prod);
    return $html;
}

public static function generaBusqueda($prod){
    $html = '';
    if ($prod!==NULL){
        $precio = $prod->precio();
    $id = $prod->id();
    $imgSrc = ImageUpload::getSource($id);
    $html .= self::cardProduct($precio, $imgSrc, $id); 
    }
    else{
        $html=<<<EOF
        <p>No coincide ningún producto</p>
EOF;
    }
    return $html;
}
//aparece en index y en categoría. genera el html para un producto con su foto y su precio
public function generaTarjeta(){ 
    $html = '';
    $htmlimg = '';
    $imgSrc = ImageUpload::getSource($this->id);
    $precio = $this->precio();
    $html .=<<<EOF
                    <div class="col-md-4">
                        <div class="card mb-4 text-center bg-light border-0">
                            <div class="card-img-top">       
EOF;
    if($imgSrc){
        $html.=<<<EOF
                                <a href="productoDetalle.php?id=$this->id">
                                    <img class="img-thumbnail" src=$imgSrc alt="imagen no disponible">
                                </a>
EOF;
    }else{
        $html.=<<<EOF
                                <a href="productoDetalle.php?id=$this->id">
                                    <p>Imagen no disponible para este producto</p>
                                </a>
EOF;    }
$html .=<<<EOF
                            </div>
                            <div class="card-body justify-content-end"> 
                                $precio €
                            </div>
                        </div>
                    </div>
EOF;
    
    return $html;
}
    public static function getByCat($idCat){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $encontrado = false;
        $idVendedor = (isset($_SESSION['userid'])) ? $_SESSION['userid'] : 0;
        $result = [];
        $query = sprintf("SELECT * FROM productos P WHERE P.categoria = '%d' AND NOT P.idVendedor='%d'",
        $conn->real_escape_string($idCat),
        $conn->real_escape_string($idVendedor));

        $rs = $conn->query($query);
        if ($rs) {
            if ( $rs->num_rows > 0) {
                while($fila = $rs->fetch_assoc()) {
                    $result[]=new Producto($fila['nombre'], $fila['idVendedor'], $fila['descripcion'], $fila['precio'], $fila['unidades'],$fila['talla'],$fila['categoria'],  $fila['id']);
                }
                $rs->free();
            } else {
                $result =  'No se ha cargado ningún producto';
            } 
        }else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        } 
        return $result;
    }

    public static function muestraProductosPorPrecioDesc($producto)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM productos P ORDER BY P.precio DESC"); $conn->real_escape_string($producto);
        $rs = $conn->query($query);
        $result = false;
        $i=0;
        if ($rs) {
            if ( $rs->num_rows > 0) {
                while ($array=$rs->fetch_array()){
                $claves = array_keys($array);
                foreach($claves as $clave){
                    $arrayauxliar[$i][$clave]=$array[$clave];
                }           
                $i++;
                $prod = $arrayauxliar;
                $result = $prod;
                }
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function añadeProd($nombreProd, $vendedor, $descripcion, $precio,$unidades,$talla,$categoria) //atributos productos
    {
        $producto = self::getByName($nombreProd);
        if ($producto) {
            return false;
        }
        $producto = new Producto($nombreProd, $vendedor, $descripcion, $precio,$unidades, $talla, $categoria);
        return self::guarda($producto);
    }
    
    public static function guarda($producto)
    {
        if ($producto->id !== null) {
            return self::actualiza($producto);
        }
        return self::inserta($producto);
    }

    private static function inserta($producto)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO `productos`  (`nombre`, `idVendedor`, `descripcion`,`precio`,`unidades`, `talla`, `categoria`) 
		 VALUES('%s','%d', '%s', '%f', '%d', '%d', '%s')"
            , $conn->real_escape_string($producto->nombre)
            , $conn->real_escape_string($producto->vendedor)
            , $conn->real_escape_string($producto->descripcion)
            , $conn->real_escape_string($producto->precio)
            , $conn->real_escape_string($producto->unidades)
			, $conn->real_escape_string($producto->talla)
			, $conn->real_escape_string($producto->categoria));

        if ( $conn->query($query) ) {
            $producto->id = $conn->insert_id;
     
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $producto;
    }
    
    private static function actualiza($producto)
    {
        $actualizado = false;
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE `productos` P SET nombre = '%s',idVendedor = '%d', descripcion='%s', precio='%f', unidades='%d', talla ='%d', categoria ='%s' WHERE P.id='%d'"
        , $conn->real_escape_string($producto->id)
        , $conn->real_escape_string($producto->nombre)
        , $conn->real_escape_string($producto->vendedor)
        , $conn->real_escape_string($producto->descripcion)
        , $conn->real_escape_string($producto->precio)
        , $conn->real_escape_string($producto->unidades)
        , $conn->real_escape_string($producto->talla)
        , $conn->real_escape_string($producto->categoria));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el producto: " . $producto->id;
                exit();
            }
            elseif($conn->affected_rows == 1){
                $actualizado = true;
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $actualizado;
    }

    
	//filas tabla productos
    private $id;

    private $nombre;

    private $vendedor;

    private $descripcion;

    private $precio;
	
    private $talla;
		
    private $categoria;

    private $unidades;

    private function __construct($nombreProd, $vendedor, $descripcion, $precio,$unidades, $talla, $categoria, $id = NULL)
    {
        $this->id = $id;
        $this->nombre = $nombreProd;
        $this->vendedor = $vendedor;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->unidades = $unidades;
        $this->talla = $talla;
		$this->categoria= $categoria;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombre;
    }
    
    public function vendedor()
    {
        return $this->vendedor;
    }

	public function descripcion()
    {
        return $this->descripcion;
    }

	public function unidades()
    {
        return $this->unidades;
    }
    public function precio()
    {
        return $this->precio;
    }

    public function talla()
    {
        return $this->talla;
    }
    
    public function categoria()
    {
        return $this->categoria;
    }



}