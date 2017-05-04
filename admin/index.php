<?php 
session_start(); 

if(!isset($_SESSION['user_email'])){// if there no session email set u ll be redirected at the main page
	
	echo "<script>window.open('login.php?not_admin=You are not an Admin!','_self')</script>";
}
else {// elese load the index

?>

<!DOCTYPE> 

<html>
	<head>
		<title>Περιβάλλον Διαχειριστή</title> 
		
	<link rel="stylesheet" href="styles/style.css" media="all" /> 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>


<body> 

	<div class="main_wrapper">
	
	
		<div id="header"></div>
		
		<div id="right">
		<h2 style="text-align:center;">Διαχείριση Περιεχομένου</h2>
			
			<a href="index.php?insert_product">Εισαγωγή νέου Προιόντος</a>
			<a href="index.php?view_products">Προβολή όλων των Προιόντων</a>
			<a href="index.php?insert_cat">Εισαγωγή νέας Κατηγορίας</a>
			<a href="index.php?view_cats">Προβολή όλων των Κατηγοριών</a>
			<a href="index.php?insert_brand">Εισαγωγή νέας Μάρκας</a>
			<a href="index.php?view_brands">Προβολή όλων των Μαρκών</a>
			<a href="index.php?view_customers">Προβολή Πελατών</a>
			<a href="index.php?view_orders">Προβολή Παραγγελιών</a>
			<a href="index.php?view_payments">Προβολή Πληρωμών</a>
			<a href="logout.php">Έξοδος Διαχειριστή</a>
		
		</div>
		
		<div id="left">
		<h2 style="color:red; text-align:center;"><?php echo @$_GET['logged_in']; ?></h2>
		<?php 
		if(isset($_GET['insert_product'])){
		
		include("insert_product.php"); 
		
		}
		if(isset($_GET['view_products'])){
		
		include("view_products.php"); 
		
		}
		if(isset($_GET['edit_pro'])){
		
		include("edit_pro.php"); 
		
		}
		if(isset($_GET['insert_cat'])){
		
		include("insert_cat.php"); 
		
		}
		
		if(isset($_GET['view_cats'])){
		
		include("view_cats.php"); 
		
		}
		
		if(isset($_GET['edit_cat'])){
		
		include("edit_cat.php"); 
		
		}
		
		if(isset($_GET['insert_brand'])){
		
		include("insert_brand.php"); 
		
		}
		
		if(isset($_GET['view_brands'])){
		
		include("view_brands.php"); 
		
		}
		if(isset($_GET['edit_brand'])){
		
		include("edit_brand.php"); 
		
		}
		if(isset($_GET['view_customers'])){
		
		include("view_customers.php"); 
		
		}
				if(isset($_GET['view_orders'])){
		
		include("view_orders.php"); 
		
		}
						if(isset($_GET['view_payments'])){
		
		include("view_payments.php"); 
		
		}
		
		
		?>
		</div>






	</div>


</body>
</html>

<?php  }?>

<?php 
	include("includes/db.php");
	if (isset($_GET['confirm_order'])) {

		
			$get_id=$_GET['confirm_order'];
			$status='Completed';

			$update_status=$con->prepare("UPDATE orders SET status=:status where order_id=:get_id");
			$update_status->execute(array(":status"=>$status,":get_id"=>$get_id));

			if($update_status){
				echo "<script>alert('Order was completed')</script>";
				echo "<script>window.open('index.php?view_orders','_self')</script>";
			}
	}

 ?>