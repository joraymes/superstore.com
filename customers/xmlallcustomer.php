<?php 

    include ('../include/customer.php');
    
    /** $pagina: */
    $pagina=(isset($_GET['pagina']))? $_GET['pagina']:0;
    /** $registros: Registres  a mostrar. */
    $registros =15;

	$customer2= new customer('xml');
	$xmlCustomer= $customer2->pagination($pagina,$registros);
	header('Content-type: text/xml');
	echo $xmlCustomer;
?>