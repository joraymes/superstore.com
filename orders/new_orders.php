<?php 
    include('../include/customer.php');
    include('../include/product.php');
    
    $customer= new customer();
    $arrCustomers= $customer->getAll();  
    
    $product= new product();
    $arrProducts= $product->getAll();
?>
<!DOCTYPE>
<html lang="es">
<head>
	<title>Superstore, Gestión de pedidos: Nuevo pedido</title>
	<link rel="stylesheet" href="/css/estilos.css" />
	<script src="/js/validaform.js"></script>
	<script type="text/javascript">
	/* Rutina de clonación de Fila */
	function addRow(objButton){
		var objFieldSet= document.getElementById('panel');
		var objChild= objFieldSet.lastElementChild;
		var newObj = objChild.cloneNode(true);

		// inicializar los campos SELECT del Nodo clonado
		var arrSelect = newObj.getElementsByTagName("SELECT");
		for(var node=0; node<=arrSelect.length-1; node++ ){
			arrSelect[node].selectedIndex=0;
			
		}
		
		document.getElementById('panel').appendChild(newObj);
		objButton.nextElementSibling.disabled=false;
	}

	function delRow(objButton){
		if(document.getElementById('panel').childElementCount>3){
		 document.getElementById('panel').removeChild(document.getElementById('panel').lastElementChild);
		 if(document.getElementById('panel').childElementCount==3){
			 objButton.disabled = true;
		 }
		}else{
			objButton.disabled = true;
		}
	}

	</script>
</head>
<body>
	<a href="/orders">Volver</a>
	<div class="form-box">
	<form action="insert_orders.php" method="post" onsubmit="return validaform(this,'sibling','es','/js/validaform.xml')" >
		<fieldset>
			<legend>Datos del pedido</legend>
			<div>
				<label>Código:</label>
				<input class="txt-obl" type="text" name="code" value=""> 
			</div>
			<div>
				<label>Fecha pedido:</label>
				<input class="txt-obl" type="date" name="orderDate" value=""> 
			</div>
			<div>
				<label>Fecha envío:</label>
				<input class="txt-obl" type="date" name="shipDate" value=""> 
			</div>
			<div>
				<label>Mètodo envío:</label>
				<select class="sel-obl" name="shipMode">
					<option value="">-- Elija una opción --</option>
					<option value="First Class">First Class</option>
					<option value="Second Class">Second Class</option>
					<option value="Standard Class">Standard Class</option>
				</select> 
			</div>
			<div>
				<label>Cliente</label>
				<select class="sol-obl" name="id_customers">
					<option value="">-- Elija una opción --</option>
					<?php 
					foreach ($arrCustomers as $row){
					    echo "<option value=\"{$row['id']}\">{$row['code']} {$row['name']}</option>";
					}
					?>
				</select> 
			</div>
		</fieldset>
		<fieldset id="panel">
			<legend>Productos</legend>
			<div>
    			<table>
    				<tr>
    					<td class="big"><label>Producto</label></td>
    					<td class="normal"><label>Sales</label> </td>
    					<td class="normal"><label>Quantity</label></td>
    					<td class="normal"><label>Discount</label></td>
    					<td class="normal"><label>Profit</label></td>
    					<td class="controls">
    						<input type="button" value="+" onclick="addRow(this)" > 
    						<input type="button" value="-" onclick="delRow(this)" disabled  >
    					</td>
    				</tr>
    			</table>
			</div>
		    <div>
				<table>
					<tr>
						<td class="big">
							<select class="sel-obl"  name="id_products[]">
        						<option value="">-- Elija una opción --</option>
        						<?php 
        						foreach($arrProducts as $row){
        						   echo "<option value=\"{$row['id']}\">{$row['code']} {$row['name']}</option>";
        						}        						
        						?>
        					</select>
						</td>
						<td class="normal">
							<input class="txt-obl" type="text" name="sales[]"> 
						</td>
						<td class="normal">
							<input class="txt-obl" type="text" name="quantity[]"> 
						</td>
						<td class="normal">
							<input class="txt-obl" type="text" name="discount[]"> 
						</td>
						<td class="normal">
							<input class="txt-obl" type="text" name="profit[]"> 
						</td>
						<td class="controls"></td>
					</tr>
				</table>
					
			</div>
			
		</fieldset>
		<fieldset>
			<input type="submit" value="Aceptar">
		</fieldset>
	</form>
	</div>
</body>
</html>