<!DOCTYPE html>
<?php 
ob_start();
session_start();
if(!isset($_SESSION['customer_email'])){
	
	echo "<script>window.open('../customer_register.php','_self')</script>";
}
else {


include("../includes/db.php");
include("../functions/functions.php");
?>
<html>

<head>
	<title>E-Commerce site</title>
	<link rel="stylesheet"  href="../styles/styles.css" media="all" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>	
	<div class="main-wrapper">
		<header>
			<a href="index.php"><img id="logo" src="../images/ecommerce-logo.png"></a>
			<img id="banner" src="../images/ecommerce-banner.jpg">
				
			
		</header>

		<nav class="menu-bar">
			<ul id="menu">
				<li><a href="../index.php">Αρχική</a></li>
				<li><a href="../customer/my_account.php">Λογαριασμός</a></li>
				<li><a href="../contact.php">Επικοινωνία</a></li>
				<li><a href="../cart.php">Καλάθι<span class="fa fa-shopping-cart"></span></a></li>
				<li><a href='../logout.php'> Αποσυνδεθείτε</a></li>
			</ul>

			<div id="form">
				<form method="get" action="../results.php" enctype="multipart/form-data">
					<input type="text" name="user_query" placeholder="Search something">
					<input type="submit" name="search" value="Search">
				</form>
				

			</div>
		</nav>


		<main >
						<aside style="float: left;">
				<div class="sidebar-title" class="container">Ο Λογαριασμός μου</div>
				<br>
				<ul id="side-list">
				<a href="my_account.php?my_orders"> Παραγγελίες </a>
				<a href="my_account.php?edit_account">Επεξεργασία </a>
				<a href="my_account.php?change_pass">Αλλαγή Κωδικού</a>
				<a href="my_account.php?delete_account">Διαγραφή </a>
				</ul>
				
				
			</aside>
			<section id="content-area" class="container-fluid">
			
			<?php 
			$user=$_SESSION['customer_email'];
			// based on email in session
				
				$get_name = $con->prepare("select customer_name from customers where customer_email=?"); 
				$get_name-> execute([$user]);// select the name
				$c_name = $get_name->fetchColumn();
				
			
				
				if(!isset($_GET['my_orders'])){
					if(!isset($_GET['edit_account'])){
						if(!isset($_GET['change_pass'])){
							if(!isset($_GET['delete_account'])){// if nothing of everything is sent show main account page
							
				echo "
				<h2 style='padding:20px;'>Welcome:  $c_name </h2>
				<b>You can see your orders progress by clicking this <a href='my_account.php?my_orders'>link</a></b>";// go to orfers
				}
				}
				}
				}
					// and here based on the queries of the url link included each partial page
				if(isset($_GET['edit_account'])){
				include("edit_account.php");
				}
				if(isset($_GET['change_pass'])){
				include("change_pass.php");
				}
				if(isset($_GET['delete_account'])){
				include("delete_account.php");
				}
				
					if(isset($_GET['my_orders'])){
				include("my_orders.php");
				}
				
				

			 ?>
		
	
				</section>


		<?php include("../footer.php"); ?>
<?php } ?>
