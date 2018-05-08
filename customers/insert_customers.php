<?php 

    include('../include/customer.php');
    
    $code       = (isset($_POST['code']))       ? $_POST['code']        : '' ;
    $name       = (isset($_POST['name']))       ? $_POST['name']        : '' ;
    $segment    = (isset($_POST['segment']))    ? $_POST['segment']     : '' ;
    $id_cities  = (isset($_POST['id_cities']))  ? $_POST['id_cities']   :  0 ;
    $customer= new customer();
    
    $data = array(
        'code' => $code,
        'name' => $name,
        'segment' => $segment,
        'id_cities' => $id_cities
        
    );
    
    $arrCustomer=$customer->insert($data);
    
    header('Refresh:5;url=index.php');
?>
<div>Cliente creado correctamente !!</div>
<a href="index.php">Volver</a>