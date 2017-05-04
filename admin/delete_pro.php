<?php 
	include("includes/db.php"); 
	
	if(isset($_GET['delete_pro'])){
	
	$delete_id = $_GET['delete_pro'];

	$delete_pro = $con->prepare("DELETE from products where product_id=:delete_id");  
	$delete_pro->execute(array(":delete_id"=>$delete_id));// delete product based on id
	
	if($delete_pro){
	
	echo "<script>alert('Ένα προιόν διαγράφηκε!')</script>";
	echo "<script>window.open('index.php?view_products','_self')</script>";
	}
	
	}





?>