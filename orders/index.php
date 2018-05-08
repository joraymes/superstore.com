<?php 
    include ('../include/order.php');
    
    /** $pagina: */
    $pagina=(isset($_GET['pagina']))? $_GET['pagina']:0;
    /** $registros: Registres  a mostrar. */
    $registros =15;
    
    $order= new order();
    $arrOrders= $order->pagination($pagina,$registros);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Superstore: Pedidos</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
	<h1>SUPERSTORE</h1>
	<a href="/">Volver</a>
	<h2>Gestión de Pedidos</h2>
	<div><a href="new_orders.php">Nuevo Pedido <i class="fa fa-plus"></i></a></div>
	<div class="pagination-box">
	<?php 
	   $order->getLinks();
	?>
	</div>
	<div class="table-box">
		<table>
			<thead>
    			<tr>
    				<th>#</th>
    				<th>Cod.</th>
    				<th>Fecha</th>
    				<th>Fecha envio</th>
    				<th>Mètodo envio</th>
    				<th>Cliente</th>
    				<th></th>
    				<th></th>
    			</tr>
			</thead>
			<tbody>
    	<?php 
    	foreach($arrOrders as $row){
    	    echo "<tr>";
    	    echo "<td>{$row['id']}</td>";
    	    echo "<td>{$row['code']}</td>";
    	    echo "<td>{$row['orderDate']}</td>";
    	    echo "<td>{$row['shipDate']}</td>";
    	    echo "<td>{$row['shipMode']}</td>";
    	    echo "<td>{$row['name']} : {$row['clientcode']}</td>";
    	    echo "<td><a href=\"edit_orders.php?id={$row['id']}\"><i class=\"fa fa-edit\"></i></a></td>";
    	    echo "<td><a href=\"edit_orders.php?id={$row['id']}\"><i class=\"fa fa-trash\"></i></a></td>";
    	    echo "</tr>";
    	}
    	?></tbody>
    	</table>
    	
	</div>
	
</body>
</html>