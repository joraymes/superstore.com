<?php 
    include('../include/order.php');
    include('../include/orderproduct.php');
    include('../include/customer.php');
    include('../include/product.php');

    $id=(isset($_GET['id']))? $_GET['id'] : '';
    if($id==''){  header('Location:index.php');exit;  }
    
    // Datos del pedido
    $order=new order();
    $arrOrder=$order->get($id);
    // Datos de linias de productos por el mismo pedido
    $orderproduct=new orderproduct();
    $arrOrderProducts= $orderproduct->getProducts($id);
    
    // Lista de Clientes completa
    $customer= new customer();
    $arrCustomers=$customer->getAll();
    
    // Lista de Productos completa
    $product=new product();
    $arrProducts=$product->getAll();
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
	<form action="update_orders.php" method="post" onsubmit="return validaform(this,'sibling','es','/js/validaform.xml')" >
		<input type="hidden"  name="id" value="<?php echo $arrOrder['id']  ?>">
		<fieldset>
			<legend>Datos del pedido</legend>
			<div>
				<label>Código:</label>
				<input class="txt-obl" type="text" name="code" value="<?php echo $arrOrder['code']  ?>"> 
			</div>
			<div>
				<label>Fecha pedido:</label>
				<input class="txt-obl" type="date" name="orderDate" value="<?php echo $arrOrder['orderDate']  ?>"> 
			</div>
			<div>
				<label>Fecha envío:</label>
				<input class="txt-obl" type="date" name="shipDate" value="<?php echo $arrOrder['shipDate']  ?>"> 
			</div>
			<div>
				<label>Mètodo envío:</label>
				<select class="sel-obl" name="shipMode">
					<option value="">-- Elija una opción --</option>
					<option <?php echo ($arrOrder['shipMode']=='First Class')? 'selected="selected"' : '' ; ?> value="First Class">First Class</option>
					<option <?php echo ($arrOrder['shipMode']=='Second Class')? 'selected="selected"' : '' ; ?> value="Second Class">Second Class</option>
					<option <?php echo ($arrOrder['shipMode']=='Standard Class')? 'selected="selected"' : '' ; ?> value="Standard Class">Standard Class</option>
				</select> 
			</div>
			<div>
				<label>Cliente</label>
				<select class="sol-obl" name="id_customers">
					<option value="">-- Elija una opción --</option>
					<?php 
					foreach ($arrCustomers as $row){
					    $selected =( $row['id'] == $arrOrder['id_customers']) ? 'selected="selected"' : '' ;
					    echo "<option $selected  value=\"{$row['id']}\">{$row['code']} {$row['name']}</option>";
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
			<?php foreach ($arrOrderProducts as $liniaProducto){?>
    			<div>
    				<table>
    					<tr>
    						<td class="big">
    							<select class="sel-obl"  name="id_products[]">
            						<option value="">-- Elija una opción --</option>
            						<?php 
            						foreach($arrProducts as $row){
            						    $selected=($row['id']== $liniaProducto['id_products'] )? 'selected="selected"' : '' ;
            						   echo "<option $selected value=\"{$row['id']}\">{$row['code']} {$row['name']}</option>";
            						}        						
            						?>
            					</select>
    						</td>
    						<td class="normal">
    							<input class="txt-obl" type="text" name="sales[]" value="<?php echo $liniaProducto['sales'] ?>"> 
    						</td>
    						<td class="normal">
    							<input class="txt-obl" type="text" name="quantity[]" value="<?php echo $liniaProducto['quantity'] ?>"> 
    						</td>
    						<td class="normal">
    							<input class="txt-obl" type="text" name="discount[]" value="<?php echo $liniaProducto['discount'] ?>"> 
    						</td>
    						<td class="normal">
    							<input class="txt-obl" type="text" name="profit[]" value="<?php echo $liniaProducto['profit'] ?>"> 
    						</td>
    						<td class="controls"></td>
    					</tr>
    				</table>
    					
    			</div>    
			<?php  }   ?>
		</fieldset>
		<fieldset>
			<input type="submit" value="Aceptar">
		</fieldset>
	</form>
	</div>
</body>
</html>