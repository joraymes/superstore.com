<?php 
    include('../include/city.php');
    $city= new city();
    $arrCities= $city->getAll();  
?>
<!DOCTYPE>
<html>
<head>
	<title>Superstore, Gestión de clientes: Nuevo cliente</title>
	<link rel="stylesheet" href="/css/estilos.css" />
	<script src="/js/validaform.js"></script>
</head>
<body>
	<a href="/customers">Volver</a>
	<div class="form-box">
	<form action="insert_customers.php" method="post" onsubmit="return validaform(this,'sibling','es','/js/validaform.xml')" >
		<fieldset>
			<legend>Datos del cliente</legend>
			<div>
				<label>Código:</label>
				<input class="txt-obl" type="text" name="code" value=""> 
			</div>
			<div>
				<label>Nombre:</label>
				<input class="txt-obl" type="text" name="name" value=""> 
			</div>
			<div>
				<label>Tipo:</label>
				<select name="segment" class="sel-obl">
					<option value="">-- Elija una opción --</option>
					<option value="Corporate"> Empresa</option>
					<option value="Home Office"> Tienda</option>
					<option value="Consumer"> Cliente final</option>
				</select>
			</div>
			<div>
				<label>Ciudad:</label>
				<select name="id_cities" class="sel-obl">
					<option value="">-- Elija una opción --</option>
					<?php 
					foreach($arrCities as $row){
					    echo "<option value=\"{$row['id']}\">{$row['city']}</option>";
					}
					?>
				</select>
			</div>
		</fieldset>
		<fieldset>
			<input type="submit" value="Aceptar">
			
		</fieldset>
	</form>
	</div>
</body>
</html>