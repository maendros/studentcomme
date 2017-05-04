<?php 
	include("includes/db.php"); 
	
	if(isset($_GET['delete_c'])){
	
	$delete_id = $_GET['delete_c'];

	$delete_customer = $con->prepare("DELETE from customers where customer_id=:delete_id");  
	$delete_customer->execute(array(":delete_id"=>$delete_id));// delete customer based on id
	
	if($delete_customer){
	
	echo "<script>alert('Ένας Πελάτης διαγράφηκε!')</script>";
	echo "<script>window.open('index.php?view_customers','_self')</script>";
	}
	
	}





?>