<?php 
    include ('../include/customer.php');
    
    /** $pagina: */
    $pagina=(isset($_GET['pagina']))? $_GET['pagina']:0;
    /** $registros: Registres  a mostrar. */
    $registros =15;
    
    $customer= new customer();
    $arrCustomers= $customer->pagination($pagina,$registros);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Superstore: Clientes</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
	<h1>SUPERSTORE</h1>
	<a href="/">Volver</a>
	<h2>Gestión de Clientes</h2>
	<div><a href="new_customers.php">Nuevo cliente<i class="fa fa-plus"></i></a></div>
	<div class="pagination-box">
	<?php 
	   $customer->getLinks();
	?>
	</div>
	<div class="table-box">
		<table>
			<thead>
    			<tr>
    				<th>#</th>
    				<th>Cod.</th>
    				<th>Nombre</th>
    				<th>Segment</th>
    				<th>city</th>
    				<th>state</th>
    				<th>country</th>
    				<th>region</th>
    				<th></th>
    				<th></th>
    			</tr>
			</thead>
			<tbody>
    	<?php 
    	foreach($arrCustomers as $row){
    	    echo "<tr>";
    	    echo "<td>{$row['id']}</td>";
    	    echo "<td>{$row['code']}</td>";
    	    echo "<td>{$row['name']}</td>";
    	    echo "<td>{$row['segment']}</td>";
    	    echo "<td>{$row['city']}</td>";
    	    echo "<td>{$row['state']}</td>";
    	    echo "<td>{$row['country']}</td>";
    	    echo "<td>{$row['region']}</td>";
    	    echo "<td><a href=\"edit_customers.php?id={$row['id']}\"><i class=\"fa fa-edit\"></i></a></td>";
    	    echo "<td><a href=\"delete_customers.php?id={$row['id']}\"><i class=\"fa fa-trash\"></i></a></td>";
    	    echo "</tr>";
    	}
    	?></tbody>
    	</table>
    	
	</div>
	<?php 
	$customer2= new customer('xml');
	$xmlCustomer= $customer2->get(1);
	var_dump($xmlCustomer);
	?>
</body>
</html>