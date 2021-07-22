<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
  include('Conexion.php');
  $link = conectar();
  $id_bodega = $_REQUEST['id_bodega'];
  $productos = array();
  $productos2 = array();

  $array=array();

  $query = mysqli_query($link, "call getProductosSucursal('$id_bodega')") or die(mysqli_error());
//$query = mysqli_query($link, "call getProductosSucursal(1)") or die(mysqli_error());
  $number = mysqli_num_rows($query);

  if($number > 0){
		while($row = mysqli_fetch_assoc($query)){
			$productos[]=$row;
		}
	}else{
		$productos[]=['0'];
	}
	header('Content-Type: application/json');
	//echo json_encode($productos);

$tama=count($productos);
$cont=0;
for($i=0;$i<$tama;$i++)
{
    $w1=$productos[$i]['idBodPro'];
    $w2=$productos[$i]['codigoBarras'];
    $w3=$productos[$i]['precioCompra'];
    $w4=$productos[$i]['precioSucursal'];
    $w5=$productos[$i]['precio'];
    $w6=$productos[$i]['nombreProducto'];
    $w7=$productos[$i]['descripcion'];
    $w8=$productos[$i]['detalleUnidadMedida'];
    $w9=$productos[$i]['id_producto'];

    $array[$cont]['idBodPro']=$w1;
    $array[$cont]['codigoBarras']=$w2;
    $array[$cont]['precioCompra']=$w3;
    $array[$cont]['precioSucursal']=$w4;
    $array[$cont]['precio']=$w5;
    $array[$cont]['nombreProducto']=$w6;
    $array[$cont]['descripcion']=$w7;
    $array[$cont]['detalleUnidadMedida']=$w8;
    $array[$cont]['id_producto']=$w9;

  $cont++;
}



mysqli_next_result($link);
$query = mysqli_query($link, "call getpromos55()") or die(mysqli_error());

$number = mysqli_num_rows($query);

if($number > 0){
  while($row = mysqli_fetch_assoc($query)){
    $productos2[]=$row;
  }
}else{
  $productos2[]=['0'];
}


$tama=count($productos2);

if($tama>0 && $productos2[0]['id_promocion']!="")
{
  for($i=0;$i<$tama;$i++)
  {
     $w1=$productos2[$i]['id_promocion'];
     $w2=$productos2[$i]['detalle_promocion'];
     $w3=$productos2[$i]['fotoPromocion'];
     $w4=$productos2[$i]['nombrePromocion'];
     $w5=$productos2[$i]['FechaInicio'];
     $w6=$productos2[$i]['FechaFin'];
     $w7=$productos2[$i]['PrecioPaquete'];
     $w8=$productos2[$i]['precioPaquetePV'];




     $array[$cont]['idBodPro']=(int)"10109".$w1;
     $array[$cont]['codigoBarras']="PP".$w1;
     $array[$cont]['precioCompra']=$w8;
     $array[$cont]['precioSucursal']=$w8;
     $array[$cont]['precio']=$w8;
     $array[$cont]['nombreProducto']='Paquete';
     $array[$cont]['descripcion']="Promoción PQT: ".$w4;
     $array[$cont]['detalleUnidadMedida']=$w2;

     $array[$cont]['id_producto']=0;
   $cont++;
  }

}



echo json_encode($array);

?>