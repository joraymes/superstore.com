<?php 
    include('../include/order.php');
    include('../include/orderproduct.php');
    
    $id       = (isset($_POST['id']))       ? $_POST['id']        : '' ;
    if($id==''){ header('Location:new_orders.php'); exit; }
    
    $code       = (isset($_POST['code']))       ? $_POST['code']        : '' ;
    if($code==''){ header('Location:new_orders.php'); exit; }
    
    $orderDate  = (isset($_POST['orderDate']))  ? $_POST['orderDate']   : '' ;
    if($orderDate==''){ header('Location:new_orders.php'); exit; }
    
    $shipDate   = (isset($_POST['shipDate']))   ? $_POST['shipDate']    : '' ;
    if($shipDate==''){ header('Location:new_orders.php'); exit; }
    
    $shipMode   = (isset($_POST['shipMode']))   ? $_POST['shipMode']    : '' ;
    if($shipDate==''){ header('Location:new_orders.php'); exit; }
    
    $id_customers = (isset($_POST['id_customers'])) ? $_POST['id_customers'] : '' ;
    if($id_customers==''){ header('Location:new_orders.php'); exit; }
    // ------ Lista de productos, sales, quantity , discount y profit ------------
    $id_products    = (isset($_POST['id_products']))?   $_POST['id_products']   : '' ;
    $sales          = (isset($_POST['sales']))?         $_POST['sales']         : '' ;
    $quantity       = (isset($_POST['quantity']))?      $_POST['quantity']      : '' ;
    $discount       = (isset($_POST['discount']))?      $_POST['discount']      : '' ;
    $profit         = (isset($_POST['profit']))?        $_POST['profit']        : '' ;
    // --------------- inserción de tbl_orders 
    $data= array(
        
        'code'          => $code,
        'orderDate'     => $orderDate,
        'shipDate'      => $shipDate,
        'shipMode'      => $shipMode,
        'id_customers'  => $id_customers
    );
    $order= new order();
    $arrOrder=$order->update($id,$data);
    $arrLiniasProducto=array();
    $orderproduct= new orderproduct();
    
    // ------- Eliminamos los datos prèvios de la table tbl_orders_products  -----------
    $arrOrderProducts = $orderproduct->getProducts($id);
    foreach($arrOrderProducts as $liniaProducto){
        var_dump( $orderproduct->delete($liniaProducto['id']));  
    }
    
    // ----------Inserción  nuevos datos tbl_orders_products -----------
    for($k=0; $k < count($id_products); $k++){
        $data= array(
            'id_orders'     => $id ,
            'id_products'   => $id_products[$k],
            'sales'         => $sales[$k],
            'quantity'      => $quantity[$k],
            'discount'      => $discount[$k],
            'profit'        => $profit[$k]
        );
        $arrLiniasProducto[]=$orderproduct->insert($data);
    }
    //header('Refresh:5;url=index.php');
    print_r($arrLiniasProducto);
?>
<div>Pedido actualizado correctamente !!</div>
<a href="index.php">Volver</a>